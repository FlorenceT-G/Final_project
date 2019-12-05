<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	
	include 'myparam.inc.php';
	session_start();
	if(isset($_SESSION['pseudo']))
	{
		$pseudo = $_SESSION['pseudo'];
		if ( !empty($_POST)) 
		{
			// keep track validation errors
			$especeError = null;
			$localisationError = null;
			$dateError = null;
			// keep track post values
			// $pseudo = $_POST['pseudo'];
			$espece = $_POST['espece'];
			$date = strtotime($_POST['date']);
			$localisation = $_POST['localisation'];
			// validate input
			$valid = true;
			
			if (empty($espece)) 
			{
				$especeError = "S'il vous plaît, sélectionnez le nom de l'espèce à signaler";
				$valid = false;
			}
			if (empty($localisation)) 
			{
				$localisationError = "S'il vous plaît, saisissez la localisation de votre signalement";
				$valid = false;
			}
			if (empty($date)) 
			{
				$dateError = "S'il vous plaît, saisissez la date à laquelle vous avez observé l'espèce nuisible";
				$valid = false;
			}
			// insert data
			if ($valid) 
			{
				$date = date("Y-m-d", $date);
				$base = mysqli_connect(MYHOST, MYUSER, MYPASS, DBNAME);
				$sql = 	"INSERT INTO `recensement`(`pseudo`, `nomverna`, `_date`, `lieu`) VALUES ('$pseudo', '".$espece."','$date', '$localisation')";
				$result = mysqli_query($base,$sql);
				
				if(!$result)
				{
 					echo("Error description: ".mysqli_error($base));
				}
				mysqli_close($base);
				header("Location: accueil.php");
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Signaler</title>
    <meta charset="utf-8">
    <link href="accueil.css"  rel="stylesheet">
</head>

<?php include "header.php"; ?>

<body>
    <div class="corps">
		<h2>Faire le signalement d'une espèce nuisible</h2>

<!-- formulaire, utilise le php du nom "signaler.php (ce fichier)"-->
		<form class="formulaire" action="signaler.php" method="post">
			<div class="control-group <?php echo !empty($Error)?'error':'';?>">

			    <label class="control-label">Nom de l'espèce nuisible</label>
				<div>
			    	<SELECT name="espece" value="<?php echo !empty($espece)?$espece:'';?>">
				    	<?php
				    		$base = mysqli_connect (MYHOST, MYUSER, MYPASS, DBNAME); 
				    		$sql = 	"SELECT nomverna FROM especes" ;
				    		$result=mysqli_query ($base,$sql);
							while($row = mysqli_fetch_array($result)) 
							{
								$espece= $row['nomverna'];
								echo "<OPTION value='$espece'> $espece </OPTION> \n"; 
							}
								
							mysqli_close($base);
						?>
					</SELECT>	

				   	<?php if (!empty($especeError)): ?>
					<span class="help-inline"> <?php echo $especeError;?> </span>
			      	<?php endif; ?>
			    </div>
			</div>

			<div class="control-group <?php echo !empty($localisationError)?'error':'';?>">

				<label class="control-label">Localisation</label>

				<div>
				  	<input  class="saisietxt" name="localisation" type="text" placeholder="Saisir une localisation" value="<?php echo !empty($localisation)?$localisation:'';?>">
				      	<?php if (!empty($localisationError)): ?>
		    	  		<span class="help-inline"><?php echo $localisationError;?></span>
				      	<?php endif;?>
		    	</div>
		  		<div class="control-group <?php echo !empty($dateError)?'error':'';?>">
				    <label class="control-label">Date</label>
				    <div>
				      	<input  class="saisietxt" name="date" type="date"  placeholder="Saisir une date" value="<?php echo !empty($date)?$date:'';?>">
				      	<?php if (!empty($dateError)): ?>
				      		<span class="help-inline"><?php echo $dateError;?></span>
				      	<?php endif;?>
				    </div>
				</div>
				<div class="form-actions">

					<button type="submit" class="button_co">Soumettre le signalement</button>

				</div>
			</div>
		</form>
    </div>
</body>

<?php include "footer.php"; ?>

</html>
