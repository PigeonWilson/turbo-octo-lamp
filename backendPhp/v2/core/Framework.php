<?php

namespace backendPhp\v2\core;

class Framework
{
    // global framework variable
    public const FRAMEWORK_IDENTIFIER = 'framework';

    // reserve some keywords
    public const DEBUG_MODE_CONST = true;
    public const HTTP_METHOD_GET = 'GET';
    public const HTTP_METHOD_POST = 'POST';
    public const COMMAND_CMD = 'cmd';
    public const COMMAND_ARG = 'arg';
    public const COMMAND_USERNAME = 'username';
    public const COMMAND_TOKEN = 'token';
    public const SESSION_TOKEN = 'session_token';
    public const COMMAND_TABLE = 'table';
    public const PACKAGE_ID = 'package_id';

    public const MODULE_AUTH = 'auth';
    public const MODULE_DB = 'db';
    public const MODULE_WHOAMI = 'whoami';
    public const MODULE_PACKAGE = 'package';

    public static function GetCommands(): array
    {
        return [
            Framework::COMMAND_CMD,
            Framework::COMMAND_ARG,
            Framework::COMMAND_USERNAME,
            Framework::COMMAND_TOKEN,
            Framework::COMMAND_TABLE];
    }

    public function GetVerbs(): array
    {
        return [Framework::HTTP_METHOD_GET, Framework::HTTP_METHOD_POST];
    }

    public function RunBasicChecks(): void
    {
        // check for valid method verb
        if (!in_array($this->network_method, $this->GetVerbs())) {
            die();
        }

        // check for table exclusions
        if (in_array($this->network_request[Framework::COMMAND_TABLE], Framework::TABLES_EXCLUSION_LIST)) {
            die();
        }
    }

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

    const TABLES_ALLOWED_LIST = ['storage'];

    // database layer
    public Db $db;

    // application variables
    public string $network_method;
    public array $network_request;
    public array $network_post;
    public array $network_get;
    public string $network_input;
    public string $network_ip;
    public string $network_userAgent;

    public static function EchoJson(string $key, mixed $value): void
    {
        header('Content-Type: application/json');
        echo json_encode([$key => $value], JSON_PRETTY_PRINT);
    }

    // register a new user
    public function Register(string $username): string
    {
        $token = $this->Random_str(256);
        $username = $username . '_' . $this->Random_str(32);
        $this->db->Create('authentication', ['username' => $username, 'token' => $token]);
        return $token;
    }

    public function Login(string $username, string $token): bool
    {
        $user = $this->db->CustomWhereClause('authentication', 'username', $username);
        if (count($user) == 1) {
            if ($user[0]->token == $token) {
                return true;
            }
        }
        return false;
    }

    public function KickOut(int $userId): void
    {
        $this->db->DeleteAllCustom('session', ['authenticationId' => $userId]);
    }

    public function Login2(string $username, string $token): string|null
    {
        $userId = $this->db->CustomWhereClause('authentication', 'username', $username)[0]->id;

        # force kick out all sessions for this user
        $this->kickOut($userId);

        $sessionToken = $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->Random_str(256);
        $user = $this->db->CustomWhereClause('authentication', 'username', $username);
        $requirement = false;
        if (count($user) == 1) {
            if ($user[0]->token == $token) {
                $requirement = true;
            }
        }

        if ($requirement) {
            $GLOBALS[Framework::FRAMEWORK_IDENTIFIER]->db->Create('session', ['authenticationId' => $user[0]->id, 'token' => $sessionToken]);
            return $sessionToken;
        }

        return null;
    }

    public function IsUserLoggedIn(int $userId): bool
    {
        $session = $this->db->CustomWhereClause('session', 'authenticationId', $userId);
        if (count($session) == 1) {
            return true;
        }
        return false;
    }

    public function WhoAmI(string $sessionToken): mixed
    {
        $session = $this->db->CustomWhereClause('session', 'token', $sessionToken);
        if (count($session) == 1) {
            $userId = $session[0]->authenticationId;
            return $this->db->Read('authentication', $userId);
        }

        return null;
    }


    public function CleanKeyValuesArray(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $result[$this->Clean($key)] = $this->Clean($value);
            if ($key != $this->clean($key)) {
                unset($result[$key]);
            }
        }
        return $result;
    }

    public function SanitizeInput(): void
    {
        $_REQUEST = $this->CleanKeyValuesArray($_REQUEST);
        $_POST = $this->CleanKeyValuesArray($_POST);
        $_GET = $this->CleanKeyValuesArray($_GET);

        $this->network_request = $_REQUEST;
        $this->network_post = $_POST;
        $this->network_get = $_GET;

        $this->network_method = $this->Clean($_SERVER['REQUEST_METHOD']);
        $this->network_input = file_get_contents('php://input');
        $this->network_ip = $this->Clean($_SERVER['REMOTE_ADDR']);
        $this->network_userAgent = $this->Clean($_SERVER['HTTP_USER_AGENT']);

        $this->RunBasicChecks();
    }

    function __construct($db_host, $db_name, $db_username, $db_password)
    {
        # require loader to be loaded
        if (!defined('PREVENT_DIRECT_FILE_ACCESS_CONST')) {
            die('Direct file access is not allowed');
        }

        $this->SanitizeInput();
        $this->db = new Db($db_host, $db_name, $db_username, $db_password);

    }

    public function Clean(string $content): string
    {
        $result = htmlspecialchars(strip_tags($content), ENT_QUOTES, 'UTF-8');
        return str_replace(['<', '>', '(', ')', ';'], '', $result);
    }

    public function Echo(string $content): void
    {
        echo $this->Clean($content);
    }

    public function Location(string $url): void
    {
        header("Location: $url");
        die();
    }

    public function GetScriptName(): string
    {
        $scriptName = $this->clean($_SERVER["SCRIPT_NAME"]);
        return substr($scriptName, strrpos($scriptName, "/") + 1);
    }

    public function Random_str
    (
        int    $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string
    {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces [] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

}
