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

  public function getMaxIdm(){
    $query="SELECT max(idm) as maxidm FROM Messaggi";
    $queryResult = mysqli_query($this->connection, $query) or die("Errore in getMaxIdm" . mysqli_error($this->connection));
    if(mysqli_num_rows($queryResult)==0){
      return null;
    }else{
      $row=mysqli_fetch_assoc($queryResult);
      $queryResult->free();
      return $row['maxidm'];
    }
  }

  public function getPostList($maxidm){
    $query="SELECT Registrati.idr, Scrive.data, Scrive.ora, Messaggi.descrizione, Messaggi.argomento, Messaggi.mipiace, Messaggi.report, Messaggi.idm FROM Registrati, Scrive, Messaggi WHERE Registrati.idr=Scrive.idr AND Scrive.idm=Messaggi.idm AND Messaggi.idm<='$maxidm' ORDER BY Scrive.idm DESC LIMIT 7";
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


  public function getWrittenPosts($usr){
    $query="SELECT Registrati.idr, Scrive.data, Scrive.ora, Messaggi.descrizione, Messaggi.argomento, Messaggi.mipiace, Messaggi.report, Messaggi.idm FROM Registrati, Scrive, Messaggi WHERE Registrati.idr=Scrive.idr AND Registrati.idr='$usr' AND Scrive.idm=Messaggi.idm ORDER BY Scrive.idm DESC";
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

  public function addPost($usr, $ttl, $txt){
		$query="INSERT INTO Messaggi (argomento,descrizione,mipiace,report) VALUES ('$ttl','$txt',0,0);";
		mysqli_query($this->connection, $query) or die("Errore nell'aggiungere Post a Messaggi" . mysqli_error($this->connection));
		$query="SELECT MAX(idm) FROM Messaggi";
		$result = mysqli_query($this->connection, $query) or die("Errore in getMaxIdm" . mysqli_error($this->connection));
		$result=$result->fetch_array()[0] ?? '';
		$anno=date("Y-m-d");
		$ora=date("h:i:s");
		$query="INSERT INTO Scrive (idr, idm, data, ora) VAlUES ('$usr', '$result', '$anno', '$ora');";
		mysqli_query($this->connection, $query) or die("Errore nell'aggiungere Post a Messaggi" . mysqli_error($this->connection));
	}

  public function getPost($idPost){
    $query="SELECT Registrati.idr, Scrive.data, Scrive.ora, Messaggi.descrizione, Messaggi.argomento, Messaggi.mipiace, Messaggi.report, Messaggi.idm FROM Registrati, Scrive, Messaggi WHERE Registrati.idr=Scrive.idr AND Scrive.idm=Messaggi.idm AND Messaggi.idm='$idPost'";
    $queryResult = mysqli_query($this->connection, $query) or die("Errore in getPostList" . mysqli_error($this->connection));
      $result = mysqli_fetch_assoc($queryResult);
      $queryResult->free();
      return $result;
    }

      public function getCommentsPost($idPost){
        $query="SELECT Commenta.idr,Commenta.data, Commenti.descrizione FROM Commenta, Commenti WHERE Commenti.idc=Commenta.idc AND Commenti.messaggio='$idPost' ORDER BY Commenti.idc DESC";
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
		$aux = mysqli_num_rows($queryResult);
    $queryResult->free();
	return $aux;
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

  public function addcomment($usrid, $idm, $new, $anno, $ora){
    $query="INSERT INTO Commenti (descrizione, messaggio) VALUES (". '"' . $new . '"'. ", $idm)";
    mysqli_query($this->connection, $query) or die("Errore in addcomment1" . mysqli_error($this->connection));
    $query="SELECT max(idc) AS maxidc FROM Commenti";
    $queryResult=mysqli_query($this->connection, $query) or die("Errore in addcomment2" . mysqli_error($this->connection));
    $row=mysqli_fetch_assoc($queryResult);
    $queryResult->free();
    $idc =$row['maxidc'];
    $query="INSERT INTO Commenta (idr, idc, idm, data, ora) VALUES (". "'" . $usrid . "'". ", $idc, $idm,". "'". $anno . "'". ","."'". $ora."'".")";
    mysqli_query($this->connection, $query) or die("Errore in addcomment3" . mysqli_error($this->connection));
  }
}
?>
