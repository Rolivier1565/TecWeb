<?php
	require_once "php/db.php";
	use DB\DBAccess;
	$paginaHTML=file_get_contents("templates/areaRiservata.txt");
	session_start();
	$connessione = new DBAccess();
  $connessioneOK= $connessione->openDBConnection();

  $post="";  //dati grezzi dal db
  $listaPost = ""; //codice html da dare in output
  if($connessioneOK){
	  if (isset($_SESSION['usrid'])){
		  $post= $connessione->getWrittenPosts($_SESSION['usrid']);
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
		       }
         }else{
           $listaPost=file_get_contents("templates/noPostScritti.txt");
         }
       }else{
         //TODO: cliente non loggato chiudere connessione prima possibile
       }
  }else{
    header("Location: noDb.html",TRUE,301);
  }
	$handle=fopen("templates/motd.txt", "r");
	if ($handle){
		$line=fgets($handle);
		$random=date("z")%4;
		for ($i=0; $i<$random; $i++){
			$line=fgets($handle);
		}
		fclose($handle);
		$paginaHTML=str_replace("<motd/>", $line, $paginaHTML);
	}
	else{
		$paginaHTML=str_replace("<motd/>","Non c'è nessuna curiosità oggi",$paginaHTML);
	}
	$paginaHTML=str_replace("<currUser/>",$_SESSION['usrid'],$paginaHTML);
    echo str_replace("<listaPost/>",$listaPost, $paginaHTML);
?>