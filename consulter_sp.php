<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>

<?php
    session_start();
    include "myparam.inc.php";
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
            <h2>Consulter les espèces nuisibles</h2>
		<!-- Formulaire affichant un menu déroulant répertoriant le nom de toutes les espèces nuisibles -->
            <form action="" method="post" class="formulaire">
                <div class="control-group <?php echo !empty($Error)?'error':'';?>">
                    <div>
                        <select name="espece" value="<?php echo !empty($espece)?$espece:'';?>">
                            <?php
                                $base = mysqli_connect (MYHOST, MYUSER, MYPASS, DBNAME); 
                                $sql = 	"SELECT nomverna FROM especes";
                                $result = mysqli_query ($base,$sql);
                                while($row = mysqli_fetch_array($result)) 
                                {
                                    
                                    $espece= $row['nomverna'];
                                    
                                    echo "<OPTION value='$espece'> $espece </OPTION> \n"; 
                                }
                                mysqli_close($base);
                            ?>
                        </select>
                    </div>
                    <?php // en cas d'erreur
                        if (!empty($fieldsErr))
                        {                            
                            echo "<span style=\"color:red; text-align:center\"; class='help-inline'>"; 
                                echo $fieldsErr; 
                            echo "</span> <br>";
                        } 
                    ?>
                    <br>
                    <input class="button_co" type="submit" value="Soumettre" >
                </div>
            </form>
        
            <br/>

            <center>
    
            <?php
                if(!empty($_POST))
                {
                    $espece = $_POST["espece"]; // récupère le choix de l'utilisateur
                
                    $fieldsErr = null;
                
                    $base = mysqli_connect(MYHOST, MYUSER, MYPASS, DBNAME) or die ("Impossible de se connecter à la base de données !");
                    $sql = "SELECT DISTINCT lieu FROM recensement WHERE nomverna = '".$espece."';"  ; // requête
                
                    $result = mysqli_query($base, $sql);
                
                    if(!$result)
                    {
                        echo("Error description: ".mysqli_error($base));
                    }
                    else
                    {	//Affichage du tableau
                        echo "<h2> Espèce sélectionnée : ".$espece."</h2>";
                        echo "<table class=\"tableau\">";
                            echo "<tr>";
                                echo "<th>Lieux</th>";
                            echo "</tr>";
                        if(mysqli_num_rows($result) == 0) // cas où l'espèce choisi n'a été aperçue nul part
                        {
                            echo "<tr>";
                                echo "<td>Espèce pas encore recensée</td>";
                            echo "</tr>";
                        }
                        else
                        {	// affichage de toutes les régions dans lesquelles l'espèce en question est apparue
                            while($row = mysqli_fetch_array($result))
                            {
                                $lieu = $row["lieu"];
                                echo "<tr>";
                                    echo "<td>".$lieu."</td>";
                                echo "</tr>";
                            }
                        }
                        echo "</table>";
                    }
                ?>

                <br>

                <?php

                $sql2 = "SELECT nom_maladie FROM `provoque` WHERE nomverna = '".$espece."';";
                $result = mysqli_query($base, $sql2);

                if(!$result)
                {
                    echo("Error description: ".mysqli_error($base));
                }
                else
                {
                    echo "<table class=\"tableau\">";
                        echo "<tr>";
                            echo "<th>Maladies véhiculées</th>";
                        echo "</tr>";

                        if(mysqli_num_rows($result) == 0)
                        { 
                            echo "<tr>";
                                echo "<td>Aucune maladie véhiculée recensée</td>";
                            echo "</tr>";
                        }
                        else
                        {
                         // affiche toutes les maladies potentiellement transmises par l'espèces en question
                            while($row2 = mysqli_fetch_array($result))
                            {
                                $maladie = $row2['nom_maladie'];
                                echo "<tr>";
                                    echo "<td>".$maladie."</td>";
                                echo "</tr>";
                            }
                        }

                    echo "</table>";
                }

                ?>

                <br/>

                <?php
                    $sql3 = "SELECT * FROM especes WHERE nomverna = '".$espece."';";
                    $result = mysqli_query($base, $sql3);

                    if(!$result)
                    {
                        echo("Error description: ".mysqli_error($base));
                    } 
                    else
                    {	// tableau affichant tous les types de nuisance liés à l'espèce en question
                        echo "<table class=\"tableau\">";
                            echo "<tr>";
                                echo "<th>Nuisances liées</th>";
                            echo "</tr>";
                            while($row3 = mysqli_fetch_array($result))
                            {
                                $ssp = $row3['nuisance_ssp'];
                                $ff = $row3['nuisance_ff'];
                                $agri = $row3['nuisance_agri'];
                                $a = $row3['nuisance_a'];
                                if($ssp)
                                {
                                    echo "<tr>";
                                        echo "<td>Dégats de santé et Sécurité publique</td>";
                                    echo "</tr>";
                                }
                                if($ff)
                                {
                                    echo "<tr>";
                                        echo "<td>Dégats envers la faune & flore</td>";
                                    echo "</tr>";
                                }
                                if($agri)
                                {
                                    echo "<tr>";
                                        echo "<td>Dégats agricoles & forestiers</td>";
                                    echo "</tr>";
                                }
                                if($a)
                                {
                                    echo "<tr>";
                                        echo "<td>Dégats à d'autres formes de propriétés</td>";
                                    echo "</tr>";
                                }
                            }
                        echo "</table>";

                    } 

                    mysqli_close($base);
                }
                ?>    
            </center>
        </div>

    </body>

    <?php include "footer.php"; ?>

</html>
