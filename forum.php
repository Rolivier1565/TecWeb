<?php
  require_once "php/db.php";
  use DB\DBAccess;
  header('Cache-Control: no cache');
  session_cache_limiter('private_no_expires');
  session_start();
  $paginaHTML=file_get_contents("forum.html");
  $connessione = new DBAccess();
  $connessioneOK= $connessione->openDBConnection();
  	if ($_SERVER["REQUEST_METHOD"] == "POST"){
      if (isset($_POST['next'])){
        array_push($_SESSION['maxidm'],($_POST['ultimopost'] -1));
      }else{
          if(end($_SESSION['maxidm'])!=$_SESSION['max']){
            array_pop($_SESSION['maxidm']);
          }
      }
  }
  $post="";  //dati grezzi dal db
  $listaPost = ""; //codice html da dare in output
  if($connessioneOK){
    if(!(isset($_SESSION['maxidm']))){
      $_SESSION['maxidm'] = array();
      array_push($_SESSION['maxidm'],0);
      array_push($_SESSION['maxidm'],$connessione->getMaxIdm());
      $_SESSION['max']=$connessione->getMaxIdm();
    }
    $post= $connessione->getPostList(end($_SESSION['maxidm']));
	  if (isset($_SESSION['usrid'])){
      if($post!=null){
		      foreach ($post as $singlePost) {
			         $listaPost.='<div class="posthead"><span class="usrname">'. $singlePost['idr'] . ':</span>' .'<span class="argomento">'. $singlePost['argomento'] .'</span>'. '<span class="datetime">'. $singlePost['data'].'</span>'. '<span class="datetime">' . $singlePost['ora'] . '</span></div>';
			         $listaPost.='<p class="post">'. $singlePost['descrizione'] . '</p>'  . '<div class="cont_bottoni"><button';
			         if ($connessione->checkLike($_SESSION['usrid'], $singlePost['idm'])){
				             $listaPost.=' class="actv" aria-label="togli mi piace" ';
			         }
			         else{
				             $listaPost.=' class="notactv" aria-label="metti mi piace" ';
			         }
			         $listaPost.= 'id="Button'. $singlePost['idm'] .'" type="button" onclick="like('. $singlePost['idm'] . ')" ></button><span class="numeroLike" id="Like'. $singlePost['idm'] .'">' . $singlePost['mipiace'] . '</span>';
               $listaPost.='<button';
               if ($connessione->checkReport($_SESSION['usrid'], $singlePost['idm'])){
                     $listaPost.=' class="repactv" aria-label="rimuovi segnalazione" ';
               }else{
				             $listaPost.=' class="repnotactv" aria-label="segnala il post" ';
			         }
               $listaPost.= 'id="Report'. $singlePost['idm'] .'" type="button" onclick="report('. $singlePost['idm'] . ')"></button>' . '<form method="post" action="getComments.php?id='.$singlePost['idm'].'"><input class="commenti" type="submit" name="commenti" value="" aria-label="apri pagina commenti del post"></form></div>';
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
  $pag=count($_SESSION['maxidm'])-1;
  if(end($_SESSION['maxidm'])==$_SESSION['max']){
      $listaPost.='<form id="piepagina" method="post" action="forum.php"><input type="hidden" name="ultimopost" value="'. $lastpost .'"/><span id="numpag">'.$pag .'</span><input type="submit" id="next" name="next" value="" aria-label="apri pagina successiva"/>';
  }
  else{
      if($lastpost==1){
        $listaPost.='<form id="piepagina" method="post" action="forum.php"><input type="hidden" name="ultimopost" value="'. $lastpost .'"/><input type="submit" id="prev" name="prev" value="" aria-label="apri pagina precedente"/><span id="numpag">'.$pag .'</span>';
      }else{
        $listaPost.='<form id="piepagina" method="post" action="forum.php"><input type="hidden" name="ultimopost" value="'. $lastpost .'"/><input type="submit" id="prev" name="prev" value="" aria-label="apri pagina successiva"/><span id="numpag">'.$pag .'</span><input type="submit" id="next" name="next" value="" aria-label="apri pagina successiva"/>';
    }
  }
    echo str_replace("<listaPost/>",$listaPost, $paginaHTML);
?>
