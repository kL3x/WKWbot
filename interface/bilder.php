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
<h1>�bersicht der WKW-User</h1>

<?php

function ShowNav($offset, $seite, $anzahl)
{
	echo "<table><tr><td>";
	//Navigation erzeugen, in diesem Fall ein einfaches Vor bzw. Zur�ck, es k�nnen nat�rlich auch Seiten angezeigt werden
	if ($offset > 0)
	{
	//Falls nicht der erste Eintrag angezeigt wird, kann immer eine Seite zur�ck gegangen werden.
	  // echo '<a href="BilderTest.php?offset='.($offset - $seite).'"><< vorherige Eintr�ge</a>';
	   echo "<h3><a href='bilder.php?offset=".($offset - $seite)."'><< vorherige Eintr�ge</a></h3>";
	}
	echo "</td><td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td><td>";

	if ($offset + $seite < $anzahl)
	{
	  // echo '<a href="BilderTest.php?offset='.($offset + $seite).'"> n�chste Eintr�ge >></a>';
	   
	   echo "<h3><a href='bilder.php?offset=".($offset + $seite)."'> n�chste Eintr�ge >></a></h3>";
	}   
	echo "</td></tr></table>";  
}



include("cfg.php");
error_reporting(E_ALL);

$seite = 18; //Anzahl der Daten pro Seite

//Falls der Wert 'offset' via GET �bergeben wurde, diesen auslesen, ansonsten bei 0 anfangen.
if (isset($_GET['offset']))
{
   $offset = $_GET['offset'];
  // echo "offset gesetzt:".$offset."<br>".$_GET['offset']."<br>";
}
else
{
   $offset = 0;
  // echo" offset=0<br><br>";
}


//Gesamtzahl der Datens�tze in der Tabelle ermitteln
list($anzahl) = mysql_fetch_array(mysql_query("SELECT COUNT(ID) FROM wkw.wkw"));
//echo $anzahl."<br><br>";

ShowNav($offset, $seite, $anzahl);

//$anzahl Datens�tze nach Datum sortiert ausw�hlen
$query = "SELECT * FROM wkw.wkw LIMIT $offset, $seite";
//echo $query;
$result = mysql_query($query, $link);

	echo "<br><table><tr>";
	$zaehler=0;

	while($row = mysql_fetch_object($result))
	{
		if ($zaehler%6==0)
		{
			echo "</tr><tr>";
		}
		//Bildergr��e �berpr�fen und Bilder schrumpfen
		echo "<td align='center' valign= 'top'> <a href='/interface/detail.php?id=$row->wkwID'>";
		if (file_exists("/srv/www/htdocs/userbilder/$row->wkwID.jpg"))
		{
			
			echo "<img src='/userbilder/$row->wkwID.jpg'>";
		}
		else
		{
			echo "<img src='WKW.png'>";
		}
		echo "<br> $row->vorname $row->name<br><br></a></td>";	
		$letzteID;
		$zaehler++;
	}   
	echo "</tr></table>"; 
   
ShowNav($offset, $seite, $anzahl);
?>
</center>
</body>
</html>