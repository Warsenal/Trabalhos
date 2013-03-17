<?php

	require_once 'Database.php';
	require_once 'View.php';
	session_start();
	
	$user = @$_POST['user'];
	$email = @$_POST['email'];
	$pass1 = @$_POST['pass1'];	$pass2= @$_POST['pass2'];
	$error= @$_GET['error'];
	$search= 0;
	
	if(isset($user)){	//Test if there is another user in the database
	
		dbConnect();
		
		$search = mysql_query("SELECT * FROM player WHERE p_user = '$user'") or die('Error'.mysql_error());
		
		if(mysql_num_rows($search)==1){

			echo('<script type="text/javascript">alert("Sorry, this user already exists please choose another user.")</script>');
		}

	}
	
	if(isset($email)){
	
		dbConnect();
		
		$search = mysql_query("SELECT * FROM player WHERE p_email = '$email'") or die('Error'.mysql_error());
		
		if(mysql_num_rows($search)==1){
			
			echo'<script type="text/javascript">alert("Sorry, but email already exists please choose another email.")</script>';
		}
	}
	
	if((isset($pass1) && isset($pass2)) && ($pass1 != $pass2)){	//Test if the pass1 and pass2 match
	
		echo('<script type="text/javascript">alert("Sorry, but the passwords are not the same.")</script>');
		@$_SESSION['user']=$user;
		@$_SESSION['email']=$email;
	}
	
	if($user != '' && ($email != '') && ($pass1 != '' && $pass2 != '') && ($pass1 == $pass2)){	//If password, login, email are ok, make the register
		
		$pass1 = md5(SAL1.$pass1.SAL2);
		
		dbConnect();
		mysql_query("INSERT INTO player(p_user, p_email, p_pass, p_expt, p_level, p_str, p_dex, p_int, p_cha, p_money) VALUES('$user', '$email', '$pass1', 14, 1, 1, 1, 1, 1, 0)") or die('Error'.mysql_error());
		echo('<script type="text/javascript">alert("Registration successfully performed! =)")</script>');
		
		@$_SESSION['user']=$user;
		header("Location: Index.php");
		exit();
	}
	
	pHeader();
	
	echo('
		
		<div id="signupTop">
			<img src="Assets/signup.png" alt="SignUP"/>
		</div>
		
		<div id="signupMid">		
			<form action="SignUp.php" method="post">
				Login <input type="text" name="user" value="'.@$_SESSION['user'].'"/><br/>
				Email <input type="text" name="email" value="'.@$_SESSION['email'].'"/>
				Password <input type="password" name="pass1"/><br/>
				Confirm Password <input type="password" name="pass2"/><br/>
				<br/>
				<input type="submit" value="Register!"/>
			</form>
		</div>
		
		<br/>
		
		<div id="signupBot">
			<form action="Index.php">
				<input type="submit" value="Cancel"/>
			</form>
		</div>
	');
	
	pFooter();
?>