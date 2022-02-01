<?php
	require_once "php/db.php";
	use DB\DBAccess;
	$paginaHTML=file_get_contents("templates/areaRiservata.txt");
	session_start();
	$connessione = new DBAccess();
  $connessioneOK= $connessione->openDBConnection();
  
  function inputTrim($input){
		$input=trim($input);
		$input=stripslashes($input);
		$input=htmlspecialchars($input);
		return $input;
	}

  $post="";  //dati grezzi dal db
  $listaPost = ""; //codice html da dare in output
  if($connessioneOK){
	  if (isset($_SESSION['usrid'])){
		  if ($_SERVER["REQUEST_METHOD"] == "POST"){			//è stato chiesto di modificare un post
				if(isset($_POST['delete'])){					//è stato chiesto di cancellarlo
					$connessione->deletePost($_POST['idm']);
					$connessione->closeConnection();
					header("Location: areaRiservata.php");
				}
				else{											//è stato chiesto di aggiungerlo
					$arg=inputTrim($_POST["argomento"]);
					$testo=inputTrim($_POST["contenuto"]);
					$connessione->addPost($_SESSION['usrid'], $arg, $testo);
					$connessione->closeConnection();
					header("Location: areaRiservata.php");
				}
		  }
		  $post= $connessione->getWrittenPosts($_SESSION['usrid']); 
		if($post!=null){
		      foreach ($post as $singlePost) {
			         $listaPost.='<div class="posthead">' .'<span class="argomento">'. $singlePost['argomento'] .'</span>'. '<span class="datetime">'. $singlePost['data'].'</span>'. '<span class="datetime">' . $singlePost['ora'] . '</span></div>';
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
               $listaPost.= 'id="Report'. $singlePost['idm'] .'" type="button" onclick="report('. $singlePost['idm'] . ')"></button><span class="numeroLike" id="ReportCount'. $singlePost['idm'] .'">' . $singlePost['report'] . '</span>' . '<form method="post" action="getComments.php"><input type="hidden" name="id" value="'. $singlePost['idm'] .'"><input class="commenti" type="submit" name="commenti" value=""></form>' . '<form method="post" action="editPost.php"><input type="hidden" name="idm" value="'. $singlePost['idm'] .'"><input class="instrBtn modPost" type="submit" name="edit" value="Modifica Post"></form><form method="post" action="areaRiservata.php"><input type="hidden" name="idm" value="'. $singlePost['idm'] .'"><input class="instrBtn modPost" type="submit" name="delete" value="Elimina Post"></form></div>';
               $lastpost = $singlePost['idm'];
		       }
         }else{
           $listaPost=file_get_contents("templates/noPostScritti.txt");
         }
       }else{
         header("Location: login.php",TRUE,301);
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