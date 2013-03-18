<?php
	
	require_once 'database.php';
	session_start();
	dbConnect();
	
	function doJob(){
		
		$j_id = $_GET['j_id'];
		$id = $_SESSION['id'];
		
		$player = mysql_query("SELECT * FROM player WHERE p_id = '$id'") or die ('Error'.mysql_error()); //Get all information about player
	
		$query1 = mysql_query("SELECT * FROM jobs WHERE j_id = $j_id") or die('Error'.mysql_error()); //Get All infermoation about job
		
		$query2 = mysql_query("SELECT * FROM itens WHERE i_id = '$j_id'") or die('Error'.mysql_error()); //Get all information about itens
		
		while($p_data = mysql_fetch_array($player)){
			$p_id = $p_data['p_id'];
			$p_money = $p_data['p_money'];
			$p_expa = $p_data['p_expa'];
			$p_expt = $p_data['p_expt'];
			$p_attribute = $p_data['p_attribute'];
			$p_level = $p_data['p_level'];
		}
		
		while($j_data = mysql_fetch_array($query1)){
			$j_id = $j_data['j_id'];
			$j_name = $j_data['j_name'];
			$j_money = $j_data['j_money'];
			$j_exp = $j_data['j_exp'];
		}
		
		while($i_data = mysql_fetch_array($query2)){
			$i_id	= $i_data['i_id'];
			$i_name = $i_data['i_name'];
		}
		
		$query3 = mysql_query("SELECT * FROM inventory WHERE p_id = '$p_id' AND i_id = '$i_id'") or die ('Error'.mysql_error());
		
		if(mysql_num_rows($query3)==1){
		
			while($inventory = mysql_fetch_array($query3)){
				$i_qt = $inventory['i_qt'];
			}
			
			$i_qt = $i_qt + 1;
			
			mysql_query("UPDATE inventory SET i_qt = '$i_qt' WHERE p_id = '$p_id' AND i_id = '$i_id'") or die('Error'.mysql_error());
		
		} else {
			mysql_query("INSERT INTO inventory(p_id, i_id, i_name, i_qt) VALUES('$p_id', '$i_id', '$i_name', 1)") or die('Error'.mysql_error());
		}
	
		$p_money = $p_money + $j_money;
		$p_expa = $p_expa + $j_exp;
		
		while($p_expt <= $p_expa){ //teste de level up
			$p_expa = $p_expa - $p_expt;	
			$p_expt = $p_expt + ((($p_level+1) *2)+1);
			
			$p_level++;
			$p_attribute++;
			
			echo"AVANCOU DE NIVEL";
		}
		
		mysql_query("UPDATE player SET p_money = '$p_money', p_expa = '$p_expa', p_expt = '$p_expt', p_level = '$p_level', p_attribute = '$p_attribute' WHERE p_id = '$p_id'");
		
		echo"
			<h1>$j_name</h1>
			</br>
			You Have Gained:</br>
			Money:$j_money </br>
			Experience: $j_exp </br>
			
			Item: $i_name
		";
	}
	
	function levelUp(){
		while($p_expmax <= $p_exp){
			$p_exp = $p_exp - $p_expmax;	
			$p_expmax = $p_expmax + ((($p_level+1) *2)+1);
			$p_level++;
			
			echo"AVANCOU DE NIVEL";
		}
	}
	
	doJob();
?>