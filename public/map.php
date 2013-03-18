<?php
	//Codificação UTF-8
	
	require_once 'view.php';

	echo'
		<div id="map">
			<img id="mapImg" src="assets/m_worldmap.jpg"/>
			<a id="j_1" href="javascript:void(0);" onClick="job(1);return(false);"> <img src="assets/j_1.jpg"> </a>
			<a id="j_2" href="javascript"void(0);" onClick="job(2);return(false);"> <img src="assets/j_2.jpg"> </a>
			<a id="j_3" href="javascript:void(0);" onClick="job(3);return(false);"> <img src="assets/j_3.jpg"> </a>
			<a id="j_4" href="javascript:void(0);" onClick="job(4);return(false);"> <img src="assets/j_4.jpg"> </a>
			<a id="j_5" href="javascript:void(0);" onClick="job(5);return(false);"> <img src="assets/j_5.jpg"> </a>
		</div>
		
		<div id="dialog" title="You Have done the job!"><a class="boxclose" id="boxclose"></a></div>
	';
?>