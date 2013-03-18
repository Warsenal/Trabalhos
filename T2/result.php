<?php
    // Codificação UTF-8
session_start();
require_once 'all.php';

function splitSongBand($search, &$song, &$band) {
    //$pos = strpos($search, ', by');
    //$song = trim(substr($search, 0, $pos));
    //$band = trim(substr($search, $pos + 4));
    //
    $keywords = preg_split("/\,[\s]+by[\s]+/", $search);
    
    
    if (!isset($keywords[0]) || !isset($keywords[1]))
        return FALSE;
    else {
        $song = trim($keywords[0]);
        $band = trim($keywords[1]);
        return TRUE;
    }
    /*
    
    echo $band;
    echo '<br/>';
    echo $song;
    echo '$$';
    echo $keywords[0];
    echo '$$';
    echo $keywords[1];
    echo '$$';
    die();
    */    
}
/*
function splitSongBand($search, &$song, &$band) {
    $pos = strpos($search, ', by');
    $song = trim(substr($search, 0, $pos));
    $band = trim(substr($search, $pos + 4));
}
*/

function replacePlusForWhite($str) {
    return preg_replace('/\s+/', '+', $str);
}

function removeWhite($str) {
    return preg_replace('/\s+/', '', $str);
}

/*====================================
 * Loads all the necessary like
 * button stuff
 *==================================*/
function prepareLikes() {
    ?>
    <!-- Facebook like button loading -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <?php
}

/*====================================
 * Prints the video
 *==================================*/
function printVideo($songPlus, $bandPlus) {
    echo "<div id=\"video\">";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://gdata.youtube.com/feeds/api/videos?q=%22$bandPlus%22+%22$songPlus%22&max-results=1&v=2");
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $body = curl_exec($ch);
    $a = strpos($body, 'video:');
    $b = strpos($body, '</id>', $a);
    $c = substr($body, $a + 6, $b - $a - 6);
    echo "<iframe width=\"533\" height=\"400\" src=\"http://www.youtube.com/embed/$c\"></iframe>";
    echo "</div>";
    curl_close($ch);
}

/*====================================
 * Prints the song lyrics
 *==================================*/
function printLyrics($songPlus, $bandPlus) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://www.lyrics007.com/search.php?q=$songPlus+$bandPlus");
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $body = curl_exec($ch);
    $a = strpos($body, 'No Results for');
    if ($a === FALSE) {
        $a = strpos($body, '<a href="click.php?url=');
        $b = strpos($body, '" target="_blank"><strong>', $a);
        $c = substr($body, $a + 23, $b - $a  - 23);
        curl_close($ch);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $c);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $body = curl_exec($ch);
        $a = strpos($body, 'rm_artist = ');
        $a = strpos($body, '</script>', $a);
        $b = strpos($body, '<script', $a);
        $c = substr($body, $a + 9, $b - $a - 9);
        echo "<div id=\"lyrics\">";
        echo "<p>Lyrics</p>";
        echo $c;
        echo "</div>";
    }
    curl_close($ch);
}

/*====================================
 * Prints social networks "like" buttons
 *==================================*/
function printLikes() {
    ?>
    <div id="likes">
		<!-- Facebook like -->
		<div class="fb-like" data-href="http://niggabox.my.phpcloud.com/" data-send="true" data-width="450" data-show-faces="true"></div>
		<!-- Tweeter like -->
        <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://niggabox.my.phpcloud.com/">Tweet</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;
        js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<!-- Google Plus: Tag for +1 button -->
		<g:plusone></g:plusone>
		<!-- Google Plus: stuff -->
		<script type="text/javascript">
			window.___gcfg = {lang: 'en-US'};
			(function() {
				var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				po.src = 'https://apis.google.com/js/plusone.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			})();
		</script>
    </div>
    <?php
}

/*====================================
 * Prints all the top albums
 *==================================*/
function printAlbums($html) {
    echo "<div id=\"albums\">";
    echo "<p>Top albums</p>";
    $alpos = -1;
    // Iterate over the albums
    for (;;) {
        $alpos = strpos($html, '<section class="r album-item', $alpos + 1);
        if (!$alpos)
            break;
        // Find the album name
        $namepos = strpos($html, '<meta content="', $alpos) + 15;
        $pos = strpos($html, '"', $namepos);
        $name = substr($html, $namepos, $pos - $namepos);        
        // Find the album picture
        $picpos = strpos($html, '<meta content="', $namepos + 1) + 15;
        $pos = strpos($html, '"', $picpos);
        $pic = substr($html, $picpos, $pos - $picpos);
        echo "<p>$name</p>";
        echo "<img src=\"$pic\" alt=\"Album cover\" />";
    }
    echo "</div>";
}

/*====================================
 * Prints biography
 *==================================*/
function printBiography($html) {
    $a = strpos($html, '<div class="wiki-text">');
	if($a !== FALSE){
		$b = strpos($html, '</div>', $a);
		$c = substr($html, $a + 23, $b - $a - 23);
		echo "<div id=\"info\">";
		echo "<p>Biography</p>";
		echo strip_tags($c);
		echo "</div>";
	}
}

/*====================================
 * Prints last.fm info
 *==================================*/
function printInfo($songPlus, $bandPlus) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.last.fm/search?q=$bandPlus&type=artist");
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $body = curl_exec($ch);
    curl_close($ch);
    $a = strpos($body, '/music/');
    $b = strpos($body, '"', $a);
    $c = substr($body, $a + 7, $b - $a - 7);
    if ($c != '+free-music-downloads') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.last.fm/music/$c");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $html = curl_exec($ch);
        printBiography($html);
        printAlbums($html);
        curl_close($ch);
    }
}

function printTitle($song, $band) {
    echo '<div id="title">';
    echo '<p>' . ucwords(strtolower($song)) . ' - ';
    echo ucwords(strtolower($band)) . '</p>';
    echo '</div>';
}

/*====================================
 * Run the main website code
 *==================================*/
function main() {
    forceLogged();
    printHeader();
	echo'<body id="result">';
    printLogout();
    printSearch();
    $search = @$_GET['search'] or '';
    $song = '';
    $band = '';
    if (!splitSongBand($search, $song, $band)) {
        echo "<p>Please search for \"Song name\", by \"Band name\", bro!</p>";
        return;
    }
    prepareLikes();
    $songPlus = replacePlusForWhite($song);
    $bandPlus = replacePlusForWhite($band);
    $bandRem = removeWhite($band);
    // Background image for main div
    echo "<div style=\"background-image:url('http://$bandRem.jpg.to');\">";
    printVideo($songPlus, $bandPlus);
    printTitle($song, $band);
    printLikes();
    printLyrics($songPlus, $bandPlus);
    printInfo($songPlus, $bandPlus);
    echo "</div>";
}

/* Run */
main();

/* Print the footer */
printFooter();
?>