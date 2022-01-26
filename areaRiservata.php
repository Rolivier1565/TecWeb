<?php
	require_once "php/db.php";
	use DB\DBAccess;
	$paginaHTML=file_get_contents("templates/areaRiservata.txt");
	session_start();
	echo str_replace("<errorMsg/>",$errMsg, $paginaHTML);
?>