<?php

$link= mysql_connect("localhost", "root", "mYsqll0r$");

function showTabelle($daten)
{
	echo "	<table border=1>
	<tr>
	<td><b>ID</b></td>
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
		if($row->ID==""){echo "&nbsp; ";}else{echo $row->ID;}
	echo "</td><td>";
		if($row->wkwID==""){echo "&nbsp; ";}else{echo "<a href='/interface/detail.php?id=$row->wkwID'>$row->wkwID</a>";}
	echo "</td><td>";
		if (file_exists("/srv/www/htdocs/userbilder/$row->wkwID.jpg"))
		{
			echo "<img src='/userbilder/$row->wkwID.jpg'>";
		}
		else
		{
			echo "<img src='WKW.png'>";
		}
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
}


?>