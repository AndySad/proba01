<?php 
include("connect.php");

$glId    = $_POST['gg'];
$grSkad     = $_POST['skad'];
$grDokad    = $_POST['dokad'];
echo "<pre>";
echo print_r($_POST);
echo "</pre>";
echo "$glId<br>$grSkad<br>$grDokad";
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
	
		$sprQ = "select count(*) liczba from glosiciels where id=$glId and ";
		switch ($grSkad){
			case 1:
				$sprQ.="czy_pionier=0 and czy_nieczynny=0;";
				break;
			case 2:
				$sprQ.="czy_starszy=1;";
				break;
			case 3:
				$sprQ.="czy_sluga=1;";
				break;
			case 4:
				$sprQ.="czy_pionier=1;";
				break;
			case 5:
				$sprQ.="czy_nieczynny=1;";
				break;
		}
		echo "<br>$sprQ<br>";
		$sprR = mysql_query($sprQ);
		$sprW = mysql_fetch_array($sprR, MYSQL_ASSOC);
		$lRek=$sprW['liczba'];
		//echo "<h2>$lRek</h2>";
		if ($lRek>0){
			if ($grDokad==1){ //'głosiciel'
				$zmianaQ="update glosiciels set czy_pionier=0, czy_nieczynny=0";
				if ($grSkad==2){
					$zmianaQ.=", czy_starszy=0";
					}
				if ($grSkad==3){
					$zmianaQ.=", czy_sluga=0";
					}
				$zmianaQ.=", updated_at=now() where id=$glId";
			}
			if ($grDokad==2){ //'starszy'
				$zmianaQ="update glosiciels set czy_starszy=1, czy_sluga=0, updated_at=now() where id=$glId";
			}
			if ($grDokad==3){ //'sługa pomocniczy'
				$zmianaQ="update glosiciels set czy_starszy=0, czy_sluga=1, updated_at=now() where id=$glId";
			}
			if ($grDokad==4){ //'pionier stały'
				$zmianaQ="update glosiciels set czy_pionier=1, updated_at=now() where id=$glId";
			}
			if ($grDokad==5){ //'nieczynny'
				$zmianaQ="update glosiciels set czy_starszy=0, czy_sluga=0, czy_pionier=0, czy_nieczynny=1, czy_zbiorki=0, updated_at=now() where id=$glId";
			}
			if ($grDokad==6){ //'zbiórki'
				$zmianaQ="update glosiciels set czy_zbiorki=1, updated_at=now() where id=$glId";
			}
			//echo "<script type=\"text/javascript\">alert('$zmianaQ');</script>";
			mysql_query($zmianaQ) or die('BŁAD! Nie udało się wprowadzić zmiany.<br><h3>'.$zmianaQ.'</h3>');
			echo "<br>Zapisano zmianę.";
		}
}
?>