<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "depozit");
if (!$connection) {
        die("Eroare MySQL");
}
//mysqli_select_db("depozit" , $connection);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Depozit de legume si fructe</title>
        <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>

<body>

        <div align="center">
                <div id="container">
                        <div id="banner"></div>
                        <ul id="menu">
                                <li><a href="index.php">Home</a></li>
                                <li><a href="fructe.php" class="current">Fructe</a></li>
                                <li><a href="legume.php">Legume</a></li>
                                <li><a href="cos.php">Cos</a></li>
                                <li><a href="admin.php">Administrare</a></li>
                        </ul>
                        <div id="continut">
                                <div style="padding:20px 20px 20px 20px;">

                                        <?php
                                        $interogare = "SELECT * FROM fructe ORDER BY nume ASC";
                                        $rezultat = mysqli_query($connection, $interogare);
                                        //print_r($rezultat);
                                        while ($row = mysqli_fetch_array($rezultat)) {
                                                echo '<table><tr><td>';
                                                echo '<a href="fruct.php?id=' . $row['id'] . '"><img src="images/' . $row['imagine'] . '" width="200"></a>';
                                                echo '</td><td>
 <h1>' . $row['nume'] . '</h1>
 <a href="fruct.php?id=' . $row['id'] . '"> Descriere:' . $row['descriere'] . ' </a> </td></tr></table>';
                                        }
                                        ?>

                                </div>
                        </div>

                </div>
        </div>
        <br />
</body>

</html>