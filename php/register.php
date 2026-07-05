<?php
require_once 'loader.php';
session_start();
unset($_SESSION['message']);
$_SESSION['username_prefix'] = '_' . Engine::Random_str(15);
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
    <title>Nouveau compte</title>
    <link rel="stylesheet" href="css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <style>
        fieldset {
            color: white;
            font-weight: bold;
            background-color: rgba(0, 0, 0, 0.5);
        }

        fieldset a{
            color: white;
        }
        body {
            /*
            image source credits https://unsplash.com/illustrations/colorful-geometric-shapes-arranged-in-a-square-pattern-SapDyXZWi7o
            */
            background-image: url("../images/background.jpg");
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>

<?php require_once 'header_public.php';?>


<main>
    <div id="form">
        <fieldset>
            <legend>Nouveau compte</legend>
            <form action="?" method="post">
                <input type="hidden" name="<?php echo web_csrf; ?>" value="<?php echo $_SESSION[web_csrf];?>">
                <input type="hidden" name="action" value="register">
                <input required type="text" name="username" placeholder="Nom d'utilisateur">
                <input required disabled type="text" name="suffix" value="<?php echo $_SESSION['username_prefix']; ?>">
                <input type="submit" value="Soumettre">
            </form>
            <p>
                Note: Le compte ne sera pas activé tant qu'il n'a pas été validé par un administrateur.
            </p>
            <p>
                Contact: <a href="mailto:<?php echo project_email_contact; ?>"><?php echo project_email_contact; ?></a>
            </p>
        </fieldset>

    </div>
</main>

<?php require_once 'footer_public.php'; ?>

</body>
</html>
