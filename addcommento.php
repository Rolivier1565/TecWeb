<?php
  require_once "php/db.php";
  use DB\DBAccess;

  session_start();
  function inputTrim($input){
		$input=trim($input);
		$input=stripslashes($input);
		$input=htmlspecialchars($input);
		return $input;
	}
  $new=inputTrim($_POST['commento']);
  $anno=date("Y-m-d");
  $ora=date("h:i:s");
  $connessione= new DBAccess;
  $connessioneOK=$connessione->openDBConnection();
  if($connessioneOK){
    $connessione->addcomment($_SESSION['usrid'], $_POST['idm'], $new, $anno, $ora);
    $connessione->closeConnection();
    $url="Location: getComments.php?id=".$_POST['idm'];
    header($url, TRUE, 308);
}else{
  echo "errore conessione DB";
}


?>
