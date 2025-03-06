<?php
    session_start();

    if(isset($_SESSION['user'])){
        header("Location: restricted.php");
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = htmlspecialchars($_POST['username']);

        if(!empty($username)){
            $_SESSION['user'] = $username;
            header("Location: restricted.php");
            exit();
        } else{
            echo "<script>alert('Enter Username')</script>";
        }
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
    <form action="" method="post">
        <input type="text" name="username" id="username">
        <input type="submit" value="Login">
    </form>
</body>
</html>