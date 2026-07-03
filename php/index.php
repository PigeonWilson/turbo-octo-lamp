<?php
require_once 'loader.php';
session_start();
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
    <title>Bonjour</title>
    <link rel="stylesheet" href="css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>

<?php require_once 'header_public.php'; ?>

<?php if(isset($_SESSION['message'])): ?>
    <div class="message">
        <p>
            <?php echo $_SESSION['message']; ?>
        </p>
    </div>
<?php endif; ?>

<hr/>

<main class="container container-main">
    <h1>BONJOUR</h1>

    <hr/>

    <h2>Quoi de neuf?</h2>

    <hr/>

    <h2>Versions</h2>

    <hr/>
</main>

<?php require_once 'footer_public.php'; ?>

</body>
</html>
