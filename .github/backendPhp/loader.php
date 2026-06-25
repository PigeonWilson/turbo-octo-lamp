<?php
// turn off all error reporting
error_reporting(0);

// database information
$db_hostname = 'localhost';
$db_name = 'backend';
$db_username = 'root';
$db_password = '';

require_once ('Core' .  DIRECTORY_SEPARATOR .'Db.php');
require_once ('Core' .  DIRECTORY_SEPARATOR .'publication.php');
