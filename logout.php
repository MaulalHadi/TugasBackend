

<?php 

session_start();
session_reset();

$_SESSION = [];
header("Location:login.php");
; ?>
