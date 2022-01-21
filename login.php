<?php
  require_once "php/db.php";
  use DB\DBAccess;

	function inputTrim($input){
		$input=trim($input);
		$input=stripslashes($input);
		$input=htmlspecialchars($input);
		return $input;
	}
	
	function checkUser($usr, $psw){
		$query="SELECT EXISTS(SELECT 1 idr FROM Registrati WHERE idr='$usr' AND password='$psw')";
		$queryResult = mysqli_query($this->connection, $query) or die("Errore in getCommentsPost" . mysqli_error($this->connection));
		return $queryResult;
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
	$paginaHTML=file_get_contents("login.html");
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$connessione = new DBAccess();
		$connessioneOK= $connessione->openDBConnection();
		if ($connessioneOK){
			$usr=inputTrim($_POST["username"]);
			$psw=inputTrim($_POST["password"]);
			if($connessione->checkUser($usr, $psw)){
				session_start();
				$_SESSION["usrid"]=$usr;
				header("Location: areaRiservata.php",TRUE,301);
				die();
			}
			else{
				$errMsg=file_get_contents("templates/errorMsg.txt");
			}
		}
		else{
			header("Location: noDb.html",TRUE,301);
		}
	}
  //Crea pagina
  echo str_replace("<errorMsg/>",$errMsg, $paginaHTML);
  ?>