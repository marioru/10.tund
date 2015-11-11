<?php

	//loob AB'i ühenduse
	
	require_once("../config_global.php");
	require_once("user class.php");
	
	$database = "if15_mkoinc_3";
	
	//tekitatakse sessioon mis hoitakse serveris,
	//kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();
	
	
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
	//saadan ühenduse class ja loon  uue classi
	
	$User = new User($mysqli);
	
	
?>