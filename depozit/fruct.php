<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "depozit");
if (!$connection) {
        die("Eroare MySQL");
}
$fruct = $_GET['id'];
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
                                        $interogare = "SELECT * FROM fructe WHERE id = " . $fruct;
                                        $rezultat = mysqli_query($connection, $interogare);

                                        while ($row = mysqli_fetch_array($rezultat)) {
                                                echo '<h1>' . $row['nume'] . '</h1>';
                                                echo '<img src="images/' . $row['imagine'] . '" align="right" width="250" > ';
                                                echo 'Descriere: <b>' . $row['descriere'] . '</b><br><br>';
                                                echo 'Pret: <b>' . $row['pret'] . ' RON / Kilogram</b><br>';
                                                if ($row['cantitate'] > 200) {
                                                        echo 'Disponibilitate: <b>In stoc</b> ' . $row['cantitate'];
                                                } else if ($row['cantitate'] > 0) {
                                                        echo 'Disponibilitate: <b>Stoc limitat </b>' . $row['cantitate'];
                                                } else {
                                                        echo 'Disponibilitate: <b> Nu este stoc furnizor</b>';
                                                }

                                                echo  '<br><br><form action="cos.php?actiune=adauga" method="POST">
Cantitatea pe care doriti sa o cumparati,in kilograme 
<input type="number" name="kg" max="' . $row['cantitate'] . '" style="width:100px; border:1px solid #F60; font-weight:bold;background-color:#999; color:#000;">
<INPUT type="hidden" name="id" value="' . $fruct . '" >
<INPUT type="hidden" name="fruct" value="' . $row['nume'] . '" >
<input type="hidden" name="pret" value="' . $row['pret'] . '" >
<input type="submit" value="Cumpara" style="width:100px; border:1px solid #F60; font-weight:bold;background-color:#333; color:#F60;">
</form>';
                                        }

                                        ?>

                                        <br />
                                </div>
                        </div>

                </div>
        </div>
        <br />
</body>

</html>