<?php

class User {
	
	
	private $connection;
	
	
	//klassi loomisel (new user)
	function __construct($mysqli) {
		
		//this tähendab selle klassi muutnuat
			$this->connection = $mysqli;
	}
	
	function createUser($name, $surename, $mail, $hash){
		
				$response = new StdClass();
		
				$stmt = $this->connection-> prepare("INSERT INTO users (name, surename, mail, passwordtwo) VALUES(?, ?, ?, ?)");
				$stmt ->bind_param("ssss", $name, $surename, $mail, $hash);
				$stmt->bind_result($id);
				$stmt ->execute();

				if($stmt->fetch()){
		
		
				$error = new StfClass();
				$error -> id = 0;
				$error -> message = "Sellise e-postiga kasutaja on juba olemas!";
				
				$response->error = $error;
				
				return $response;
		
		
		
		// panen eelmise päringu kinni
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO users (mail, passwordtwo) VALUES (?,?)");
		$stmt->bind_param("ss", $mail, $hash);
		
		// sai edukalt salvestatud
		if($stmt->execute()){
			
			$success = new StdClass();
			$success->message = "Kasutaja edukalt loodud!";
			
			$response->success = $success;
			
		}else{
			
			// midagi läks katki
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Midagi läks katki!";
			
			$response->error = $error;
			
		}
		
		$stmt->close();
		
		return $response;
	}
	
	function loginUser($email, $hash){
		$response = new StdClass();
		$stmt = $this->connection->prepare("SELECT id, email FROM users WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		
		
		if(!$stmt->fetch()){
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellist kasutajat ei ole!";
			
			$response->error = $error;
			return $response;
		}
		
		//*********************
		//***** OLULINE *******
		//*********************
		$stmt->close();
		
		$stmt = $this->connection->prepare("SELECT id, email FROM users WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			
			// kõik õige 
			$success = new StdClass();
			$success->message = "Kasutaja edukalt sisselogitud!";
			
			$response->success = $success;
			
			$user = new StdClass();
			$user->id = $id_from_db;
			$user->email = $email_from_db;
			
			$response->user = $user;
			
		}else{
			
			// parool vale
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Parool oli vale!";
			
			$response->error = $error;
			
		}
		$stmt->close();
		
		return $response;
	}
}
} ?>