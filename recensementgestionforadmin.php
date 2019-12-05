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
	<title>Gestion table recensement</title>
	<link href="accueil.css"  rel="stylesheet">
	<meta charset="utf-8">
</head>
	
<?php include "header.php"; ?>

<body><div class="corps">

<h2>Gestion table recensement</h2>

<!-- tableau liste des utilisateurs centré-->
<center><table class="tableau">

<!-- titres des colonnes -->
<tr>
	<th class = 'colonnepseudo'>Pseudo</th>
	<th class = 'colonnenomverna'>Nom vernaculaire</th>
	<th class = 'colonnedate'>Date</th>
	<th class = 'colonnelieu'>lieu</th>
	<th></th>
	<th></th>
</tr>



<!-- affichage ligne par ligne du résultat de la query-->
		<?php
			$base = mysqli_connect (MYHOST, MYUSER, MYPASS, DBNAME) or die ("Impossible de se connecter à la base de données"); 
			$sql = 	"SELECT pseudo, nomverna, _date, lieu FROM recensement ORDER BY _date DESC" ;
			$result=mysqli_query ($base,$sql);
			
			while($row = mysqli_fetch_array($result)) //déroule chaque ligne de la query jusqu'à la fin
			{
				//récupération des information de la ligne
				$pseudoch= $row['pseudo'];
				$nomverna= $row['nomverna'];
				$date= $row['_date'];
				$lieu= $row['lieu'];
				
				echo "<tr>"; // une ligne par signalement

				//formulaire dont les valeurs par défaut sont basées sur ce qu'il y a dans la base de données, mais qui sont modifiables. Avec le submit la base de données est mise à jour avec les informations dans les zones de texte

				echo "<form action=\"modifrecensement.php\" method=\"post\">"; 
					
					echo "<td class='colonnepseudo'>";
						//pseudo visible mais non modifiable, puis non visible sans disabled (sinon ne peut pas s'exporter en variable POST)	
						echo "<input class=\"textimput\"type=\"text\" name =\"pseudo\" value=\"$pseudoch\" disabled=\"disabled\">";
						echo "<input class=\"textimput\"type=\"hidden\" name =\"pseudo\" value=\"$pseudoch\">";
					echo "</td>"; 
 					echo "<td class = 'colonnenomverna'>";
 						// nom vernaculaire visible mais non modifiable, puis non visible sans disabled (sinon ne peut pas s'exporter en variable POST)
 						echo "<input class=\"textimput\" type=\"text\" name =\"nomverna\" value=\"$nomverna\" disabled=\"disabled\">";
 						echo "<input class=\"textimput\" type=\"hidden\" name =\"nomverna\" value=\"$nomverna\">";
 					echo "</td>";  
 					echo "<td class = 'colonnedate'>";
 						// date visible mais non modifiable, puis non visible sans disabled (sinon ne peut pas s'exporter en variable POST) 
 						echo "<input class=\"dateimput\" type=\"date\" name =\"date\" value=\"$date\" disabled=\"disabled\" >";
 						echo "<input class=\"dateimput\" type=\"hidden\" name =\"date\" value=\"$date\" >";
 					echo "</td>"; 
 					echo "<td class = 'colonnelieu'>";
 						// variable pour garder le lieu initial, en cas de modification dans l'imput précédent, invisible
 						echo "<input type=\"hidden\" class=\"textimput\" type=\"text\" name =\"lieuinitial\" value=\"$lieu\">";
 						// lieu visible et modifiable, ne peut pas être soumis si vide grâce à required
 						echo "<input class=\"textimput\" type=\"text\" name =\"lieu\" value=\"$lieu\" required>";
 					echo "</td>"; 
 					//bouton submit pour le formulaire de modification
 					echo "<td> <button type=\"submit\" name=\"Modifier\">Modifier</button> </td>";
 				echo"</form>";
 				
 				echo "<form action=\"supprrecensement.php\" method=\"post\">"; //formulaire qui reprend les info de la ligne sans les montrer à l'utilisateur pour lancer la suppression
 					echo "<td>";
 						echo "<input type=\"hidden\" name =\"pseudo\" value=\"$pseudoch\">";
 						echo "<input type=\"hidden\" name =\"nomverna\" value=\"$nomverna\">";
 						echo "<input type=\"hidden\" name =\"date\" value=\"$date\">";
 						echo "<input type=\"hidden\" name =\"lieu\" value=\"$lieu\">";
 						//bouton submit pour le formulaire de suppression
						echo "<button type=\"submit\" name=\"Supprimer\">Supprimer</button>";"
					echo "</td>";
 				echo"</form>";
 				
 				echo "</tr>";
			}
			
		mysqli_close($base); // fermeture de la connexion sql
		
		?>

</table></center>
</div></body>
	
<?php include "footer.php"; ?>

</html>