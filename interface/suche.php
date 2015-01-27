<html>
<head>
<style type="text/css">
a:link{color:#000000;}		<!-- Links bleiben schwarz -->
a:visited{color:#000000;}	<!-- Besuchte LInks bleiben Schwarz-->
a {text-decoration:none;}	<!-- Links werden nicht unterstrichen (umrahmt) werden-->
</style>
</head>
<body bgcolor="4481b9">

<center>

<?php
include("cfg.php");

if(isset($_POST['suchtext']))
{
	$query="SELECT * FROM wkw.wkw WHERE id like '".$_POST['suchtext']."' or
		wkwID like '".$_POST['suchtext']."' or 
		vorname like '".$_POST['suchtext']."' or
		name like '".$_POST['suchtext']."' or 
		name like '".$_POST['suchtext']."' or 
		gebName like '".$_POST['suchtext']."' or 
		nick like '".$_POST['suchtext']."' or 
		geschl like '".$_POST['suchtext']."' or 
		geb like '".$_POST['suchtext']."' or 
		str like '".$_POST['suchtext']."' or 
		land like '".$_POST['suchtext']."' or 
		plz like '".$_POST['suchtext']."' or
		ort like '".$_POST['suchtext']."' or 
		telefon like '".$_POST['suchtext']."' or 
		fax like '".$_POST['suchtext']."' or 
		handy like '".$_POST['suchtext']."' or
		icq like '".$_POST['suchtext']."' or 
		skype like '".$_POST['suchtext']."' or
		aim like '".$_POST['suchtext']."' or 
		msn like '".$_POST['suchtext']."' or 
		jabber like '".$_POST['suchtext']."' or 
		yahoo like '".$_POST['suchtext']."' or 
		hp like '".$_POST['suchtext']."' or 
		beziehung like '".$_POST['suchtext']."' or 
		position like '".$_POST['suchtext']."' or 
		beruf like '".$_POST['suchtext']."' or 
		links like '".$_POST['suchtext']."' or 
		bild like '".$_POST['suchtext']."'";

		$daten = mysql_query($query, $link);

		$zahl=mysql_num_rows($daten);

		if($zahl!=0)
		{
			echo "<big><br>Es ";

			if($zahl>1)
			{
				echo "wurden <b>$zahl</b> Datensätze";
			}
			else
			{
				echo "wurde <b>$zahl</b> Datensatz";
			}
		
			echo " gefunden!<br><br></big>";
			showTabelle($daten);
		}
		else
		{
			?>
			<h2>Hier können Sie nach sämtlichen Feldern suchen...</h2>
			<h3>Statt '*' bitte '%' verwenden!</h3>
			<br><br><br>
			<form action="<?php $_SERVER['PHP_SELF'] ?>", method="post", name="suche">
			<input type="text" name="suchtext">
			<br><br>
			<input type="submit" name="senden" value="Suchen">
			</form>
			<h2>Leider nichts gefunden!</h2>
			<?php
		}
}
else
{
?>
	<h2>Hier können Sie nach sämtlichen Feldern suchen...</h2>
	<h3>Statt '*' bitte '%' verwenden!</h3>
	<br><br><br>
	<form action="<?php $_SERVER['PHP_SELF'] ?>", method="post", name="suche">
	<input type="text" name="suchtext">
	<br><br>
	<input type="submit" name="senden" value="Suchen">
	</form>
<?php
}
?>
</center>
</body>
</html>