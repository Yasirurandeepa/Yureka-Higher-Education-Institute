<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['logged']);
session_destroy();
echo "Sesstion Destroyed";
header("Location: login.php");
exit();
?>