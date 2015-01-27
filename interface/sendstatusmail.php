<?php 
// Daten holen
		

		 
		$srvuptime=system(uptime);

		 
		$srvdatum=system(date);



$sender = "wkw_Bot@XXX.org";
$empfaenger = "bla@blubb.org";
$betreff = "Statusmail vom WKW Crawler";
$mailtext = "Moin X,<br><br>Hier der Status vom Bot:<br> 
Server Uptime: <b>$srvuptime</b> <br>
Server Datum:  <b>$srvdatum</b>";
mail($empfaenger, $betreff, $mailtext, "From: $sender\n" . "Content-Type: text/html; charset=iso-8859-1\n"); 
echo "Mail gesendet";
?>
