<?php
  require_once "php/db.php";
  use DB\DBAccess;

  $paginaHTML=file_get_contents("forum.html");
  $connessione = new DBAccess();
  $connessioneOK= $connessione->openDBConnection();

  $post="";  //dati grezzi dal db
  $listaPost = ""; //codice html da dare in output
  if($connessioneOK){
    $post= $connessione->getPostList();
    $connessione=$connessione->closeConnection();
    if($post!=null){
      foreach ($post as $singlePost) {
        $listaPost.='<h3>'. $singlePost['idr'] . '</h3>' .'<span>'. $singlePost['data'] .'</span>'. '<span>'. $singlePost['ora'].'</span>'. '<span>' . $singlePost['argomento'] . '</span>';
        $listaPost.='<p>'. $singlePost['descrizione'] . '</p>' . '<button type="button" onclick="likehandler()">Mi Piace</button><span>(' . $singlePost['mipiace'] . ')</span>'. '<span> Report ' . $singlePost['report'] . '<form method="post" action="getComments.php"><input type="hidden" name="id" value="'. $singlePost['idm'] .'"><input type="submit" name="commenti" value="commenti"></form>';
      }
    }else{
      $listaPost="<p> Non ci sono post da vedere...riprova più tardi.</p>";
    }
  }else{
    $listaPost="<p>Ci scusiamo ma i sistemi non sono al momento disponibili riprova più tardi.</p>";
  }
    echo str_replace("<listaPost/>",$listaPost, $paginaHTML);
?>
