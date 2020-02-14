<?php
session_start();
$connection = mysqli_connect("localhost","root","");
if (!$connection) {
 die ("Eroare MySQL");
}
mysqli_select_db("depozit" , $connection);
$actiune = $_GET['actiune'];
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
<li><a href="cos.php" class="current" >Cos</a></li>
<li><a href="admin.php" >Administrare</a></li>
</ul>
<div id="continut">
<div style="padding:20px 20px 20px 20px;">


<?php
if (isset($_GET['actiune']) && ($_GET['actiune']=="trimite") ) {	

if ($_POST['num'] == "") { echo '<div style="height:300px;"><h1>Nu putem trimite comanda fara sa completati numele</h1></div>'; }
  else if ($_POST['pren'] == "") { echo '<div style="height:300px;"><h1>Nu putem trimite comanda fara sa completati numele</h1></div>'; }
    else if ($_POST['tel'] == "") { echo '<div style="height:300px;"><h1>Nu putem trimite comanda fara sa completati numele</h1></div>'; }
        else{

$sql_comanda="INSERT INTO comanda (id_comanda,valoare,data,onorare,nume,prenume,telefon,strada,numar,bloc,apartament,cod_postal,localitate,produse) 
  VALUES ('','".$_SESSION['total']."', NOW() ,'0' , '".$_POST['num']."','".$_POST['pren']."','".$_POST['tel']."','".$_POST['str']."','".$_POST['nr']."','".$_POST['bl']."','".$_POST['ap']."','".$_POST['cod']."','".$_POST['loc']."' , '".$_SESSION['produse']."')";
    $rez = mysqli_query ($sql_comanda);
echo '<div style="height:300px;"><h1>Comanda a fost trimisa</h1></div>';
session_destroy();
		}
}
else{
	
	echo '<h2>Cos de cumparaturi</h2>';
if (count($_SESSION['id']) == 0 ){ echo '<br><h2>Nu aveti nici un produs in cosul de cumparaturi</h2>';}
  else{ 
echo '
<table border="1" cellspacing="0" cellpadding="4" bordercolor="#000000">
<tr bgcolor="#CCCCCC">
    <td><b>Cantitate (kg)</b></td>
    <td><b>Fruct</b></td>
  <td><b>Pret</b></td>  
  <td><b>Total</b></td>
</tr>';
$totalGeneral = 0;
$produse = '';
for ($i=0; $i < count($_SESSION['nr']); $i++)
	{ 
	  {$produse =  $produse.' '.$_SESSION['nr'][$i].' kg de '.$_SESSION['fruct'][$i].'; ' ;
	   print'<tr><td><b>'.$_SESSION['nr'][$i].'</b></td>
	   <td><b>'.$_SESSION['fruct'][$i].'</b></td>
	   <td align="right">'.$_SESSION['pret'][$i].' RON</td>
	   <td align="right">'.($_SESSION['pret'][$i]*$_SESSION['nr'][$i]).' RON</td></tr>';	  
	  $totalGeneral = $totalGeneral + ($_SESSION['pret'][$i]*$_SESSION['nr'][$i]);
	 }
	}
print '<tr><td align="right"
	colspan="3"><b>Total in cos</b></td><td align="right"><b>'.$totalGeneral.
	'</b> RON</td></tr></table><br />
 </form>';}
?>
<br /><br />
 <?php
 if ($totalGeneral > 0 ){  
 $_SESSION['total'] = $totalGeneral;
 $_SESSION['produse'] = $produse;
 ?>
 <form action="casa.php?actiune=trimite" method="POST"> 
 <table>
 <tr><td>Nume <font color="#FF0000">*</font> </td><td> <input type="text" name="num" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#999; color:#000;"/></td></tr>
 <tr><td>Prenume <font color="#FF0000">*</font> </td><td> <input type="text" name="pren" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#999; color:#000;"/></td></tr>
 <tr><td>Telefon <font color="#FF0000">*</font> </td><td> <input type="text" name="tel" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#999; color:#000;"/></td></tr>
 <tr><td>Strada </td><td> <input type="text" name="str" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#999; color:#000;"/></td></tr>
 <tr><td>Numar</td><td> <input type="text" name="nr" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#999; color:#000;"/></td></tr>
 <tr><td>Bloc</td><td> <input type="text" name="bl" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#999; color:#000;"/></td></tr>
 <tr><td>Apartament</td><td> <input type="text" name="ap" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#999; color:#000;"/></td></tr>
 <tr><td>Cod postal</td><td> <input type="text" name="cod" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#999; color:#000;"/></td></tr>
 <tr><td>Localitate</td><td> <input type="text" name="loc" style="width:200px; border:1px solid #F60; font-weight:bold;background-color:#999; color:#000;"/></td></tr>
 </table><br /><br />
 <input type="submit" value="Cumpara" style="width:100px; border:1px solid #F60; font-weight:bold;background-color:#333; color:#F60;">
 </form>
<?php
 }
}
 ?>
<br /><br />
<br />
</div>
</div>

</div>
</div>
<br />
</body>
</html>
