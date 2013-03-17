<?php
	
	require_once "Database.php";
	session_start();
	
	dbConnect();
	
	function doItem(){
	
		$p_id = $_SESSION['id'];
		$i_id = $_GET['i_id'];
		
		//$query1 = mysql_query("SELECT * FROM inventory WHERE p_id = '$p_id'") or die ('Error'.mysql_error()); //Search for player inventory
		$query2 = mysql_query("SELECT * FROM itens WHERE i_id = '$i_id'") or die ('Error'.mysql_error()); //Search for information about the item
		$query3 = mysql_query("SELECT * FROM inventory WHERE p_id = '$p_id' AND i_id = '$i_id'") or die ('Error'.mysql_error()); //Search for player inventory
		
		while($i_data = mysql_fetch_array($query2)){
			$item_id	= $i_data['i_id'];
			$item_name = $i_data['i_name'];
		}
		
		if(mysql_num_rows($query3)==1){
		
			while($data = mysql_fetch_array($query3)){
				$i_id = $data['i_id'];
				$i_qt = $data['i_qt'];
			}
			
			$i_qt = $i_qt+1;
			
			mysql_query("UPDATE inventory SET i_qt = '$i_qt' WHERE p_id = '$p_id' AND i_id = '$i_id'") or die('Error'.mysql_error());
			echo'You have gained +1 iron bar';
		
		} else {
			mysql_query("INSERT INTO inventory(p_id, i_id, i_name, i_qt) VALUES('$p_id', '$item_id', '$item_name', 1)") or die('Error'.mysql_error());
			echo'You have gained 1 iron bar';
		}
	}
	doItem();
?>