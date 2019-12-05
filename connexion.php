<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include_once("myparam.inc.php");
	$_SESSION = null; // les variables de sessions sont nulles avant la connexion de l'utilisateur
	if(!empty($_POST)) // si les champs sont remplis
	{
		$pseudoError = null; // aucune erreur
		$mdpError = null;
		$pseudo = $_POST['pseudo']; // $pseudo fetch le pseudo entré dans l'input prévu à cet effet
		$mdp = $_POST['mdp']; 	   // Pareil que pour pseudo
		$valid = true;
		if(empty($pseudo)) // si les champs sont vides
		{
			$pseudoErreur = 'Veuillez entrer un pseudo.';
			$valid = false;
		}
		if(empty($mdp)) 
		{
			$mdpErreur = 'Veuillez entrer un pseudo.';
			$valid = false;
		}
		if($valid) // si les champs sont valides
		{
			$mdp = md5($mdp); // on encrypte le mot de passe
			$connect = mysqli_connect(MYHOST, MYUSER, MYPASS, DBNAME) or die ("Problème de connexion à la base de données");
			$sql = "SELECT pseudo FROM personne WHERE pseudo = '".$pseudo."' AND mot_de_passe = '".$mdp."';"; // query
			$requete = mysqli_query($connect,$sql);
			if(mysqli_num_rows($requete) == 0) // si la query ne retourne rien, alors on soulève une erreur
			{
				echo "Le pseudo ou le mot de passe que vous avez entrés sont erronnés ou n'existent pas dans la base de données. Veuillez recommencer ou vous inscrire.";
	        }
	        else
	        {
				if(isset($_POST['pseudo'])) // sinon
				{
					session_start(); // start la session
	        			$_SESSION['pseudo'] = $pseudo; // on store le pseudo dans une variable de session
	        			header('Location: ./accueil.php'); // redirige vers l'accueil
				}
			}
		}
	}
// connexion à la base de données : myparam.inc.php
//
// $requete = mysqli_query($connect, "SELECT * FROM personne WHERE pseudo = '".pseudo."' AND mot_de_passe = '".$mdp."';");
// si mysqli_num_rows($connect) != 0) // mysqli_PHP/index.php_num_rows : compte le nombre de résultat de la requête. 1 s'il y a un résultat
// stocker les variables siimples dans des variables de sessions qui sera valable sur toutes les pages du site $_SESSION['pseudo'] = $pseudo;
// header('Location: ./acceP_PHP/index.phpuil.php'); // permet de rediriger l'utilisateur vers la page d'acceuil une fois connecté/inscrit
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="accueil.css" rel="stylesheet">
		<title>Connexion</title>
	</head>

	<?php include "header.php"; ?>

	<body>
	<div class="corps">
	<h2>Connexion</h2>
	<!-- Formulaire de connexion -->
	<form action="#" method="post" class="formulaire">
	<center>
		<table>
		<tr>
			<td><label for="pseudo">Pseudo :</label></td>
			<td><input type="text" name="pseudo" placeholder="Nom d'utilisateur..."></td>
		</tr>
	
		<tr>
			<td><label for="mdp">Mot de Passe :</label></td>
			<td><input type="password" name="mdp"  placeholder="Mot de passe..."></td>
		</tr>
		</table>
		<div>
			<input class="button_co" type="submit" value="Connexion" />
		</div>
		</center>
		</form>
	</div>
	</body>

	<?php include "footer.php"; ?>

</html>
