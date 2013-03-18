<?php

	require_once 'Database.php';
	session_start();
	dbConnect();
	
	function doCharacterSave(){

		$p_id = $_SESSION['id'];	$p_atr = $_GET['p_atr'];
		$p_str = $_GET['p_str'];	$p_dex = $_GET['p_dex'];	$p_int = $_GET['p_int'];	$p_cha = $_GET['p_cha'];
				
		mysql_query("UPDATE player SET p_attribute = '$p_atr', p_str = '$p_str', p_dex = '$p_dex', p_int = '$p_int', p_cha = '$p_cha' WHERE p_id = '$p_id'") or die ('Error'.mysql_error());
		
		echo"Save Sucessful!";
	}
	
	doCharacterSave();
?>