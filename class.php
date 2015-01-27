<?php 
/********************************************************/ 
/* Name: wkw.class.php                                  */ 
/* Version: v3.0 (24.11.2009)                          */ 
/*                                                      */ 
/* Beschreibung:                                        */ 
/* Kleiner Bot fuer wer-kennt-wen.de                    */ 
/********************************************************/ 
error_reporting(E_ALL ^ E_NOTICE);

set_time_limit(0);		//0 -> Script wird niemals abgebrochen !
 
$tiefe = 0; 			//tiefe der rekursion, wird hochesetzt sobald die person deren Freunde ausgelesen werden wechselt
$waitZaehler = 0; 		//mit jedem curl_exec erhöhen, da dies einem Sietenaufruf entspricht, nach x aufrufen - >WAIT 
$username;
$pw;



//Log erstellen
$aktuelldatum = date("j, n, Y");
$fp = fopen("$aktuelldatum.html","a+"); 
//$uhrzeit = date("H:i",$timestamp);
//global $aktuelldatum, $fp, $uhrzeit;

$vorherigerUser;

$ersatzUser = "kreditkartenmonster@gmx.de";
$ersatzPw = "ftaJCQhMg7rs";

class wkw 
{ 
    private $cookies; 
    private $logged_in = false; 
	private $ch;			//handle für curl-Befehle
	
    function wkw($benutzername ="ichmagdieleute@gmx.de", $passwort= "lodade44") 
    { 
		global $username;			//Übergebener Benutzername und Passwort in globale Variablen speichern
		global $pw;
		$username = $benutzername;
		$pw = $passwort;
		
        	$this->ch = curl_init(); 			//curl handle initialisieren
		$this->login($benutzername, $passwort);
		$this->tiefe=0;
    } 
        
    function closeCurl() 
    { 
        curl_close ($this->ch);  
    } 
 
    function login($benutzername, $passwort) 
    { 
		global $fp;
		
        $this->cookieholen(); 						//zuerst den Cookie holen, da man sich ansonsten nicht einloggen kann
        $this->einloggen($benutzername,$passwort); 	//...dann einloggen
        $this->logged_in = true; 
	    echo "<br>------login-------"; 
	    fputs($fp,"<br><br><br>[Zeit: ".date("H:i",$timestamp)."] ---------- Login ----------<br>");
    } 
	
	function logout()
	{
		global $fp;
		
		echo "<br>------logout-----";
		fputs($fp,"[Zeit:".date("H:i",$timestamp)."] ---------- Logout ----------<br>");
		curl_setopt($this->ch, CURLOPT_URL, 'http://www.wer-kennt-wen.de/logout');	// Logoutseite 
		curl_exec($this->ch); 	
	}
  
    function cookieholen() 
    { 
		global $fp;
		
        curl_setopt($this->ch, CURLOPT_URL, 'http://www.wer-kennt-wen.de/start.php');	// Loginseite 
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie_von_wkw.txt');                // Browser imitieren 
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);                       		// store returndata 
        $loginform = curl_exec($this->ch); 												//curl ausführen
		//	echo "<br>cookie holen() ,loginform: $loginform <br>";
		fputs($fp,"[Zeit: ".date("H:i",$timestamp)."] ---------- grapping cookie ----------<br>");
    }

    function einloggen($benutzername,$passwort) 
    { 
            $postfields  = "loginName=".$benutzername; 
            $postfields .= "&pass=".$passwort; 
			$postfields .= "&logIn=1&x=30&y=7";			//logIn , x, y werden von WKW per Post mitgegeben. Noch kein Sinn dahinter entdeckt

              curl_setopt ($this->ch, CURLOPT_URL, 'http://www.wer-kennt-wen.de/start.php');//login Seite 
              curl_setopt ($this->ch, CURLOPT_POST, 1);										//http POST einschalten 
              curl_setopt ($this->ch, CURLOPT_POSTFIELDS, $postfields);						//postfields setzen 
              curl_setopt ($this->ch, CURLOPT_COOKIEJAR, 'cookie_von_wkw.txt');				//cookie nehmen und... 
              curl_setopt ($this->ch, CURLOPT_RETURNTRANSFER, 1);							//zuruecksenden 
              $login =curl_exec ($this->ch); 
				//print_r($login);	
      }//einloggen 
 
		//Gibt die Aufgerufene Seite komplett zurück
		function getData()
		{
			//echo $this->ch;
		//   curl_setopt ($this->ch, CURLOPT_POST, 0);                                                     // http post not needed 
            curl_setopt($this->ch, CURLOPT_URL, 'http://www.wer-kennt-wen.de/people/friends');    // message page 
            $sMessages = curl_exec($this->ch); 
            //echo "Messages - /people/friends - :$sMessages"; 
			print_r($sMessages);
			// preg_match_all("/\/Messages\/".$type."\/messageId\/(.*)\/p\/".$dPage."/",$sMessages,$aAllMessageIDs); 
			//   return $aAllMessageIDs[0]; 
		}
		

//REKURSIV !
 function getFreunde($id)
 {
	global $tiefe; 						//Variable hier brauchbar machen, die anzeigt wieoft man von Person zu Person gesprungen ist
	global $vorherigerUser;
	global $username;
	global $fp;
	
	echo "<br>tiefe: ".$tiefe;
	//fputs($fp,"[Zeit: $uhrzeit] Aktuelle Tiefe: $tiefe<br>");
	$tiefe++;
		
	//--- Überprüfen wieviele ausgelesen wurden und Pause einbauen
	$this->Wait();
	//--- ----

	
	//Überprüfen obs die Seite überhaupt gibt, wenn nicht, wkw.de aufrufen, dann wird man automatisch zu der Fehlermeldung weitergeleitet (captcha, Person nicht gefunden, usw)
	if (curl_setopt($this->ch, CURLOPT_URL, "http://www.wer-kennt-wen.de/people/friends/$id/$seite"))
	{
		$freunde= curl_exec($this->ch);
		if ($freunde!="")
		{
			//----In die LogDB schreiben----
				/*$daten= $this->DBabfrage("SELECT * FROM wkw.wkw WHERE wkwID = '".$id."'");
				if( mysql_num_rows($daten)>0)	// Überprüfen ob leer , wenn ja ist noch kein Datensatz mit dieser ID vorhanden...
				{
					$vorhanden="ja";
				}
				else
				{
					$vorhanden="nein";
				}
				$query="INSERT INTO wkw.bot_log (email, wkwID, status, vorhanden) VALUES('$username', '$id', 'wird ausgelesen', '$vorhanden')";
				//echo $query;
				$this->DBabfrage($query);*/
			//-----------------------------

			//Alle links auslesen die "/person" enthalten
			preg_match_all('"/person/(.*)"', $freunde, $freundeListe);		//es wird ein array erzeugt das im  element[0] ein weiteres array mit allen freunden enthält.
			echo "<br><br>FREUNDE von $id";									//  dieses innere Array wird durchlaufen und jeder 2.eintrag (eine person hat irgendwie immer 2 links, ein LInk für Schriftzug, einer für Bild) wird ausgegeben (manchmal auch 3 O_o....)
			fputs($fp,"[Zeit:".date("H:i",$timestamp)."] Freunde von: $id<br>");			
																//     da nun die Überprüfung auf vonhandenInDB drinist ist dies egal...
			//Zuerst ALLE freunde der aktuellen PErson ausgeben lassen, ...
			for($i=0; $i<count($freundeListe[0]);$i=$i+2)
			{
				$f = substr($freundeListe[0][$i],8,8);
				$this->einzelheitenAuslesen($f);			
			}
			//....dann auch die Freunde auf den nächsten Seiten....	
				//...wenn die Seiten denn existieren...
			if(preg_match("#sort\/friends\/0\/0\/64#", $freunde )==1)
			{			//Überprüfung ob der string gefunden wird, wenn ja ist der LInk zur 2. Seite mit Freunden vorhanden
				$this->getFreundeNaechsteSeite($id);	//Funktion um alle Seiten mit Freunden auszulesen
			}
			//...dann einfach IRGENDEIN (in diesem fall der 6 der 1. Seite) Freund nehmen, wieder ALLE freundes von dem ausgeben lassen usw...
			
			//---------Random GetFreunde------------
			/*$query="SELECT wkwID FROM wkw.wkw order by id desc limit 1";
			$daten=$this->DBabfrage($query);
			$array=mysql_fetch_array($daten);

			if ($array[0]==$vorherigerUser)
			{
				$query="SELECT wkwID FROM wkw.wkw order by id desc limit 4";
				$daten=$this->DBabfrage($query);
				$array=mysql_fetch_array($daten);
				echo "<br>nächster Freund (drittletzer): $array[3] <br>";
				//fputs($fp,"[Zeit: $uhrzeit] nächster Freund (drittletzter) $array[3]<br>");
				$vorherigerUser=$id;
				$this->getFreunde($array[3]);	
			}
			else
			{
				echo "<br>nächster Freund (letzter): $array[0] <br>";
				//fputs($fp,"[Zeit: $uhrzeit] nächste Freund (letzter): $array[0]<br>");
				$vorherigerUser=$id;
				$this->getFreunde($array[0]);			
			}*/

			$query="SELECT wkwID FROM wkw.wkw order by id desc limit 10";
			$daten=$this->DBabfrage($query);
			$array=mysql_fetch_array($daten);
			$zufall=rand(0,9);
			echo "<br>zufallswert:".$array[$zufall];
			fputs($fp,"[Zeit:".date("H:i",$timestamp)."] Zufallswert: ".$array[zufall]."<br>");
			$this->getFreunde($array[$zufall]);
			//---------------------------------------------
		}
		else
		{	
			echo "<br>---CAPTCHA---";
			//fputs($fp,"<br><br><br>[Zeit: $uhrzeit] ---------- C A P C H A ----------<br><br><br>");
			$this->userWechsel($id);
			/*//Wenn man Captcha eingeben muss, wird es angezeigt,
			//  nun eigentlich unsinning, man bräuchte nurnoch sicherheitshabler das "die"/exit
			curl_setopt($this->ch, CURLOPT_URL, 'http://www.wer-kennt-wen.de/captcha');
			$captcha= curl_exec($this->ch);
			print_r($captcha);
			//Signalton ?
			echo "<form name='captcha' action=".$_SERVER['PHP_SELF']." , method='post'>
				  <textarea name='recaptcha_challenge_field' rows='3' cols='40'>
				</textarea>
				<input type='submit' name='senden' value='captcha senden'>
				</form>";					//kläglihce versuche ein Captchar zu umgehen und durch den bot ausfüllen zulassen		
			//entweder Timer einabuen oder hier weitermachen mti captcha durchgeben
			die("---CAPTCHA---");			//Script komplett beenden und Meldung für Captchar ausgeben*/
		}
	}
	else
	{	//Wenn Person nicht gefunden
		curl_setopt($this->ch, CURLOPT_URL, 'http://www.wer-kennt-wen.de');
		$captcha= curl_exec($this->ch);
		print_r($captcha);
		//Signalton ?
		die("--Person nicht gefunden oder so---");	//Script komplett beenden und Meldung für NIchtGefunden ausgeben
	}
 }
 
function getFreundeNaechsteSeite($id)
{
	global $fp;
	$seite1 = 0;
	$seite2 = 0;
	$seite3 = 64;
	
	$fehler = 0;
	while($fehler==0)
	{
		//--- Überprüfen wieviel ausgelesen wurden und Pause einbauen
		$this->Wait();
		//--- ----
		echo "nächste seite $seite3";
		fputs($fp,"[Zeit:".date("H:i",$timestamp)."] nächste Seite: Seite $seite3<br>");
		
		//Überprüfen obs die Seite überhaupt gibt, wenn nicht, wkw.de aufrufen, dann wird man automatisch zu der Fehlermeldung weitergeleitet (captcha, Person nicht gefunden, usw)
		if (curl_setopt($this->ch, CURLOPT_URL, "http://www.wer-kennt-wen.de/people/friends/$id/sort/friends/$seite1/$seite2/$seite3"))
		{
			$freunde= curl_exec($this->ch);
			
			if ($freunde!="")
			{
				//Alle links auslesen die "/person" enthalten
				preg_match_all('"/person/(.*)"', $freunde, $freundeListe);
				//es wird ein array erzeugt das im  element[0] ein weiteres array mit allen freunden enthält.
				//	dieses innere Array wird durchlaufen und jeder 2.eintrag (eine person hat irgendwie immer 2 links) wird ausgegeben (manchmal auch 3 O_o....)
				for($i=0; $i<count($freundeListe[0]);$i=$i+2)
				{
					$f = substr($freundeListe[0][$i],8,8);
					$this->einzelheitenAuslesen($f);			
				}
				//Anscheinden wird nur die letzte Zahl erhöt, die 0/0/ bleibt immer stehen
				$seite3 = $seite3+64;	//da auf jede Seite 64 Personen passen, imme rum 64 erhöhen
										//  habs eben getestet, mann kann auch 0/0/50 nehmen und kommt auf die 2. Seite...
										
				if(preg_match("#sort\/friends\/$seite1\/$seite2\/$seite3#", $freunde )==0)
				{						//Überprüfen ob die nächste Seite in der aktuellen als Link gefunden wird
					$fehler = 1;		//  ...fehler auf 1 setzten
					return $fehler;		//  ... mit return die function beenden
				}		
			}
			else
			{	//bei captcha
				echo "captcha";		//Meldung machen ...
				fputs($fp,"<br><br><br>[Zeit:".date("H:i",$timestamp)."] ---------- C A P C H A ----------<br><br><br>");
				$fehler = 1;		//  ...fehler auf 1 setzten
				return $fehler; 	//  ... mit return die function beenden
			}
		}
		else
		{	//Wenn Person nicht gefunden
			echo "gibt keine weitere seite für $id";
			fputs($fp,"[Zeit:".date("H:i",$timestamp)."] I N F O: Keine weitere Seite für $id<br>");
			$fehler = 1;
			return $fehler;
		}
	}
	return 0; //diese Funktion wird niemals 0 zurückgeben ^^
}
 
 function einzelheitenAuslesen($id)
 {	//Auslesen der angegebenen Personendaten und schreiben in die DB 	
	global $username;
	global $fp;
	
	$daten= $this->DBabfrage("SELECT * FROM wkw.wkw WHERE wkwID = '".$id."'");
	if( mysql_num_rows($daten)>0)	// Überprüfen ob leer , wenn ja ist noch kein Datensatz mit dieser ID vorhanden...
	{
		echo "<br> schon in DB! $id";		//...wenn nicht leer --> NICHTs machen
		fputs($fp,"[Zeit:".date("H:i",$timestamp)."] Schon in DB: $id<br>");
		$row = mysql_fetch_object($daten);
		$anzahl= $row->links + 1;
		$this->DBAbfrage("UPDATE wkw.wkw SET links=$anzahl WHERE wkwID = '".$id."'");
		echo " ".$anzahl."te Verlinkung";
		fputs($fp,"[Zeit:".date("H:i",$timestamp)."] Verlinkung $anzahl<br>");
		$vorhanden="ja";
	}
	else
	{//Daten noch nicht vorhanden
		$vorhanden="nein";
		//--- Überprüfen weiviel ausgelesen wurden und Pause einbauen
		$this->Wait();
		//--- ----
		
		if(curl_setopt($this->ch, CURLOPT_URL, "http://www.wer-kennt-wen.de/person/$id"))
		{	//überprüfen obs klappt, wenn nicht gibts die Person nicht
			$info= curl_exec($this->ch);

			if($info!="")
			{// überprüfen ob was drinsteht, wenn nicht hängt man wohl am Captcha
		//-------------------------Daten rausholen------------------------		
		//INFO 		"Notice: Undefined offset: 1 "/"2"
		//INFO		Die meldung kommt daher das es z.b. kein 1. oder 2 element in dem array  Name gibt, weil garkein Nachname angegeben wurde...
		//INFO
				
			//----------------Allgemeines ---------------------------
				$name = $vorname = $gebName = $nick = $geschl = $geb = $str = $land = $plz = $ort = ""; //Alle Variabeln leeren
			
				//VORNAME
				preg_match("#\/users\/firstName\/(.*)\/user\/$id\"\>(.*)\<\/a\>#",$info,$ergebnis);
				$vorname = substr($ergebnis[1],0,strpos($ergebnis[1],'/'));
							
				//NACHNAME
				preg_match("#\/users\/lastName\/(.*)\/user\/$id\"\>(.*)\<\/a\>#",$info,$ergebnis);
				$name =$ergebnis[2]; 	//Name steht in [1] und in [2] drin, allerdings nur in [2] mit korrekten soinderzeichen
				
				//GEBURTSNAME 
				preg_match("#\/users\/birthName\/(.*)\/user\/$id\"\>(.*)\<\/a\>#",$info,$ergebnis);
				$gebName= $ergebnis[2];
				
				//NICKNAME 
				preg_match("#\/users\/lastName\/(.*)\/user\/$id\"\>(.*)\<\/a\>(.*)\<\/td\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$nick = substr($ergebnis[3],2, strlen($ergebnis[3])-3); //keine ahung warum minus 3, aber so sind die Klammer weg die immer um den Nick herum stehen

				//GESCHLECHT
				preg_match("#\/users\/gender\/(.*)\/user\/$id\"\>(.*)\<\/a\>#",$info,$ergebnis);
				$geschl = $ergebnis[2];
				
				//GEBURTSTAG TAG&MONAT 
				preg_match("#\/users\/birthday\/(.*)\/user\/$id\"\>(.*)\<\/a\>#",$info,$ergebnis);
				//echo $ergebnis[1];		//[1] ist datum in der Form Monat-Tag, || [2] ist datum  in normaler FOrm tag.monat
										//  mann muss aber [1] nehmen da an [2] noch dsa jahr als link dranhängt
				$tagmonat = substr($ergebnis[1],3,4).".".substr($ergebnis[1],0,2);
				//echo $tagmonat;			
				preg_match("#\/users\/birthyear\/(.*)\"\>(.*)\<\/a\>#",$info,$ergebnis);
				//[1] und [2] enthalten beide das Jahr
				$geb = $tagmonat.".".$ergebnis[1];
				
				//ORT
				preg_match("#\/users\/city\/(.*)\/user\/$id\"\>(.*)\<\/a\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$ort = $ergebnis[2];
	
				//PLZ
				preg_match("#\/users\/zipCode\/(.*)\/user\/$id\"\>(.*)\<\/a\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$plz = $ergebnis[2];
	
				//STRAßE
				preg_match("#\/users\/street\/(.*)\/user\/$id\"\>(.*)\<\/a\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$str = $ergebnis[2];
				
				//LAND 
				preg_match("#\<th\>Land\<\/th\>\s{7}\<td\>(.*)\<\/td\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$land = $ergebnis[2];

			//------------------------------ENDE allgemeines ------------------------
			
			//-----------------------------Kontakt----------------------------------
				$telefon = $fax = $handy = $icq = $skype = $aim = $msn = $jabber = $yahoo = $hp = ""	; // Alle Variabeln leeren
				
				//ICQ  
				preg_match("#\<th\>ICQ\<\/th\>\s{7}\<td\>\<img src=\"(.*)\" align=\"absmiddle\"\/\>(.*)\<\/td\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$icq = $ergebnis[2];
				
				//MSN  
				preg_match("#http:\/\/www.imwrapper.com\/msn\/(.*)/live\" align=\"absmiddle\" \/\>(.*)\<\/td\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$msn = $ergebnis[2];
				
				//YAHOO 
				preg_match("#\<a href=\"ymsgr:sendim?(.*)\"\>(.*)\<\/a\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$yahoo = $ergebnis[2];
				
				//HOMEPAGE 
				preg_match("#\<a target=\"_blank\" href=\"\/redirect\/to\/(.*)\">(.*)\<\/a\>\<\/td\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$hp = $ergebnis[2];
				
				//TELEFON
				preg_match("#\<th\>Telefon\<\/th\>\s{7}\<td\>(.*)\<\/td\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$telefon = $ergebnis[1];
				
				//FAX
				preg_match("#\<th\>Fax\<\/th\>\s{7}\<td\>(.*)\<\/td\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$fax = $ergebnis[1];
				
				//HANDY 
				preg_match("#\<th\>Handy\<\/th\>\s{7}\<td\>(.*)\<\/td\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$handy = $ergebnis[1];
				
				//SKYPE 
				preg_match("#\<img src=\"http:\/\/mystatus.skype.com\/smallicon\/(.*)\" align=\"absmiddle\" \/\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$skype = $ergebnis[1];
				
				//AIM 
				preg_match("#<img src=\"http:\/\/www.imwrapper.com\/aim\/(.*)/standard\" alt=\"aim status\" />#",$info,$ergebnis);
				//print_r($ergebnis);
				$aim = $ergebnis[1];
				
				//JABBER
				preg_match("#\<th\>Jabber\<\/th\>\s{7}\<td\>(.*)\<\/td\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$jabber = $ergebnis[1];
				
			//-------------------------- ENDE kontakt-----------------------------------------------
				
			//-----------------------persönlocihes----------------------------------------------
				$beziehung = $beruf = $position = ""; 		// Alle Variablen leeren
				
				//BEZIEHUNG
				preg_match("#\<a href=\"\/users\/partnership\/(.*)\/user\/$id\">(.*)\<\/a\>\<\/td\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$beziehung = $ergebnis[2];		
				
				//POSITION  Hier fehlt von wkw aus ein schließendes </a>
				preg_match("#\<a href=\"\/users\/jobclass\/(.*)\/user\/$id\">(.*)\<\/td\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$position = $ergebnis[2];
				
				//BERUF
				preg_match("#\<th\>Beruf\<\/th\>\s{7}\<td\>(.*)\<\/td\>#",$info,$ergebnis);
				//print_r($ergebnis);
				$beruf = $ergebnis[1];		
									
			//--------------------------ENDE persönlcihes----------------------------------
				
		  //------------------------- FOTO AUSLESeN ---------------------------------
        $foto="";
	      preg_match("#\<img src=\"http:\/\/(.*).werkenntwen.de/(.*)/(.*)/big/(.*)/(.*)\.jpg\" border=\"0\"  alt=\"(.*)\"  title=\"(.*)\"  \/\>#",$info,$ergebnis);
				//print_r($ergebnis);
        $foto=substr($ergebnis[0],10,strlen($ergebnis[0]));
        $foto = substr($foto, 0,strpos($foto,'"'));

        if($foto == "" || $foto == " ")
        {
          echo "leer- $foto -";
          preg_match("#\<img src=\"http:\/\/(.*).werkenntwen.de/(.*)/big/(.*)/(.*)\.jpg\" border=\"0\"  alt=\"(.*)\"  title=\"(.*)\"  \/\>#",$info,$ergebnis);
  				//print_r($ergebnis);
          $foto=substr($ergebnis[0],10,strlen($ergebnis[0]));
          $foto = substr($foto, 0,strpos($foto,'"'));
          
          if($foto=="" || $foto==" ")
          {
             echo "leer- $foto -";
             preg_match("#\<img src=\"http:\/\/static.werkenntwen.de\/images\/dummy\/dummy_1_big.gif\" border=\"0\"  alt=\"(.*)\"  title=\"(.*)\"  \/\>#",$info,$ergebnis);
      				//print_r($ergebnis);
             $foto=substr($ergebnis[0],10,strlen($ergebnis[0]));
             $foto = substr($foto, 0,strpos($foto,'"'));
          }
        }
		$pfad= "/srv/www/htdocs/userbilder/".$id.".jpg";
		echo "<br><h>id - $id - pfad - $pfad - foto - $foto<br><br>";
		file_put_contents($pfad, file_get_contents($foto));

		
			//----------------------------------------------------------------------	

				//Abfrage zusammensetzen...
				$query = "INSERT INTO wkw.wkw (wkwID, vorname, name , gebName, nick, geschl, geb, str, land, plz, ort , telefon, fax, handy , icq , skype, aim, msn , jabber , yahoo, hp , beziehung , position, beruf , bild) 
							VALUES ('$id', '$vorname', '$name' , '$gebName','$nick','$geschl','$geb','$str','$land','$plz','$ort' , '$telefon' , '$fax', '$handy' , '$icq' , '$skype' , '$aim', '$msn', '$jabber', '$yahoo' , '$hp' , '$beziehung' , '$position', '$beruf' , '$foto')";
				//....und Abfrage losschicken
				$this->DBabfrage($query);
				echo "<br>gespeichert $id";
				fputs($fp,"[Zeit:".date("H:i",$timestamp)."] In DB gespeichert: $id<br>");
			}
			else
			{	
				echo "<br>---CAPTCHA---";
				fputs($fp,"<br><br><br>[Zeit: ".date("H:i",$timestamp)."] ---------- C A P C H A ----------<br><br><br>");
				$this->userWechsel($id);
			/*	//Bei Problemem mit Captchas, Script beenden
				die("---CAPTCHA---");*/
				
			}
		}
		else
		{	//Wenn die Seite aus sonstigen gründen nicht aufgerufen werden kann
			die("--Person $id nicht gefunden oder so---");
		}
	}
	//----In die LogDB schreiben----
	/*			$query="INSERT INTO wkw.bot_log (email, wkwID, status, vorhanden) VALUES('$username', '$id', 'ist Freund', '$vorhanden')";
				//echo $query;
				$this->DBabfrage($query);*/
	//-----------------------------
 }
 
 function DBabfrage($query)
 {	// Funktion die die übergebene Abfrage ausführt und das Ergebnis zurückliefert
 	$link = mysql_connect("localhost", "root", "mYsqll0r$");

	if ($daten = mysql_query($query, $link))
	{
		return $daten;
	}	
	echo mysql_error();		//Falls es zu DB-Problemen kommt, Fehler ausgeben lassen
 }
 
 function Wait()
 {	//Wartefunktion um keine Captchas zu bekommen
	global $waitZaehler; 		//wenn alles in einer funtion ist braucht man eigentlich kein global mehr, eine Statikvar in dieser Funktion würde reichen
	global $username;
	global $pw;
	global $fp;
	
	//echo "<br><br>".$username.$pw."<br><br>";
	$waitZaehler++;
								//Beispiel für eine Zufällige Wartezeit
								//$ms = rand(1000000,2000000); // minus 6 STellen -> Sek  || 10-20sek
								//usleep($ms); 	//MICRO sekunden!!!
	echo $waitZaehler."<br>$waitZaehler Warten: 3sek";
	fputs($fp,"[Zeit:".date("H:i",$timestamp)."] Warten: 3 Sekunden<br>");
	usleep(3000000); 	//MICRO sekunden!!!
		
	if ($waitZaehler % 20 == 0)
	{	//Nach 20 wkw-zugriffen längere Pause machen
		echo $waitZaehler."<br>$waitZaehler Warten: 1sek";
		fputs($fp,"[Zeit:".date("H:i",$timestamp)."] Warten: 1 Sekunde<br>");
		usleep(1000000); 	//MICRO sekunden!!!
	}
	
	if($waitZaehler % 500 == 0)
	{	//Nach 500 wkw-zugriffen längere Pause machen
		echo $waitZaehler."<br>$waitZaehler Warten: 1sek";
		fputs($fp,"[Zeit:".date("H:i",$timestamp)."] Warten: 1 Sekunde<br>");
		usleep(1000000); 	//MICRO sekunden!!!
		
		$this->logout();				//ausloggen und wieder...
		$this->login($username,$pw);	//..einloggen, (nicht meine Idee ;) )
	}
		
		//Funktionieren tuts bis mind 310 mit 1-3 sek + 10-15 sek innhalb von ca. 25min 
		// CAPTCHA FEHLER--- tuts bis 90 mit 1-2sek + 5-10sek innerhalb von 5 min,
		//Funktioniert: 25min,  2sek + 9sek,  432 gespeicherte ~100 schon bekannte, 
		//- CAPTCHAFEHLER  2sek + 9 sek ->14min,  212 Datensätze 
		//3sek + 10 sek-> 19:37 - 1671 datensätze ---> 20:37, 900 ---> 21:37, 1738 nach 2 1/2 stunden captcha 2300 Datensätze...
		
		//3sek + 10sek + 15sek  +logoutLogin- 22:28  ~3700datensätze ----->
		//3sek + 10sek + 15sek  +logoutLogin 13:20 ~4100 ------>5500, ca 2h
		//3sek + 10sek + 15sek  +logoutLogin +Userwechsel 16:13 , 5520 Datensätze ------------->FEHLER  ~16:23
		//3sek + 10sek + 15sek  +logoutLogin +Userwechsel 16:24, 5697 Datensätze -----------> 10 000 21:21 -  4303 , 860proStunde, 14proMinute
		
	}
	
	function userWechsel($id)
	{	//Wechselt den User bei Captchas
		global $username;
		global $pw;
		global $ersatzUser;
		global $ersatzPw;
		global $fp;
		
		$this->logout();
		
		echo"<br><br>--------USER WECHSELN---------<br>";
		fputs($fp,"<br><br><br>[Zeit:".date("H:i",$timestamp)."] ---------- User wechseln ----------<br><br><br>");
		
		if ($username==$ersatzUser)
		{
			$this->login();
			echo "Neuer User: $username<br><br>";
			fputs($fp,"[Zeit:".date("H:i",$timestamp)."] Neuer User: $username<br>");
		}
		else
		{
			$this->login($ersatzUser, $ersatzPw);
			echo "Neuer User: $ersatzuser<br><br>";
			fputs($fp,"[Zeit:".date("H:i",$timestamp)." Neuer User: $ersatzuser<br>");
		}	
		//echo $id;
		$this->getFreunde($id);
	}
	
	function getZufallsId()
	{
		$daten= $this->DBabfrage("Select * FROM wkw.wkw");
		$zahl=mysql_num_rows($daten);
		$zufall=rand(1,$zahl);
  		// echo $zufall;
		$daten=$this->DBabfrage("SELECT wkwID FROM wkw.wkw WHERE id = $zufall");
		$row = mysql_fetch_object($daten);
		echo $row->wkwID;
		return $row->wkwID;
	}
} //klasse 
?>