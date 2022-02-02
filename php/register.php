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
  $errMsg=$wrngMail=$wrngPsw=$usr=$psw=$mail="";
  $ok=TRUE;
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$connessione = new DBAccess();
		$connessioneOK= $connessione->openDBConnection();
		$psw=inputTrim($_POST["password"]);
		$pswRe=inputTrim($_POST["passwordRe"]);
		$mail=inputTrim($_POST["email"]);
		if ($psw!=$pswRe){
			$ok=FALSE;
			$wrngPsw=file_get_contents("../templates/wrongConfirm.txt");
		}
		if (!preg_match("/^([\w\-\+\.]+)@([\w\-\+\.]+).([\w\-\+\.]+)$/", $mail)){
			$ok=FALSE;
			$wrngMail=file_get_contents("../templates/wrongEmail.txt");
		}
		if ($connessioneOK){
			$usr=inputTrim($_POST["username"]);
			if(($ok)&&(!$connessione->checkForUser($usr))){
				$connessione->insertUser($usr, $psw, $mail);
				$connessione=$connessione->closeConnection();
				session_start();
				$_SESSION["usrid"]=$usr;
				header("Location: areaRiservata.php",TRUE,301);
				die();
			}
			else if(!$connessione->checkForUser($usr)){
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
  $paginaHTML=str_replace("<wrongConfirm/>",$wrngPsw, $paginaHTML);
  $paginaHTML=str_replace("<wrongEmail/>",$wrngMail, $paginaHTML);
  echo str_replace("<usrTkn/>",$errMsg, $paginaHTML);
  
  ?>