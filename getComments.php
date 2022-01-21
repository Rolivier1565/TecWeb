<?php
  require_once "php/db.php";
  use DB\DBAccess;

  $paginaHTML=file_get_contents("forum_commenti.html");
  $connessione = new DBAccess();
  $connessioneOK= $connessione->openDBConnection();

  $listaCommenti="";
  if($connessioneOK){
    $post = $connessione->getPost($_POST['id']);
    $commenti = $connessione->getCommentsPost($_POST['id']);
    $connessione=$connessione->closeConnection();

    if($commenti!=null){
    $listaCommenti.='<h3>'. $post['idr'] . '</h3>' .'<span>'. $post['data'] .'</span>'. '<span>'. $post['ora'].'</span>'. '<span>' . $post['argomento'] . '</span>';
    $listaCommenti.='<p>'. $post['descrizione'] . '</p>' . '<span> Mi piace ' . $post['mipiace'] . '</span>'. '<span> Report ' . $post['report'];
        foreach ($commenti as $singleCommenti) {
          $listaCommenti.="<h4>". $singleCommenti['idr'] . "</h4> <span>" . $singleCommenti['data']."</span>" ."<p>". $singleCommenti['descrizione'] . "</p>" . "<span> mi piace " . $singleCommenti['mipiace'] . "</span><span> report " . $singleCommenti['report'] . "</span>";
    }
    }else{
        $listaCommenti="<p>Non ci sono ancora commenti .... inizia tu la discussione !!</p>";
    }
  }else{
    $listaCommenti="<p>Ci scusiamo ma i sistemi non sono al momento disponibili riprova più tardi.</p>";
  }
   echo str_replace("<listaCommenti/>",$listaCommenti, $paginaHTML);
 ?>