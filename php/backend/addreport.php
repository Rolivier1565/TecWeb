<?php
//logged as user
session_start();


require_once "db.php";
use DB\DBAccess;

if(isset($_SESSION['usrid'])){
  $idm = $_REQUEST['idm'];
  $usr = $_SESSION['usrid'];

  $connessione = new DBAccess;
  $connessioneOK = $connessione->openDBConnection();

  if($connessioneOK){
      if($connessione->checkReport($usr, $idm)){
        $connessione->deleteReport($usr, $idm);
        $connessione = $connessione->closeConnection();
        echo "true";
      }else{
        $connessione->insertReport($usr, $idm);
        $connessione = $connessione->closeConnection();
        echo "false";
    }
  }else{
    echo "dbError";
  }
}else{
  echo "NL";
}
?>
