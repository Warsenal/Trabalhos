<?php

	@session_start();

	if($_SESSION['login']!=true){
	
		header("Location: index.php");
		exit();
	}
	
	echo'
		<div id=equipmentTop>
			Coming Soon! :)
		</div>
	';
?>