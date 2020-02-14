<?php
session_start();
$connection = mysqli_connect("localhost","root","");
if (!$connection) {
 die ("Eroare MySQL");
}


if(isset($_GET['actiune']) && $_GET['actiune'] == "adauga")
{
    $_SESSION['id'][] = $_POST['id'];
        $_SESSION['nr'][] = $_POST['kg'];  
        $_SESSION['pret'][] = $_POST['pret'];
        $_SESSION['fruct'][] = $_POST['fruct'];  
}
 

if(isset($_GET['actiune']) && $_GET['actiune'] == "modifica")
 {
  for ($i=0;$i<count($_SESSION['id']);$i++)  
   {
	   if ( is_numeric($_POST['noulNr'][$i]) && ($_POST['noulNr'][$i] >=0)) {
	   $_SESSION['nr'][$i] = ceil($_POST['noulNr'][$i]);}
    }
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
<li><a href="cos.php" class="current" >Cos</a></li>
<li><a href="admin.php" >Administrare</a></li>
</ul>
<div id="continut">
<div style="padding:20px 20px 20px 20px;">

<h2>Cos de cumparaturi</h2>
<?php
if (isset($_SESSION['id']) && count($_SESSION['id']) == 0 )
{ 
	echo '<br><h2>Nu aveti nici un produs in cosul de cumparaturi</h2>';
}
else
{ 
	echo '<form action="cos.php?actiune=modifica" method="POST">
	<table border="1" cellspacing="0" cellpadding="4" bordercolor="#33CCFF">
	<tr bgcolor="#CCCCCC">
	    <td><b>Cantitate (kg)</b></td>
	    <td><b>Fruct</b></td>
	  <td><b>Pret</b></td>  
	  <td><b>Total</b></td>
	</tr>';
	$totalGeneral = 0;
	if (isset($_SESSION['nr'])) {
		for ($i=0; $i < count($_SESSION['nr']); $i++)
		{ 
		  { print'<tr><td>
		  <input type="text" name="noulNr['.$i.']" size="1" 
			value="'.$_SESSION['nr'][$i].'"></td>
		   <td><b>'.$_SESSION['fruct'][$i].'</b>
		   
		   </td>
		   <td align="right">
		   '.$_SESSION['pret'][$i].' RON</td>
		   <td align="right">'
		   .(intval($_SESSION['pret'][$i])*intval($_SESSION['nr'][$i])).
		   ' RON</td></tr>';	  
		  $totalGeneral = $totalGeneral + (intval($_SESSION['pret'][$i])*intval($_SESSION['nr'][$i]));
		 }
		}
	}
	print '<tr><td align="right"
		colspan="3"><b>Total in cos</b></td><td align="right"><b>'.$totalGeneral.
		'</b> RON</td></tr></table><br />
	<input type="submit" value="Modifica" style="width:100px; border:1px solid #F60; font-weight:bold;background-color:#333; color:#F60;">
	 </form>';
}
?>
<br /><br />
 <a href="index.php">Continua cumparaturile</a> 
 <?php
 if ($totalGeneral > 0 ){
 echo '| <a href="casa.php">Mergi la casa</a>';
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
