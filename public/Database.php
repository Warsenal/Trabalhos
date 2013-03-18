<?php

	define('SAL1', 'huehue');
	define('SAL2', 'brbr');

	//$senha = md5($_POST['senha'] . SAL); // 32 chars

	function dbConnect(){
		mysql_connect("localhost", "root", "") or die('Erro'.mysql_error());
		mysql_select_db("medieval_adventure") or die('Erro'.mysql_error());
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