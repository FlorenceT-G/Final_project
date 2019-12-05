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
                $region = $_POST['region'];

                $base = mysqli_connect (MYHOST, MYUSER, MYPASS, DBNAME);
                $sql = "SELECT DISTINCT nomverna FROM recensement WHERE lieu = '".$region."';";

                $result = mysqli_query($base, $sql);

                if(!$result)
                {
                    echo("Error description: ".mysqli_error($base));
                }
                else
                {
                    echo "<h2>Espèces nuisibles dans la région de ".$region."</h2>";
                    echo "<table class=\"tableau\">";
                        echo "<tr>";
                            echo "<th>Espèces recensées</th>";
                        echo "</tr>";
                    if(mysqli_num_rows($result) == 0)
                    {
                        echo "<tr>";
                            echo "<td>Aucune espèce recensée</td>";
                        echo "</tr>";
                    }
                    else
                    {
                        while($row = mysqli_fetch_array($result))
                        {
                            $espece = $row['nomverna'];

                            echo "<tr>";
                                echo "<td>".$espece."</td>";
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
