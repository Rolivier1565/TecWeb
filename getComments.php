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
    $post = $connessione->getPost($_POST['id']);
    $commenti = $connessione->getCommentsPost($_POST['id']);

    if($commenti!=null){
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
      $listaCommenti.='<form method="post" action="php/addcommento.php"><input id="boxcommento" class="inputField" type="text" name="commento" placeholder="Inserisci il tuo commento"/><input class="instrBtn" type="submit" name="aggiungi" value="aggiungi"/></form>';
        foreach ($commenti as $singleCommenti) {
          $listaCommenti.='<span class="usrname">'. $singleCommenti['idr'] . '</span> <span class="datetime">' . $singleCommenti['data']."</span>" .'<p calss="post">'. $singleCommenti['descrizione'] . "</p>";
    }
    }else{
        $listaCommenti="<p>Non ci sono ancora commenti .... inizia tu la discussione !!</p>";
    }
  }else{
    $listaCommenti="<p>Ci scusiamo ma i sistemi non sono al momento disponibili riprova più tardi.</p>";
  }
   echo str_replace("<listaCommenti/>",$listaCommenti, $paginaHTML);
 ?>
