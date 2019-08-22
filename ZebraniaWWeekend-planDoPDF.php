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
	$konfiguracja=new konfiguracja('Warszawa-Bielany',array(3,18,30),array(7,13,30));
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

        $tekst='
        <style>
        body {
            font-family: Calibri, serif;
        }
        .tblNaglowekPlanu {
            border-bottom:4px solid grey;
            padding: 2px;
        }
        .zbor { 
            text-transform:capitalize;
            font-variant:small-caps;
            font-weight:bold;
            font-size: 16px;
        }
        .tytul {
            text-transform:uppercase;
            font-variant:small-caps;
            font-weight:bold;
            font-family: Cambria, serif;
            font-size: large;
            text-align:right;
        }
        
        .tblZebranie {
            background-color: #fcf3cf;
            padding: 1px;
        }
        .dzien {
            width: 50%;
            color: #ff0800;
            font-size: small;
            font-weight:bold;
            text-transform:uppercase;
        }
        .nazwaZadania {
            width:25%;
            text-align:right;
            color: #a4a4a4;
            font-size: xx-small;
        }
        .prowadzacy {
            width:25%;
            font-size: small;
        }
        .tblWyklad {
            width:100%;
            padding: 1px;
        }
        .wykladNaglowek {
            background-color: #5a6a70;
            color: #ffffff;
            font-size: small;
            width: 50%;
            padding: 4px;
        }
        .wykladTytul {
            color: #2e86c1;
            font-size: large;
            width: 70%;
            font-weight: bold;
            height: 40px;
        
        }
        .tblStraznica {
            width:100%;
            padding: 1px;
        }
        .straznicaNaglowek {
            background-color: #c18626;
            color: #ffffff;
            font-size: small;
            width: 50%;
            padding: 4px;
        }
        
        table {
            width: 100%;
            border-spacing: 0px;
        }
        
        td {
            vertical-align: middle;
        }
        </style>
        ';
        $naglowek='
        <table class="tblNaglowekPlanu">
            <tbody>
                <tr>
                    <td width="60%" class="zbor">Warszawa-Bielany</td>
                    <td width="40%" class="tytul"><span style="font-size:x-large;">P</span>lan zebrań w weekend</td>
                </tr>
            </tbody>
        </table>
        <p style="font-size:6px;">&nbsp;</p>
        ';
        $szablonWidokuWeekendDzien='
        <table class="tblZebranie">
            <tbody>
                <tr>
                    <td class="dzien">%s</td>
                    <td class="nazwaZadania">Modlitwa i prowadzenie:</td>
                    <td class="prowadzacy">%s</span></td>
                </tr>
            </tbody>
        </table>
        <p style="font-size:1px;">&nbsp;</p>
        ';
        $szablonWidokuWeekendWyklad='
        <table class="tblWyklad">
            <tbody>
                <tr>
                    <td class="wykladNaglowek">Wykład publiczny (30 min)</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
        <table class="tblWyklad">
            <tbody>
                <tr>
                    <td width="5%%">&nbsp;</td>
                    <td class="wykladTytul">%s</td>
                    <td class="prowadzacy">%s</td>
                </tr>
            </tbody>
        </table>
        <p style="font-size:1px;">&nbsp;</p>
        ';
        $szablonWidokuWeekendStraznica='
        <table class="tblStraznica">
            <tbody>
                <tr>
                    <td class="straznicaNaglowek">Studium <i>Strażnicy</i> (60 min)</td>
                    <td class="nazwaZadania">Prowadzący:</td>
                    <td class="prowadzacy">%s</td>
                </tr>
                <tr>
                    <td width="50%%">&nbsp;</td>
                    <td class="nazwaZadania">Lektor:</td>
                    <td class="prowadzacy">%s</td>
                </tr>
            </tbody>
        </table>
        ';
        $szablonWidokuWeekendModlitwaKoncowa='
        <table class="tblStraznica">
            <tbody>
                <tr>
                    <td width="50%%">&nbsp;</td>
                    <td class="nazwaZadania" style="padding-top:4px;vertical-align: top;">Modlitwa:</td>
                    <td class="prowadzacy">%s%s</td>
                </tr>
            </tbody>
        </table>        
        ';
        //<br /><span style="font-size: xx-small;color: #a4a4a4;">[Andrzej Sadowski]</span>
	    $szablonWidokuWeekendStraznicaSkrocona='
        <table class="tblStraznica">
            <tbody>
                <tr>
                    <td class="straznicaNaglowek">Studium <i>Strażnicy</i> (30 min)</td>
                    <td class="nazwaZadania">Prowadzący:</td>
                    <td class="prowadzacy">%s</td>
                </tr>
            </tbody>
        </table>
        ';
        $szablonWidokuWeekendPrzemowienieNO='
        <table class="tblWyklad">
            <tbody>
                <tr>
                    <td class="wykladNaglowek">Przemówienie nadzorcy obwodu (30 min)</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
        <table class="tblWyklad">
            <tbody>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td class="wykladTytul">%s</td>
                    <td class="prowadzacy">%s</td>
                </tr>
            </tbody>
        </table>
        <p style="font-size:1px;">&nbsp;</span>
        ';
        $tekst.=$naglowek;

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

                $tekst.=sprintf($szablonWidokuWeekendDzien,$zebranie->get_dzien_zebrania(),$zebranie->get_przewodniczacy());
                $tekst.=sprintf($szablonWidokuWeekendWyklad,$zebranie->get_wyklad()[1],$zebranie->get_wyklad()[2]);
                $tekst.=sprintf($szablonWidokuWeekendStraznica,$zebranie->get_straznica()[0],$zebranie->get_straznica()[1]);
                $modlitwaRezerwa="";
                if(!empty($zebranie->get_modlitwy()[2])){
                    $modlitwaRezerwa=sprintf('<br /><span style="font-size: xx-small;color: #a4a4a4;">[%s]</span>',$zebranie->get_modlitwy()[2]);
                }
                $tekst.=sprintf($szablonWidokuWeekendModlitwaKoncowa,$zebranie->get_modlitwy()[1],$modlitwaRezerwa);
                $tekst.='<p style="font-size:6px;">&nbsp;</p>';
	    	}

            echo "<pre>";
			print_r($zebranie);
			echo "</pre>";
	    	printf("%s [%d]<br>",$row['tydzien_od'],$row['id']);
        }
        echo $tekst;
        $mpdf = new \Mpdf\Mpdf();
        // Write some HTML code:
        $mpdf->WriteHTML($tekst);
        
        // Output a PDF file directly to the browser
        //$mpdf->Output();
        // Saves file on the server as 'filename.pdf'
        $mpdf->Output('filename.pdf', \Mpdf\Output\Destination::FILE);
//$nazwaZboru=iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE',$konfiguracja->get_zbor());
//$objWriter->save('./WYNIKI/'.$okres.' '.basename(__FILE__, '.php').' ('.$nazwaZboru.').docx');
//$objWriter->save('./WYNIKI/'.$row['tydzien_od'].' '.basename(__FILE__, '.php').'.docx');

	}
?>	
</body>
</html>