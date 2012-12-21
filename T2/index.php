<?php
    // Codificação UTF-8
    // warsenal

require_once 'all.php';
printHeader();
$error = @$_GET['error'] or 0;
echo '<body id="index">';
if ($error) {
    echo "<h1>Whada shit ya doin' man!</h1>";
}
?>

<img src="images\nb.png" alt="Nigga Box"/>

<div class="index">
	<form method="post" action="login.php">
		<p>Type your username here, bro!</p>
		<input type="text" name="user"/><br/>
		<p>Type your password here, bro!</p>
		<input type="password" name="password"/><br/>
		<input type="submit" value="Login now, bro!"/>
	</form>
</div>

<div class="index">
	<a href="register.php">Click here to regista, bro!</a><br/>
</div>

<?php
printFooter();
?>