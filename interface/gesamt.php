<html>
<head>
<meta http-equiv="refresh" content="5; URL=gesamt.php">
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

$link = mysql_connect("localhost", "root", "mYsqll0r$");
$query="SELECT COUNT(id) FROM wkw.wkw";
$daten = mysql_fetch_row(mysql_query($query, $link));
$anzahl=$daten[0];


$querymaenner="SELECT COUNT(id) FROM wkw.wkw WHERE geschl LIKE 'm%'";
$zahlmaenner= mysql_fetch_row(mysql_query($querymaenner, $link));
$maenner=$zahlmaenner[0];

$queryfrauen="SELECT COUNT(id) FROM wkw.wkw WHERE geschl LIKE 'w%'";
$zaehlefrauen=mysql_fetch_row(mysql_query($queryfrauen, $link));
$frauen=$zaehlefrauen[0];

$queryicq="SELECT COUNT(id) FROM wkw.wkw WHERE icq != ''";
$zahlicq=mysql_fetch_row(mysql_query($queryicq, $link));
$icq=$zahlicq[0];


$querytelefon="SELECT COUNT(id) FROM wkw.wkw WHERE telefon != ''";
$zahltelefon=mysql_fetch_row(mysql_query($querytelefon, $link));
$telefon=$zahltelefon[0];


$queryhandy="SELECT COUNT(id) FROM wkw.wkw WHERE handy != ''";
$zahlhandy=mysql_fetch_row(mysql_query($queryhandy, $link));
$handynummer=$zahlhandy[0];


//Homepages
//$queryhomepages="SELECT * FROM wkw.wkw WHERE hp != ''";
//$zahlhomepages=mysql_query($queryhomepages, $link);
//$homepages=mysql_num_rows($zahlhomepages);

//Skype
//$queryskype="SELECT * FROM wkw.wkw WHERE skype != '';
//$zahlskype=mysql_query($queryskype, $link);
//$skype=mysql_num_rows($zahlskype);

//Geschlechtlose :-)
$mitgeschlecht=$maenner+$frauen;
$geschlechtlose=$anzahl-$mitgeschlecht;


//Kerle und Weiber in Prozent
$prozentmaenner=$maenner/$anzahl;
$prozentfrauen=$frauen/$anzahl;
$frauenanteilinprozent=substr($prozentfrauen,2,2); //Wird mit substring geschnitten weil sonst 0.XYZZYX rauskommt
$maenneranteilinprozent=substr($prozentmaenner,2,2); //Die erste 2 schneidet '0.' vom string ab die zweite beschraenkt seine laenge auf insgesamt 2 zeichen


//Zahlen gescheit darstellen
$anzahl = number_format($anzahl);
$maenner = number_format($maenner);
$frauen = number_format($frauen);
$icq = number_format($icq);
$telefon = number_format($telefon);
$handynummer = number_format($handynummer);




echo "<br><br>Es gibt momentan <b><i>$anzahl</i></b> Datensätze in der Datenbank!";
echo "<br><br>Darunter sind <b><i>$maenner</i></b> ( $maenneranteilinprozent% ) <u>Männer</u> und <b><i>$frauen</i></b> ( $frauenanteilinprozent% ) <u>Frauen</u>. ( Macht <b><i>$geschlechtlose</i></b> Personen ohne Geschlecht ^_^' )";
echo "<br><br>Unter allen haben <b><i>$icq</i></b> ihre <u>ICQ Nummer</u> angegeben, <b><i>$telefon</i></b> ihre private <u>Telefonnummer</u> und <b><i>$handynummer</i></b> die eigene <u>Handynummer</u>";
//echo "<br><br>Es haben <b><i>$homepages</i></b> Leute eine <u>Homepage</u> und <b><i>$skype</i></b> Personen kann man mit <u>Skype anrufen</u>!";
echo "<br><br><br><br><br>Diese Seite aktualisiert sich alle 5 Sekunden von selbst!";






?>
</body>
</html>