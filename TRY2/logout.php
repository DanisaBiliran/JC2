<?php
    session_start();
    session_unset();
    session_destroy();
    header("Location: restricted.php");
    exit();
?>
