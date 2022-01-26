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
    $query="SELECT Registrati.idr, Scrive.data, Scrive.ora, Messaggi.descrizione, Messaggi.argomento, Messaggi.mipiace, Messaggi.report, Messaggi.idm FROM Registrati, Scrive, Messaggi WHERE Registrati.idr=Scrive.idr AND Scrive.idm=Messaggi.idm ORDER BY Scrive.idm DESC";
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
  
  public function getLikedPosts($usr){
	  $query="SELECT idm FROM Piace WHERE idr='$usr' ORDER BY idm";
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

	public function checkLogin($usr, $psw){
		$query="SELECT * FROM Registrati WHERE idr='$usr' AND password='$psw'";
		$queryResult = mysqli_query($this->connection, $query) or die("Errore in checkUser" . mysqli_error($this->connection));
    $aux = mysqli_num_rows($queryResult);
    $queryResult->free();
		return $aux;
	}
	
	public function checkForUser($usr){
		$query="SELECT idr FROM Registrati WHERE idr='$usr'";
		$queryResult = mysqli_query($this->connection, $query) or die("Errore in checkUser" . mysqli_error($this->connection));
		if ($queryResult==FALSE){
			$queryResult->free();
			return FALSE;
		}
		else{
			$queryResult->free();
			return TRUE;
		}
	}
	
	public function insertUser($usr, $psw, $mail){
		$query="INSERT INTO Registrati (idr,password,mail,accesso) VALUES ('$usr','$psw','$mail',1);";
		mysqli_query($this->connection, $query) or die("Errore in insertLike1" . mysqli_error($this->connection));
	}

  public function checkLike($usr, $idm){
    $query="SELECT * FROM Piace WHERE idr='$usr' AND idm=$idm";
    $queryResult = mysqli_query($this->connection, $query) or die("Errore in checkLike" . mysqli_error($this->connection));
    $aux = mysqli_num_rows($queryResult);
    $queryResult->free();
		return $aux;
  }

  public function deleteLike($usr,$idm){
    $query="DELETE FROM Piace WHERE idr='$usr' AND idm=$idm";
    mysqli_query($this->connection, $query) or die("Errore in deleteLike1" . mysqli_error($this->connection));
    $query="UPDATE Messaggi SET mipiace=mipiace-1 WHERE idm='$idm'";
    mysqli_query($this->connection, $query) or die("Errore in deleteLike2" . mysqli_error($this->connection));
  }

  public function insertLike($usr,$idm){
    $query="INSERT INTO Piace (idr,idm) VALUES (". "'" . $usr ."'" . ", $idm);";
    mysqli_query($this->connection, $query) or die("Errore in insertLike1" . mysqli_error($this->connection));
    $query="UPDATE Messaggi SET mipiace=mipiace+1 WHERE idm='$idm'";
    mysqli_query($this->connection, $query) or die("Errore in insertLike2" . mysqli_error($this->connection));
  }

  public function checkReport($usr, $idm){
    $query="SELECT * FROM Report WHERE idr='$usr' AND idm=$idm";
    $queryResult = mysqli_query($this->connection, $query) or die("Errore in checkLike" . mysqli_error($this->connection));
    $aux = mysqli_num_rows($queryResult);
    $queryResult->free();
		return $aux;
  }

  public function deleteReport($usr,$idm){
    $query="DELETE FROM Report WHERE idr='$usr' AND idm=$idm";
    mysqli_query($this->connection, $query) or die("Errore in deleteLike1" . mysqli_error($this->connection));
    $query="UPDATE Messaggi SET report=report-1 WHERE idm='$idm'";
    mysqli_query($this->connection, $query) or die("Errore in deleteLike2" . mysqli_error($this->connection));
  }

  public function insertReport($usr,$idm){
    $query="INSERT INTO Report (idr,idm) VALUES (". "'" . $usr ."'" . ", $idm);";
    mysqli_query($this->connection, $query) or die("Errore in insertLike1" . mysqli_error($this->connection));
    $query="UPDATE Messaggi SET report=report+1 WHERE idm='$idm'";
    mysqli_query($this->connection, $query) or die("Errore in insertLike2" . mysqli_error($this->connection));
  }
}
?>
