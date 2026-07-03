<?php
# database information
$db_host = "127.0.0.1";
$db_name = "backendphp";
$db_username = "root";
$db_password = "";

# project info
const project_name = 'Turbo Octo Lamp';
const version = '0.0.1';
const project_email_contact = 'pigeonWilson@pm.me';
const source_code_link = 'https://github.com/pigeonwilson/turbo-octo-lamp/tree/main/';
const source_code_license_link = 'https://github.com/PigeonWilson/turbo-octo-lamp/blob/main/LICENSE';
const project_documentation_link = 'https://github.com/PigeonWilson/turbo-octo-lamp/tree/main/php';
const project_manifest_link = 'https://github.com/PigeonWilson/turbo-octo-lamp/blob/main/Manifeste.md';
const project_rules_link = 'https://github.com/PigeonWilson/turbo-octo-lamp/blob/main/reglements.md';
const project_multimedia_credits_link = 'https://github.com/PigeonWilson/turbo-octo-lamp/blob/main/credits_multimedia.md';
# set debug mode
const debug_mode = true;

# set error reporting
error_reporting(debug_mode);
ini_set('display_errors', debug_mode);

/*
 * The api commands are used to communicate with the server.
 * The server will respond with a JSON object.
 * The JSON object will contain the result of the command.
 * */
// https require a certificate
const http_security = 'https';
const http_get = 'get';
const http_post = 'post';
const http_no_security = 'http';
const http_verbs_allowed = [http_get, http_post];

/*
 * api parameters
 * */
const api_cmd = 'cmd';
const api_result = 'result';
const api_username = 'username';

/*
 * The token is used to authenticate the user.
 * It is given by the user when the user wants to authenticate.
 * */
const api_token = 'token';

/*
 * The session token is given when the user is authenticated.
 * It is used to authenticate the user for requests.
 * */
const api_session_token = 'session_token';

/*
 * The 'auth' module doesn't require authentication.
 * It provides a service to authenticate users.
 * It requires a token to open a session into the database
 * and it provides a token to authenticate the user for all requests
 * until the session is closed. The user session can be
 * terminated by the user or by the server.
 * */
const api_module_auth = 'auth';

/*
 * The 'registration' module doesn't require authentication.
 * It provides a service to register new users.
 * */
const api_module_registration = 'registration';

/*
 * The 'db' module require authentication.
 * It provides crud operations to the database
 * and some other operations.
 * */
const api_module_db = 'db';

/*
 * Provide information about the modules that are available.
 * */

/*
 * The 'whoami' module requires authentication.
 * It provides information about the user.
 * */
const api_module_whoami = 'whoami';

/*
 * The 'package' module doesn't require authentication.
 * It provides information about the packages.
 * */
const api_module_package = 'package';

/*
 * The 'packaging' module requires authentication.
 * It provides a service to decommission protected information
 * into a format that is accessible to the public.
 * */
const api_module_packaging = 'packaging';

const web_session_loggedIn = 'loggedin';
const web_csrf = 'csrf';
const web_lang = 'fr';

# api url
const project_base_url = http_no_security . '://' . 'localhost/' . 'turbo-octo-lamp/';
const backend_project_folder = 'php';

# url
const api_url = project_base_url . backend_project_folder . '/api.php';
const admin_url = project_base_url . backend_project_folder . '/admin.php';
const web_login_url = project_base_url . backend_project_folder . '/login.php';
const web_index_url = project_base_url . backend_project_folder . '/index.php';
const web_register_url = project_base_url . backend_project_folder . '/register.php';
const prevent_direct_access = 'ehm';
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

// return a list of tables that CANNOT be used by api db module
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
        'task',
        'localization'
    ];
}

// return a list of tables that CAN be used by api db module
function GetTablesAllowedList() : array
{
    return [
        'storage'
    ];
}

/*
 *
 * */
function IsHttpVerbAllowed($verb) : bool
{
    return in_array(mb_strtolower($verb), http_verbs_allowed);
}

/*
 * The order of these files is important.
 * The engine depends on the database and the web client. */
require_once 'core' . DIRECTORY_SEPARATOR . 'WebClient.php';
require_once 'core' . DIRECTORY_SEPARATOR . 'Database.php';
require_once 'core' . DIRECTORY_SEPARATOR . 'Engine.php';
require_once 'core' . DIRECTORY_SEPARATOR . 'Caching.php';

#  boot load the framework
$engine = new Engine($db_host, $db_name, $db_username, $db_password);
engine::SanitizeInput();