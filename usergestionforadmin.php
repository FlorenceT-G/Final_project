<!DOCTYPE html>
<html>
<?php
	include 'myparam.inc.php';
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	session_start(); // ouverture de la session
	// si la variable de session pseudo est renseigner, la récupérer dans la variable $pseudo
	if (isset($_SESSION['pseudo']))
		{
			$pseudo = $_SESSION['pseudo'];
		}
?>

<head>
	<title>Gestion utilisateurs</title>
	<link href="accueil.css"  rel="stylesheet">
	<meta charset="utf-8">
</head>
	
<?php include "header.php"; ?>

<body><div class="corps">

<h2>Gestion des utilisateurs</h2>


<?php
if (isset($_GET['pseudoutilise']))
{
	//$testpseudo=$_GET['pseudoutilise']; //variable get qui revient du formulaire si le pseudo modifié était déjà utilisé dans la bdd et que la modification a échoué
	echo "<p class= 'msgerreur'>La modification a échoué : le pseudo existait déjà.</p>";
}
?>

<!-- tableau liste des utilisateurs centré-->
<center><table class="tableau">

<!-- titres des colonnes -->
<tr>
	<th class = 'colonnepseudo'>Pseudo</th>
	<th class = 'colonnenomprenom'>Nom</th>
	<th class = 'colonnenomprenom'>Prénom</th>
	<th class = 'colonnedate'>Date de naissance</th>
	<th class = 'colonnemail'>Mail</th>
	<th class = 'colonnelieu'>Lieu de résidence</th>
	<th class = 'colonnedate'>Date d'inscription</th>
	<th></th>
	<th></th>
</tr>



<!-- affichage ligne par ligne du résultat de la query-->
		<?php
			$base = mysqli_connect (MYHOST, MYUSER, MYPASS, DBNAME) or die ("Impossible de se connecter à la base de données"); 
			$sql = 	"SELECT pseudo, nom, prenom, naissance, mail, inscription, residence FROM personne ORDER BY inscription DESC" ;
			$result=mysqli_query ($base,$sql);
			
			while($row = mysqli_fetch_array($result)) 
			{
				//récupération des informations de la ligne
				$pseudoch= $row['pseudo'];
				$nom= $row['nom'];
				$prenom= $row['prenom'];
				$naissance= $row['naissance'];
				$mail= $row['mail'];
				$residence= $row['residence'];
				$inscription= $row['inscription'];
				
				
				echo "<tr>"; // une ligne par inscrit

				//formulaire dont les valeurs par défaut sont basées sur ce qu'il y a dans la base de données, mais qui sont modifiables. Avec le submit la base de données est mise à jour avec les informations dans les zones de texte

				echo "<form action=\"modifuser.php\" method=\"post\">"; 
					
					echo "<td class='colonnepseudo'>";
					echo "<input type=\"hidden\" name =\"pseudoinitial\" value=\"$pseudoch\">"; // pseudo initial non modifiable, non visible					
					echo "<input class=\"textimput\"type=\"text\" name =\"pseudo\" value=\"$pseudoch\" required></td>"; //pseudo modifiable
 					echo "<td class = 'colonnenomprenom'>";
 						echo "<input class=\"textimput\" type=\"text\" name =\"nom\" value=\"$nom\" required>";
 					echo "</td>";
 					echo "<td class = 'colonnenomprenom'>"; 
 					echo "<input class=\"textimput\" type=\"text\" name =\"prenom\" value=\"$prenom\" required>";
 					echo "</td>";
 					echo "<td class = 'colonnedate'>";
 						echo "<input class=\"dateimput\" type=\"date\" name =\"naissance\" value=\"$naissance\" required>";
 					echo "</td>";
 					echo "<td class = 'colonnemail'>";
 						echo "<input class=\"textimput\" type=\"text\" name =\"mail\" value=\"$mail\" required>";
 					echo "</td>";
 					echo "<td class = 'colonneresidence'>";
 						echo "<input class=\"textimput\" type=\"text\" name =\"residence\" value=\"$residence\" required>";
 					echo " </td>";
					echo "<td class = 'colonnedate'>";
						echo "<input class=\"dateimput\" type=\"date\" name =\"inscription\" value=\"$inscription\" disabled=\"disabled\">";
					echo "</td>";
 					echo "<td> <button type=\"submit\" name=\"Modifier\">Modifier</button> </td>";
 				echo"</form>";
 				
 				echo "<form action=\"suppruserforadmin.php\" method=\"post\">"; //formulaire qui reprend $pseudo avec un imput qui n'apparaît pas à l'écran et exécute un script pour supprimer l'utilisateur
 					echo "<td> <input type=\"hidden\" name =\"pseudoinitial\" value=\"$pseudoch\">";
					echo "<button type=\"submit\" name=\"Supprimer\">Supprimer</button> </td>";
 				echo"</form>";
 				
 				echo "</tr>";
			}
			
		mysqli_close($base);
		
		?>

</table></center>
</div></body>
	
<?php include "footer.php"; ?>

</html>