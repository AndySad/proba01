<?php 
include("connect.php");

$glLista	= $_POST['gg'];
$grId       = $_POST['grupa'];

if ($_POST['update'] == "update"){
	
	$pozycja = 1;
	foreach ($glLista as $glId) {
		$sprQ = "select count(*) liczba from glosiciel_grupa where glosiciel_id=$glId";
		$sprR = mysql_query($sprQ);
		$sprW = mysql_fetch_array($sprR, MYSQL_ASSOC);
		$lRek=$sprW['liczba'];
		if ($lRek==0){
			$zmianaQ="Insert into glosiciel_grupa(glosiciel_id, grupa_id, pozycja, created_at, updated_at) values($glId,$grId,$pozycja,now(),now())";
		}
		elseif ($lRek>0){
			$zmianaQ="update glosiciel_grupa set grupa_id=$grId, pozycja=$pozycja, updated_at=now() where glosiciel_id=$glId";
		}
		//echo "<script type=\"text/javascript\">alert('$zmianaQ');</script>";
		mysql_query($zmianaQ) or die('BŁAD! Nie udało się wprowadzić zmiany.');
		$pozycja ++;	
	}
	//echo 'Zapisano zmianę.';
}
?>