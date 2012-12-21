<?php
    // Codificação UTF-8

session_start();
require_once 'all.php';
connectDB();
$user = @$_POST['user'] or '';
$password = @$_POST['password'] or '';
$user = addslashes(trim($user));
$password = addslashes(trim($password)); // Lacking salt and md5
$res = mysql_query("SELECT login FROM user WHERE login='$user' AND password='$password'");
if (mysql_num_rows($res) == 1) {
    $_SESSION['user'] = $user;
    $_SESSION['logged'] = 1;
    header('Location:search.php');
    die();
} else {
    header('Location:index.php?error=1');
    die();
}

?>