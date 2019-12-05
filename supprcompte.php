<?php
	session_start()
?>

<?php
	if(isset($_POST['pseudo']))
	{
		header('Location: supprcompte.php');
	}	
	// utiliser le fichier indiquer pour les données de connexion à la bdd
	include_once("myparam.inc.php");
?>


<?php
	if(isset($_SESSION['pseudo']))
	{
	//obtenir une variable avec le pseudo de la session active, s'il y en a une
		$pseudo = $_SESSION['pseudo'];
	}
	
	// initialisation de la variable erreur
	$mdpError = null;

	// renseignement de la variable post au sortir du formulaire
	$mdp = $_POST['mdp'];
		
	// initialisation de la variable (doit être true pour passer à l'étape suivante)
	$valid = true;
	
	//s'il n'y a pas de mot de passe, erreur et les requêtes qui suivent ne s'effectueront pas
	if (empty($mdp)) 
	{
		$mdpError = "S'il vous plaît, saisissez votre mot de passe pour supprimer votre mot de passe";
		$valid = false;
	}
		
	//teste si le mot de passe est correct, sinon la suppression ne se fera pas
	if ($valid)
	{
		//encryptage du mot de passe (mdp encrypté sur la bdd)
		//$mdp = md5($mdp);

		$base = mysqli_connect (MYHOST, MYUSER, MYPASS,DBNAME) or die ("Problème de connexion à la base de données");
		$sqlcheckpassword = "SELECT pseudo FROM personne WHERE pseudo = '".$pseudo."' AND mot_de_passe = '".$mdp."'" ;
		$resultcheckpassword=mysqli_query($base,$sqlcheckpassword);
		
		//si la requête sqlcheckpassword ne donne aucun résultat (mauvais mot de passe)
		if(mysqli_num_rows($resultcheckpassword) == 0)
		{
			echo "Le mot de passe que vous avez entré est erronné. Veuillez recommencer pour supprimer votre compte.";
			$valid=false;
		}
		//TESTING EN COURS
		else
		{
		echo "Mdp trouvé et valide";
		}
			
	}
			// si toutes les conditions sont ok, suppression du compte
	if ($valid)
	{	 			/*DELETE FROM `personne` WHERE `personne`.`pseudo` = 'sasouxd' 	*/	   
		$sqlsuppr = "DELETE FROM personne  WHERE personne . pseudo = $pseudo";
		$resultsuppr=mysqli_query($base,$sqlsuppr);
		if(!$resultsuppr)
		{
			echo("Error description: " . mysqli_error($base));
		}
		else
		{
		echo "Votre compte a bien été supprimé";
		}
	    mysqli_close($base);
		header("Location: supprcompte.php");
		
	} 
?>

<!DOCTYPE html>

<html>

<body>
<?php
echo "<br>";
echo $mdp;
echo "<br>";
echo $pseudo;
echo "<br>";
echo ok;

?>
<h2>Supprimer son compte</h2>
<center> 
 <p> Voulez-vous vraiment supprimer votre compte ?</p>
 <p> Veuillez saisir votre mot de passe</p>
 
 <form class="formulaire" action="supprcompte.php" method="post">
 	
   <div class="control-group <?php echo !empty($mdpError)?'error':'';?>">
 	<label class="control-label">Mot de passe :</label>
		<input  class="saisietxt" name="mdp" type="text" placeholder="Saisir votre mot de passe" value="<?php echo !empty($mdp)?$mdp:'';?>">

				<?php if (!empty($mdpError)): ?>

					      		<span class="help-inline"><?php echo $mdp;?></span>
				<?php endif;?>
  </div>

<!--Bouton "soumettre" -->
  <div class="form-actions">
	<button type="submit" class="button_co">Supprimer son compte définitivement</button>
  </div>

 </form>

<p> Attention : vous allez supprimer définitivement votre compte et les signalements que vous avez effectués. Il n'y aura aucune possibilité de le récupérer par la suite. </p>

</center>
</body>
</html>


