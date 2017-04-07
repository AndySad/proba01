<?php
//funkcje
function daj_tydzien($tekst){
	$miesiace=array(
			'stycznia'=>1,
			'lutego'=>2,
			'marca'=>3,
			'kwietnia'=>4,
			'maja'=>5,
			'czerwca'=>6,
			'lipca'=>7,
			'sierpnia'=>8,
			'września'=>9,
			'października'=>10,
			'listopada'=>11,
			'grudnia'=>12
	);
	$tablica=explode(" ",rtrim($tekst));
	$dzien=explode("-",$tablica[0])[0];
	$miesiac=$tablica[1];
	//echo date("Y-m-d", mktime(0, 0, 0, $miesiace[$miesiac], $dzien, date("Y")));
	$pierwszy_dzien_tygodnia=new DateTime(date("Y-m-d", mktime(0, 0, 0, $miesiace[$miesiac], $dzien, date("Y"))));
	//$dzien_zebrania=$pierwszy_dzien_tygodnia->add(new DateInterval('P2D'));
	//echo "<br>daj_tydzien...<h1>$tablica[0]</h1>$miesiace[$miesiac]>>".$dzien_zebrania->format('Y-m-d')."<<";
	//return $dzien_zebrania->format('Y-m-d');
	return $pierwszy_dzien_tygodnia;
}
