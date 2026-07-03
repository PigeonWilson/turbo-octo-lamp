<?php
require_once 'loader.php';
session_start();

if (isset($_SESSION[web_session_loggedIn])
            && $_SESSION[web_session_loggedIn] === true)
{
    header('Location: ' . admin_url);
    die();
}

if (!isset($_SESSION[web_csrf])) {
    $_SESSION[web_csrf] = bin2hex(random_bytes(64));
}

if (
        isset($_REQUEST['action'])
        && isset($_REQUEST['password'])
        && isset($_REQUEST[web_csrf])
        && $_REQUEST['action'] === 'login'
        && $_REQUEST[web_csrf] === $_SESSION[web_csrf])
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
            $_SESSION[web_session_loggedIn] = true;
            $_SESSION[api_session_token] = $data->result->session_token;
            unset($_SESSION[web_csrf]);
            header('Location: ' . admin_url);
            die();
        }
    }catch (Exception $e){die();}
}
?>
<!DOCTYPE html>
<html lang="<?php echo web_lang; ?>">
<head>
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

</head>
    <body>

    <?php require_once 'header_public.php';?>

    <?php if(isset($_SESSION['message'])): ?>
    <div class="message">
        <p>
            <?php echo $_SESSION['message']; ?>
        </p>
    </div>
    <?php endif; ?>

    <hr/>

    <main>
        <div id="form">
            <fieldset>
                <legend>Connexion</legend>
                <form action="?" method="post">
                    <input type="hidden" name="<?php echo web_csrf; ?>" value="<?php echo $_SESSION[web_csrf];?>">
                    <input type="hidden" name="action" value="login">
                    <input required type="password" name="password" placeholder="Mot de passe">
                    <input type="submit" value="Soumettre">
                </form>
                <p>
                    Vous n'avez pas de compte ? <a href="register.php">Inscrivez-vous</a>
                </p>
            </fieldset>
        </div>
    </main>



    <?php require_once 'footer_public.php'; ?>

    </body>
</html>