<?php

	//loob AB'i �henduse
	
	require_once("../config_global.php");
	require_once("user class.php");
	
	$database = "if15_mkoinc_3";
	
	//tekitatakse sessioon mis hoitakse serveris,
	//k�ik session muutujad on k�ttesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();
	
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
	//saadan �henduse class ja loon  uue classi
	
	$User = new User($mysqli);
	
	
?>