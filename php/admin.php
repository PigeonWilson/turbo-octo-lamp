<?php
require_once 'loader.php';
session_start();
if (!isset($_SESSION['loggedin']))
{
    header('Location: ' . login_url);
    die();
}

if (isset($_REQUEST['logout']))
{
    unset($_SESSION['loggedin']);

    header('Location: ' . login_url);
    die();
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
    <title>Admin</title>
    <style>
        div {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 75vh;
        }

        body {
            margin: 0;
            padding: 0;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333333;
        }

        ul li {
            float: left;
        }

        ul li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        ul li a:hover {
            background-color: #111111;
        }
    </style>
</head>
<body>

<div>
    <ul>
        <li><a href="?logout">Logout</a></li>
    </ul>
    <h1>Administration</h1>
</div>

</html>
