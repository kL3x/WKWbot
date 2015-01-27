<html>
<head>
<meta http-equiv="refresh" content="1; URL=live.php">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">

<style type="text/css">
a:link{color:#000000;}		<!-- Links bleiben schwarz -->
a:visited{color:#000000;}	<!-- Besuchte LInks bleiben Schwarz-->
a {text-decoration:none;}	<!-- Links werden nicht unterstrichen (umrahmt) werden-->
</style>

</head>
<body bgcolor="4481b9">

<?php
include("cfg.php");

/*$query="SELECT wkw.bot_log.wkwID FROM wkw.bot_log WHERE status like 'wird ausgelesen' order by wkw.bot_log.logID desc limit 1";
$daten= mysql_query($query,$link);
$row=mysql_fetch_object($daten);
echo $row->wkwID." wird ausgelesen<br>";*/

//$query="SELECT wkw.bot_log.email, wkw.bot_log.wkwID, wkw.bot_log.status, wkw.bot_log.vorhanden, wkw.* FROM wkw.wkw INNER JOIN wkw.bot_log ON wkw.bot_log.wkwID = wkw.wkw order by id desc limit 3";
$query="SELECT * FROM wkw.wkw order by id desc limit 3";

$daten = mysql_query($query, $link);

echo "	<table border=1>
	<tr>";
	//<td><b>User<b></td>
	//<td><b>Status<b></td>
	//<td><b>Vor handen<b></td>
echo "	<td><b>ID</b></td>
	<td><b>wkwID</b></td>
	<td><b>Bild</b></td>
	<td><b>Vorname</b></td>
	<td><b>Name</b></td>
	<td><b>Geburtsname</b></td>
	<td><b>Nickname</b></td>
	<td><b>Geschlecht</b></td>
	<td><b>Geburtsdatum</b></td>
	<td><b>Straﬂe</b></td>
	<td><b>Land</b></td>
	<td><b>Postleitzahl</b></td>
	<td><b>Wohnort</b></td>
	<td><b>Telefonnummer</b></td>
	<td><b>Faxnummer</b></td>
	<td><b>Handynummer</b></td>
	<td><b>ICQ UIN</b></td>
	<td><b>Skype Name</b></td>
	<td><b>AIM Messenger</b></td>
	<td><b>MSN Messenger</b></td>
	<td><b>Jabber Name</b></td>
	<td><b>Yahoo Name</b></td>
	<td><b>Homepage</b></td>
	<td><b>Beziehungsstatus</b></td>
	<td><b>Berufsposition</b></td>
	<td><b>Beruf</b></td>
	<td><b>Beliebtheitsindex</b></td>
	</tr>";

	while($row = mysql_fetch_object($daten))
	{
	echo "<tr><td>";
//		if($row->email==""){echo "&nbsp; ";}else{echo $row->email;}
//	echo "</td><td>";
//		if($row->status==""){echo "&nbsp; ";}else{echo $row->status;}
//	echo "</td><td>";
//		if($row->vorhanden==""){echo "&nbsp; ";}else{echo $row->vorhanden;}
//	echo "</td><td>";
		if($row->ID==""){echo "&nbsp; ";}else{echo $row->ID;}
	echo "</td><td>";
		if($row->wkwID==""){echo "&nbsp; ";}else{echo "<a href='/interface/detail.php?id=$row->wkwID'>$row->wkwID</a>";}
	echo "</td><td>";
		if($row->bild==""){echo "&nbsp; ";}else{echo "<img src=\"$row->bild\">";}
	echo "</td><td>";
		if($row->vorname==""){echo "&nbsp; ";}else{echo $row->vorname;}
	echo "</td><td>";
		if($row->name==""){echo "&nbsp; ";}else{echo $row->name;}
	echo "</td><td>";
		if($row->gebName==""){echo "&nbsp; ";}else{echo $row->gebName;}
	echo "</td><td>";
		if($row->nick==""){echo "&nbsp; ";}else{echo $row->nick;}
	echo "</td><td>";
		if($row->geschl==""){echo "&nbsp;";}else{ echo $row->geschl;}
	echo "</td><td>";
		if($row->geb==""){echo "&nbsp;";}else{echo $row->geb;}
	echo "</td><td>";
		if($row->str==""){echo "&nbsp; ";}else{echo $row->str;}
	echo "</td><td>";
		if($row->land==""){echo "&nbsp; ";}else{echo $row->land;}
	echo "</td><td>";
		if($row->plz==""){echo "&nbsp; ";}else{echo $row->plz;}
	echo "</td><td>";
		if($row->ort==""){echo "&nbsp; ";}else{echo $row->ort;}
	echo "</td><td>";
		if($row->telefon==""){echo "&nbsp; ";}else{echo $row->telefon;}
	echo "</td><td>";
		if($row->fax==""){echo "&nbsp; ";}else{echo $row->fax;}
	echo "</td><td>";
		if($row->handy==""){echo "&nbsp; ";}else{echo $row->handy;}
	echo "</td><td>";
		if($row->icq==""){echo "&nbsp; ";}else{echo $row->icq;}
	echo "</td><td>";
		if($row->skype==""){echo "&nbsp; ";}else{echo $row->skype;}
	echo "</td><td>";
		if($row->aim==""){echo "&nbsp; ";}else{echo $row->aim;}
	echo "</td><td>";
		if($row->msn==""){echo "&nbsp; ";}else{echo $row->msn;}
	echo "</td><td>";
		if($row->jabber==""){echo "&nbsp; ";}else{echo $row->jabber;}
	echo "</td><td>";
		if($row->yahoo==""){echo "&nbsp; ";}else{echo $row->yahoo;}
	echo "</td><td>";
		if($row->hp==""){echo "&nbsp; ";}else{echo $row->hp;}
	echo "</td><td>";
		if($row->beziehung==""){echo "&nbsp; ";}else{echo $row->beziehung;}
	echo "</td><td>";
		if($row->position==""){echo "&nbsp; ";}else{echo $row->position;}
	echo "</td><td>";
		if($row->beruf==""){echo "&nbsp; ";}else{echo $row->beruf;}
	echo "</td><td>";
		if($row->links==""){echo "&nbsp; ";}else{echo $row->links;}
	echo "</td></tr>";
	}
	echo "</table>";


?>
</body>
</html>