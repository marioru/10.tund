<?php
require_once("functions.php");

	//kui kasutaja on sisse loginud siis suunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
		
		//see katkestab faili edasise lugemise
		exit();
	}
	
	
	
	//kasutaja tahav v�lja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutjua logout
		
		//kustutame k�ik session muutjuad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	
		$target_dir = "profile_pics/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check if image file is a actual image or fake image
	
		if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
		}
		
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
		
?>
<?php if(isset($_SESSION["login_success_message"])): ?>
	
	<p style="color:green;" >
		<?=$_SESSION["login_success_message"];?>
	</p>

<?php 
	//kustutan selle s�numi p�rast esimest n�itamist
	unset($_SESSION["login_success_message"]);
	
	endif; ?>

<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi v�lja <a> 
</p>

<h2>Profiilipilt</h2>

<?php if(file_exists($target_file)): ?>

<div style =" 
width: 200px;
height: 200px;
backround-image:url(<?=$target_file;?>);
background-position: center center;
background-size: cover;" ></div>

<form action="data.php" method="post" enctype="multipart/form-data">
    Lae �les pilt (1MB ja png, jpg, gif)
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>


<?php endif; ?>