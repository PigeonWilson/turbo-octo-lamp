<?php
if (!defined('prevent_direct_access'))
{
    // prevent direct access to this file
    die();
}

## database for the project configuration
$system_db_host = "127.0.0.1";
$system_db_name = "backendphp_system";
$system_db_username = "root";
$system_db_password = "";

# force system to generate file(s)
const system_force_generate_files = true;