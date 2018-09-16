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
	$konfiguracja=new konfiguracja('Warszawa-Bielany',3,18,30);
?>
<!DOCTYPE HTML> 
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $okres; ?> programu zebrań</title>
	<!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

	<style>
		.error {color: #FF0000;}
		.skarby={color: #5A6A70;}
		.sluzba={color: #C18626;}
		.zycie={color: #961526;}
	</style>
</head>
<body> 
	<div class="container">
		<div class="page-header">
			<h4>Plan Zebrań w Tygodniu</h4>
		</div>
		<div class="col-md-6"><!--treść planu zebrań - POCZATEK-->
		
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
/*
	echo "<pre>";
	print_r($konfiguracja);
//	print_r($zebranie);
	echo "</pre>";
*/
	if(isset($_POST['okres'])){
	    $okres = $_POST['okres'];
	    $sql="SELECT * FROM `tydzien` where DATE_FORMAT(tydzien_od,'%Y-%m') = '$okres' order by tydzien_od";
	    $tygodnie = $dbo->query($sql); // Run your query
	    $ileTygodniNaKartke=2;
	    $licznikTygodni=0;
	    $stopka="";

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
			$zebranie->set_przewodniczacy($row['przewodniczacy']);
			$zebranie->set_modlitwa($row['modlitwa_poczatkowa']);

			$szablonSqlPunkty="SELECT tydzien_id, czesc, tytul, czas, opis, uczestnik, pomocnik FROM punkty WHERE czesc='%s' and tydzien_id=".$row['id']." order by id";
			$sqlPunkty=sprintf($szablonSqlPunkty,'SKARBY');
	    	$punkty = $dbo->query($sqlPunkty); // Run your query
	    	while ($rowPunkty = $punkty->fetch(PDO::FETCH_ASSOC)){
				$zebranie->set_punkt_skarby($rowPunkty['tytul'],$rowPunkty['opis'],$rowPunkty['czas'],$rowPunkty['uczestnik']);	    		
				//printf("%d<br>",$rowPunkty['id']);
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

/*
			echo "<pre>";
			print_r($zebranie);
			echo "</pre>";
*/
		include "widoki/ZebraniaWTygodniu-widok.php";
	    }


	}
?>	
	</div>                <!--treść planu zebrań - KONIEC-->
	<div class="col-md-6 bg-secondary text-white"><!--listy głosicieli - POCZATEK-->
		lista głosicieli
	</div>                <!--listy głosicieli - KONIEC-->
</div>
 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="js/popper-1.12.9.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>