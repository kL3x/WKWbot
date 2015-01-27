<?php
error_reporting(E_ALL);

set_time_limit(0);		//0 -> Script wird niemals abgebrochen !
 
//letzte ID aus txtDatei auslesen
$fp1 = fopen("id.txt","r"); 
$ID = fread($fp1);
fclose($fp1);
echo $ID;

//MySQL verbindung herstellen
$link=mysql_connect("localhost", "root", "mYsqll0r$");
$query="SELECT ID,wkwID,bild FROM wkw.wkw";
echo $query;
$daten = mysql_query($query, $link);

while($row = mysql_fetch_object($daten))
{
	$pfad= "/srv/www/htdocs/userbilder/".$row->wkwID.".jpg";
	 file_put_contents($pfad, file_get_contents($row->bild));
	echo "<br>$row->wkwID";
	$letzteID= $row->ID;
}

$fp = fopen("id.txt","w"); 
fputs($fp,$letzteID);
fclose($fp);
?>
