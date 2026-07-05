<?php
if (!defined('prevent_direct_access'))
{
    // prevent direct access to this file
    die();
}

class Loader
{
    static function GetModules() : array
    {
        $regular = [
            api_module_db,
            api_module_whoami,
            api_module_packaging
        ];
        return array_merge($regular, self::GetModulesAnonymous());
    }

// list of modules that do not require a session token
    static function GetModulesAnonymous() : array
    {
        return [
            api_module_auth,
            api_module_package,
            api_module_registration
        ];
    }

// return a list of tables that CANNOT be used by api db module
    static function GetTablesExclusionList() : array
    {
        return [
            'authentication',
            'authorization_role',
            'module',
            'modulemethod',
            'role',
            'role_group_tasks',
            'session',
            'task',
            'localization'
        ];
    }

// return a list of tables that CAN be used by api db module
    static function GetTablesAllowedList() : array
    {
        return [
            'storage'
        ];
    }

    /*
     *
     * */
    static function IsHttpVerbAllowed($verb) : bool
    {
        return in_array(mb_strtolower($verb), http_verbs_allowed);
    }
}