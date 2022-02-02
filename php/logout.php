<?php
session_start();
session_unset();
session_destroy();
header("Location: forum.php",TRUE,302);
?>