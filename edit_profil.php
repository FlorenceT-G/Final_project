<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include_once 'myparam.inc.php';
	session_start();
	$pseudo = $_SESSION['pseudo'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset ="UTF-8">
        <title>Editer le profil</title>
        <link href="accueil.css"  rel="stylesheet">
    </head>
    <header></header>
    <body><div class="corps"></body>
    <footer></footer>
</html>
