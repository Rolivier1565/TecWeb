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
      if($connessione->checkLike($usr, $idm)){
        $connessione->deleteLike($usr, $idm);
        $connessione = $connessione->closeConnection();
        echo "true";
      }else{
        $connessione->insertLike($usr, $idm);
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
