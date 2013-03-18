<?php

	require_once 'view.php';
	session_start();
	
	$error = @$_GET['error'];
	
	pHeader();

	if(isset($error)){
		echo"Password or Username are incorrect, try again! Verify if caps lock is activated.";
	}
	
	echo'
		<div id="indexUp">
			<img src="assets/Logo.jpg" alt="Medieval Adventure"/>
		</div>

		</br>
		
		<div id="indexMid">
			<form action="signIn.php" method="post">
				Login: <input type="text" name="user" value="'.@$_SESSION['user'].'"/> Password: <input type="password" name="pass1"/><br>
				<input type="submit" value="SignIn!">
			</form>
		</div>
		
		</br>
		
		<div id="indexBot">
			<form action="signUp.php" method="post">
				<input type="submit" value="SignUp!">
			</form>
		</div>
	';
	
	pFooter();
?>