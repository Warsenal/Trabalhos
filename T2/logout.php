<?php
    // Codificação UTF-8

session_start();
session_destroy();
header('Location:index.php');
die();

?>