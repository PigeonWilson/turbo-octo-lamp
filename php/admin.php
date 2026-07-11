<?php
require_once 'loader.php';
session_start();

if (!isset($_SESSION[web_csrf])) {
    $_SESSION[web_csrf] = bin2hex(random_bytes(64));
}

if (!isset($_SESSION[web_session_loggedIn]))
{
    header('Location: ' . web_login_url);
    die();
}

if (isset($_REQUEST['logout']))
{
    unset($_SESSION[web_session_loggedIn]);
    $_SESSION['message'] = "Vous avez été déconnecté.";
    header('Location: ' . web_login_url);
    die();
}
?>
<!DOCTYPE html>
<html lang="<?php echo project_default_lang; ?>">
<head>
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div  class="container">
        <ul class="heading">
            <li><a href="?Users">Utilisateurs</a></li>
            <li><a href="?logout">Déconnexion</a></li>
        </ul>
    </div>
</header>

<main class="container container-main">

    <?php if(isset($_SESSION['message'])) { ?>
        <div class="message"><?php echo $_SESSION['message']; ?></div>
    <?php unset($_SESSION['message']); } ?>

    <h1>Administration</h1>

    <?php if(isset($_REQUEST['Users'])){ ?>
        <hr/>
        <h2>Utilisateurs</h2>

        <table>
            <tr>
                <th>commande</th>
                <th>nom d'utilisateur</th>
                <th>jeton</th>
            </tr>

        <?php
        $users = $project_engine->database->ReadAll('authentication');
        foreach ($users as $user) {
        ?>
                <tr>
                    <td>
                        <form action="?Users" method="post">
                            <input type="hidden" name="<?php echo web_csrf; ?>" value="<?php echo $_SESSION[web_csrf]; ?>">
                            <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                            <input type="submit" value="Supprimer">
                        </form>

                        <form action="?Users" method="post">
                            <input type="hidden" name="<?php echo web_csrf; ?>" value="<?php echo $_SESSION[web_csrf]; ?>">
                            <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                            <input type="submit" value="réinitialiser jeton">
                        </form>

                        <form action="?Users" method="post">
                            <input type="hidden" name="<?php echo web_csrf; ?>" value="<?php echo $_SESSION[web_csrf]; ?>">
                            <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                            <input type="submit" value="Désactiver">
                        </form>
                    </td>
                    <td>
                        <form action="?Users" method="post">
                            <input type="hidden" name="<?php echo web_csrf; ?>" value="<?php echo $_SESSION[web_csrf]; ?>">
                            <input class="input" required type="text" value="<?php echo $user->username; ?>">
                            <input type="submit" value="Modifier">
                        </form>

                    </td>
                    <td><?php echo $user->token; ?></td>
                </tr>
        <?php } ?>

        </table>

    <?php } ?>

</main>



<?php require_once 'footer_public.php'; ?>

</html>
