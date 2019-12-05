<?php
	session_start();
	$pseudo = $_SESSION['pseudo'];	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Page d'accueil</title>
	<link href="accueil.css"  rel="stylesheet">
	<meta charset="utf-8" >
</head>

	<?php include "header.php" ?>

<body>

	<div class="corps">
	<?php 
		if ($_SESSION['pseudo'])
		{
			echo("Bonjour, $pseudo");
		}
	?>
	
	<h2>Bienvenue !</h2>
	<p> Bienvenue cher utilisateur ! </p>
	<p>
		Tu es sur un site collaboratif qui permet la collecte de nombreuses informations sur la localisation d'espèces nuisibles :
	</p>
	<ul>
		<li>
			Pour consulter les différentes signalisations déjà effectuées, pas besoin de t'inscrire, tu peux directement accéder à la page <a href="MenuConsultation">Consultation</a> et effectuer une recherche selon l'espèce ou la localisation désirée.
		</li>
	    <li>
	    	Pour pourvoir soumettre un signalement, il faut que tu te crées un profil, et que tu te connectes dessus. Ensuite, rendez-vous sur la page <a href="MenuSignalement">Signalement</a>.
	    </li>
	    <li>
	    	Pour que l'expérience des inscrits soit plus sympathique, un système de <a href = "ClassementUtilisateur"> classement </a> existe : signale toutes les espèces nuisibles que tu vois pour te hisser en haut du podium !
	    </li>
	    <li>
	    	Nos utilisateurs ne sont pas les seuls à être classés ! Découvre le classement des <a href="ClassementEspeces"> espèces les plus signalées</a> sur le site !
	    </li>
    </ul>
    <p> C'est bien de signaler des espèces et de connaître leur localisation, mais à quoi ça sert ? </p>
    <p> Certaines espèces nuisibles recensées sur ce site sont des vecteurs de maladie ! Découvre comment t'en prémunir sur la page <a href="MenuMaladies">Maladies</a></p>
	</div>
</body>
	
	<?php include "footer.php" ?>

</html>
