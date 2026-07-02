<?php
class Engine
{
    public Database $database;

    public function __construct(string $host, string $dbname, string $username, string $password)
    {
        $this->database = new Database($host, $dbname, $username, $password);
    }

    public static function CleanKeyValuesArray(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $result[Engine::Clean($key)] = Engine::Clean($value);
            if ($key != Engine::Clean($key)) {
                unset($result[$key]);
            }
        }
        return $result;
    }

    public static function GetScriptName(): string
    {
        $scriptName = Engine::Clean($_SERVER["SCRIPT_NAME"]);
        return substr($scriptName, strrpos($scriptName, "/") + 1);
    }

    public static function Clean(string $content): string
    {
        $result = htmlspecialchars(strip_tags($content), ENT_QUOTES, 'UTF-8');
        return str_replace(['<', '>', '(', ')', ';'], '', $result);
    }

    public static function Random_str
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

    public static function SanitizeInput(): void
    {
        if (isset($_REQUEST)) $_REQUEST = Engine::CleanKeyValuesArray($_REQUEST);
        if (isset($_POST)) $_POST = Engine::CleanKeyValuesArray($_POST);
        if (isset($_GET)) $_GET = Engine::CleanKeyValuesArray($_GET);
        if (isset($_SERVER['REQUEST_METHOD'])) Engine::Clean($_SERVER['REQUEST_METHOD']);
        if (isset($_SERVER['REMOTE_ADDR'])) Engine::Clean($_SERVER['REMOTE_ADDR']);
        if (isset($_SERVER['HTTP_USER_AGENT'])) Engine::Clean($_SERVER['HTTP_USER_AGENT']);
    }
}