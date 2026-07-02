<?php
# database credentials
$db_host = "127.0.0.1";
$db_name = "backendphp";
$db_username = "root";
$db_password = "";

# set debug mode
const debug_mode = true;

const http_verbs_allowed = ['get', 'post'];
const api_cmd = 'cmd';
const api_result = 'result';
const api_username = 'username';
const api_token = 'token';
const api_session_token = 'session_token';
const api_module_auth = 'auth';
const api_module_registration = 'registration';
const api_module_db = 'db';
const api_module_whoami = 'whoami';
const api_module_package = 'package';
const api_module_packaging = 'packaging';

# api url
const api_url = 'http://localhost/turbo-octo-lamp/php/index.php';
const admin_url = 'http://localhost/turbo-octo-lamp/php/admin.php';
const login_url = 'http://localhost/turbo-octo-lamp/php/login.php';
# set error reporting
error_reporting(debug_mode);
ini_set('display_errors', debug_mode);

// order matters
require_once 'core' . DIRECTORY_SEPARATOR . 'WebClient.php';
require_once 'core' . DIRECTORY_SEPARATOR . 'Database.php';
require_once 'core' . DIRECTORY_SEPARATOR . 'Engine.php';

$engine = new Engine($db_host, $db_name, $db_username, $db_password);
engine::SanitizeInput();