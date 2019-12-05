<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>

<?php
    include_once "myparam.inc.php";
    session_start();
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
            <h2>Consulter les espèces véhiculant des maladies</h2>
            <form action="" method="post" class="formulaire">
                <div class="control-group <?php echo !empty($Error)?'error':'';?>">
                    <div>
                        <select name="maladie" value="<?php echo !empty($maladie)?$maladie:'';?>">
                            <option value="$maladie">Sélectionner maladie</option>
                            <?php
                                $base = mysqli_connect (MYHOST, MYUSER, MYPASS, DBNAME); 
                                $sql = 	"SELECT DISTINCT nom_maladie FROM maladie";
                                $result = mysqli_query ($base,$sql);
                                while($row = mysqli_fetch_array($result))
                                {
                                    $maladie = $row['nom_maladie'];

                                    echo "<option value=\"$maladie\">$maladie</option> \n";
                                }
                                mysqli_close($base);
                            ?>
                        </select>
                    </div>
                    <br>
                    <input class="button_co" type="submit" value="Soumettre la requête" >

                </div>
            </form>

            <br>

            <center>

            <?php

                if(!empty($_POST))
                {
                    $maladie = $_POST['maladie'];

                    $base = mysqli_connect (MYHOST, MYUSER, MYPASS, DBNAME);
                    $sql = "SELECT * FROM provoque NATURAL JOIN maladie WHERE nom_maladie = '".$maladie."';";
                    $result = mysqli_query($base, $sql);

                    if(!$result)
                    {
                        echo("Error description: ".mysqli_error($base));
                    }
                    else
                    {
                        echo "<h2>Maladie sélectionnée : ".$maladie."</h2>";
                        echo "<table class=\"tableau\">";
                            echo "<tr>";
                                echo "<th>Espèces véhiculant ".$maladie."</th>";
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
                }        
            ?>

        </center>

        </div>
    </body>

    <?php include "footer.php"; ?>

</html>