<?php
  require_once "backend/db.php";
  use DB\DBAccess;

	function inputTrim($input){
		$input=trim($input);
		$input=stripslashes($input);
		$input=htmlspecialchars($input);
		return $input;
	}
	
  $paginaHTML=file_get_contents("../HTML/register.html");
  $errMsg=$usr=$psw=$mail="";
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$connessione = new DBAccess();
		$connessioneOK= $connessione->openDBConnection();
		if ($connessioneOK){
			$usr=inputTrim($_POST["username"]);
			$psw=inputTrim($_POST["password"]);
			$mail=inputTrim($_POST["email"]);
			if(!$connessione->checkForUser($usr)){
				$connessione->insertUser($usr, $psw, $mail);
				$connessione=$connessione->closeConnection();
				session_start();
				$_SESSION["usrid"]=$usr;
				header("Location: areaRiservata.php",TRUE,301);
				die();
			}
			else{
				$connessione=$connessione->closeConnection();
				$errMsg=file_get_contents("../templates/userTaken.txt");
			}
		}
		else{
			header("Location: ../HTML/noDb.html",TRUE,301);
		}
	}
  //Crea pagina
  echo str_replace("<errorMsg/>",$errMsg, $paginaHTML);
  
  ?>