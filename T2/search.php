<?php
    // Codificação UTF-8

session_start();
require_once 'all.php';
forceLogged();
printHeader();
echo'<body id="search">';
printLogout();
echo'<h1>Nigga Search</h1>';


echo'<div class="search">';
printSearch();
echo'</div>';
printFooter();
?>