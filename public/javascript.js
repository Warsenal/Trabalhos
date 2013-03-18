//Function from Game.php

function ok(text){
	$("#gameMid").html(text);
}
	
function character(){
	$.ajax({
		url:"character.php"
	}).done(ok);
}

function map(){
	$.ajax({
		url:"map.php"
	}).done(ok);
}

function inventory(){
	$.ajax({
		url:"inventory.php"
	}).done(ok);
}

function equipment(){
	$.ajax({
		url:"equipment.php"
	}).done(ok)
}

function blacksmith(){
	$.ajax({
		url:"blacksmith.php"
	}).done(ok)
}

//Functions from map.php

function jobResult(text){

	window.document.getElementById('dialog').innerHTML=text;
	$(function() {
		$( "#dialog" ).dialog();
	});
}

function job(j_id){
	$.ajax({
		url:"jobs.php?j_id="+j_id
	}).done(jobResult);
}

//Function From character.php

/*
function increaseAttribute(attribute){
	$.ajax({
		url:"Attributes.php?attribute="+attribute
	}).done(attributeResult);
}
*/

function attributeResult(text){
	$("#characterResult").html(text);
}

function decreaseAttribute(){ //Decrease the attribute
	
	var number = -1;
	var attribute = window.document.getElementById("a_0");
	
	if(parseInt(attribute.innerHTML)>=1){
		attribute.innerHTML = parseInt(attribute.innerHTML)+number;
		return (1);
	} else {
		return (0);
	}
}

function increaseStr(str){
	
	var decrease = decreaseAttribute();
	
	if(decrease == 1){
		var attribute = window.document.getElementById("a_1");
		attribute.innerHTML = parseInt(attribute.innerHTML)+str;
	}
}

function increaseDex(dex){
	
	var decrease = decreaseAttribute();
	if(decrease == 1){
		var attribute = window.document.getElementById("a_2");
		attribute.innerHTML = parseInt(attribute.innerHTML)+dex;
	}
}

function increaseaInt(Int){

	var decrease = decreaseAttribute();
	if(decrease == 1){
		var attribute = window.document.getElementById("a_3");
		attribute.innerHTML = parseInt(attribute.innerHTML)+Int;
	}
}

function increaseCar(car){
	
	var decrease = decreaseAttribute();
	if(decrease == 1){
		var attribute = window.document.getElementById("a_4");
		attribute.innerHTML = parseInt(attribute.innerHTML)+car;
	}
}

function save(){ //Get all information about player and save in the Database
	
	var attribute = window.document.getElementById("a_0");
	var str = window.document.getElementById("a_1");
	var dex = window.document.getElementById("a_2");
	var Int = window.document.getElementById("a_3");
	var cha = window.document.getElementById("a_4");
	
	var p_atr = parseInt(attribute.innerHTML);
	var p_str = parseInt(str.innerHTML);
	var p_dex = parseInt(dex.innerHTML);
	var p_int = parseInt(Int.innerHTML);
	var p_cha = parseInt(cha.innerHTML);
		
	$.ajax({
		url:"characterSave.php?p_atr="+p_atr+"&p_str="+p_str+"&p_dex="+p_dex+"&p_int="+p_int+"&p_cha="+p_cha
	}).done(attributeResult);
	
}

//blacksmith Page

function blacksmithResult(text){
	alert(text);
}

function Blakcsmith(i_id){
	$.ajax({
		url:"forge.php?i_id="+i_id
	}).done(blacksmithResult);
}