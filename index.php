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
include "LIB/zebranie.php";
global $dbo;
date_default_timezone_set("Europe/Warsaw");
// define variables and set to empty values
$errProgramCaly = "";
$programCaly = "";
$tydzien_od="";
	$skarby=array();//plan części SKARBY ZE SŁOWA BOŻEGO
	$sluzba=array();//plan częsci ULEPSZAJMY SWĄ SŁUŻBĘ
	$zycie=array(); //plan części CHRZEŚCIJAŃSKI TRYB ŻYCIA
	$piesni=array();

$zebranie=new zebranie();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["programCaly"])) {
		$errProgramCaly = "należy wypełnić pole z programem";
	}
	else {
		$programCaly = test_input($_POST["programCaly"]);
	}
}

function podziel_zebrania($data){
	if (empty($data)) {
		$program=array();
	} else {
		global $sluzba;
		global $zycie;
		global $zebranie;
		$skarby_start=0;
		$skarby_stop=0;
		$sluzba_start=0;
		$sluzba_stop=0;
		$zycie_start=0;
		$zycie_stop=0;
		$skarby_czytanie="";
		$program=explode("\n",$data);
	}
	//print_r($program);
	//$dzien_zebrania=$pierwszy_dzien_tygodnia->add(new DateInterval('P2D'));
	//$zebranie->tydzien_od=daj_tydzien($program[0])->format('Y-m-d');
	$zebranie->set_tydzien_od(daj_tydzien($program[0]));
	//$zebranie->dzien_zebrania=new DateTime($GLOBALS['tydzien_od']);
	//$dzien_zebrania=$dzien_zebrania->add(new DateInterval('P2D'))->format('Y-m-d');
	$zebranie->set_rozdzialy($program[1]);
	
	for ($i=2;$i<count($program);$i++){
		$wiersz_programu=explode(" ",$program[$i]);
		if ($wiersz_programu[0]=="Pieśń"){
			array_push($GLOBALS['piesni'],$wiersz_programu[1]);
		}
		elseif ($program[$i]=="SKARBY ZE SŁOWA BOŻEGO") {
			$skarby_start =$i + 1;
		}
		elseif (substr($program[$i],0,15)=="Czytanie Biblii"){
			$skarby_czytanie=explode(": ",$program[$i])[1];
		}
		
		elseif ($program[$i]=="ULEPSZAJMY SWĄ SŁUŻBĘ"){
			$skarby_stop  =$i - 1;
			$sluzba_start=$i + 1;
		}
		elseif ($program[$i]=="CHRZEŚCIJAŃSKI TRYB ŻYCIA"){
			$sluzba_stop =$i - 1;
			$zycie_start =$i + 2;
		}
		//echo "<br>[$i]...$program[$i]";
	}
	$zycie_stop=$i - 3;
	$zebranie->set_piesni($GLOBALS['piesni']);
	$zebranie->set_przemowienie(explode("(",$program[$skarby_start])[0]);
	$zebranie->set_fragment_biblii($skarby_czytanie);
	
	echo "<i>".daj_sql_tydzien()."</i><br />";

	for ($isluzba=$sluzba_start;$isluzba<=$sluzba_stop;$isluzba++){
		$sluzba_punkt_calosc=explode("(",$program[$isluzba]);
		$sluzba_punkt['nazwa']=$sluzba_punkt_calosc[0];
		$sluzba_punkt['opis']=explode("): ",$program[$isluzba])[1];
			$poczatek_czasu=strrpos(explode("): ",$program[$isluzba])[0],"(");
		$sluzba_punkt['czas']=explode("(",explode(" min",$program[$isluzba])[0])[1];
		$zebranie->set_punkt_sluzby($sluzba_punkt);
	}
	for ($izycie=$zycie_start;$izycie<=$zycie_stop;$izycie++){
		$zycie_punkt_calosc=explode("(",$program[$izycie]);
		$zycie_punkt['nazwa']=$zycie_punkt_calosc[0];
		$zycie_punkt['opis']=explode("): ",$program[$izycie])[1];
			$poczatek_czasu=strrpos(explode("min): ",$program[$izycie])[0],"(");
		$zycie_punkt['czas']=substr(explode("min): ",$program[$izycie])[0],$poczatek_czasu + 1);
		$zebranie->set_punkt_zycia($zycie_punkt);
	}
	

	//$zebranie->wyswietl();
	//print_r($zebranie);
	//include "widoki/zebranie_w_tygodniu.php";
	
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
	$dzien=explode("-",$tablica[0])[0];
	$miesiac=$tablica[1];

	$pierwszy_dzien_tygodnia=new DateTime(date("Y-m-d", mktime(0, 0, 0, $miesiace[$miesiac], $dzien, date("Y"))));
	//$dzien_zebrania=$pierwszy_dzien_tygodnia->add(new DateInterval('P2D'));
	//echo "<br>daj_tydzien...<h1>$tablica[0]</h1>$miesiace[$miesiac]>>".$dzien_zebrania->format('Y-m-d')."<<";
	//return $dzien_zebrania->format('Y-m-d');
	return $pierwszy_dzien_tygodnia;
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   $data = preg_replace("/[\r\n]+/", "\n", $data);
   
   return $data;
}
function daj_sql_tydzien(){
	global $dbo;
	global $zebranie;
	//$stmt=$dbo->prepare("delete from tydzien where tydzien_od_data='".$GLOBALS['tydzien_od']."'");
	//$stmt->execute();
	$sql_tydzien=sprintf("insert into tydzien(tydzien_od,piesn_1,piesn_2,piesn_3,rozdzialy_do_czytania) values('%s',%s,%s,%s,'%s');"
		,$zebranie->get_tydzien_od()
		,$zebranie->get_piesn1()
		,$zebranie->get_piesn2()
		,$zebranie->get_piesn3()
		,$zebranie->get_rozdzialy()
		);
	$stmt=$dbo->prepare($sql_tydzien);
	try {
		$stmt->execute();
	}
	catch (PDOException $e){
		if ($stmt->errorCode() == 23000 ) { 
			echo "DUPLIKAT"; 

			$upd=sprintf("update tydzien set piesn_1=%s,piesn_2=%s,piesn_3=%s,rozdzialy_do_czytania='%s' where tydzien_od='%s';"
				,$zebranie->get_piesn1()
				,$zebranie->get_piesn2()
				,$zebranie->get_piesn3()
				,$zebranie->get_rozdzialy()
				,$zebranie->get_tydzien_od()
				);
		}
		else {
			echo "<h1 style=\"color:red\">Nie udało się zapisać programu na tydzień od '".$zebranie->get_tydzien_od()."'</h1>";
			echo $stmt->errorCode();
			die($e->getMessage());
		}
	}
	$tydzien_id=$dbo->lastInsertId();
	echo "<br>tydzień od ".$zebranie->get_tydzien_od()." został oznaczony identyfikatorem: <h1>".$tydzien_id."</h1><br>";
	//daj_sql_zebranie($tydzien_id);
	return $sql_tydzien;
}
function daj_sql_czesci_zebrania(){
		$sql_czesc_skarby=sprintf("insert into punkty(tydzien_id,czesc,tytul,czas,opis) values(%s,'%s','%s','%s','%s');"
		);
	

}
function daj_sql_zebranie($tydzien_id){
	global $sluzba;
	global $zycie;
	global $dbo;
	for ($i=0;$i<count($sluzba);$i++){
		$sql_zebranie="INSERT INTO zebranie_w_tygodniu_punkty(tydzien_id, punkt_rodzaj_id, punkt_temat, punkt_czas,punkt_opis) values('";
		$sql_zebranie.=$tydzien_id."',(select id from punkt_rodzaj where punkt_rodzaj='"
				.$sluzba[$i]['nazwa']."'),'"
				.($sluzba[$i]['nazwa']=='Powtórka' ? 'Powtórka' : $sluzba[$i]['tytul'])."',"
				.$sluzba[$i]['czas'].",'"
				.$sluzba[$i]['opis']."')";
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
	for ($i=0;$i<count($zycie);$i++){
		$sql_zebranie="INSERT INTO zebranie_w_tygodniu_punkty(tydzien_id, punkt_rodzaj_id, punkt_temat, punkt_czas,punkt_opis) values('";
				$sql_zebranie.=$tydzien_id."',(select id from punkt_rodzaj where punkt_rodzaj='"
				.$zycie[$i]['nazwa']."'),'"
				.$zycie[$i]['tytul']."',"
				.$zycie[$i]['czas'].",'"
				.$zycie[$i]['opis']."')";
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
		include "widoki/zebranie_w_tygodniu.php";
		//daj_sql_tydzien();
	}
?>
</body>
</html>