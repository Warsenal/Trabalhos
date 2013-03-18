<?php

	require_once 'View.php';
	session_start();
	
	$error = @$_GET['error'];
	
	pHeader();

	if(isset($error)){
		echo"Password or Username are incorrect, try again! Verify if caps lock is activated.";
	}
	
	echo'
		<div id="indexUp">
			<img src="Assets/Logo.jpg" alt="Medieval Adventure"/>
		</div>

		</br>
		
		<div id="indexMid">
			<form action="SignIn.php" method="post">
				Login: <input type="text" name="user" value="'.@$_SESSION['user'].'"/> Password: <input type="password" name="pass1"/><br>
				<input type="submit" value="SignIn!">
			</form>
		</div>
		
		</br>
		
		<div id="indexBot">
			<form action="SignUp.php" method="post">
				<input type="submit" value="SignUp!">
			</form>
		</div>
	';
	
	pFooter();
?>