<!DOCTYPE html>
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

<html>
<head>
	<title>Page d'accueil</title>
	<link href="accueil.css"  rel="stylesheet">
	<meta charset="utf-8" >
</head>
	
<?php include "header.php" ?>

<body>
	<div class="corps">

<h2>Classement des utilisateurs selon le nombre de signalements</h2>
<!-- tableau du classement centré-->
<center><table class="tableau">
<!-- titres des colonnes -->
<tr>
	<th>Pseudo</th>
	<th>Nombre de signalements</th>
</tr>
		<!-- affichage ligne par ligne du résultat de la query : nom et nombre de signalements de la personne, dans l'ordre croissant du nombre de signalements -->
		<?php
			$base = mysqli_connect (MYHOST, MYUSER, MYPASS, DBNAME); 
			$sql = 	"SELECT pseudo, count(*) as nbsignalements FROM recensement GROUP BY pseudo ORDER BY count(*) DESC " ;
			$result=mysqli_query ($base,$sql);

			while($row = mysqli_fetch_array($result)) {
				$pseudo= $row['pseudo'];
				$nb= $row['nbsignalements'];

				echo "<tr>";
 				echo "<td>$pseudo</td>";
 				echo "<td>$nb</td>";
 				echo "</tr>";
								}
		mysqli_close($base);
		?>
</table></center>
</div>
</body>
	
<?php include "footer.php" ?>
	
</html>
