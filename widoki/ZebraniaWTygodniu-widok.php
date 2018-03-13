<?php

	echo "<h2>Zebranie w tygodniu od ".$zebranie->get_tydzien_od()."</h2>";
	echo "<h4>Pieśń nr ".$zebranie->get_piesn1()."</h4>";
	echo "<h3>".$zebranie->get_rozdzialy()."</h3>";
	
	echo "<h3>SKARBY ZE SŁOWA BOŻEGO</h3>";
	echo "<div class='row'>";
      
	foreach($zebranie->get_punkty_skarby() as $skarby_punkt){
		echo '<div class="col-md-6">'.$skarby_punkt['tytul'].' ('.$skarby_punkt['czas'].' min)</div>';
		echo '<div class="col-md-3 bg-secondary text-dark">'.$skarby_punkt['uczestnik'].'</div>';
	}
	echo "</div>";
	
	echo "<h3>ULEPSZAJMY SWĄ SŁUŻBĘ</h3>";
	echo "<div class='row'>";
    foreach($zebranie->get_punkty_sluzby() as $sluzba_punkt){
		echo '<div class="col-md-6">'.$sluzba_punkt['tytul'].' ('.$sluzba_punkt['czas'].' min)</div>';
		echo '<div class="col-md-3 bg-secondary text-white">'.$sluzba_punkt['uczestnik'].'</div>';
		echo '<div class="col-md-3 bg-secondary text-white">'.$sluzba_punkt['pomocnik'].'</div>';
	}
	echo "</div>";
	
	echo "<h3>CHRZEŚCIJAŃSKI TRYB ŻYCIA</h3>";
	echo "<h4>Pieśń nr ".$zebranie->get_piesn2()."</h4>";
	echo "<div class='row'>";
    foreach($zebranie->get_punkty_zycia() as $zycie_punkt){
		echo '<div class="col-md-6">'.$zycie_punkt['tytul'].' ('.$zycie_punkt['czas'].' min)</div>';
		echo '<div class="col-md-3 bg-secondary text-dark">'.$zycie_punkt['uczestnik'].'</div>';
		echo '<div class="col-md-3 bg-secondary text-white">'.$zycie_punkt['pomocnik'].'</div>';
	}
	echo "</div>";
	
	echo "<h4>Pieśń nr ".$zebranie->get_piesn3()."</h4>";
?>