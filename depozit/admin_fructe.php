<?php 
//start de sesiune
session_start();
$connection = mysqli_connect("localhost","root","");
if (!$connection) {
 die ("Eroare MySQL");
}
mysqli_select_db("depozit" , $connection);

if (isset($_GET['id'])) {
	$id= $_GET['id'];
}
if (isset($_GET['actiune'])) {
	$actiune = $_GET['actiune'];
}
//conectare la baza de date
if (isset($_POST['username']) && isset($_POST['password'])) {
$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT username , password FROM admin WHERE username='$username' AND password=md5('$password')";
$result = mysqli_query($query);
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
//inceput continut
if(isset($_GET['actiune']) && $_GET['actiune'] == "modifica") {
$interogare = "SELECT * FROM fructe WHERE id = ".$id; 
$rezultat = mysqli_query($interogare);
while ($row = mysqli_fetch_array($rezultat)){
		echo '<form action="admin_fructe.php?actiune=modif" method="POST">
	<table>
<tr><td>Nume </td>
<td><input type="text" name="nume" value="'.$row['nume'].'" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#333; color:#F60;"></td></tr>
<tr><td>Descriere </td>
<td><textarea name="descr"  style="width:200px; height:150px;overflow:hidden; border:1px solid #F60; font-weight:bold;background-color:#333; color:#F60;">
'.$row['descriere'].'</textarea></td></tr>
<tr><td>Pret </td>
<td><input type="text" name="pret" value="'.$row['pret'].'" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#333; color:#F60;"></td></tr>
<tr><td>Cantitate(kg)</td>
<td> <input type="text" name="cant" value="'.$row['cantitate'].'" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#333; color:#F60;"></td></tr>
<tr><td>Imagine</td>
<td> <input type="text" name="img" value="'.$row['imagine'].'" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#333; color:#F60;"></td></tr>
</table><br><br>
<input type="hidden" name="id" value="'.$id.'" >
<input type="submit" value="Modifica fruct" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#999; color:#000;"><br><br>
</form';

echo '<br><form action="admin_fructe.php?actiune=delete" method="POST">
     <input type="hidden" name="id" value="'.$id.'" >
      <input type="submit" value="Sterge fructul" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#999; color:#000;">
      </form>';
         }
}
else if (isset($_GET['actiune']) && $_GET['actiune'] == "delete"){
	$sql="DELETE FROM `fructe` WHERE `fructe`.`id` = '".$_POST['id']."' LIMIT 1";
      $result = mysqli_query($sql);
	  echo '<div style="height:300px;"><h1>Fructul a fost sters</h1></div>';
}
else if (isset($_GET['actiune']) && $_GET['actiune'] == "modif"){
	 $sql="UPDATE `depozit`.`fructe` SET `nume` = '".$_POST['nume']."', `descriere` = '".$_POST['descr']."', `pret` = '".$_POST['pret']."' , `cantitate` = '".$_POST['cant']."' , `imagine` = '".$_POST['img']."' WHERE `fructe`.`id` =".$_POST['id']." LIMIT 1 ";
    mysqli_query ($sql);
	echo '<div style="height:300px;"><h1>Fructul a fost modificat</h1></div>';
}
else if (isset($_GET['actiune']) && $_GET['actiune'] == "adauga"){
	echo '<form action="admin_fructe.php?actiune=add" method="POST">
	<table>
<tr><td>Nume </td><td><input type="text" name="nume" style="width:160px; border:1px solid #F60; font-weight:bold;background-color:#333; color:#F60;"></td></tr>
<tr><td>Descriere </td><td><input type="text" name="descr" style="width:160px; border:1px solid #F60; font-weight:bold;background-color:#333; color:#F60;"></td></tr>
<tr><td>Pret </td><td><input type="text" name="pret" style="width:160px; border:1px solid #F60; font-weight:bold;background-color:#333; color:#F60;"></td></tr>
<tr><td>Cantitate(kg)</td><td> <input type="text" name="cant" style="width:160px; border:1px solid #F60; font-weight:bold;background-color:#333; color:#F60;"></td></tr>
<tr><td>Imagine</td><td> <input type="text" name="img" style="width:160px; border:1px solid #F60; font-weight:bold;background-color:#333; color:#F60;"></td></tr>
</table><br><br>
<input type="submit" value="Adauga fruct" style="width:160px; border:1px solid #F60; font-weight:bold;background-color:#999; color:#000;"><br><br>';
}
else if (isset($_GET['actiune']) && $_GET['actiune'] == "add"){
	$sql_comanda="INSERT INTO fructe (id,nume,descriere,pret,cantitate,imagine) 
  VALUES ('','".$_POST['nume']."','".$_POST['descr']."','".$_POST['pret']."','".$_POST['cant']."','".$_POST['img']."')";
    $rez = mysqli_query ($sql_comanda);
echo '<div style="height:300px;"><h1>Fructul a fost adaugat</h1></div>';
}
else{
echo '<h2>Adauga fruct:</h2>';
echo '<form action="admin_fructe.php?actiune=adauga" method="POST">
<input type="submit" value="Adauga fruct" style="width:160px; border:1px solid #F60; font-weight:bold;background-color:#333; color:#F60;">
</form>';

echo '<h2>Modifica fruct:</h2>';
$interogare = "SELECT * FROM fructe ORDER BY nume ASC";
$rezultat = mysqli_query($interogare);
while ($row = mysqli_fetch_array($rezultat)){
echo '<a href="admin_fructe.php?actiune=modifica&id='.$row['id'].'">'.$row['nume'].'</a><br>';	
}
echo '<br><br><br>';

}

//sfarsit continut
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
?>

</div>
</div>

</div>
</div>
<br />
</body>
</html>
