<?php
/* Codificação UTF-8 */
    require_once 'lib/lib.php';
    echoHeader();
    echoMenu();
    if (isset($_REQUEST['err'])) {
        $err = $_REQUEST['err'];
        echo '<p>';
        if ($err == 1) {
            echo "Player name can't be empty";
        } else if ($err == 2) {
            echo 'Game is already full';
        }
        echo '</p>';
    }
    $gameName = '';
    if (isset($_REQUEST['game'])) {
        $gameName = $_REQUEST['game'];
        echo "<p>Join game $gameName</p>";
    }
?>
        <form action="play.php<?php
            if (isset($_REQUEST['game'])) {
                echo "?game=$gameName";
            }
        ?>" method="post">
			<h1> Tic - Tac - Toe</h1>
            <h3 id="index_p">Type your name:</h3><p><input name="name" type="text" /></p>
            <p><input value="<?php
                if (isset($_REQUEST['game']))
                    echo 'Join game';
                else
                    echo 'Create game';
            ?>" type="submit" /></p>
        </form>
<?php
    function listRanking() {
        $i = 0;
        echo "<table class='ranking'>";
        echo "<tr><td colspan='3'>Ranking</td></tr>";
        $str = FALSE;
        @$str = file_get_contents('games/ranking.txt');
        if (!$str) {
            $ranking = array();;
        } else {
            $ranking = unserialize($str);
        }
        echo "<tr><th>Order</th><th>Name</th><th>Victories</th></tr>";
        foreach($ranking as $name => $victories) {
            $i++;
            echo "<tr><td>$i</td><td>$name</td><td>$victories</td></tr>";
        }
        echo "</table>";
    }
    listRanking();

    echoFooter();
?>
