<?php
//TODO: chiudere connessione
  require_once "php/db.php";
  use DB\DBAccess;

  session_start();
  $paginaHTML=file_get_contents("forum_commenti.html");
  $connessione = new DBAccess();
  $connessioneOK= $connessione->openDBConnection();

  $listaCommenti="";
  if($connessioneOK){
    $post = $connessione->getPost($_REQUEST['id']);
    $commenti = $connessione->getCommentsPost($_REQUEST['id']);

    if($commenti!=null){
	  $listaCommenti.='<p>Vai alla tua <a href="areaRiservata.php">Area Personale!</a></p>';
      $listaCommenti.='<div class="posthead"><span class="usrname">'. $post['idr'] . ':</span>' .'<span class="argomento">'. $post['argomento'] .'</span>'. '<span class="datetime">'. $post['data'].'</span>'. '<span class="datetime">' . $post['ora'] . '</span></div>';
      $listaCommenti.='<p class="post">'. $post['descrizione'] . '</p>'  . '<div class="cont_bottoni"><button';
      if ($connessione->checkLike($_SESSION['usrid'], $post['idm'])){
            $listaCommenti.=' class="actv" aria-label="togli mi piace" ';
      }
      else{
            $listaCommenti.=' class="notactv" aria-label="metti mi piace" ';
      }
      $listaCommenti.= 'id="Button'. $post['idm'] .'" type="button" onclick="like('. $post['idm'] . ')" ></button><span class="numeroLike" id="Like'. $post['idm'] .'">' . $post['mipiace'] . '</span>';
      $listaCommenti.='<button';
      if ($connessione->checkReport($_SESSION['usrid'], $post['idm'])){
            $listaCommenti.=' class="repactv" aria-label="rimuovi segnalazione" ';
      }else{
            $listaCommenti.=' class="repnotactv" aria-label="segnala il post" ';
      }
      $listaCommenti.= 'id="Report'. $post['idm'] .'" type="button" onclick="report('. $post['idm'] . ')"></button><span class="numeroLike" id="ReportCount'. $post['idm'] .'">' . $post['report'] . '</span></div>';
      $listaCommenti.='<form method="post" action="addcommento.php" id="creacommento"><input type="hidden" name="idm" value="'. $post['idm'] .'"><label for="commento" id="lc">Inserisci il commento:</label><textarea id="boxcommento" class="inputField" name="commento" required></textarea><input class="instrBtn" id="agg" type="submit" name="aggiungi" value="aggiungi"/></form>';
        foreach ($commenti as $singleCommenti) {
          $listaCommenti.='<div class="commenthead"><span class="usrname">'. $singleCommenti['idr'] . '</span> <span class="datetime">' . $singleCommenti['data']."</span>" .'<p class="descrizionecomm">'. $singleCommenti['descrizione'] . "</p></div>";
    }
    }else{
      $listaCommenti.='<div class="posthead"><span class="usrname">'. $post['idr'] . ':</span>' .'<span class="argomento">'. $post['argomento'] .'</span>'. '<span class="datetime">'. $post['data'].'</span>'. '<span class="datetime">' . $post['ora'] . '</span></div>';
      $listaCommenti.='<p class="post">'. $post['descrizione'] . '</p>'  . '<div class="cont_bottoni"><button';
      if ($connessione->checkLike($_SESSION['usrid'], $post['idm'])){
            $listaCommenti.=' class="actv" aria-label="togli mi piace" ';
      }
      else{
            $listaCommenti.=' class="notactv" aria-label="metti mi piace" ';
      }
      $listaCommenti.= 'id="Button'. $post['idm'] .'" type="button" onclick="like('. $post['idm'] . ')" ></button><span class="numeroLike" id="Like'. $post['idm'] .'">' . $post['mipiace'] . '</span>';
      $listaCommenti.='<button';
      if ($connessione->checkReport($_SESSION['usrid'], $post['idm'])){
            $listaCommenti.=' class="repactv" aria-label="rimuovi segnalazione" ';
      }else{
            $listaCommenti.=' class="repnotactv" aria-label="segnala il post" ';
      }
      $listaCommenti.= 'id="Report'. $post['idm'] .'" type="button" onclick="report('. $post['idm'] . ')"></button></div>';
      $listaCommenti.='<form method="post" action="addcommento.php" id="creacommento"><input type="hidden" name="idm" value="'. $post['idm'] .'"><label for="commento" id="lc">Inserisci il commento:</label><textarea id="boxcommento" class="inputField" name="commento" required></textarea><input class="instrBtn" id="agg" type="submit" name="aggiungi" value="aggiungi"/></form>';
      $listaCommenti.="<p>Non ci sono ancora commenti ... Inizia tu la discussione!!</p>";
    }
  }else{
    $listaCommenti="<p>Ci scusiamo ma i sistemi non sono al momento disponibili riprova più tardi.</p>";
  }
   echo str_replace("<listaCommenti/>",$listaCommenti, $paginaHTML);
 ?>
