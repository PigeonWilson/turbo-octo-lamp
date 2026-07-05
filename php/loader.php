<?php
// order is important
const prevent_direct_access = 'ehm';
require_once 'config' . DIRECTORY_SEPARATOR . 'config.system.php';
require_once 'config' . DIRECTORY_SEPARATOR . 'config.project.php';

# set error reporting
error_reporting(system_debug_mode);
ini_set('display_errors', system_debug_mode);

require_once 'common' . DIRECTORY_SEPARATOR . 'common.web.php';
require_once 'common' . DIRECTORY_SEPARATOR . 'common.module.php';

require_once 'core' . DIRECTORY_SEPARATOR . 'Loader.php';

/*
 * The order of these files is important. */
require_once 'core' . DIRECTORY_SEPARATOR . 'WebClient.php';
require_once 'core' . DIRECTORY_SEPARATOR . 'Database.php';
require_once 'core' . DIRECTORY_SEPARATOR . 'Engine.php';
require_once 'core' . DIRECTORY_SEPARATOR . 'Caching.php';

try{
    # required configuration loaded from config.project.php
    # boot load the framework
    $engine = new Engine($project_db_host, $project_db_name, $project_db_username, $project_db_password);
    engine::SanitizeInput();
}catch (Exception $e){die();}