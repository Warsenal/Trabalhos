<?php
    // Codificação UTF-8
    
function printHeader() {
    //echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
    echo '<!DOCTYPE html>';
    echo '<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
    echo '<title>Nigga box</title>';
    echo '<link rel="stylesheet" type="text/css" href="nigga.css" />';
    echo '</head>';

}

function printFooter() {
    echo '</body></html>';
}

function printSearch() {
?>
<form method="get" action="result.php">
    <p>Type your search here, bro!</p>
    <input type="text" name="search" placeholder="e.g.: Imagine, by John Lennon"/>
    <input type="submit" value="Go get it, bro!"/>
</form>
<?php
}

function printLogout() {
?>
    <p><a href="logout.php">Logout this fuckin shit by clinkin here, bro!</a></p>
<?php
}

function forceLogged() {
    $logged = @$_SESSION['logged'] or FALSE;
    if ($logged != 1) {
        header('Location:index.php?error=1');
        die();
    }
}

function connectDB() {
    $link = mysql_connect('niggabox-db.my.phpcloud.com', 'niggabox', 'batata44');
    if (!$link) {
        $link = mysql_connect('localhost', 'nigga', 'nigga');
        if (!$link)
            die();
    }
    $db_selected = mysql_select_db('niggabox', $link);
    if (!$db_selected) {
        $db_selected = mysql_select_db('nigga', $link);
    }
}

?>