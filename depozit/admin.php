<?php 
//start de sesiune
session_start();
//conectare la baza de date
if (isset($_POST['username']) && isset($_POST['password'])) {
$username = $_POST['username'];
$password = $_POST['password'];

$connection = mysqli_connect("localhost","root","", "depozit");
if (!$connection) {
 die ("Eroare la conectarea cu Baza de Date MySQL");
 exit();}


$query = "SELECT username , password FROM admin WHERE username='$username' AND password=md5('$password')";
$result = mysqli_query($connection,$query);
if (mysqli_fetch_array($result)) {
       $_SESSION['valid_user'] = $username;}
// Inchidere conexiune
mysqli_close($connection);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
<li><a href="index.php" >Home</a></li>
<li><a href="fructe.php" >Fructe</a></li>
<li><a href="legume.php" >Legume</a></li>
<li><a href="cos.php" >Cos</a></li>
<li><a href="admin.php" class="current">Administrare</a></li>
</ul>
<div id="continut">
<div style="padding:20px 20px 20px 20px;">


<?php
if (isset($_SESSION['valid_user']))  {
   echo '<h3>Esti logat ca <b>'.$_SESSION['valid_user'].'</b></h3><br>';
 ?>
 <a href="admin_fructe.php">Fructe</a><br />
 <a href="admin_legume.php">Legume</a><br />
 <a href="admin_comenzi.php">Prelucrare comenzi</a><br />
 <a href="admin_onorate.php">Comenzi onorate</a><br /><br /><br />
 <?php
   }
   
else {
 if (isset($username)){ //formular pentru cazul in care username-ul sau parola sunt introduse incorect
  echo '<div align="center">';
   echo "Nu va puteti loga.Username sau parola incorecte<br><br>";
   echo '<form method="POST" action="admin.php">';
echo'<br>Username: <input type="text" name="username"><br>';
echo'Password: <input type="password" name="password"><br><br>';
echo '<input type="submit" value="Log in" style="width:80px"></form>';
 echo '</div>';
   }
   else { // formular pentru cazul in care nu a fost introdus un user sau o parola
    echo '<div align="center">';
   echo "Nu sunteti logat. Introduceti username-ul si parola<br><br>";
   echo '<form method="POST" action="admin.php">';
echo'<br>Username: <input type="text" name="username"><br>';
echo'Password: <input type="password" name="password"><br><br>';
echo '<input type="submit" value="Log in" style="width:80px"></form>';
 echo '</div>';
   }
  }
?>


</div>
</div>

</div>
</div>
<br />
</body>
</html>
