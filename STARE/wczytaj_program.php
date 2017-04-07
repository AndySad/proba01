<!DOCTYPE HTML> 
<html>
<head>
	<meta charset="utf-8">
	<title>wczytywanie programu zebrań</title>
	<style>
		.error {color: #FF0000;}
	</style>
</head>
<body> 
<?php
require 'connect.php';
global $dbo;
date_default_timezone_set("Europe/Warsaw");
// define variables and set to empty values
$errProgramCaly = "";
$programCaly = "";
$tydzien_od="";
	$zsb=array();//plan zborowego studium biblii 
	$tssk=array();//plan teokratycznej szkoły słuzby kaznodziejskiej
	$nsk=array();//plan zebrania służby
$tssk_czy_powtorka=0;
$piesni=array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["programCaly"])) {
		$errProgramCaly = "należy wypełnić pole z programem";
	}
	else {
		$programCaly = test_input($_POST["programCaly"]);
	}
}
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
	$dzien=$tablica[5];
	$miesiac=$tablica[6];
	$pierwszy_dzien_tygodnia=date("Y-m-d", mktime(0, 0, 0, $miesiace[$miesiac], $dzien, date("Y")));
	//echo "<br>daj_tydzien...<h1>$tablica[6]</h1>$miesiace[$miesiac]>>$pierwszy_dzien_tygodnia<<";
	return $pierwszy_dzien_tygodnia;
}
function daj_piesn($tekst){
	$tablica=explode(" ",rtrim($tekst));
	$nr_piesni=$tablica[1];
	return $nr_piesni;
}
function podziel_zebrania($data){
	if (empty($data)) {
		$program=array();
	} else {
		global $tssk;
		global $nsk;
		$zsb_start=0;
		$zsb_stop=0;
		$tssk_start=0;
		$tssk_stop=0;
		$nsk_start=0;
		$nsk_stop=0;
		$program=explode("\n",$data);
		
		for ($i=0;$i<count($program);$i++){
			$wiersz_programu=explode(" ",$program[$i]);
			if ($wiersz_programu[0]=="Pieśń"){
				array_push($GLOBALS['piesni'],$wiersz_programu[1]);
			}
			elseif ($program[$i]=="Zborowe studium Biblii:") {
				$zsb_start =$i + 1;
			}
			elseif ($program[$i]=="Szkoła teokratyczna:"){
				$zsb_stop  =$i - 1;
				$tssk_start=$i + 1;
			}
			elseif ($program[$i]=="Zebranie służby:"){
				$tssk_stop =$i - 1;
				$nsk_start =$i + 3;
			}
			//echo "<br>[$i]...$program[$i]";
		}
		$nsk_stop=$i - 2;
		$GLOBALS['tydzien_od']=daj_tydzien($program[0]);
		
		//ZSB
		$kolor="blue";
		echo "<h1 style=\"color:$kolor\"><small>ZSB: od $zsb_start do $zsb_stop</small></h1>";//plan ZSB skrót publikacji
		for ($izsb=$zsb_start;$izsb<=$zsb_stop;$izsb++){
			$prg_zsb=explode(" ", $program[$izsb]);
			$GLOBALS['zsb_publikacja']=$prg_zsb[0];
			array_shift($prg_zsb);
			array_pop($prg_zsb);
			$czas=substr(array_pop($prg_zsb),1,2);//plan ZSB czas trwania studium
			$GLOBALS['zsb_material']=join(" ",$prg_zsb);
			$GLOBALS['zsb_czas']=$czas;
		}
		
		//TSSK
		$kolor="grey";
		echo "<h1 style=\"color:$kolor\"><small>TSSK: od $tssk_start do $tssk_stop</small></h1>";//plan TSSK
		$GLOBALS['tssk_czy_powtorka']=0;
		for ($itssk=$tssk_start;$itssk<=$tssk_stop;$itssk++){
			$tssk_punkt=array();
			$prg_tssk_punkt=explode(" ", $program[$itssk]);
			$tssk_punkt['nazwa']=tssk_punkt_nazwa($prg_tssk_punkt);
			$tssk_punkt['tytul']=tssk_punkt_tytul($prg_tssk_punkt);
			$tssk_punkt['czas']=tssk_punkt_czas($prg_tssk_punkt);
			$tssk_punkt['opis']='';
			array_push($tssk,$tssk_punkt);
		}
		
		//NSK
		$kolor="magenta";
		echo "<h1 style=\"color:$kolor\"><small>NSK: od $nsk_start do $nsk_stop</small></h1>";//plan NSK
		$nsk_nr_punktu=0;
		for ($insk=$nsk_start;$insk<=$nsk_stop;$insk++){ //10 min: Proponowanie czasopism we wrześniu. Omówienie z udziałem obecnych. Na początku wprowadź pokazy ilustrujące, jak można wykorzystać dwie propozycje z następnej strony.
			$nsk_punkt=array();
			$nsk_nr_punktu++;
			$prg_nsk_punkt=explode(" ", $program[$insk]);//$prg_nsk_punkt=['10','min:','Proponowanie','czasopism',...]
			$nsk_punkt_czas=array_shift($prg_nsk_punkt); //'10'   -> $prg_nsk_punkt=['min:','Proponowanie','czasopism',...]
			array_shift($prg_nsk_punkt);                 //'min:' -> $prg_nsk_punkt=['Proponowanie','czasopism',...]
			$prg_nsk_punkt=join(" ",$prg_nsk_punkt);     //$prg_nsk_punkt='Proponowanie czasopism we wrześniu. Omówienie z udziałem obecnych. Na początku wprowadź pokazy ilustrujące, jak można wykorzystać dwie propozycje z następnej strony.'
			$prg_nsk_punkt=explode(". ",$prg_nsk_punkt); //$prg_nsk_punkt=['Proponowanie czasopism we wrześniu','Omówienie z udziałem obecnych','Na początku wprowadź pokazy ilustrujące, jak można wykorzystać dwie propozycje z następnej strony']
			$nsk_punkt_tytul=array_shift($prg_nsk_punkt);//$nsk_punkt_tytul='Proponowanie czasopism we wrześniu' -> $prg_nsk_punkt=['Omówienie z udziałem obecnych','Na początku wprowadź pokazy ilustrujące, jak można wykorzystać dwie propozycje z następnej strony']
			$nsk_punkt_opis=join(". ",$prg_nsk_punkt);   //$nsk_punkt_opis='Omówienie z udziałem obecnych. Na początku wprowadź pokazy ilustrujące, jak można wykorzystać dwie propozycje z następnej strony.'
			if (strpos($nsk_punkt_tytul,"?")>0){
				$prg_nsk_punkt=explode(": ",$program[$insk]);
				$prg_nsk_punkt=explode("? ",$prg_nsk_punkt[1]);
				$nsk_punkt_tytul=array_shift($prg_nsk_punkt)."?";
				$nsk_punkt_opis=join("? ",$prg_nsk_punkt);
			}
			$nsk_punkt['nazwa']="NSK Nr $nsk_nr_punktu";
			$nsk_punkt['tytul']=$nsk_punkt_tytul;
			$nsk_punkt['czas']=$nsk_punkt_czas;
			$nsk_punkt['opis']=$nsk_punkt_opis;
			array_push($nsk, $nsk_punkt);
		}
	}
	
	return count($program);
}
function tssk_punkt_nazwa($tekst_tablica){
	$nazwa_punktu=array_shift($tekst_tablica);
	if ($nazwa_punktu!="Powtórka"){
		$nazwa_punktu.=" ".array_shift($tekst_tablica);
	}
	else {
		$GLOBALS['tssk_czy_powtorka']=1;
	}
	$nazwa_punktu=explode(":",$nazwa_punktu);
	
	return "TSSK ".$nazwa_punktu[0];
}
function tssk_punkt_tytul($tekst_tablica){
	array_shift($tekst_tablica);
	array_shift($tekst_tablica);
	array_pop($tekst_tablica);
	$info=array_pop($tekst_tablica);
	if ($info=="lub"){
		array_pop($tekst_tablica);
		array_pop($tekst_tablica);
	}
	
	return join(" ",$tekst_tablica);
}
function tssk_punkt_czas($tekst_tablica){
	$czas_punktu=array_shift(explode(" ",array_pop(explode("(",join(" ",$tekst_tablica)))));
	//echo "<br>".join(" ",$tekst_tablica)."<br>".$czas_punktu;
	return $czas_punktu;
}
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   $data = preg_replace("/[\r\n]+/", "\n", $data);
   
   return $data;
}
function nsk_punkt_tytul($tekst_tablica){
	$nsk_zdania=explode(".",$tekst_tablica);
	return join(" ",$tekst_tablica);
}

function daj_sql_tydzien(){
	global $dbo;
	//$stmt=$dbo->prepare("delete from tydzien where tydzien_od_data='".$GLOBALS['tydzien_od']."'");
	//$stmt->execute();
	$sql_tydzien="INSERT INTO tydzien(tydzien_od_data, czy_powtorka, piesn_1, piesn_2, piesn_3,zsb_publikacja,zsb_material,zsb_czas) "
			."VALUES ('"
			.$GLOBALS['tydzien_od']."','"
			.$GLOBALS['tssk_czy_powtorka']."',"
			.join(',',$GLOBALS['piesni']).",'"
			.$GLOBALS['zsb_publikacja']."','"
			.$GLOBALS['zsb_material']."',"
			.$GLOBALS['zsb_czas'].")";
	$stmt=$dbo->prepare($sql_tydzien);
	try {
		$stmt->execute();
	}
	catch (PDOException $e){
		echo "<h1 style=\"color:red\">Próbujesz ponownie wprowadzić program na tydzień od '".$GLOBALS['tydzien_od']."'</h1>";
		die($e->getMessage());
	}
	$tydzien_id=$dbo->lastInsertId();
	echo "<br><h1>".$tydzien_id."</h1><br>";
	daj_sql_zebranie($tydzien_id);
	return $sql_tydzien;
}
function daj_sql_zebranie($tydzien_id){
	global $tssk;
	global $nsk;
	global $dbo;
	for ($i=0;$i<count($tssk);$i++){
		$sql_zebranie="INSERT INTO zebranie_w_tygodniu_punkty(tydzien_id, punkt_rodzaj_id, punkt_temat, punkt_czas,punkt_opis) values('";
		$sql_zebranie.=$tydzien_id."',(select id from punkt_rodzaj where punkt_rodzaj='"
				.$tssk[$i]['nazwa']."'),'"
				.($tssk[$i]['nazwa']=='Powtórka' ? 'Powtórka' : $tssk[$i]['tytul'])."',"
				.$tssk[$i]['czas'].",'"
				.$tssk[$i]['opis']."')";
		echo "<h2 style=\"color:brown\">".$sql_zebranie."</h2>";
		$stmt=$dbo->prepare($sql_zebranie);
		try {
			$stmt->execute();
		}
		catch (PDOException $e){
			echo "<h1 style=\"color:red\">Próbujesz ponownie wprowadzić punkty programu na tydzień od '".$GLOBALS['tydzien_od']."'</h1>";
			die($e->getMessage());
		}
		$punkt_id=$dbo->lastInsertId();
		echo "<br><h1>".$punkt_id."</h1><br>";
	}
	for ($i=0;$i<count($nsk);$i++){
		$sql_zebranie="INSERT INTO zebranie_w_tygodniu_punkty(tydzien_id, punkt_rodzaj_id, punkt_temat, punkt_czas,punkt_opis) values('";
				$sql_zebranie.=$tydzien_id."',(select id from punkt_rodzaj where punkt_rodzaj='"
				.$nsk[$i]['nazwa']."'),'"
				.$nsk[$i]['tytul']."',"
				.$nsk[$i]['czas'].",'"
				.$nsk[$i]['opis']."')";
		echo "<h2 style=\"color:brown\">".$sql_zebranie."</h2>";
		$stmt=$dbo->prepare($sql_zebranie);
		try {
			$stmt->execute();
		}
		catch (PDOException $e){
			echo "<h1 style=\"color:red\">Próbujesz ponownie wprowadzić punkty programu na tydzień od '".$GLOBALS['tydzien_od']."'</h1>";
			die($e->getMessage());
		}
		$punkt_id=$dbo->lastInsertId();
		echo "<br><h1>".$punkt_id."</h1><br>";
	}
	
	return $sql_zebranie;
}

?>

<h2>Program zebrań w tygodniu</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   Treść programu: <textarea name="programCaly" rows="35" cols="160" placeholder="skopiuj program z WOL.JW.ORG"><?php echo $programCaly;?></textarea>
   <br><br>
   <input type="submit" name="submit" value="Submit"> 
</form>

<?php
	if (!empty($_POST)){
		echo "<h2>Do zapisania:</h2>";
		echo "<br><br>".podziel_zebrania($programCaly);
		daj_sql_tydzien();
	}
?>
</body>
</html>