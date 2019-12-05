<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include 'myparam.inc.php';

// récupération des variables post ( tirée directement de la base de données, pas d'erreur possible (que ce soit vide, ou de non correspondance) )
$pseudoch = $_POST['pseudo'];
$nomverna= $_POST['nomverna'];
$date= $_POST['date'];
$lieu= $_POST['lieu'];	
		
//connexion à la base de données
$base = mysqli_connect (MYHOST, MYUSER, MYPASS, DBNAME); 
		
//requête SQL pour supprimer les informations du signalement dans la base de données
$sql = "DELETE FROM recensement WHERE pseudo = '$pseudoch' and nomverna = '$nomverna' and _date = '$date' and lieu = '$lieu'";

$result=mysqli_query ($base,$sql);
			
mysqli_close($base);// fermeture de la connexion

header("Location: recensementgestionforadmin.php"); // relance sur la page usergestionforadmin.php	
?>