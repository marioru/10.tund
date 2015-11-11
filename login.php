<?php
	//LOGIN.PHP
	require_once("functions.php");
	
	
	
	//kui kasutaja on sisse loginud siis suunan data.php lehele
	if(isset($_SESSION["looged_in_user_id"])){
		header("Location: data.php");
	}
	
	
	$email_error = "";
	$password_error = "";
	$name_error = "";
	$surename_error = "";
	$username_error = "";
	
	$mail_error = "";
	$passwordtwo_error = "";

	
	//muutjuad ab väärtuste jaoks
	$name = "";
	$surename = "";
	$email = "";
	$password = "";
	$mail = "";
	$passwordtwo = "";
	
	//echo $_POST€["email"];
	
	//kontrollime et keegi vajutas nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// *********************
		// **** LOGI SISSE *****
		// *********************
	
		
		//vajutas login nuppu
		if(isset($_POST["login"])){
			
			
			//kontrollin et e-post ei ole tühi
			
			if ( empty($_POST["email"]) ) {
				$email_error = "See väli on kohustuslik";
				
			}else{
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}
			
			//kontrollin et parool ei ole tühi
			 if ( empty($_POST["password"]) ) {
				 $password_error = "See väli on kohustuslik";
			} else{
				$password = cleanInput($_POST["password"]);
			}
			// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == "")
			{
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
				
				$hash = hash("sha512", $password);
				
				//kasutaja sisselogiminse fn, failist functions.php
				
				$login_response = $User->loginUser($email, $hash);
				
			if (isset($login_response->success)){
				
				
				//id, emaili
				$_SESSION["logged_in_user_id"] = $login_response->user->id;
				$_SESSION["logged_in_user_email"] =$login_response->user->email;
			
			//saadan sõnumi teise faili kasutades SESSIOONI
					$_SESSION["login_success_message"] = $login_response->success->message;
					
					header("Location: data.php");
					
			}
					}
		}
			
	
				
				
		// *********************
		// ** LOO KASUTAJA *****
		// *********************
				
		
	//kontrollime et keegi vajutas nuppu
		if(isset($_POST["create"])){
			
			
			//kontrollin et nimi ja perekonnanime väljad ei oleks tühjad
			if ( empty($_POST["name"]) ) {
				$name_error = "See väli on kohustuslik";
			}else{
				//kõik korras
				//cleanInput eemaldab pahatahtlikud osad
				$name = cleanInput($_POST["name"]);
				
			}
			if($name_error == ""){
				echo "salvestan ab'i ".$name;
			}
			//kontrollin et perekonnanimi ei oleks tühi	
			if ( empty($_POST["surename"]) ) {
				$surename_error = "See väli on kohustuslik";
				
			}else{
 				
 				$surename = cleanInput($_POST["surename"]);
 				}


			
			if (empty($_POST["mail"])) {
				$mail_error = "See väli on kohustuslik";
			}else{
					$mail = cleanInput($_POST["mail"]);
				}

			if (empty($_POST["passwordtwo"])) {
				$passwordtwo_error = "See väli on kohustuslik";
				} else {
				
				//kui oleme siia jõudnud, siis parool ei ole tühi
				//konrollin et oleks vähemalt 8 üsmbolit pikk
				if(strlen($_POST["password"]) < 8) {
					
					$passwordtwo_error = "Peab olema vähemalt 8 tähemärki pikk!";
					}
					
			if($mail_error == "" && $passwordtwo_error == ""){
				
				//räsi paroolist
				$hash = hash("sha512", $passwordtwo);
				
				echo "Võib kasutajat luua! Kasutajanimi on ".$mail." ja parool on ".$passwordtwo." ja räsi on ".$hash;
				
				$create_response->$User->createUser($create_mail, $hash);
			}

				}
				
	}
			
	
			
	
	}
	
	
		function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
		}
	
?>


<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body bgcolor="E0FFF0">

	<h2>Log in</h2>

		
	  <form action="login.php" method="post">	
		<input name="email" type="email" placeholder="E-post"> <?php echo $email_error;?><br><br>
		<input name="password" type="password" placeholder="Parool"> <?php echo $password_error;?><br><br>
		<input name="login" type="submit" value="Log in">
	  </form>	
	<h2>Create user</h2>
	
		<form action="login.php" method="post">	
		<input name="name" type="name"  placeholder="Eesnimi"><?php echo $name_error;?><br><br>
		<input name="surename" type="surename" placeholder="Perekonnanimi"><?php echo $surename_error;?><br><br>
		<input name="password" type="password" placeholder="Parool"> <?php echo $passwordtwo_error;?> <br><br>
		<input name="email" type="email" placeholder="E-post"> <?php echo $mail_error;?><br><br>
		<input name="create" type="submit" value="Create user">
	  </form>	
</body>

</html>