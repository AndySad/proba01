<?php
require 'vendor/autoload.php';
require_once 'bootstrap.php';

	require 'connect.php';
	include "LIB/zebranie.php";
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
	//$konfiguracja=new konfiguracja('Warszawa-Bielany',array(3,18,30),array(7,10,00));
	#$konfiguracja=new konfiguracja('Płońsk-Północ',array(2,18,30),array(7,10,00));
	$konfiguracja=new konfiguracja('Warszawa-Żoliborz',array(2,18,30),array(7,10,00));
	$zebranie=new zebranie();

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
	<h4>Plan Zebrań w Tygodniu</h4>
	<?php
		$okresy = $dbo->query(
			//"SELECT date_format(tydzien_od, '%Y-%m') as XX, count(*) as liczba_zebran FROM `tydzien` where tydzien_od > DATE_FORMAT(NOW() ,'%Y-%m-01') group by 1 order by 1"
			"SELECT date_format(tydzien_od, '%Y-%m') as XX, count(*) as liczba_zebran FROM `tydzien` where tydzien_od > DATE_FORMAT(NOW() ,'%Y-%m-01') group by 1 order by 1"
			//  "SELECT date_format(tydzien_od, '%Y-%m') as XX, count(*) as liczba_zebran FROM `tydzien` where tydzien_od > '2019-12-20' group by 1 order by 1"
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
	echo "</pre>";

	if(isset($_POST['okres'])){
	    $okres = $_POST['okres'];
	    $sql="SELECT * FROM `tydzien` where DATE_FORMAT(tydzien_od,'%Y-%m') = '$okres' order by tydzien_od";
	    $tygodnie = $dbo->query($sql); // Run your query
	    $ileTygodniNaKartke=2;
	    $licznikTygodni=0;
	    $stopka="";

		// Creating the new document...
		$phpWord = new \PhpOffice\PhpWord\PhpWord();
		$properties = $phpWord->getDocInfo();
		$properties->setCreator('Andrzej Sadowski');
		$properties->setTitle("$okres - program zebrań w tygodniu");
		$properties->setCategory('Program zebrań');
		$properties->setLastModifiedBy('Andrzej Sadowski by PhpWord');
		//style
		include "widoki/ch.z.is.style.php";
		//nagłówek planu zebrań
		include "widoki/ch.z.is.00.naglowek_i_stopka_strony.php";

	    while ($row = $tygodnie->fetch(PDO::FETCH_ASSOC)){
	    	$zebranie=new zebranie();
	    	$zebranie->get_tydzien_od_z_BAZY($row['id']);
	    	$zebranie->set_tydzien_od(
				Carbon::createFromFormat('Y-m-d', $row['tydzien_od'])->hour(0)->minute(0)->second(0),
				$konfiguracja->get_zebranie_w_tygodniu_dzien(),
				$konfiguracja->get_zebranie_w_tygodniu_godzina(),
				$konfiguracja->get_zebranie_w_tygodniu_minuta()
			);
			$zebranie->set_rozdzialy($row['rozdzialy_do_czytania']);
			$zebranie->set_piesni(array($row['piesn_1'],$row['piesn_2'],$row['piesn_3']));
			//if($konfiguracja->get_zbor()=='Warszawa-Bielany'){
			if($konfiguracja->get_zbor()=='Warszawa-Żoliborz'){
					$szablonSqlPunkty="SELECT tydzien_id, czesc, tytul, czas, opis, uczestnik, pomocnik FROM punkty WHERE czesc='%s' and tydzien_id=".$row['id']." order by id";
				$zebranie->set_przewodniczacy($row['przewodniczacy']);
				$zebranie->set_modlitwa($row['modlitwa_poczatkowa']);
			} else {
				$szablonSqlPunkty="SELECT tydzien_id, czesc, tytul, czas, opis, '' uczestnik, '' pomocnik FROM punkty WHERE czesc='%s' and tydzien_id=".$row['id']." order by id";
				$zebranie->set_przewodniczacy('');
				$zebranie->set_modlitwa('');
			}
			$sqlPunkty=sprintf($szablonSqlPunkty,'SKARBY');
			//echo "$sqlPunkty<br>";
			$punkty = $dbo->query($sqlPunkty); // Run your query
	    	while ($rowPunkty = $punkty->fetch(PDO::FETCH_ASSOC)){
				$zebranie->set_punkt_skarby($rowPunkty['tytul'],$rowPunkty['opis'],$rowPunkty['czas'],$rowPunkty['uczestnik']);	    		
	    	}
			$sqlPunkty=sprintf($szablonSqlPunkty,'SŁUŻBA');
			$punkty = $dbo->query($sqlPunkty); // Run your query
	    	while ($rowPunkty = $punkty->fetch(PDO::FETCH_ASSOC)){
				$zebranie->set_punkt_sluzby($rowPunkty['tytul'],$rowPunkty['opis'],$rowPunkty['czas'],$rowPunkty['uczestnik'],$rowPunkty['pomocnik']);	    		
	    	}
			$sqlPunkty=sprintf($szablonSqlPunkty,'ŻYCIE');
			$punkty = $dbo->query($sqlPunkty); // Run your query
	    	while ($rowPunkty = $punkty->fetch(PDO::FETCH_ASSOC)){
				$zebranie->set_punkt_zycia($rowPunkty['tytul'],$rowPunkty['opis'],$rowPunkty['czas'],$rowPunkty['uczestnik'],$rowPunkty['pomocnik']);	    		
	    	}
		
//wprowadzenie: dzień zebrania, rozdziały do czyatnia i przewodniczący,
include "widoki/ch.z.is.01.wprowadzenie.php";
//wprowadzenie: pieśń nr 1, modlitwa i uwagi wstępne
include "widoki/ch.z.is.02.wstep.php";
//wyszukujemy duchowe skarby
include "widoki/ch.z.is.03.skarby.php";
//ulepszajmy swą służbę
//include "widoki/ch.z.is.04.sluzba.php";
include "widoki/ch.z.is.04A.sluzba.php";
//chrześcijańskie życie
//include "widoki/ch.z.is.05.zycie.php";
include "widoki/ch.z.is.05A.zycie.php";
	    	$licznikTygodni++;
	    	$stopka.=$licznikTygodni;
	    	if ($licznikTygodni%$ileTygodniNaKartke) {
	    		$stopka.=" i ";
	    		for($lPrzerw=1;$lPrzerw<5;$lPrzerw++){ //szerokość przerwy pomiędzy tygodniami
	    			$section->addTextBreak(1,$stylPrzerwy);
	    		}
	    	} else {
	    		
	    		$section->addPageBreak();
	    		//nagłówek planu zebrań
				//include "widoki/ch.z.is.00.naglowek_strony.php";

	    	}
	    	printf("%s [%d]<br>",$row['tydzien_od'],$row['id']);
/*
			echo "<pre>";
			print_r($zebranie);
			echo "<br /></pre>";
*/

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