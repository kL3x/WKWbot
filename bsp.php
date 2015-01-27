<?php 
  require("class.php"); 	//die wkw-Klasse einbinden
  //error_reporting(E_ALL); 		//Alle Fehler anzeigen lassen

error_reporting(E_ALL ^ E_NOTICE);

//		error_reporting(E_ALL ^ E_NOTICE); 
//INFO      // Melde alle Fehler außer E_NOTICE
//		// Dies ist der Vorgabewert in php.ini
// d.h. wohl man kanns auch weglassen =)
  
//#################### IN MEMORIAN #########################
// 							##
// 						#########
//						#########
//  							##
//							##
//$WKW = new wkw("bottiderbot@gmx.de", "ClQrN6jP"); // Unser gelöschter Benutzer
//
//					"Wir werden dich rächen" ;)
//
//#######################################################

 $WKW = new wkw("ichmagdieleute@gmx.de", "lodade44"); 
 //$WKW->getData();
 //$WKW->logout();
 //$WKW->getFreunde("ku424wp6"); // Bigdings, nun jakob müller
 //$WKW->getFreunde("cc48owof"); //botti
 //$WKW->getFreunde("7omrwoy8"); //erste tussi die wir kennen
 //$WKW->getFreunde("2l3p8o43") //Michelle, die nächstebeste mit vielen bekannten
 //$WKW->getFreunde("n6k3hp6w"); // Dahner Tussi
 
 $zufall=$WKW->getZufallsID();
 echo $zufall;
 echo "nun gehts weiter";
 $WKW->getFreunde($zufall);


/*$query="SELECT wkwID FROM wkw.wkw order by id desc limit 10";
$daten=$WKW->DBabfrage($query);
$array=mysql_fetch_array($daten);
$zufall=rand(0,9);
$WKW->getFreunde($array[$zufall]);*/



//$WKW->einzelheitenAuslesen("t3vi1fme");
//$WKW->einzelheitenAuslesen("knr0suqr");

//Wenn man immer beim selben anfängt bringt man den zähler für "soundsooft verlinkt" durcheinander^^
//  aber wenn man genug datensätze hat sollte das nichtsmehr ausmachen
 
 //$WKW->closeCurl(); 
?>