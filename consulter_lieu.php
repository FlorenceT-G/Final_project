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
            <h2>Consulter les espèces nuisibles suivant le lieu</h2>
		<!-- Formulaire permettant d'afficher un menu déroulant à partir des lieux des recensement de la base de donnée -->
            <form action="" method="post" class="formulaire">
                <div class="control-group <?php echo !empty($Error)?'error':'';?>">
                    <div>
                        <select name="region" value="<?php echo !empty($region)?$region:'';?>">
                            <option value="$region">None</option>
                            <?php
                                $base = mysqli_connect (MYHOST, MYUSER, MYPASS, DBNAME); 
                                $sql = 	"SELECT DISTINCT lieu FROM recensement";
                                $result = mysqli_query ($base,$sql);
                                while($row = mysqli_fetch_array($result))
                                {
                                    $region = $row['lieu'];

                                    echo "<option value='$region'>".$region."</option> \n";
                                }
                                mysqli_close($base);
                            ?>
                        </select>
                    </div>
                        <br>
                        <input class="button_co" type="submit" value="Soumettre" >
                </div>
            </form>

            <br>

            <center>

            <?php
            if(!empty($_POST))
            {
                $region = $_POST['region']; // récupère la sélection de l'utilisateur

                $base = mysqli_connect (MYHOST, MYUSER, MYPASS, DBNAME); // connexion à la base de donnée
                $sql = "SELECT DISTINCT nomverna FROM recensement WHERE lieu = '".$region."';"; // requête

                $result = mysqli_query($base, $sql);

                if(!$result)
                {
                    echo("Error description: ".mysqli_error($base));
                }
                else
                {	// résultat sous forme d'un tableau affichant les espèces trouvées dans la région choisi par l'utilisateur
                    echo "<h2>Espèces nuisibles dans la région de ".$region."</h2>";
                    echo "<table class=\"tableau\">";
                        echo "<tr>";
                            echo "<th>Espèces recensées</th>";
                        echo "</tr>";
                        while($row = mysqli_fetch_array($result))
                        {
                            $espece = $row['nomverna'];

                            echo "<tr>";
                                echo "<td>".$espece."</td>";
                            echo "</tr>";
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
