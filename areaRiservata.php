<?php
	require_once "php/db.php";
	use DB\DBAccess;
	session_start();
	echo "Benvenuto, " . $_SESSION["usrid"];
?>