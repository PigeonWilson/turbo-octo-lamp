<?php
/*
 * This file must be included first
 * */
const prevent_direct_access = 'ehm';
require_once 'core' . DIRECTORY_SEPARATOR . 'directories.php';
require_once $GLOBALS['dir_core'] . DIRECTORY_SEPARATOR . 'files.php';
require_once $GLOBALS['dir_config'] . DIRECTORY_SEPARATOR . 'config.system.php';
require_once $GLOBALS['dir_config'] . DIRECTORY_SEPARATOR . 'config.project.php';
require_once $GLOBALS['file_common.web'];
require_once $GLOBALS['file_common.module'];
require_once $GLOBALS['file_common.project'];

# set error reporting
error_reporting(debug_mode);
ini_set('display_errors', debug_mode);

# load core functionalities
require_once $GLOBALS['dir_core'] . DIRECTORY_SEPARATOR . 'Loader.php';
require_once $GLOBALS['dir_core'] . DIRECTORY_SEPARATOR . 'WebClient.php';
require_once $GLOBALS['dir_core'] . DIRECTORY_SEPARATOR . 'Database.php';
require_once $GLOBALS['dir_core'] . DIRECTORY_SEPARATOR . 'Engine.php';
require_once $GLOBALS['dir_core'] . DIRECTORY_SEPARATOR . 'Caching.php';
require_once $GLOBALS['dir_core'] . DIRECTORY_SEPARATOR . 'Loader.php';
try{
    # required configuration loaded from config.project.php
    # boot load the framework
    $project_engine = new Engine($project_db_host, $project_db_name, $project_db_username, $project_db_password);
    $system_engine = new Engine($system_db_host, $system_db_name, $system_db_username, $system_db_password);
    Engine::SanitizeInput();
}catch (Exception $e){die();}
/*
 * authorization
 *
 * */
require_once $GLOBALS['dir_accessManagement'] . DIRECTORY_SEPARATOR . 'AuthorizationProfile.php';
require_once $GLOBALS['dir_accessManagement'] . DIRECTORY_SEPARATOR . 'ICommand.php';
require_once $GLOBALS['dir_authorization'] . DIRECTORY_SEPARATOR . 'authorization.role.php';
require_once $GLOBALS['dir_authorization'] . DIRECTORY_SEPARATOR . 'authorization.task.php';
try{
    $authorization_profile = new AuthorizationProfile();

}catch (Exception $e){die();}

/*
 * generate files if they do not exist
 *
 * */
if (!file_exists($GLOBALS['file_common.module']))
{
    Loader::GenerateModuleConstants($GLOBALS['file_common.module'], $system_engine);
}

if (!file_exists($GLOBALS['file_common.project']))
{
    Loader::GenerateProjectConstants($GLOBALS['file_common.project'], $system_engine);
}

# generate files if forced
if (system_force_generate_files)
{
    Loader::GenerateModuleConstants($GLOBALS['file_common.module'], $system_engine);
    Loader::GenerateProjectConstants($GLOBALS['file_common.project'], $system_engine);
}