<html>
<head>
<style type="text/css">
a:link{color:#000000;}		<!-- Links bleiben schwarz -->
a:visited{color:#000000;}	<!-- Besuchte LInks bleiben Schwarz-->
a {text-decoration:none;}	<!-- Links werden nicht unterstrichen (umrahmt) werden-->
</style>
</head>
<body bgcolor="4481b9">

<?php
echo "Blub";



$seite = 21 //Anzahl der Daten pro Seite

//Falls der Wert 'offset' via GET �bergeben wurde, diesen auslesen, ansonsten bei 0 anfangen.
if (isset($_GET['offset']))
{
   $offset = intval($_GET['offset']);
}
else
{
   $offset = 0;
}


//Gesamtzahl der Datens�tze in der Tabelle ermitteln
list($anzahl) = mysql_fetch_array(safe_query("SELECT COUNT(ID) FROM wkw.wkw"));

//$anzahl Datens�tze nach Datum sortiert ausw�hlen
$query = "SELECT * FROM wkw.wkw $offset,$seite";
$result = safe_query($query);

	echo "<table><tr><td>blub</td><tr>";
	$zaehler=0;

	while($row = mysql_fetch_object($result))
	{
		if ($zaehler%7==0)
		{
			echo "<tr>";
		}
		echo "<td><a href=''><img src='../userbilder/$row->wkwID.jpg'><br> $row->vorname $row->name</a></td>";
		$letzteID;
		$zaehler++;
	}
	echo "</table>"; 

//Navigation erzeugen, in diesem Fall ein einfaches Vor bzw. Zur�ck, es k�nnen nat�rlich auch Seiten angezeigt werden
if ($offset > 0)
{
//Falls nicht der erste Eintrag angezeigt wird, kann immer eine Seite zur�ck gegangen werden.
   echo '<a href="index.php?offset="'.($offset - $seite).'"><< vorherige Eintr�ge</a> ';
}

if ($offset + $seite < $anzahl)
{
   echo '<a href="index.php?offset="'.($offset + $seite).'"> n�chste Eintr�ge >></a>';
}

?>
</body>
</html>