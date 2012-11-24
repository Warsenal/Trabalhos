<?php
/* Codificação UTF-8 */

$mySession = array();
$mySessionStr = '';

function echoHeader($time = 0, $target = '') {
    ?>
    <?php
//$_SERVER['PHP_SELF'];

    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" ';
    echo '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
    echo '<html xmlns="http://www.w3.org/1999/xhtml">';
    echo "<head>";
    if ($time != 0) {
        echo "<meta http-equiv=\"refresh\" content=\"$time;URL='$target'\" />";
    }
    echo '<title>Sheety Tic-tac-toe</title>';
    echo '<link rel="stylesheet" type="text/css" href="css/ttt.css" media="screen" />';
    echo '</head><body>';
    
    
    //<p>Isto está no topo</p>
}

function echoFooter() {
    //Isto estah embaixo
    ?>
    </body></html>
    <?php
}

function echoMenu() {
    ?>
    <?php
}

function my_session_start() {
    global $mySession;
    global $mySessionStr;

    //file_get_contents()
    $sessionid = '';
    if (isset($_COOKIE['sessionid']))
        $sessionid = $_COOKIE['sessionid'];
    if ($sessionid != '') {
        $str = FALSE;
        @$str = file_get_contents($sessionid);
        if (!$str) {
            $sessionid = '';
        } else {
            $mySessionStr = $str;
            $mySession = unserialize($str);
        }
    } 
    if ($sessionid === '') {
        $sessionid = tempnam('tmp', '');
        $_COOKIE['sessionid'] = $sessionid;
        setcookie('sessionid', $sessionid);
    }
    register_shutdown_function('my_session_end');
}

function my_session_end() {
    global $mySession;
    global $mySessionStr;
    if (isset($_COOKIE['sessionid'])) {
        $sessionid = $_COOKIE['sessionid'];
        $str = serialize($mySession);
        if ($str !== $mySessionStr) {
            file_put_contents($sessionid, $str);
        }
        unset($_COOKIE['sessionid']);
    }
}

function my_session_destroy() {
    global $mySession;
    if (isset($_COOKIE['sessionid'])) {
        $sessionid = $_COOKIE['sessionid'];
        unlink($sessionid);
        unset($_COOKIE['sessionid']);
        //$str = serialize($mySession);
        //file_put_contents($sessionid, $str);
    }
}

?>
