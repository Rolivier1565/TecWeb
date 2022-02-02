<?php
  require_once "backend/db.php";
  use DB\DBAccess;

	function inputTrim($input){
		$input=trim($input);
		$input=stripslashes($input);
		$input=htmlspecialchars($input);
		return $input;
	}
	
	
	/*Workflow
		Controlla se siamo stati chiamati col post	ok
			+Controlla se il server c'è				ok
				+Controlla che siano giusti i dati di login	ok
					+Redirect ad area Personale		ok
					-Imposta messaggio di login sbagliato
				-Redirect a pagina di errore
		Crea pagina
	*/
	$errMsg=$usr=$psw="";
	$paginaHTML=file_get_contents("../HTML/login.html");
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$connessione = new DBAccess();
		$connessioneOK= $connessione->openDBConnection();
		if ($connessioneOK){
			$usr=inputTrim($_POST["username"]);
			$psw=inputTrim($_POST["password"]);
			if($connessione->checkLogin($usr, $psw)){
				$connessione=$connessione->closeConnection();
				session_start();
				$_SESSION["usrid"]=$usr;
				header("Location: areaRiservata.php",TRUE,301);
				die();
			}
			else{
				$errMsg=file_get_contents("../templates/errorMsg.txt");
			}
		}
		else{
			header("Location: noDb.html",TRUE,301);
		}
	}
  //Crea pagina
  echo str_replace("<errorMsg/>",$errMsg, $paginaHTML);
  ?>