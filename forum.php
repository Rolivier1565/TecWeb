<?php
  require_once "php/db.php";
  use DB\DBAccess;

  session_start();
  $paginaHTML=file_get_contents("forum.html");
  $connessione = new DBAccess();
  $connessioneOK= $connessione->openDBConnection();

  $post="";  //dati grezzi dal db
  $listaPost = ""; //codice html da dare in output
  if($connessioneOK){
    $post= $connessione->getPostList();
	$liked="";
	$counter=-1;
	if (isset($_SESSION['usrid'])){
		$liked=$connessione->getLikedPosts($_SESSION['usrid']);
		if ($liked!=""){
			$counter=count($liked)-1; //counter a -1 == Non c'è un utente loggato o l'utente non ha messo nessun mi piace
		}
	}
	$connessione=$connessione->closeConnection();
    if($post!=null){
      foreach ($post as $singlePost) {
        $listaPost.='<h3>'. $singlePost['idr'] . '</h3>' .'<span>'. $singlePost['data'] .'</span>'. '<span>'. $singlePost['ora'].'</span>'. '<span>' . $singlePost['argomento'] . '</span>';
        $listaPost.='<p>'. $singlePost['descrizione'] . '</p>'  . '<button';
		if ($counter>=0){
			if ($singlePost['idm']==$liked[$counter]){
				$listaPost.=' class="actv"';
				$counter-=1;
			}
			else{
				$listaPost.=' class="notactv"';
			}
		}
		
		$listaPost.= ' type="button" onclick="like('. $singlePost['idm'] . ')" >Mi Piace</button><span id="'. $singlePost['idm'] .'">' . $singlePost['mipiace'] . '</span>'. '<button type="button" onclick="report('. $singlePost['idm'] . ')">Report</button>' . '<form method="post" action="getComments.php"><input type="hidden" name="id" value="'. $singlePost['idm'] .'"><input type="submit" name="commenti" value="commenti"></form>';
      }
    }else{
      $listaPost="<p> Non ci sono post da vedere...riprova più tardi.</p>";
    }
  }else{
    $listaPost="<p>Ci scusiamo ma i sistemi non sono al momento disponibili riprova più tardi.</p>";
  }
    echo str_replace("<listaPost/>",$listaPost, $paginaHTML);
?>
