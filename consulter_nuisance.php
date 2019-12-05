<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>

<?php
    session_start();
    include_once "myparam.inc.php";	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Consulter</title>
		<link href="accueil.css"  rel="stylesheet">
	</head>
	
	<?php include "header.php"; ?>
	
	<body>
        <div class="corps">
            <h2>Consulter le type du nuisance</h2>
		<!-- Formulaire de sélections des types de nuisances -->
            <form action="" method="post" class="formulaire" name="nuisance">
                <div class="control-group <?php echo !empty($Error)?'error':'';?>">
                    <div>
                        <input type="checkbox" name="nuisance_ssp" checked value="1">
                        <label for="nuisance_ssp">Sécurité & santé publique</label>                    
                        <br>
                        <input type="checkbox" name="nuisance_ff" value="1">
                        <label for="nuisance_ff">Faune & Flore</label>
                        <br>
                        <input type="checkbox" name="nuisance_agri" value="1">
                        <label for="nuisance_ff">Agricole</label>
                        <br>
                        <input type="checkbox" name="nuisance_a" value="1">
                        <label for="nuisance_ff">Autres formes de proprité</label>
                    </div>
                    <?php 
			// si aucun checkbox n'a été checkée, on soulève une erreur
                        if (!empty($fieldsErr)):
                                            
                            echo "<span style=\"color:red; text-align:center\"; class='help-inline'>"; 
                                echo $fieldsErr; 
                            echo "</span> <br>";
                        endif; 
                    ?>
                    <br>
                    <input class="button_co" type="submit" value="Soumettre">
                </div>
            </form>
            <br>

            <center>

            <?php       
                if(!empty($_POST))
                {
		// On réccupère toutes les valeurs des box checkées. 
		// Si elles sont été cochées alors on assigne à la variabel $where de quoi complèter la requête SQL plus tard
                    if(isset($_POST['nuisance_ssp']))
                    { 
                        $ssp = $_POST['nuisance_ssp']; 
                        if($ssp == 1)
                        {
                            $where = "nuisance_ssp = 1";
                        }
                    }
                    if(isset($_POST['nuisance_ff']))
                    { 
                        $ff = $_POST['nuisance_ff'];

                        if($ff == 1)
                        {
                            if(isset($where)) // si $where contient déjà quelque chose, alors on ajoute au morceau de requête avec pour liaison le mot clé SQL "AND"
                            {
                                $where = $where." AND nuisance_ff = 1";
                            }
                            else
                            {
                                $where = "nuisance_ff = 1";
                            }
                        } 
                    }
                    if(isset($_POST['nuisance_agri']))
                    { 
                        $agri = $_POST['nuisance_agri']; 

                        if($agri == 1)
                        {
                            if(isset($where))
                            {
                                $where = $where." AND nuisance_agri = 1";
                            }
                            else
                            {
                                $where = "nuisance_agri = 1";
                            }
                        }
                    }
                    if(isset($_POST['nuisance_a']))
                    { 
                        $a = $_POST['nuisance_a'];

                        if($a == 1)
                        {
                            if(isset($where))
                            {
                                $where = $where." AND nuisance_a = 1";
                            }
                            else
                            {
                                $where = "nuisance_a = 1";
                            }
                        } 
                    }

                    $base = mysqli_connect(MYHOST, MYUSER, MYPASS, DBNAME); // connexion à la base de onnée
                    $sql = "SELECT * FROM especes WHERE $where;"; // requête, complétée suivant les choix fait pas l'utilisateur

                    $result = mysqli_query($base, $sql);

                    if(!$result)
                    {
                        echo("Error description: ".mysqli_error($base));
                    }
                    else
                    {
			// début du tableau, affichage des en-tête suivant ce qui a été choisi par l'utilisateur
                        echo "<table class=\"tableau\">";
                            echo "<tr>";
                                echo "<th>Espèces recensées</th>";
                        if(mysqli_num_rows($result) == 0) // cas où aucune espèces ne présente les critères de nuisance sélectionnés
                        {
                            echo "<tr>";
                                echo "<td>Aucune espèce recensée</td>";
                            echo "</tr>";
                        }
                        else
                        {
                            if(isset($_POST['nuisance_ssp']) == 1)
                            {
                                echo "<th>Sécurité & Santé Publique</th>";
                            }
                            if(isset($_POST['nuisance_ff']) == 1)
                            {
                                echo "<th>Dommages à la Faune & la Flore</th>";
                            }
                            if(isset($_POST['nuisance_agri']) == 1)
                            {
                                echo "<th>Nuisance & Dommages Agricole</th>";
                            }
                            if(isset($_POST['nuisance_a']) == 1)
                            {
                                echo "<th>Dommages à d'Autres types de Propriété</th>";
                            }
                            echo "</tr>";
                            
                            //  Affichage du tableau recensant les espèces pour le(s) type(s) de nuisance sélectionée(s)
                            while($row = mysqli_fetch_array($result))
                            {
                                $espece = $row['nomverna'];
                                echo "<tr>";
                                    echo "<td>".$espece."</td>";
                                if(isset($_POST['nuisance_ssp']) == 1)
                                { 
                                    $n_ssp = $row['nuisance_ssp']; 
                                    echo "<td>Oui</td>";
                                }
                                if(isset($_POST['nuisance_ff']) == 1)
                                {
                                    $n_ff = $row['nuisance_ff'];
                                    echo "<td>Oui</td>";
                                }
                                if(isset($_POST['nuisance_agri']) == 1)
                                {
                                    $n_agri = $row['nuisance_agri'];
                                    echo "<td>Oui</td>";
                                }
                                if(isset($_POST['nuisance_a']) == 1)
                                { 
                                    $n_a = $row['nuisance_a']; 
                                    echo "<td>Oui</td>";
                                }
                            }
                        }
                        echo "</table>";
                    }
                }
                else
                {
                    echo "<center><span style=\"color:red; text-align:center\"; class='help-inline'>"; 
                        echo "Veuillez selectionner au moins un champs"; 
                    echo "</span></center><br>";
                }

            ?>
        </center>

        </div>
    </body>

    <?php include "footer.php"; ?>

</html>
