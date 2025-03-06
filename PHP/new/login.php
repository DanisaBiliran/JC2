<?php
    // session_start();
    require 'session_start_secure.php';
    startSecureSession();

    if (isset($_SESSION['user'])){
        header("Location: restricted.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = htmlspecialchars($_POST['username']);

        if (!empty($username)) {
            $_SESSION['user'] = $username;
            $_SESSION['last_activity'] = time();
            $_SESSION['timeout_duration'] = 5;
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            header("Location: restricted.php");
            exit();
        } else {
            echo "<script>alert('Please enter a username.'); </script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/forms.css">
    <title>Login</title>
</head>
<body>
    <?php
        if(isset($_GET['timeout'])){
            echo"<script>alert('Session expired.');</script>";
        }
        if(isset($_GET['error']) && $_GET['error'] === 'security'){
            echo "<script>alert('Session security violation.');</script>";
        }
    ?>

    <form action="" method="post">
    <h2>Login</h2>
    
    <br><br>
        <input type="text" name="username" id="username" required>
        <button type="submit" class="login-btn">Login</button>

        
    </form>
</body>
</html>