<?php
	
	require_once "database.php";
	session_start();
	
	if($_SESSION['login']!=true){
	
		header("Location: index.php");
		exit();
	}
	
	$p_id = $_SESSION['id'];
	
	dbConnect();
	$query = mysql_query("SELECT * FROM inventory WHERE p_id = '$p_id'") or die ('Error'.mysql_error());
	
	if(mysql_num_rows($query)>=1){
		
		while($data = mysql_fetch_array($query)){
			echo"<img src=\"assets/i_0".$data['i_id'].".png\">"; echo" ".$data['i_name']." ".$data['i_qt'];
		}
	} else {
		echo"You Don't Have Itens, Try to do some Jobs to get Itens! :)";
	}
?>