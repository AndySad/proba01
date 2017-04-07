<?php 
include("connect.php");

$glLista	= $_POST['gg'];
$grId       = $_POST['grupa'];

/*
 * $query  = "select id, nazwa from (
							SELECT 'głosiciel' nazwa,1 id union
							SELECT 'starszy',2 union
							SELECT 'sługa pomocniczy',3 union
							SELECT 'pionier stały',4 union
							SELECT 'nieczynny',5) as x
  		        ";
 */
if ($_POST['update'] == "update"){
	
	$pozycja = 1;
	foreach ($glLista as $glId) {
		$sprQ = "select count(*) liczba from glosiciel_grupa where glosiciel_id=$glId";
		$sprR = mysql_query($sprQ);
		$sprW = mysql_fetch_array($sprR, MYSQL_ASSOC);
		$lRek=$sprW['liczba'];
		if ($grId==1){ //'głosiciel'
			$zmianaQ="update glosiciels set czy_pionier=0, czy_nieczynny=0, updated_at=now() where id=$glId";
		}
		if ($grId==2){ //'starszy'
			$zmianaQ="update glosiciels set czy_starszy=1, czy_sluga=0, updated_at=now() where id=$glId";
		}
		if ($grId==3){ //'sługa pomocniczy'
			$zmianaQ="update glosiciels set czy_starszy=0, czy_sluga=1, updated_at=now() where id=$glId";
		}
		if ($grId==4){ //'pionier stały'
			$zmianaQ="update glosiciels set czy_pionier=1, updated_at=now() where id=$glId";
		}
		if ($grId==5){ //'nieczynny'
			$zmianaQ="update glosiciels set czy_starszy=0, czy_sluga=0, czy_pionier=0, czy_nieczynny=1, czy_zbiorki=0, updated_at=now() where id=$glId";
		}
		if ($grId==6){ //'zbiórki'
			$zmianaQ="update glosiciels set czy_zbiorki=1, updated_at=now() where id=$glId";
		}
		//echo "<script type=\"text/javascript\">alert('$zmianaQ');</script>";
		mysql_query($zmianaQ) or die('BŁAD! Nie udało się wprowadzić zmiany.<br><h3>'.$zmianaQ.'</h3>');
		$pozycja ++;	
	}
	echo "$zmianaQ<br>Zapisano zmianę.";
}
?>