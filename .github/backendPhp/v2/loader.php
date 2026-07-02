<?php
const PREVENT_DIRECT_FILE_ACCESS_CONST = true;

# database credentials
$db_host = "127.0.0.1";
$db_name = "backendphp";
$db_username = "root";
$db_password = "";

# load components
require_once 'core' . DIRECTORY_SEPARATOR . 'Database.php';
require_once 'core' . DIRECTORY_SEPARATOR . 'Framework.php';

# set error reporting
error_reporting(Framework::DEBUG_MODE_CONST);
ini_set('display_errors', Framework::DEBUG_MODE_CONST);

# boot load the framework
try
{
    $GLOBALS[Framework::FRAMEWORK_IDENTIFIER] = new Framework($db_host, $db_name, $db_username, $db_password);
    $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->SanitizeInput();
    // the preloader prepares the framework for use
    require_once 'preloader.php';
}catch (Exception $e)
{
    if (Framework::DEBUG_MODE_CONST)
    {
        echo $e->getMessage();
    }

    die();
}
