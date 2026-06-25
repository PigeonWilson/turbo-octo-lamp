<?php
class Framework
{
    // database layer
    public Db $db;
    public string $network_method;
    public array $network_request;
    public array $network_post;
    public array $network_get;
    public string $network_input;
    public string $network_ip;
    public string $network_userAgent;

    public function Register(string $username) : string
    {
        $token = $this->Random_str(256);
        $username = $username . '_' .  $this->Random_str(32);
        $this->db->Create('authentication', ['username' => $username, 'token' => $token]);
        return $token;
    }

     public function Login(string $username, string $token) : bool
     {
         $user = $this->db->CustomWhereClause('authentication', 'username', $username);
         if (count($user) == 1)
         {
             if ($user[0]->token == $token)
             {
                 return true;
             }
         }
         return false;
     }

    public function SanitizeInput() : void
    {
        foreach ($_REQUEST as $key => $value)
        {
            $key = $this->Clean($key);
            $_REQUEST[$key] = $this->Clean($value);

            if ($key != $this->clean($key))
            {
                unset($_REQUEST[$key]);
            }
        }

        foreach (array_keys($_POST) as $key)
        {
            $_POST[$key] = $this->clean($_POST[$key]);

            if ($key != $this->clean($key))
            {
                unset($_POST[$key]);
            }
        }

        foreach (array_keys($_GET) as $key)
        {
            $_GET[$key] = $this->clean($_GET[$key]);

            if ($key != $this->clean($key))
            {
                unset($_GET[$key]);
            }
        }

        $this->network_request = $_REQUEST;
        $this->network_post = $_POST;
        $this->network_get = $_GET;

        $this->network_method = $this->Clean($_SERVER['REQUEST_METHOD']);
        $this->network_input = file_get_contents('php://input');
        $this->network_ip = $this->Clean($_SERVER['REMOTE_ADDR']);
        $this->network_userAgent = $this->Clean($_SERVER['HTTP_USER_AGENT']);
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

    public function Clean(string $content) : string
    {
        $result = htmlspecialchars(strip_tags($content), ENT_QUOTES, 'UTF-8');
        return str_replace(['<', '>','(',')',';'], '', $result);
    }

    public function Echo(string $content) : void
    {
        echo $this->Clean($content);
    }

    public function Location(string $url) : void
    {
        header("Location: $url");
        die();
    }

    public function GetScriptName() : string
    {
        $scriptName = $this->clean($_SERVER["SCRIPT_NAME"]);
        return substr($scriptName,strrpos($scriptName,"/")+1);
    }

    public function Random_str
    (
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i)
        {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

}
