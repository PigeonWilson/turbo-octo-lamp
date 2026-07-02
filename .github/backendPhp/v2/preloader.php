<?php
# require loader to be loaded
if (!defined('PREVENT_DIRECT_FILE_ACCESS_CONST')) {
    die();
}
/*
 * The preloader role is to prepare
 * some basic environment for the framework.
 * This script is added after the framework is loaded.
 * */
# arguments
$GLOBALS[Framework::COMMAND_CMD] = mb_strtolower($GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->network_request[Framework::COMMAND_CMD]);
$GLOBALS[Framework::COMMAND_ARG] = mb_strtolower($GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->network_request[Framework::COMMAND_ARG]);
$GLOBALS[Framework::COMMAND_USERNAME] = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->network_request[Framework::COMMAND_USERNAME];
$GLOBALS[Framework::COMMAND_TOKEN] = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->network_request[Framework::COMMAND_TOKEN];
$GLOBALS[Framework::SESSION_TOKEN] = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->network_request[Framework::SESSION_TOKEN];

# helpers
// these are ALL the modules that are available to the framework
$GLOBALS['MODULE_LIST'] = [
    Framework::MODULE_DB,
    Framework::MODULE_AUTH,
    Framework::MODULE_WHOAMI,
    Framework::MODULE_PACKAGE];

// these modules are available to all users any other modules require a session token
$GLOBALS['MODULE_ANONYMOUS_LIST'] =
    [
        Framework::MODULE_AUTH,
        Framework::MODULE_PACKAGE];

$GLOBALS[Framework::MODULE_WHOAMI] = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->WhoAmI($GLOBALS[Framework::SESSION_TOKEN]);

# some rules for the api
if (!is_null($GLOBALS[Framework::COMMAND_CMD]))
{
    # check if the command is valid
    if (!in_array($GLOBALS[Framework::COMMAND_CMD], $GLOBALS['MODULE_LIST']))
    {
        // Invalid command
        die();
    }

    // connected users can only access if logged in
    if (!is_null($GLOBALS[Framework::MODULE_WHOAMI]))
    {
        if (!$GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->IsUserLoggedIn($GLOBALS[Framework::MODULE_WHOAMI]->id))
        {
            // check if session token is valid
            die();
        }
    }else{
        // not connected
        if (!in_array($GLOBALS[Framework::COMMAND_CMD], $GLOBALS['MODULE_ANONYMOUS_LIST']))
        {
            // the command is not anonymous
            die();
        }
    }
}else{
    // if the command is null, die
    die();
}
