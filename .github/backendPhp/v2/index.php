<?php
require_once 'loader.php';

/*
 * This is the backend of the application, it receives requests from the frontend.
 * This requires authentication.
 * Phase 1
 * Version change:
 * -> Version 0.1.0: Phase 1
 * -> Version 0.1.1: Code refactoring to reduce hard-coded value
 * -> Version 0.1.2: Added separated authentication module and relaxed usage
 * */

/*
 * Authentication module gives a session token to the user.
 * This token is used to authenticate the user for all subsequent requests.
 * */
if ($GLOBALS[Framework::COMMAND_CMD] === Framework::MODULE_AUTH)
{
    if (is_null($GLOBALS[Framework::COMMAND_USERNAME])
        || is_null($GLOBALS[Framework::COMMAND_TOKEN]))
    {
        die();
    }

    $sessionToken = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->Login2($GLOBALS[Framework::COMMAND_USERNAME], $GLOBALS[Framework::COMMAND_TOKEN]);
    if (is_null($sessionToken))
    {
        die();
    }

    $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]::EchoJson(Framework::SESSION_TOKEN, $sessionToken);
    die();
}

if ($GLOBALS[Framework::COMMAND_CMD] === Framework::MODULE_WHOAMI)
{
    $sessionToken
        = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->network_request[Framework::SESSION_TOKEN];
    if (!is_null($sessionToken))
    {
        $whoAmI = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->WhoAmI($sessionToken);
        $whoAmI->token = null;
        if (!is_null($whoAmI))
        {
            $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]::EchoJson(Framework::MODULE_WHOAMI, $whoAmI);
            die();
        }
    }
}

# if there is no session token and the cmd is not auth, then the user is not logged in
$sessionToken = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->network_request[Framework::SESSION_TOKEN];
if (!is_null($sessionToken))
{
    $user = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->WhoAmI($sessionToken);
    if (!is_null($user))
    {
        $isUserLoggedIn = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->IsUserLoggedIn($user->id);
        if (!$isUserLoggedIn)
        {
            die();
        }
    }
}

# if a command is given, then the user must be logged in
# except for commands in the whitelist
if (!is_null($GLOBALS[Framework::COMMAND_CMD]))
{
    $whiteList = [Framework::MODULE_AUTH, Framework::MODULE_PACKAGE];

    if (!in_array($GLOBALS[Framework::COMMAND_CMD], $whiteList) && is_null($sessionToken))
    {
        die();
    }
}

/*
 * publication module
 * This module is for retrieving packages. It doesn't require authentication.
 * */
if ($GLOBALS[Framework::COMMAND_CMD] === Framework::MODULE_PACKAGE)
{
    try
    {
        $packageId = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->network_request[Framework::PACKAGE_ID];
        $package = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->CustomWhereClause('package', 'id', $packageId)[0];
        $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]::EchoJson(Framework::MODULE_PACKAGE, $package);
        die();
    }catch (Exception $e)
    {
        die();
    }
}

# database module
if ($GLOBALS[Framework::COMMAND_CMD] === Framework::MODULE_DB)
{
    # domain-specific argument
    $table = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->network_request[Framework::COMMAND_TABLE];

    # enforce table exclusion
    if (is_null($table) || in_array($table, Framework::TABLES_EXCLUSION_LIST))
    {
        die();
    }

    # filter out the command and table
    $data = [];
    foreach ($GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->network_request as $key => $value)
    {
        if (!in_array($key, Framework::GetCommands()))
        {
            $data[$key] = $value;
        }
    }

    $result = null;

    if ($GLOBALS[Framework::COMMAND_ARG] === 'create' || $GLOBALS[Framework::COMMAND_ARG] === 'c')
    {
        $result['operationResult']
            = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->db->Create($table, $data);
        $result['lastInsertedId']
            = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->db->LastInsertedId();
    }

    if ($GLOBALS[Framework::COMMAND_ARG] === 'read' || $GLOBALS[Framework::COMMAND_ARG] === 'r')
    {
        $result['operationResult']
            = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->db->Read($table, $data['id']);
    }

    if ($GLOBALS[Framework::COMMAND_ARG] === 'update' || $GLOBALS[Framework::COMMAND_ARG] === 'u')
    {
        $result['operationResult']
            = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->db->Update($table, $data['id'], $data);
    }

    if ($GLOBALS[Framework::COMMAND_ARG] === 'delete' || $GLOBALS[Framework::COMMAND_ARG] === 'd')
    {
        $result['operationResult']
            = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->db->Delete($table, $data['id']);
    }

    $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]::EchoJson(Framework::MODULE_DB, $result);
    die();
}
