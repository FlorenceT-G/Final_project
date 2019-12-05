<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include 'myparam.inc.php';

// récupération de variable post ( tirée directement de la base de données, pas d'erreur possible (que ce qoit vide, ou une non correspondance) )
$pseudoinitial = $_POST['pseudoinitial'];	
		
//connexion à la base de données
$base = mysqli_connect (MYHOST, MYUSER, MYPASS, DBNAME); 
		
//requête SQL pour supprimer les informations de l'utilisateur dans la base de données
$sql = "DELETE FROM personne WHERE pseudo = '$pseudoinitial'";

$result=mysqli_query ($base,$sql);
			
mysqli_close($base);	// fermeture de la connexion

header("Location: usergestionforadmin.php"); // relance sur la page usergestionforadmin.php
	
		
?>