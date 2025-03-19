<?php
    require 'session_secure.php';
    startSecureSession();

    if(isset($_SESSION['user'])){
        header("Location: restricted.php");
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = htmlspecialchars($_POST['username']);

        if(!empty($username)){
            $_SESSION['user'] = $username;
            $_SESSION['last_activity'] = time();
            $_SESSION['timeout_duration'] = 10;
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            header("Location: restricted.php");
            exit();
        }
    } else{
        echo"<script>alert('enter username');</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
        if(isset($_GET['timeout'])){
            echo"<script>alert('timeout');</script>";
        }

        if(isset($_GET['error']) && $_GET['error'] === 'security'){
            echo"<script>alert('error');</script>";
        }
    ?>

    <form action="" method="post">
        <h2>Login</h2>
        <input type="text" name="username" id="username">
        <input type="submit" value="Login">
    </form>
</body>
</html>