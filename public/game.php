<?php

	require_once 'database.php';
	require_once 'view.php';
	@session_start();
	
	if($_SESSION['login']!=true){
	
		header("Location: index.php");
		exit();
	}
	
	pHeaderScript();
	pJavascript();
	
	echo('
		<div id="exit"><a href="signOut.php"> <input type="submit" value="Exit"></a></div>
	');
	
	echo('
		<div id="announcement">
			Announcement:
				<br>This is a Demo version from a game :)<br>
		</div>
	');


	echo('
	
		<div class="game">
		
			<div id="gameTop">
				
				<button onClick="character();">Character</button>
				<button onClick="inventory();">Inventory</button>
				<button onClick="equipment();">Equipment</button>
				<button onClick="map();">Map</button>
			</div>

			<div id="gameMid">
				<br>
				<img src="assets/Logo.jpg" alt="Medieval Adventure"/>
				<br>
			</div>
			
			<div id="gameBot">
				<button onClick="blacksmith();">blacksmith</button>
			</div>
		</div>
	
	');
	
	pFooter();
?>