<?php 
  require("class.php"); 	//die wkw-Klasse einbinden
  //error_reporting(E_ALL); 		//Alle Fehler anzeigen lassen

error_reporting(E_ALL ^ E_NOTICE);

//		error_reporting(E_ALL ^ E_NOTICE); 
//INFO      // Melde alle Fehler au�er E_NOTICE
//		// Dies ist der Vorgabewert in php.ini
// d.h. wohl man kanns auch weglassen =)
  
//#################### IN MEMORIAN #########################
// 							##
// 						#########
//						#########
//  							##
//							##
//$WKW = new wkw("bottiderbot@gmx.de", "ClQrN6jP"); // Unser gel�schter Benutzer
//
//					"Wir werden dich r�chen" ;)
//
//#######################################################

 $WKW = new wkw("ichmagdieleute@gmx.de", "lodade44"); 
 //$WKW->getData();
 //$WKW->logout();
 //$WKW->getFreunde("ku424wp6"); // Bigdings, nun jakob m�ller
 //$WKW->getFreunde("cc48owof"); //botti
 //$WKW->getFreunde("7omrwoy8"); //erste tussi die wir kennen
 //$WKW->getFreunde("2l3p8o43") //Michelle, die n�chstebeste mit vielen bekannten
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

//Wenn man immer beim selben anf�ngt bringt man den z�hler f�r "soundsooft verlinkt" durcheinander^^
//  aber wenn man genug datens�tze hat sollte das nichtsmehr ausmachen
 
 //$WKW->closeCurl(); 
?>