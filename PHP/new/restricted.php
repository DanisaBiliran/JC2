<?php
    // session_start();
    require 'session_start_secure.php';
    startSecureSession();

    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    }

    if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']){
        session_unset();
        session_destroy();
        header("Location: login.php?error-security");
        exit();
    }

    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['timeout_duration'])){
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
    <meta name="viewport" content="width=h2, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
    <!-- <p>You have successfully logged in. You cannot access the login page anymore unless you log out.</p> -->
    <p>Secure session is active. If you remain inactive for 5 minutes, you will be logged out automatically.</p>
    <a href="logout.php">Logout</a>
</body>
</html>