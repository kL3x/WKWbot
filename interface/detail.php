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
error_reporting(E_ALL);
include("cfg.php");

$query = "SELECT * FROM wkw.wkw WHERE wkwID = '".$_GET['id']."'";

$daten = mysql_query($query, $link);

$row = mysql_fetch_object($daten);

	echo "	<table border=1>";
	echo"<th rowspan=26><img src='/userbilder/".$row->wkwID.".jpg'></th>";
	echo"<tr><td><b>ID</b></td><td> "; if($row->ID==""){echo "&nbsp; ";}else{echo $row->ID;} echo "</td></tr>";
	echo"<tr><td><b>wkwID</b></td><td>"; if($row->wkwID==""){echo "&nbsp; ";}else{echo $row->wkwID;} echo"</td></tr>";
	echo"<tr><td><b>Vorname</b></td><td>";if($row->vorname==""){echo "&nbsp; ";}else{echo $row->vorname;} echo"</td></tr>";
	echo"<tr><td><b>Name</b></td><td>";if($row->name==""){echo "&nbsp; ";}else{echo $row->name;} echo"</td></tr>";
	echo"<tr><td><b>Geburtsname</b></td><td>";if($row->gebName==""){echo "&nbsp; ";}else{echo $row->gebName;} echo"</td></tr>";
	echo"<tr><td><b>Nickname</b></td><td>";if($row->nick==""){echo "&nbsp; ";}else{echo $row->nick;} echo"</td></tr>";
	echo"<tr><td><b>Geschlecht</b></td><td>";if($row->geschl==""){echo "&nbsp;";}else{ echo $row->geschl;} echo"</td></tr>";
	echo"<tr><td><b>Geburtsdatum</b></td><td>";if($row->geb==""){echo "&nbsp;";}else{echo $row->geb;} echo"</td></tr>";
	echo"<tr><td><b>Straﬂe</b></td><td>";if($row->str==""){echo "&nbsp; ";}else{echo $row->str;} echo"</td></tr>";
	echo"<tr><td><b>Land</b></td><td>";if($row->land==""){echo "&nbsp; ";}else{echo $row->land;} echo"</td></tr>";
	echo"<tr><td><b>Postleitzahl</b></td><td>";if($row->plz==""){echo "&nbsp; ";}else{echo $row->plz;} echo"</td></tr>";
	echo"<tr><td><b>Wohnort</b></td><td>";if($row->ort==""){echo "&nbsp; ";}else{echo $row->ort;} echo"</td></tr>";
	echo"<tr><td><b>Telefonnummer</b></td><td>";if($row->telefon==""){echo "&nbsp; ";}else{echo $row->telefon;} echo"</td></tr>";
	echo"<tr><td><b>Faxnummer</b></td><td>";if($row->fax==""){echo "&nbsp; ";}else{echo $row->fax;} echo"</td></tr>";
	echo"<tr><td><b>Handynummer</b></td><td>";if($row->handy==""){echo "&nbsp; ";}else{echo $row->handy;} echo"</td></tr>";
	echo"<tr><td><b>ICQ UIN</b></td><td>";if($row->icq==""){echo "&nbsp; ";}else{echo $row->icq;} echo"</td></tr>";
	echo"<tr><td><b>Skype Name</b></td><td>";if($row->skype==""){echo "&nbsp; ";}else{echo $row->skype;} echo"</td></tr>";
	echo"<tr><td><b>AIM Messenger</b></td><td>";if($row->aim==""){echo "&nbsp; ";}else{echo $row->aim;} echo"</td></tr>";
	echo"<tr><td><b>MSN Messenger</b></td><td>";if($row->msn==""){echo "&nbsp; ";}else{echo $row->msn;} echo"</td></tr>";
	echo"<tr><td><b>Jabber Name</b></td><td>";if($row->jabber==""){echo "&nbsp; ";}else{echo $row->jabber;} echo"</td></tr>";
	echo"<tr><td><b>Yahoo Name</b></td><td>";if($row->yahoo==""){echo "&nbsp; ";}else{echo $row->yahoo;} echo"</td></tr>";
	echo"<tr><td><b>Homepage</b></td><td>";if($row->hp==""){echo "&nbsp; ";}else{echo $row->hp;} echo"</td></tr>";
	echo"<tr><td><b>Beziehungsstatus</b></td><td>";if($row->beziehung==""){echo "&nbsp; ";}else{echo $row->beziehung;} echo"</td></tr>";
	echo"<tr><td><b>Berufsposition</b></td><td>";if($row->position==""){echo "&nbsp; ";}else{echo $row->position;} echo"</td></tr>";
	echo"<tr><td><b>Beruf</b></td><td>";if($row->beruf==""){echo "&nbsp; ";}else{echo $row->beruf;} echo"</td></tr>";
	echo"<tr><td><b>Beliebtheitsindex</b></td><td>";if($row->links==""){echo "&nbsp; ";}else{echo $row->links;} echo"</td></tr>";

?>

</body>
</html>