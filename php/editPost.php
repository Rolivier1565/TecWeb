<?php
	require_once "backend/db.php";
	use DB\DBAccess;
	$paginaHTML=file_get_contents("../HTML/editPost.html");
	session_start();
	$connessione = new DBAccess();
  
  function inputTrim($input){
		$input=trim($input);
		$input=stripslashes($input);
		$input=htmlspecialchars($input);
		return $input;
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$connessione = new DBAccess();
		$connessioneOK= $connessione->openDBConnection();
		if ($connessioneOK){
			$post=$connessione->getPost($_POST['idm']);
			if (isset($_POST['modifica'])){
				$connessione->editPost($_POST['idm'], inputTrim($_POST['testo']));
				$connessione->closeConnection();
				header("Location: areaRiservata.php");
			}
			$paginaHTML=str_replace("<testo/>",$post['descrizione'], $paginaHTML);
			$paginaHTML=str_replace("<idm/>",$_POST['idm'], $paginaHTML);
			$connessione->closeConnection();
			echo $paginaHTML;
		}
		else{
			header("Location: ../HTML/noDb.html",TRUE,301);
		}
		
	}
	else{
		//You shouldn't be here
	}
	
  ?>