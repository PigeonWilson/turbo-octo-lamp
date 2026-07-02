<?php
require_once 'loader.php';
session_start();

if (isset($_SESSION['loggedin']))
{
    header('Location: ' . admin_url);
    die();
}

if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(64));
}

if (
        isset($_REQUEST['action'])
        && isset($_REQUEST['password'])
        && isset($_REQUEST['csrf'])
        && $_REQUEST['action'] === 'login'
        && $_REQUEST['csrf'] === $_SESSION['csrf'])
{


    $data =
            [
                    api_cmd => api_module_auth,
                    api_token => $_REQUEST['password']
            ];

    $response = sendHttpQuery(api_url, $data);
    $data = json_decode($response);

    try
    {
        if ($data->result->session_token !== null)
        {

            $_SESSION['loggedin'] = true;
            $_SESSION[api_session_token] = $data->result->session_token;
            unset($_SESSION['csrf']);
            header('Location: ' . admin_url);
            die();
        }
    }catch (Exception $e){die();}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        div {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 75vh;
        }
    </style>
</head>
<body>

    <div>
        <fieldset>
            <legend>Login</legend>
            <form action="login.php" method="post">
                <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf'];?>">
                <input type="hidden" name="action" value="login">
                <input type="password" name="password" placeholder="Password">
                <input type="submit" value="Login">
            </form>
        </fieldset>
    </div>

</html>