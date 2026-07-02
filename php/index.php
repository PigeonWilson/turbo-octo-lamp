<?php
require_once 'loader.php';


// list available modules
function GetModules() : array
{
    $regular = [
        api_module_db,
        api_module_whoami,
        api_module_packaging
    ];
    return array_merge($regular, GetModulesAnonymous());
}

// list of modules that do not require a session token
function GetModulesAnonymous() : array
{
    return [
        api_module_auth,
        api_module_package,
        api_module_registration
    ];
}

// return a list of tables that should not be used by api db module
function GetTablesExclusionList() : array
{
    return [
        'authentication',
        'authorization_role',
        'module',
        'modulemethod',
        'role',
        'role_group_tasks',
        'session',
        'task'
    ];
}

// return a list of tables that should be used by api db module
function GetTablesAllowedList() : array
{
    return [
        'storage'
    ];
}

function IsHttpVerbAllowed($verb) : bool
{
    return in_array(mb_strtolower($verb), http_verbs_allowed);
}

// result is re-used for each module
$result = null;
/*
 * the next section determines reasons to end communication
 * */
if (isset($_SERVER['REQUEST_METHOD'])
    && !IsHttpVerbAllowed($_SERVER['REQUEST_METHOD']))
{
    // the http verb is not allowed
    die();
}

if (!isset($_REQUEST[api_cmd]))
{
    // missing mandatory cmd argument
    die();
}

if (!isset($_REQUEST[api_session_token]))
{
    // the module is not anonymous and the session token is not set
    if (!in_array($_REQUEST[api_cmd], GetModulesAnonymous()))
    die();
}

if (!in_array($_REQUEST[api_cmd], GetModules()))
{
    // the module is not valid
    die();
}

// authentication is done here
if (isset($_REQUEST[api_session_token]))
{
    $session = $engine->database->Read('session', ['token' => $_REQUEST[api_session_token]]);
    if (is_null($session))
    {
        // invalid session token
        die();
    }
}

// modules
if ($_REQUEST[api_cmd] === api_module_registration)
{
    if (is_null($_REQUEST[api_username]))
    {
        // missing mandatory username argument
        die();
    }

    $username = $_REQUEST[api_username] . engine::Random_str(8);
    $token = engine::Random_str(256);
    $engine->database->Create('authentication', [api_username => $username, api_token => $token]);
    $result = [api_username => $username, api_token => $token];
}

if ($_REQUEST[api_cmd] === api_module_whoami)
{
    $session = $engine->database->Read('session', ['token' => $_REQUEST[api_session_token]]);
    $user = $engine->database->Read('authentication', ['id' => $session->authenticationId]);
    $user->token = null;
    $result = [api_module_whoami => $user];
}

if ($_REQUEST[api_cmd] === api_module_packaging)
{
    //
}

if ($_REQUEST[api_cmd] === api_module_db)
{
    if (is_null($_REQUEST['arg'])
    || is_null($_REQUEST['table']))
    {
        // missing mandatory arg argument
        die();
    }

    if (in_array($_REQUEST['table'], GetTablesExclusionList()))
    {
        // the table is not allowed
        die();
    }

    if (!in_array($_REQUEST['table'], GetTablesAllowedList()))
    {
        // the table is not allowed
        die();
    }

    $argsToFilters = ['arg', 'table'];
    $data = [];
    foreach ($_REQUEST as $key => $value)
    {
        if (!in_array($key, $argsToFilters))
        {
            $data[$key] = $value;
        }
    }

    if ($_REQUEST['arg'] === 'c' || $_REQUEST['arg'] === 'create')
    {
        $result['operationResult'] = $engine->database->Create($_REQUEST['table'], $data);
        $result['lastInsertedId'] = $engine->database->LastInsertedId();
    }

    if ($_REQUEST['arg'] === 'r' || $_REQUEST['arg'] === 'read')
    {
        if (is_null($_REQUEST['id']))
        {
            // missing mandatory id argument
            die();
        }

        $result['operationResult'] = $engine->database->Read($_REQUEST['table'], ['id' => $_REQUEST['id']]);
    }

    if ($_REQUEST['arg'] === 'u' || $_REQUEST['arg'] === 'update')
    {
        if (is_null($_REQUEST['id']))
        {
            // missing mandatory id argument
            die();
        }

        $result['operationResult'] = $engine->database->Update($_REQUEST['table'], $data, ['id' => $_REQUEST['id']]);
    }

    if ($_REQUEST['arg'] === 'd' || $_REQUEST['arg'] === 'delete')
    {
        if (is_null($_REQUEST['id']))
        {
            // missing mandatory id argument
            die();
        }

        $result['operationResult'] = $engine->database->Delete($_REQUEST['table'], ['id' => $_REQUEST['id']]);
    }
}

if ($_REQUEST[api_cmd] === api_module_package)
{
    $package = $engine->database->Read('package', ['id' => $_REQUEST['id']]);
    $result = [api_module_package => $package];
}

if ($_REQUEST[api_cmd] === api_module_auth)
{
    if (is_null($_REQUEST[api_token]))
    {
        // missing mandatory token argument
        die();
    }

    $user = $engine->database->CustomWhereClause('authentication', api_token, $_REQUEST[api_token]);
    if (count($user) === 0)
    {
        // invalid token
        die();
    }

    // erase all sessions for this user
    $engine->database->DeleteAllCustom('session',['authenticationId' => $user[0]->id]);

    $sessionToken = engine::Random_str(256);
    $engine->database->Create('session', ['authenticationId' => $user[0]->id, 'token' => $sessionToken]);
    $result = [api_session_token => $sessionToken];
}



// output json
header('Content-Type: application/json');
echo json_encode([api_result => $result], JSON_PRETTY_PRINT);
die();