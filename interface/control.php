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
include("../class.php");


if(isset($_POST['login']) || isset($_POST['logout']))
{
	if(isset($_POST['login']))
	{
	//Script starten
	exec("/home/wkwbot/./startbot.sh > /dev/null &");	
	echo "LoginScript gestartet";
	}

	if(isset($_POST['logout']))
	{
	//Script starten
	exec("/home/wkwbot/./stopwkw.sh > /dev/null &");
	echo "LogoutScript gestartet";
	}
}
?>
		<form action="<?php $_SERVER['PHP_SELF'] ?>", method="post", name="form1">
		<br><br>
		<input type="submit" name="login" value="Login">
		<br><br>
		<input type="submit" name="logout" value="Logout">
		</form>

	<?php

		$run=exec("pgrep bot.sh");
		if($run!="")
		{
		echo "<br><br>Der Bot läuft momentan!";
		}
		else
		{
		echo "<br><br>Der Bot läuft momentan nicht!";
		}

		echo "<br>----------------------------------------------------------------";
		echo "<br>Server Informationen:";
	
		$freierhdplatz="df -h | grep /dev/sda1 | tr -s ' '| cut -d ' ' -f 4";
		$freierhdplatzinprozent="df -h | grep /dev/sda1 | tr -s ' '| cut -d ' ' -f 5";
		echo "<br><br>Freier Platz auf der Festplatte: ";
		system($freierhdplatz);
		echo "frei ";
		echo "( ";
		system($freierhdplatzinprozent);
		echo "belegt )";

	
		echo "<br> Server Uptime: "; 
		system(uptime);

		echo "<br> Server Datum: "; 
		system(date);

		echo "<br>----------------------------------------------------------------";
		echo "<br>Datenbank Informationen:";

		$abfrage="ps ax | grep mysqld";
		echo "<br><br>Datenbank Prozess: ";
		system($abfrage);

		echo "<br>----------------------------------------------------------------";
		echo "<br>Webserver Informationen:";

		echo "<br><br>Arbeitsspeicher: ";
		system(free);
		
		$kernelinfo="uname -a";
		echo "<br><br> Kernel-Info: "; 
		system($kernelinfo);

		echo "<br><br> Prozessorfamilie: ";
		system(arch);

		$susever="cat /etc/SuSE-release | grep openSUSE";
		echo "<br><br>SuSE Version: ";
		system($susever);

		$eingeloggte=exec("who");
		if($eingeloggte=="")
		{
		$eingeloggte = "Niemand per Shell eingeloggt";
		}
		echo "<br><br> Eingeloggte Benutzer: ";
		echo "$eingeloggte";

		echo "<br><br>Apache Version: ";
		echo $_SERVER["SERVER_SOFTWARE"];

		echo "<br><br>PHP Version: ";
		echo '' . phpversion();

		
		
		
?>

</body>
</html>