<?php
/* Codificação UTF-8 */
define('WORKING_DIRECTORY', getcwd());

require_once('lib/lib.php');
my_session_start();

class GameState {
    private $fileName;
    private $stateString;
    private $state;
    
    private static function createFileName() {
        return basename(tempnam('games', ''));
    }
    
    private function loadState() {
        @$str = file_get_contents('games/' . $this->fileName);
        if ($str) {
            $this->stateString = $str;
            $this->state = unserialize($str);
        }
    }

    public function __construct($fname = '') {
        if ($fname === '') {
            $this->fileName = $this->createFileName();
            $this->state = array();
            $this->stateString = '';
        } else {
            $this->fileName = $fname;
            $this->loadState();
        }
    }
    
    public function getVar($name) {
        return $this->state[$name];
    }
    
    public function setVar($name, $value) {
        $this->state[$name] = $value;
    }
    
    public function finalize() {
        $str = serialize($this->state);
        //if ($str !== $this->stateString) {
            //sleep(2);
            file_put_contents('games/' . $this->fileName, $str);
            //sleep(2);
        //}
    }
    
    public function getFileName() {
        return $this->fileName;
    }

}

class TicTacToe {
    private $turn;
    private $board;
    private $numPeople;
    private $personName;
    private $personType;
    private $myPerson;
    private $lastPerson;
    private $won;
    private $player;        /* array */

    public function __construct() {
        $this->player = array();
        $this->player[0] = 0;
        $this->player[1] = 0;
        $this->player[2] = 0;
        $this->personType = array();
        $this->personName = array();
        $this->won = 0;
    }
    
    public function discriminatePeople() {
        $count = 0;
        $this->numPeople = 0;
        foreach($this->personName as $key => $name) {
            $count++;
            $this->numPeople++;
            if ($count <= 2) {
                $code = $count;
            } else {
                $code = 0;
            }
            $this->personType[$key] = $code;
            if ($code == 1 || $code == 2) {
                $this->player[$code] = $key;
            }
        }
    }
    
    private function isObserver() {
        return $this->personType[$this->myPerson] == 0;
    }
    
    private function switchTurn() {
        if ($this->turn == 1)
            $this->turn = 2;
        else if ($this->turn == 2)
            $this->turn = 1;
    }
    
    private function stopGame() {
        $this->turn = 0;
    }
    
    private function startGame() {
        $this->won = 0;
        $this->turn = 1;
        $this->board = '.........';
    }
    
    public function init() {
        global $mySession;

        if (isset($_REQUEST['cmd'])) {
            if ($_REQUEST['cmd'] == 'logout') {
                $this->state = new GameState($mySession['game']);
                $this->load();
                $this->discriminatePeople();
                $this->getCurrentPerson();
                unset($this->personName[$this->myPerson]);
                if ($this->won == $this->myPerson)
                    $this->won = 0;
                if (!$this->isObserver()) {
                    // Quando um jogador sai...
                    $this->stopGame();
                }
                $this->save();
                $this->finalize();
                my_session_destroy();
                header('location:index.php');
                die();
            }
        }
        // If name is set, this is the first run
        if (isset($_REQUEST['name'])) {
            // We need a name!!
            if ($_REQUEST['name'] === '') {
                my_session_destroy();
                header('location:index.php?err=1');
                die();
            }
            if (!isset($_REQUEST['game'])) {
                // Player creating game
                $this->state = new GameState();
                $mySession['game'] = $this->state->getFileName();
                $mySession['loggedin'] = 1;
                $this->startNewGame();
            } else {
                // Player joining game
                $this->state = new GameState($_REQUEST['game']);
                $mySession['game'] = $this->state->getFileName();
                $mySession['loggedin'] = 1;
                $this->load();
                $this->discriminatePeople();
                if ($this->numPeople == 1) {
                    $this->startGame();
                }
                /*
                if ($this->numplayers >= 2) {
                    $player = 0;
                }
                if ($player != 0) {
                    $this->numplayers++;
                    if ($this->playerName[2] == '')
                        $player = 2;
                    $this->turn = 3 - $player;
                }
                */
            }
            $this->myPerson = ++$this->lastPerson;
            $this->setCurrentPerson();
            $this->personName[$this->myPerson] = $_REQUEST['name'];
            $this->save();
            $this->finalize();
            header('location:play.php');
            die();
        } else if (!isset($mySession['loggedin'])) {
            my_session_destroy();
            header('location:index.php');
            die();
        }
        $this->state = new GameState($mySession['game']);
        $this->load();
        
        if (isset($_REQUEST['cmd'])) {
            if ($_REQUEST['cmd'] == 'restart') {
                $this->startGame();
                $this->save();
            }
        }
    }
    
    public function finalize() {
        $this->state->finalize();
    }
    
    function load() {
        $this->turn = $this->state->getVar('turn');
        $this->lastPerson = $this->state->getVar('lastperson');
        $this->board = $this->state->getVar('board');
        $this->personName = $this->state->getVar('personname');
        $this->won = $this->state->getVar('won');
    }
    
    function save() {
        $this->state->setVar('turn', $this->turn);
        $this->state->setVar('lastperson', $this->lastPerson);
        $this->state->setVar('board', $this->board);
        $this->state->setVar('personname', $this->personName);
        $this->state->setVar('won', $this->won);
    }

    function startNewGame() {
        $this->turn = 0;    // Nao eh a vez de ninguem!
        $this->lastPerson = 0;
        $this->board = '.........';
    }
    
    function drawCell($index, $value) {
        if ($value === '.')
            $value = 'white';
        else
            $value = ($value === 'X') ? 'x' : 'circle';
        echo "<td><form action='play.php' method='post'>";
        echo "<div><input type='hidden' name='c' value='$index' />";
        echo "<input type='image' src='media/$value.png' /></div>";
        echo "</form></td>";
    }
            
    function drawBoard() {
        echo '<div id="board">';
        echo '<table><tbody>';
        for ($i = 0; $i < 3; $i++) {
            echo '<tr>';
            for ($j = 0; $j < 3; $j++) {
                $index = $i * 3 + $j;
                $this->drawCell($index + 1, $this->board[$index]);
            }
            echo '</tr>';
        }
        echo '</tbody></table>';
        echo '</div>';
    }
    
    function htmlHead() {
        echoHeader(5, $_SERVER['PHP_SELF']);
        /*
        echo "<html><head><meta http-equiv=\"refresh\" content=\"5;URL='play.php'\" />";
        echo '<link rel="stylesheet" type="text/css" href="css/ttt.css" media="screen" />';
        echo '</head><body>';
        */
    }
    
    function getCurrentPerson() {
        $this->myPerson = 0;
        if (isset($_COOKIE['person']))
            $this->myPerson = (int)($_COOKIE['person']);
    }

    function setCurrentPerson() {
        setcookie('person', $this->myPerson);
    }
    
    function getCell($i, $j) {
        return $this->board[($i - 1) * 3 + $j - 1];
    }
    
    function testWin() {
        $win = 0;
        for ($player = 1; $player <= 2; $player++) {
            $symbol = ($player == 1) ? 'X' : 'O';
            for ($i = 1; $i <= 3; $i++) {
                $countH = 0;
                $countV = 0;
                for ($j = 1; $j <= 3; $j++) {
                    if ($this->getCell($i, $j) == $symbol)
                        $countH++;
                    if ($this->getCell($j, $i) == $symbol)
                        $countV++;
                }
                if ($countV == 3 || $countH == 3) {
                    $win = $player;
                    break;
                }
            }
            if ($win != 0)
                break;
            if ($this->getCell(2, 2) == $symbol) {
                if ($this->getCell(1, 1) == $symbol && $this->getCell(3, 3) == $symbol) {
                    $win = $player;
                    break;
                }
                if ($this->getCell(1, 3) == $symbol && $this->getCell(3, 1) == $symbol) {
                    $win = $player;
                    break;
                }
            }
        }
        if ($win != 0) {
            $this->won = $this->myPerson;
            $this->turn = 0;    // Nao eh a vez de ninguem!
            $this->addRanking($this->personName[$this->myPerson]);
        }
    }
    
    function addRanking($name) {
        $str = FALSE;
        @$str = file_get_contents('games/ranking.txt');
        if (!$str) {
            $ranking = array();;
        } else {
            $ranking = unserialize($str);
        }
        if (!isset($ranking[$name])) {
            $ranking[$name] = 1;
        } else {
            $ranking[$name]++;
        }
        arsort($ranking);
        file_put_contents('games/ranking.txt', serialize($ranking));
    }
    
    function testClick() {
        $click = 0;
        if (isset($_REQUEST['c'])) {
            $click = (int)($_REQUEST['c']);
            if ($click < 0 && $click >= 10) {
                $click = 0;
            }
        }
        if (($this->player[$this->turn] == $this->myPerson) && ($click !== 0)) {
            if ($this->board[$click - 1] == '.') {
                $symbol = ($this->turn == 1) ? 'X' : 'O';
                $this->board = substr_replace($this->board, $symbol, $click - 1, 1);
                $this->testWin();
                $this->switchTurn();
                $this->save();
            }
        }
    }
    
    function listPeople() {
        $i = 0;
        echo "<table class='ranking'>";
        echo "<tr><td colspan='2'>People online</td></tr>";
        foreach($this->personName as $key => $name) {
            $playsign = '';
            if ($this->personType[$key] != 0) {
                $playsign = '(P)';
            }
            $i++;
            echo "<tr><td>$i$playsign</td><td>$name</td></tr>";
        }
        echo "</table>";
    }
    
    function htmlBody() {
        $gameName = $this->state->getFileName();
        $name1 = '';
        $name2 = '';
        if ($this->player[1] != 0)
            $name1 = $this->personName[$this->player[1]];
        if ($this->player[2] != 0)
            $name2 = $this->personName[$this->player[2]];
        $myname = $this->personName[$this->myPerson];
        echo "<div id='stats'>";
        echo '<table class="ranking">';
        echo "<tr><td>Game code</td><td>$gameName</td></tr>";
        //echo "<p>Last player: <strong>";
        //echo $this->lastPerson;
        //echo "</strong></p>";
        echo "<tr><td>Players</td><td>$name1 X $name2</td></tr>";
        echo "<tr><td>You are</td><td>$myname</td></tr>";
        echo "<tr><td>Notes</td><td>&nbsp;";
        if ($this->won != 0) {
            if ($this->won == $this->myPerson)
                echo "You are a winner!";
            else {
                echo $this->personName[$this->won];
                echo " is a winner!";
            }
        }
        echo "</td></tr>";
        echo "<tr><td>Turn</td><td>";
        if ($this->turn == 0) {
            echo "No game";
        } else {
            if ($this->player[$this->turn] == $this->myPerson) {
                echo "Now it's your turn!";
            } else {
                echo "Now it's ";
                echo $this->personName[$this->player[$this->turn]];
                echo "'s turn";
            }
        }
        echo "</td></tr>";
        
        ///*
        //if ($this->player === 1) {
            echo "<tr><td colspan='2'><a href='index.php?game=";
            echo $this->state->getFileName();
            echo "'>Multiplayer link</a></td></tr>";
        //}
        //if ($this->numplayers
        echo '</table>';
        //*/
        echo '<p><a href="play.php?cmd=logout">Logout</a></p>';
        echo '<p><a href="play.php?cmd=restart">Restart</a></p>';
        $this->listPeople();        
        echo "</div>";
        $this->drawBoard();
    }
    
    function htmlFooter() {
        //echo '</body></html>';
        echoFooter();
    }
}

function finalizeTTT() {
    global $ttt;
    chdir(WORKING_DIRECTORY);
    $ttt->finalize();
}

$ttt = new TicTacToe();
register_shutdown_function('finalizeTTT');
$ttt->init();
$ttt->getCurrentPerson();
$ttt->discriminatePeople();
$ttt->testClick();
$ttt->htmlHead();
$ttt->htmlBody();
$ttt->htmlFooter();

?>
