<?php
	echo "<h1>Zebranie w tygodniu od ".$zebranie->get_tydzien_od()." <small>[".$zebranie->get_dzien_zebrania()."]</small></h1>";
	echo "<h4>Pieśń nr ".$zebranie->get_piesn1()."</h4>";
	echo "<h3>".$zebranie->get_rozdzialy()."</h3>";
	echo "<h2>SKARBY ZE SŁOWA BOŻEGO</h2>";
	//echo "     od $sluzba_start do $sluzba_stop.";
	foreach($zebranie->get_punkty_skarby() as $skarb_punkt){
		echo "<h3>".$skarb_punkt['tytul']."</h3>(".$skarb_punkt['czas']." min) ".$skarb_punkt['opis']."<br />";
	}
	echo "<h2>ULEPSZAJMY SWĄ SŁUŻBĘ</h2>";
	//echo "     od $sluzba_start do $sluzba_stop.";
	foreach($zebranie->get_punkty_sluzby() as $sluzba_punkt){
		echo "<h3>".$sluzba_punkt['tytul']."</h3>(".$sluzba_punkt['czas']." min) ".$sluzba_punkt['opis']."<br />";
	}
	
	echo "<h2>CHRZEŚCIJAŃSKI TRYB ŻYCIA</h2>";
	echo "<h4>Pieśń nr ".$zebranie->get_piesn2()."</h4>";
	
	foreach($zebranie->get_punkty_zycia() as $zycie_punkt){
		echo "<h3>".$zycie_punkt['tytul']."</h3>(".$zycie_punkt['czas']."min) ".$zycie_punkt['opis']."<br />";
	}
	

	echo "<h4>Pieśń nr ".$zebranie->get_piesn3()."</h4>";
	

?>