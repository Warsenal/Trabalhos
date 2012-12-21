<?php
    // Codificação UTF-8

session_start();
require_once 'all.php';

$user = @$_POST['user'] or '';
$pass1 = @$_POST['password1'] or '';
$pass2 = @$_POST['password2'] or '';

$user = trim($user);
$pass1 = trim($pass1);
$pass2 = trim($pass2);

$error = FALSE;

if ($user != '' && $pass1 != '') {
    if ($pass1 == $pass2) {
        connectDB();
        mysql_query("INSERT INTO user (login, password) VALUES ('$user', '$pass1')");
        if (mysql_affected_rows() == 1) {
            mysql_close();
            $_SESSION['logged'] = 1;
            $_SESSION['user'] = $user;
            header('Location:search.php');
            die();
        }
        mysql_close();
        $error = TRUE;
    }
}

printHeader();
echo '<body id="register">';
if ($error) {
    echo '<p>Registering error, bro!</p>';
}
?>
<h1>Fuckin Nigga Register</h1>
<div class="register">
	<form method="post" action="register.php">
		<p>Type da username ya wishe to use here, bro!</p>
		<input type="text" name="user" value="<?php echo $user; ?>"/>
		<p>Type da password ya wishe to use here, bro!</p>
		<input type="password" name="password1"/>
		<p>Retype da password ya wishe to use here, bro!</p>
		<input type="password" name="password2"/><br/><br/>
		<input type="submit" value="Register this fuckin mess now, bro!"/>
	</form>
</div>

<?php
printFooter();
?>