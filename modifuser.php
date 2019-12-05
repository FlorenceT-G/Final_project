<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include 'myparam.inc.php';
	

	$globaleErreur = null;

	if ( !empty($_POST) ) // s'il y a des valeurs post
	{
		//on vide les codes erreurs 		
		$pseudoutiliseError=null;
	
		// récupération des variables post
		$pseudoinitial = $_POST['pseudoinitial'];
		$pseudoch = $_POST['pseudo'];
		$nom= $_POST['nom'];
		$prenom= $_POST['prenom'];
		$naissance= $_POST['naissance'];
		$mail= $_POST['mail'];
		$residence= $_POST['residence'];
		
		
		// validate input
		$valid=true;
		
		//nom de la table à modifier
		$table="personne";
		 		
		if ( !filter_var($mail,FILTER_VALIDATE_EMAIL) ) //si l'email est valide
		{
			$mailErreur = 'Veuillez entrer une adresse mail valide';
			$valid = false;
		}		

		// si le pseudo a été modifié (est différent du pseudo initial)
		if ($pseudoinitial != $pseudoch) 
		{
			$base = mysqli_connect (MYHOST, MYUSER, MYPASS, DBNAME); // connexion à la bdd
			$check_pseudo = "SELECT pseudo FROM personne WHERE pseudo = '$pseudoch'";
			$check_result =  mysqli_query($base,$check_pseudo); // requête qui permet de vérifier si le pseudo entré n'est pas déjà utilisé
			$count = mysqli_num_rows($check_result); // si le pseudo n'est pas utilisé retourne 0, sinon 1
			
			if ($count == 1) // s'il y a un résultat correspondant au pseudo saisi par l'utilisateur
			{
				$pseudoutiliseErreur="ERREUR: Le pseudo que vous avez entré est déjà utilisé.";
				$valid = false; 
			}
			mysqli_close($base); //fermeture de la connexion
		}


		if ($valid) //si tout est bon jusqu'ici on peut passer au reste
		{
			$naissance = date("Y-m-d", $naissance); //transformation de la date de naissance par l'utilisateur en un format accepté par MySQL
			//$inscription = date("Y-m-d", $inscription); //transformation de la date d'inscription en un format accepté par MySQL
			
			$base = mysqli_connect(MYHOST, MYUSER, MYPASS, DBNAME); //requête de connexion à la base de donnée					   
		
			//requête SQL pour modifier les champs dans la base de données
			$sql ="UPDATE $table
					SET pseudo = '$pseudoch', nom = '$nom', prenom = '$prenom', naissance = '$naissance', mail = '$mail', residence = '$residence'
					WHERE pseudo = '$pseudoinitial'";

			$result=mysqli_query ($base,$sql);
			

			mysqli_close($base);	// fermeture de la connexion

			
		}
	}

	if (!($count == 1)) // si le pseudo modifié existait déjà dans la bdd et donc que la modification n'a pas pu se faire
	{
		header("Location: usergestionforadmin.php"); // relance sur la page usergestionforadmin.php avec variables get
	}
	else // si tout s'est bien exécuté
	{
		header("Location: usergestionforadmin.php?pseudoutilise=1"); // relance sur la page usergestionforadmin.php
	}
	
	
		
?>