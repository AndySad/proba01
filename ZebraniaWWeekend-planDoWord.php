<?php
require 'vendor/autoload.php';
require_once 'bootstrap.php';

	require 'connect.php';
	include "LIB/zebranieWeekend.php";
	include "LIB/konfiguracja.php";
    include "LIB/funkcje.php";
	global $dbo;
	date_default_timezone_set("Europe/Warsaw");
	use Carbon\Carbon;
	Carbon::setLocale('pl');
	$okres="XX";
	$page = null;
	if(isset($_POST['okres'])){
	    $okres = $_POST['okres'];
	}
	//$konfiguracja=new konfiguracja(($nazwa,$chzis_dzien,$chzis_godzina,$chzis_minuta);
	$konfiguracja=new konfiguracja('Warszawa-Bielany',array(3,18,30),array(7,10,00));
	$zebranie=new zebranieWeekend();

?>
<!DOCTYPE HTML> 
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $okres; ?> programu zebrań</title>
	<style>
		.error {color: #FF0000;}
	</style>
</head>
<body> 
	<h4>Plan Zebrań w weekend</h4>
	<?php
		$okresy = $dbo->query(
			//"SELECT date_format(tydzien_od, '%Y-%m') as XX, count(*) as liczba_zebran FROM `tydzien` where tydzien_od > DATE_FORMAT(NOW() ,'%Y-%m-01') group by 1 order by 1"
			"SELECT date_format(tydzien_od, '%Y-%m') as XX, count(*) as liczba_zebran FROM `tydzien` where tydzien_od > DATE_FORMAT(NOW() ,'%Y-%m-01') group by 1 order by 1"
			); //Run your query
	?>
	<form name="myform" action="" method="post">
		<select name="okres" onchange="this.form.submit()">
		<option value="XX">-- wybierz okres --</option>';
		<?php
		// Loop through the query results, outputing the options one by one
			while ($row = $okresy->fetch(PDO::FETCH_ASSOC)) {
				echo '<option value="'.$row['XX'].'" ';
				if($okres == $row['XX']){ echo " selected"; }
				echo '>'.$row['XX'].'</option>';
			}
		?>
		</select>
	</form>
<?php
	echo "<pre>";
	print_r($konfiguracja);
	print_r($zebranie);
	echo "</pre>";

	if(isset($_POST['okres'])){
	    $okres = $_POST['okres'];
        //$sql="SELECT * FROM `tydzien` where DATE_FORMAT(tydzien_od,'%Y-%m') = '$okres' order by tydzien_od";
        $sql="SELECT * FROM `tydzien` where DATE_FORMAT(date_add(tydzien_od, interval 6 day),'%Y-%m') = '$okres' order by tydzien_od";
	    $tygodnie = $dbo->query($sql); // Run your query
	    $ileTygodniNaKartke=2;
	    $licznikTygodni=0;
	    $stopka="";

		// Creating the new document...
		$phpWord = new \PhpOffice\PhpWord\PhpWord();
		$properties = $phpWord->getDocInfo();
		$properties->setCreator('Andrzej Sadowski');
		$properties->setTitle("$okres - program zebrań w weekend");
		$properties->setCategory('Program zebrań');
		$properties->setLastModifiedBy('Andrzej Sadowski by PhpWord');
		//style
		include "widoki/ch.z.is.style.php";
		//nagłówek planu zebrań
		include "widoki/z.n.00.naglowek_i_stopka_strony.php";

	    while ($row = $tygodnie->fetch(PDO::FETCH_ASSOC)){
	    	$zebranie=new zebranieWeekend();
	    	$zebranie->get_tydzien_od_z_BAZY($row['id']);
	    	$zebranie->set_tydzien_od(
				Carbon::createFromFormat('Y-m-d', $row['tydzien_od'])->hour(0)->minute(0)->second(0),
				$konfiguracja->get_zebranie_w_weekend_dzien(),
				$konfiguracja->get_zebranie_w_weekend_godzina(),
				$konfiguracja->get_zebranie_w_weekend_minuta()
			);
			$sqlWeekend="SELECT tydzien_id, przewodniczacy, 
                                modlitwaPoczatkowa, modlitwaKoncowa, modlitwaKoncowaRezerwa,
                                wykladNr, wykladTytul, wykladMowca, 
                                StraznicaProwadzacy, StraznicaLektor, StraznicaCzas
                                 FROM zebraniaweekend WHERE tydzien_id=".$row['id'];
			//echo "<br />$sqlWeekend<br>";
			$punkty = $dbo->query($sqlWeekend); // Run your query
	    	while ($rowPunkty = $punkty->fetch(PDO::FETCH_ASSOC)){
                $zebranie->set_przewodniczacy($rowPunkty['przewodniczacy']);
                $zebranie->set_modlitwy(array($rowPunkty['modlitwaPoczatkowa'],$rowPunkty['modlitwaKoncowa'],$rowPunkty['modlitwaKoncowaRezerwa']));
                $zebranie->set_straznica(array($rowPunkty['StraznicaProwadzacy'],$rowPunkty['StraznicaLektor'],$rowPunkty['StraznicaCzas']));
                $zebranie->set_wyklad(array($rowPunkty['wykladNr'],$rowPunkty['wykladTytul'],$rowPunkty['wykladMowca']));
	    	}
//wprowadzenie: dzień zebrania, modlitwa i przewodniczący,
include "widoki/z.n.01.wprowadzenie.php";
//wykład
include "widoki/z.n.02.wyklad.php";
//Strażnica
include "widoki/z.n.03.straznica.php";
/*
//ulepszajmy swą służbę
include "widoki/ch.z.is.04.sluzba.php";
//chrześcijańskie życie
include "widoki/ch.z.is.05.zycie.php";
*/
 			echo "<pre>";
			print_r($zebranie);
			echo "</pre>";


	    	printf("%s [%d]<br>",$row['tydzien_od'],$row['id']);
	    	//echo $row['tydzien_od']."<br />";
	    	if (!($licznikTygodni%$ileTygodniNaKartke)) {
	    		echo "tydzień $stopka<br />";
	    		$stopka="";
	    	}
	    }
	    if ($licznikTygodni==5){
	    	echo "tydzień 5<br />";
	    }

// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$nazwaZboru=iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE',$konfiguracja->get_zbor());
$objWriter->save('./WYNIKI/'.$okres.' '.basename(__FILE__, '.php').' ('.$nazwaZboru.').docx');
//$objWriter->save('./WYNIKI/'.$row['tydzien_od'].' '.basename(__FILE__, '.php').'.docx');

	}
?>	
</body>
</html>