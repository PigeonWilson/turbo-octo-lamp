<?php
if (!defined('prevent_direct_access'))
{
    // prevent direct access to this file
    die();
}

class Loader
{
    static function GenerateProjectConstants(string $fullNamePath, Engine &$engine) : void
    {
        $instance_information = $engine->database->ReadAll('instance_information');
        $content = '<?php ' . PHP_EOL;
        $content .= '/* This file is auto-generated */' . PHP_EOL;
        $content .= 'const project_name = ' . '"' . $instance_information[0]->project_name . '"' . ';' . PHP_EOL;
        $content .= 'const project_version = ' . '"' . $instance_information[0]->project_version . '"' . ';' . PHP_EOL;
        $content .= 'const project_email_contact = ' . '"' . $instance_information[0]->project_email_contact . '"' . ';' . PHP_EOL;
        $content .= 'const source_code_link = ' . '"' . $instance_information[0]->source_code_link . '"' . ';' . PHP_EOL;
        $content .= 'const project_documentation_link = ' . '"' . $instance_information[0]->project_documentation_link . '"' . ';' . PHP_EOL;
        $content .= 'const project_manifest_link = ' . '"' . $instance_information[0]->project_manifest_link . '"' . ';' . PHP_EOL;
        $content .= 'const project_rules_link = ' . '"' . $instance_information[0]->project_rules_link . '"' . ';' . PHP_EOL;
        $content .= 'const project_multimedia_credits_link = ' . '"' . $instance_information[0]->project_multimedia_credits_link . '"' . ';' . PHP_EOL;
        $content .= 'const project_default_lang = ' . '"' . $instance_information[0]->project_default_lang . '"' . ';' . PHP_EOL;
        $content .= 'const debug_mode = ' . $instance_information[0]->debug_mode . ';' . PHP_EOL;
        $content .= '?>';
        file_put_contents($fullNamePath, $content);
    }

    static function GenerateModuleConstants(string $fullNamePath, Engine &$engine) : void
    {
        # Generate a constant file for all modules
        $modules = $engine->database->ReadAll('instance_module');
        $content = '<?php ' . PHP_EOL;
        $content .= '/* This file is auto-generated */' . PHP_EOL;
        foreach ($modules as $module)
        {
            $content .= '/* ' . $module->description . '*/' . PHP_EOL;
            $content .= 'const ' . $module->prefix . $module->name . ' = ' . '"' . $module->name . '"' . ';' . PHP_EOL;
            $content .= PHP_EOL;
        }
        $content .= '?>';
        file_put_contents($fullNamePath, $content);
    }

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
            'cache',
            'session',
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