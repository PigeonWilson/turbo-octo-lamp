<?php
require_once 'loader.php';
#
# Phase 1
#
#
const COMMAND_CMD = 'cmd';
const COMMAND_ARG = 'arg';
const COMMAND_USERNAME = 'username';
const COMMAND_TOKEN = 'token';
const COMMAND_TABLE = 'table';
const COMMANDS = [COMMAND_CMD, COMMAND_ARG, COMMAND_USERNAME, COMMAND_TOKEN, COMMAND_TABLE];
const TABLES_EXCLUSION_LIST =
[
    'authentication',
    'authorization_role',
    'module',
    'modulemethod',
    'role',
    'role_group_tasks',
    'session',
    'task'
];

# arguments
$verbs = [HTTP_METHOD_GET, HTTP_METHOD_POST];
$command = $GLOBALS['framework']->network_request[COMMAND_CMD];
$argument = $GLOBALS['framework']->network_request[COMMAND_ARG];
$username = $GLOBALS['framework']->network_request[COMMAND_USERNAME];
$token = $GLOBALS['framework']->network_request[COMMAND_TOKEN];

function PrintIfDebug($message)
{
    if (DEBUG_MODE_CONST)
    {
        $GLOBALS['framework']->Echo($message);
    }
}

if (is_null($command)
    || is_null($argument)
    || is_null($username)
    || is_null($token)
)
{
    die();
}

# authentication
$authenticated = $GLOBALS['framework']->Login($username, $token);
if ($authenticated === false) die();

# database module
const DATABASE_ALLOWED_TABLES = ['storage'];
if (mb_strtolower($command) === 'db')
{
    # domain-specific argument
    $table = $GLOBALS['framework']->network_request[COMMAND_TABLE];

    # enforce table exclusion
    if (is_null($table) || in_array($table, TABLES_EXCLUSION_LIST))
    {
        die();
    }

    # filter out the command and table
    $data = [];
    foreach ($GLOBALS['framework']->network_request as $key => $value)
    {
        if (!in_array($key, COMMANDS))
        {
            $data[$key] = $value;
        }
    }

    $result = null;

    if (mb_strtolower($argument) === 'create' || mb_strtolower($argument) === 'c')
    {
        $result['operationResult'] = $GLOBALS['framework']->db->Create($table, $data);
        $result['lastInsertedId'] = $GLOBALS['framework']->db->LastInsertedId();
    }

    if (mb_strtolower($argument) === 'read' || mb_strtolower($argument) === 'r')
    {
        $result['operationResult'] = $GLOBALS['framework']->db->Read($table, $data['id']);
    }

    if (mb_strtolower($argument) === 'update' || mb_strtolower($argument) === 'u')
    {
        $result['operationResult'] = $GLOBALS['framework']->db->Update($table, $data['id'], $data);
    }

    if (mb_strtolower($argument) === 'delete' || mb_strtolower($argument) === 'd')
    {
        $result['operationResult'] = $GLOBALS['framework']->db->Delete($table, $data['id']);
    }

    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
    die();
}