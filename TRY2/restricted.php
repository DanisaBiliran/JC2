<?php
    require 'session_secure.php';
    startSecureSession();

    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    }

    if($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']){
        session_unset();
        session_destroy();
        header("Location: login.php?error=security");
        exit();
    }

    if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['timeout_duration'])){
        session_unset();
        session_destroy();
        header("Location: login.php?timeout=1");
        exit();
    }

    $_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restricted Page</title>
</head>
<body>
    <h2>WELCOME</h2>
    <p>This is restricted page.</p>
    <button onclick="window.location.href='logout.php'">Logout</button>
</body>
</html>