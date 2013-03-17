<?php

	require_once 'Database.php';
	session_start();
	
	$user=$_POST['user'];
	$pass=$_POST['pass1'];

	dbConnect();
	
	$pass = md5(SAL1.$pass.SAL2);

	$query = mysql_query("SELECT * FROM player WHERE p_user='$user' AND p_pass='$pass'") or die('Error'.mysql_error()); //Get all information about player
	
	if(mysql_num_rows($query)==1){ //test if the player is registered
	
		$_SESSION['login']=true;
		
		while($data = mysql_fetch_array($query)){
		
			$_SESSION['id'] = $data['p_id'];
			$_SESSION['user'] = $data['p_user'];
		}
		
		header("Location: game.php");
		exit();
		
	} else {
	
		header("Location: index.php?error=1");
		exit();
	}
	
?>