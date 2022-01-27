<?php
  require_once "php/db.php";
  use DB\DBAccess;

  session_start();
  unset($_SESSION['maxidm']);
  $paginaHTML=file_get_contents("forum.html");
  $connessione = new DBAccess();
  $connessioneOK= $connessione->openDBConnection();
  	if ($_SERVER["REQUEST_METHOD"] == "POST"){
      if (isset($_POST['next'])){
        array_push($_SESSION['maxidm'],($_POST['ultimopost'] -1));
      }else{
          array_pop($_SESSION['maxidm']);
      }
  }
  $post="";  //dati grezzi dal db
  $listaPost = ""; //codice html da dare in output
  if($connessioneOK){
    if(!(isset($_SESSION['maxidm']))){
      $_SESSION['maxidm'] = array();
      array_push($_SESSION['maxidm'],$connessione->getMaxIdm());
    }
    $post= $connessione->getPostList(end($_SESSION['maxidm']));
	  if (isset($_SESSION['usrid'])){
      if($post!=null){
		      foreach ($post as $singlePost) {
			         $listaPost.='<h3>'. $singlePost['idr'] . '</h3>' .'<span>'. $singlePost['data'] .'</span>'. '<span>'. $singlePost['ora'].'</span>'. '<span>' . $singlePost['argomento'] . '</span>';
			         $listaPost.='<p>'. $singlePost['descrizione'] . '</p>'  . '<button';
			         if ($connessione->checkLike($_SESSION['usrid'], $singlePost['idm'])){
				             $listaPost.=' class="actv"';
			         }
			         else{
				             $listaPost.=' class="notactv"';
			         }
			         $listaPost.= 'id="Button'. $singlePost['idm'] .'" type="button" onclick="like('. $singlePost['idm'] . ')" ></button><span id="Like'. $singlePost['idm'] .'">' . $singlePost['mipiace'] . '</span>';
               $listaPost.='<button';
               if ($connessione->checkReport($_SESSION['usrid'], $singlePost['idm'])){
                     $listaPost.=' class="repactv"';
               }else{
				             $listaPost.=' class="repnotactv"';
			         }
               $listaPost.= 'id="Report'. $singlePost['idm'] .'" type="button" onclick="report('. $singlePost['idm'] . ')"></button>' . '<form method="post" action="getComments.php"><input type="hidden" name="id" value="'. $singlePost['idm'] .'"><input type="submit" name="commenti" value="commenti"></form>';
               $lastpost = $singlePost['idm'];
           }
         }else{
           $listaPost="<p>Non ci sono altri post da vedere torna indietro o più tardi...</p>";
         }
       }else{
         //TODO: cliente non loggato chiudere connessione prima possibile
       }
  }else{
    $listaPost="<p>Ci scusiamo ma i sistemi non sono al momento disponibili riprova più tardi.</p>";
  }
    $listaPost.='<form method="post" action="forum.php"><input type="hidden" name="ultimopost" value="'. $lastpost .'"><input type="submit" id="prev" name="prev" value="prev"/><input type="submit" id="next" name="next" value="next"/>';
    echo str_replace("<listaPost/>",$listaPost, $paginaHTML);
?>
