<?php
const PREVENT_DIRECT_FILE_ACCESS_CONST = true;
const DEBUG_MODE_CONST = true;
const HTTP_METHOD_GET = 'GET';
const HTTP_METHOD_POST = 'POST';

# database credentials
$db_host = "127.0.0.1";
$db_name = "backendphp";
$db_username = "root";
$db_password = "";

# load components
require_once 'core' . DIRECTORY_SEPARATOR . 'Db.php';
require_once 'core' . DIRECTORY_SEPARATOR . 'Framework.php';

# set error reporting
error_reporting(DEBUG_MODE_CONST);
ini_set('display_errors', DEBUG_MODE_CONST);

# boot load the framework
try
{
    $GLOBALS['framework'] = new Framework($db_host, $db_name, $db_username, $db_password);
    $GLOBALS['framework']->SanitizeInput();
}catch (Exception $e)
{
    if (DEBUG_MODE_CONST)
    {
        echo $e->getMessage();
    }

    die();
}
