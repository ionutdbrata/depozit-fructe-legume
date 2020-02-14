<?php
//start de sesiune
session_start();
$connection = mysqli_connect("localhost", "root", "", "depozit");
if (!$connection) {
      die("Eroare MySQL");
}

if (isset($_GET['id'])) {
      $id = $_GET['id'];
}
if (isset($_GET['actiune'])) {
      $actiune = $_GET['actiune'];
}

//conectare la baza de date
if (isset($_POST['username']) && isset($_POST['password'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];

      $query = "SELECT username , password FROM admin WHERE username='$username' AND password=md5('$password')";
      $result = mysqli_query($connection, $query);
      if (mysqli_fetch_array($result)) {
            $_SESSION['valid_user'] = $username;
      }
      // Inchidere conexiune
      mysqli_close($connection);
}

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
                        <li><a href="fructe.php">Fructe</a></li>
                        <li><a href="legume.php">Legume</a></li>
                        <li><a href="cos.php">Cos</a></li>
                        <li><a href="admin.php" class="current">Administrare</a></li>
                  </ul>
                  <div id="continut">
                        <div style="padding:20px 20px 20px 20px;">

                              <?php
                              if (isset($_SESSION['valid_user'])) {
                                    //inceput continut

                                    if (isset($_GET['actiune']) && $_GET['actiune'] == "onorare") {
                                          $interogare = "SELECT * FROM comanda WHERE onorare=1 AND id_comanda =" . $id;
                                          $rezultat = mysqli_query($interogare);
                                          while ($row = mysqli_fetch_array($rezultat)) {
                                                echo 'Valoare: <b>' . $row['valoare'] . ' RON</b><br>';
                                                echo 'Data: <b>' . $row['data'] . '</b><br>';
                                                echo 'Produse: <b>' . $row['produse'] . '</b><br><br>';

                                                echo 'Nume: <b>' . $row['nume'] . '</b><br>';
                                                echo 'Preume: <b>' . $row['prenume'] . '</b><br>';
                                                echo 'Telefon: <b>' . $row['telefon'] . '</b><br>';
                                                echo 'Strada: <b>' . $row['strada'] . '</b><br>';
                                                echo 'Numar: <b>' . $row['numar'] . '</b><br>';
                                                echo 'Bloc: <b>' . $row['bloc'] . '</b><br>';
                                                echo 'Apartament: <b>' . $row['apartament'] . '</b><br>';
                                                echo 'Cod postal: <b>' . $row['cod_postal'] . '</b><br>';
                                                echo 'Localitate: <b>' . $row['localitate'] . '</b><br><br><br>';

                                                echo '<form action="admin_onorate.php?actiune=delete" method="POST">
     <input type="hidden" name="id" value="' . $id . '" >
      <input type="submit" value="Sterge comanda" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#999; color:#000;">
      </form>';
                                          }
                                    } else if (isset($_GET['actiune']) && $_GET['actiune'] == "delete") {
                                          $sql = "DELETE FROM `comanda` WHERE `comanda`.`id_comanda` = '" . $_POST['id'] . "' LIMIT 1";
                                          $result = mysqli_query($sql);
                                          echo '<div style="height:300px;"><h1>Comanda a fost stearsa</h1></div>';
                                    } else {
                                          echo '<h2>Alege comanda</h2>';
                                          $interogare = "SELECT * FROM comanda WHERE onorare=1 ORDER BY id_comanda ASC";
                                          $rezultat = mysqli_query($interogare);
                                          while ($row = mysqli_fetch_array($rezultat)) {
                                                echo '<a href="admin_onorate.php?actiune=onorare&id=' . $row['id_comanda'] . '">Comanda <b>' . $row['data'] . ' - ' . $row['nume'] . ' ' . $row['prenume'] . '</b></a><br>';
                                          }
                                    }


                                    //sfarsit continut
                              } else { // formular pentru cazul in care nu a fost introdus un user sau o parola
                                    echo '<div align="center">';
                                    echo "Nu sunteti logat. Introduceti username-ul si parola<br><br>";
                                    echo '<form method="POST" action="admin.php">';
                                    echo '<br>Username: <input type="text" name="username"><br>';
                                    echo 'Password: <input type="password" name="password"><br><br>';
                                    echo '<input type="submit" value="Log in" style="width:80px"></form>';
                                    echo '</div>';
                              }
                              ?>

                        </div>
                  </div>

            </div>
      </div>
      <br />
</body>

</html>