<?php
require_once '../loader.php';

const root_path = __DIR__;

try{
    # required configuration loaded from config.system.php
    # boot load the framework
    $system_engine = new Engine($system_db_host, $system_db_name, $system_db_username, $system_db_password);
    engine::SanitizeInput();
}catch (Exception $e){die();}

# Generate a new Loader
$modules = $system_engine->database->ReadAll('instance_module');
$content = '';
foreach ($modules as $module)
{

}