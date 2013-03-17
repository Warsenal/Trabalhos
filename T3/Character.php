<?php
	
	require_once 'Database.php';
	session_start();
	
	$id = $_SESSION['id'];
	dbConnect();
	
	$query = mysql_query("SELECT * FROM player WHERE p_id = '$id'");
	
	while($data = mysql_fetch_array($query)){
		$p_id = $data['p_id'];
		$p_user = $data['p_user'];
		$p_expa = $data['p_expa'];
		$p_expt = $data['p_expt'];
		$p_level = $data['p_level'];
		$p_attribute = $data['p_attribute'];
		$p_str = $data['p_str'];
		$p_dex = $data['p_dex'];
		$p_int = $data['p_int'];
		$p_cha = $data['p_cha'];
		$p_money = $data['p_money'];
	}
	
	echo("
		<div id=\"character\">
	
			<div id=\"characterTop\">
				<h1>Character</h1>
				<h1>$p_user </h1>
				
				</br>Level: $p_level
				</br>Experience: $p_expa / $p_expt
				</br></br>Wealth: $p_money Gold Coins
			</div>
			
			<div id=\"characterResult\"> </div>

			<div id=\"mid\">
			
				<div id=\"characterMidLeft\">
					</br>Attribute:<p id=\"a_0\"> $p_attribute</p>
					<table>
						<tr>
							<td>
								<a id=\"c_1\"	href=\"javascript:void(0);\"	OnClick=\"increaseStr(1);\"> <img src=\"Assets/p_s.png\"></a>
								</br>Strength: <p id=\"a_1\">$p_str</p>
							</td>
							<td>
								<a id=\"c_2\"	href=\"javascript:void(0);\"	onClick=\"increaseDex(1);\"> <img src=\"Assets/p_d.png\"></a>
								</br>Dexterity: <p id=\"a_2\">$p_dex</p>
							</td>
						</tr>
						<tr>
							<td>
								<a id=\"c_3\"	href=\"javascript:void(0);\"	onClick=\"increaseaInt(1);\"> <img src=\"Assets/p_i.png\"></a>
								</br>Intelligence: <p id=\"a_3\">$p_int</p>
							</td>
							<td>
								<a id=\"c_4\"	href=\"javascript:void(0);\"	onClick=\"increaseCar(1);\"> <img src=\"Assets/p_c.png\"></a>
								</br>Charism:<p id=\"a_4\">$p_cha</p>
							</td>
						</tr>
					</table>
				</div>


				<div id=\"characterMidRight\">
					Coming Soon
					</br>
					16 Skill to Personalize Your Character! :)
				</div>
			</div>
	
	");
	
	/* Old Menu Style
					</br>Strength: $p_str	<button OnClick=\"increaseAttribute(1);\"> Strength </button>
					</br>Dexterity: $p_dex	<button onClick=\"increaseAttribute(2);\"> Dexterity</button>
					</br>Intelligence: $p_int	<button onClick=\"increaseAttribute(3);\"> Intelligence</button>
					</br>Charism: $p_cha	<button onClick=\"increaseAttribute(4);\"> Charism</button>
	*/

	if($p_attribute >= 1){
		echo("
			<div id=\"characterSave\">
				<button onClick=\"save();\">Save</button>
			</div>
		");
	}
	
	/*
	echo("

			<div id=\"characterBottom\">

				
			</div>

		</div>
		
	");
	*/
	
?>