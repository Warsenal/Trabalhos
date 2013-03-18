<?php

	if($_SESSION['login']!=true){
	
		header("Location: index.php");
		exit();
	}


	define('SAL1', 'huehue');
	define('SAL2', 'brbr');

	//$senha = md5($_POST['senha'] . SAL); // 32 chars

	function dbConnect(){
	
	if ($_SERVER['DOCUMENT_ROOT'] === 'C:/Users/User/Documents/xampp/htdocs') {
			$hostname = 'localhost';
			$username= 'root';
			$password = '';
			$dbname= 'medieval_adventure';
		} else {
			$hostname = 'madv-db.my.phpcloud.com';
			$username= 'madv';
			$password = 'd237h848';
			$dbname= 'madv';
		}
		
		mysql_connect($hostname, $username, $password) or die('Erro'.mysql_error());
		mysql_select_db($dbname) or die('Erro'.mysql_error());
	
	}
	
	function dbQuery($query){
		
		($search = mysql_query($query)) or die('Error'.mysql_error());
		return $search;
	}
	
	function dbSearchId(){
	
		mysql_query("SELECT * FROM player WHERE p_user = '$user'") or die('Error'.mysql_error());
	}
	
	function dbSignIn(){
	
		$search = mysql_query("SELECT * FROM player WHERE p_user='$id' AND p_pass='$pass'") or die('Error'.mysql_error());
	}
	
	function dbSignUp(){
	
		mysql_query("INSERT INTO player (p_user, p_pass) VALUES ('$user', '$pass1')") or die('Error'.mysql_error());
	}
?>