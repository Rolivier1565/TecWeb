<?php
namespace DB;

class DBAccess{
  private const HOST_DB= "127.0.0.1";
  private const DATABASE_NAME= "egaspari";
  private const USERNAME= "egaspari";
  private const PASSWORD= "ieNgieZ0aing7fuY";

  private $connection;

  public function openDBConnection(){
    $this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);
    if(mysqli_connect_errno($this->connection)){
      return false;
    }else{
      return true;
    }
  }

  public function closeConnection(){
    mysqli_close($this->connection);
  }

  public function getPostList(){
    $query="SELECT Registrati.idr, Scrive.data, Scrive.ora, Messaggi.descrizione, Messaggi.argomento, Messaggi.mipiace, Messaggi.report, Messaggi.idm FROM Registrati, Scrive, Messaggi WHERE Registrati.idr=Scrive.idr AND Scrive.idm=Messaggi.idm";
    $queryResult = mysqli_query($this->connection, $query) or die("Errore in getPostList" . mysqli_error($this->connection));
    if(mysqli_num_rows($queryResult)==0){
      return null;
    }else{
      $result = array();
      while($row = mysqli_fetch_assoc($queryResult)){
        array_push($result, $row);
      }
      $queryResult->free();
      return $result;
    }
  }

  public function getPost($idPost){
    $query="SELECT Registrati.idr, Scrive.data, Scrive.ora, Messaggi.descrizione, Messaggi.argomento, Messaggi.mipiace, Messaggi.report, Messaggi.idm FROM Registrati, Scrive, Messaggi WHERE Registrati.idr=Scrive.idr AND Scrive.idm=Messaggi.idm AND Messaggi.idm='$idPost'";
    $queryResult = mysqli_query($this->connection, $query) or die("Errore in getPostList" . mysqli_error($this->connection));
      $result = mysqli_fetch_assoc($queryResult);
      $queryResult->free();
      return $result;
    }

      public function getCommentsPost($idPost){
        $query="SELECT Commenta.idr,Commenta.data, Commenti.descrizione, Commenti.mipiace, Commenti.report FROM Commenta, Commenti WHERE Commenti.idc=Commenta.idc AND Commenti.messaggio='$idPost'";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in getCommentsPost" . mysqli_error($this->connection));
        if(mysqli_num_rows($queryResult)==0){
          return null;
        }else{
          $result = array();
          while($row = mysqli_fetch_assoc($queryResult)){
            array_push($result, $row);
          }
          $queryResult->free();
          return $result;
    }
  }
  
	public function checkUser($usr, $psw){
		$query="SELECT EXISTS(SELECT 1 idr FROM Registrati WHERE idr='$usr' AND password='$psw')";
		$queryResult = mysqli_query($this->connection, $query) or die("Errore in getCommentsPost" . mysqli_error($this->connection));
		return $queryResult;
	}
}
?>
