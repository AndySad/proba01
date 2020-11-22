<?php
require 'vendor/autoload.php';
require_once 'bootstrap.php';

	require 'connect.php';
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
	#$konfiguracja=new konfiguracja('Płońsk-Północ',array(2,18,30),array(7,10,00));

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
	<h4>Porządkowi i nagłośnienie</h4>
	<?php
		$okresy = $dbo->query(
			//"SELECT date_format(tydzien_od, '%Y-%m') as XX, count(*) as liczba_zebran FROM `tydzien` where tydzien_od > DATE_FORMAT(NOW() ,'%Y-%m-01') group by 1 order by 1"
			"SELECT date_format(tydzien_od, '%Y-%m') as XX, count(*) as liczba_zebran FROM `tydzien` where tydzien_od >= DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 month) ,'%Y-%m-01') group by 1 order by 1"
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
	    $sqlPorzadkowi="SELECT `dzien_zebrania`, ifnull(`porzadkowy_SALA`,'--'), ifnull(`porzadkowy_HOL`,'--'), ifnull(`porzadkowy_PARKING`,'--') 
		                  FROM `porzadkowi_i_naglosnienie` 
	                     WHERE DATE_FORMAT(dzien_zebrania,'%Y-%m') = '$okres' 
	                     ORDER BY dzien_zebrania";
	    $sqlNaglosnienie="SELECT `dzien_zebrania`, ifnull(`naglosnienie_APARATURA`,'--'), ifnull(`naglosnienie_MIKROFON1`,'--'), ifnull(`naglosnienie_MIKROFON2`,'--'), ifnull(`naglosnienie_MIKROFONY_podium`, '--') 
		                  FROM `porzadkowi_i_naglosnienie` 
	                     WHERE DATE_FORMAT(dzien_zebrania,'%Y-%m') = '$okres' 
	                     ORDER BY dzien_zebrania";
		$planPorzadkowi = $dbo->query($sqlPorzadkowi); 
		$planNaglosnienie = $dbo->query($sqlNaglosnienie); 
		
		$stylNaglowkaMiesiac = [
			'font' => [
				'bold' => true,
				'size' => 18,
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => [
					'argb' => 'BEE3D3',
				],
			],
		];
		$stylNaglowkaRodzaj = [
			'font' => [
				'bold' => true,
				'size' => 18,
			],
		];
		$stylRamka = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => 'cccccc'],
				],
			],
		];
		$stylRamkaGoraBoki = [
			'borders' => [
				'top' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => 'cccccc'],
				],
				'right' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => 'cccccc'],
				],
				'left'  => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => 'cccccc'],
				],
			],
		];
		$stylRamkaDolBoki = [
			'borders' => [
				'right' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => 'cccccc'],
				],
				'left'  => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => 'cccccc'],
				],
				'bottom' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => 'cccccc'],
				],
			],
		];
		
		// Creating the new document...
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator("Andrzej Sadowski")
			->setLastModifiedBy("Andrzej Sadowski")
			->setTitle("$okres - porządkowi i nagłośnienie")
			->setDescription(
				"Document for Office 2007 XLSX, generated using PHP classes."
			)
			->setKeywords("office 2007 openxml php");
		$spreadsheet->getSheet(0);
		$spreadsheet->getActiveSheet()
			->setTitle('Porządkowi i nagłośnienie');
		$wiersz=1;
		$kolumna=1;
		//NAGŁÓWEK - 1. wiersz (miesiąc)
		$spreadsheet->getActiveSheet()->getStyle("A$wiersz")->applyFromArray($stylNaglowkaMiesiac);
		$spreadsheet->getActiveSheet()
			->getCellByColumnAndRow($kolumna,$wiersz)->setValue('=DATEVALUE("'.$okres.'-01")')->getStyle()->getNumberFormat()->setFormatCode('mmmm YYYY');
		$spreadsheet->getActiveSheet()->mergeCells("A$wiersz:M$wiersz");
		$spreadsheet->getActiveSheet()->getRowDimension($wiersz)->setRowHeight(30);
		$wiersz++;
		//####### P O R Z Ą D K O W I ######################################################################################
		//NAGŁÓWEK - 2. wiersz (Porządkowi)
		$spreadsheet->getActiveSheet()->getRowDimension($wiersz)->setRowHeight(15);
		$wiersz++;
		$spreadsheet->getActiveSheet()->getStyle("A$wiersz")->applyFromArray($stylNaglowkaRodzaj);
		$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->setValue('Porządkowi');
		$spreadsheet->getActiveSheet()->mergeCells("A$wiersz:M$wiersz");
		$spreadsheet->getActiveSheet()->getRowDimension($wiersz)->setRowHeight(30);
		$wiersz++;
		$spreadsheet->getActiveSheet()->getRowDimension($wiersz)->setRowHeight(5);
		$wiersz++;
		//PORZĄDKOWI
		$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->setValue('Data');
		$kolumna++;
		$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->setValue('Sala Królestwa');
		$spreadsheet->getActiveSheet()->mergeCells("B$wiersz:E$wiersz");
		$kolumna+=4;
		$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->setValue('Hol');
		$spreadsheet->getActiveSheet()->mergeCells("F$wiersz:I$wiersz");
		$kolumna+=4;
		$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->setValue('Parking');
		$spreadsheet->getActiveSheet()->mergeCells("J$wiersz:M$wiersz");
		$spreadsheet->getActiveSheet()->getRowDimension($wiersz)->setRowHeight(16);
		$spreadsheet->getActiveSheet()->getStyle("A$wiersz:M$wiersz")->applyFromArray($stylRamka);
		$spreadsheet->getActiveSheet()->getStyle("A$wiersz:M$wiersz")->getFont()->setBold(true);

		$kolumna=1;
		$wiersz++;
		$spreadsheet->getActiveSheet()->getRowDimension($wiersz)->setRowHeight(5);
		$wiersz++;
		$wierszPorzadkowiStart=$wiersz;
		while ($danePorzadkowi = $planPorzadkowi->fetch(PDO::FETCH_ASSOC)){
			foreach ($danePorzadkowi as $wartoscPorzadkowi) {
				echo "$wiersz:$kolumna::$wartoscPorzadkowi ";
				
				if ($kolumna == 1){ //data
					$komorka=$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->getCoordinate();
					$spreadsheet->getActiveSheet()
						->getCellByColumnAndRow($kolumna,$wiersz)
						->setValue('=DATEVALUE("'.$wartoscPorzadkowi.'")')
						->getStyle()
						->getNumberFormat()
						->setFormatCode('YYYY-MM-DD')
						;
					$spreadsheet->getActiveSheet()->getStyle($komorka)->applyFromArray($stylRamkaGoraBoki);
					$komorkaDnia=$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,($wiersz + 1))->getCoordinate();
					$spreadsheet->getActiveSheet()						
						->getCell($komorkaDnia)
						->setValue('='.$komorka)
						->getStyle()
						->getNumberFormat()
						->setFormatCode('dddd')
						;
					$spreadsheet->getActiveSheet()->getStyle($komorkaDnia)->getFont()->setSize(8);
					$spreadsheet->getActiveSheet()->getStyle($komorkaDnia)->applyFromArray($stylRamkaDolBoki);
					
				} else {
					$komorkaOd=$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->getCoordinate();
					$kolumna+=3;
					$komorkaDo=$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,($wiersz + 1))->getCoordinate();

					$spreadsheet->getActiveSheet()->getCell($komorkaOd)->setValue($wartoscPorzadkowi);
					if ($wartoscPorzadkowi == '--'){
						$spreadsheet->getActiveSheet()->getStyle($komorkaOd)
							->getFont()->getColor()->setARGB('DDDDDD');
						$spreadsheet->getActiveSheet()->getStyle($komorkaOd)
							->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
					} else {
						if ($kolumna==9){ //jeśli jest dyżur na holu, to na żółtym tle
							$spreadsheet->getActiveSheet()->getStyle($komorkaOd)
								->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
						}
					}
					
					$spreadsheet->getActiveSheet()->mergeCells("$komorkaOd:$komorkaDo");
				}
				$kolumna++;
			}
			$kolumna=1;
			$wiersz+=2;
			echo "<br />";
		}
		$wierszPorzadkowiStop=$wiersz - 1;
		$spreadsheet->getActiveSheet()->getStyle("B$wierszPorzadkowiStart:M$wierszPorzadkowiStop")->applyFromArray($stylRamka);

		//####### N A G Ł O Ś N I E N I E ######################################################################################
		//NAGŁÓWEK - wiersz (Nagłośnienie)
		$spreadsheet->getActiveSheet()->getRowDimension($wiersz)->setRowHeight(15);
		$wiersz++;
		$spreadsheet->getActiveSheet()->getStyle("A$wiersz")->applyFromArray($stylNaglowkaRodzaj);
		$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->setValue('Nagłośnienie');
		$spreadsheet->getActiveSheet()->mergeCells("A$wiersz:M$wiersz");
		$spreadsheet->getActiveSheet()->getRowDimension($wiersz)->setRowHeight(30);
		$wiersz++;
		$spreadsheet->getActiveSheet()->getRowDimension($wiersz)->setRowHeight(5);
		$wiersz++;
		//Nagłośnienie
		$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->setValue('Data');
		$kolumna++;
		$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->setValue('Aparatura');
		$spreadsheet->getActiveSheet()->mergeCells("B$wiersz:D$wiersz");
		$kolumna+=3;
		$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->setValue('Mikrofony przenośne');
		$spreadsheet->getActiveSheet()->mergeCells("E$wiersz:J$wiersz");
		$kolumna+=6;
		$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->setValue('Mikrofony na podium');
		$spreadsheet->getActiveSheet()->mergeCells("K$wiersz:M$wiersz");
		$spreadsheet->getActiveSheet()->getRowDimension($wiersz)->setRowHeight(16);
		$spreadsheet->getActiveSheet()->getStyle("A$wiersz:M$wiersz")->applyFromArray($stylRamka);
		$spreadsheet->getActiveSheet()->getStyle("A$wiersz:M$wiersz")->getFont()->setBold(true);
		$kolumna=1;
		$wiersz++;
		$spreadsheet->getActiveSheet()->getRowDimension($wiersz)->setRowHeight(5);
		$wiersz++;
		$wierszNaglosnienieStart=$wiersz;
		while ($daneNaglosnienie = $planNaglosnienie->fetch(PDO::FETCH_ASSOC)){
			foreach ($daneNaglosnienie as $wartoscNaglosnienie) {
				echo "$wiersz:$kolumna::$wartoscNaglosnienie ";
				
				if ($kolumna == 1){ //data
					$komorka=$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->getCoordinate();
					$spreadsheet->getActiveSheet()->getStyle($komorka)->applyFromArray($stylRamkaGoraBoki);
					$spreadsheet->getActiveSheet()
						->getCellByColumnAndRow($kolumna,$wiersz)
						->setValue('=DATEVALUE("'.$wartoscNaglosnienie.'")')
						->getStyle()
						->getNumberFormat()
						->setFormatCode('YYYY-MM-DD')
						;
					$komorkaDnia=$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,($wiersz + 1))->getCoordinate();
					$spreadsheet->getActiveSheet()						
						->getCell($komorkaDnia)
						->setValue('='.$komorka)
						->getStyle()
						->getNumberFormat()
						->setFormatCode('dddd')
						;
					$spreadsheet->getActiveSheet()->getStyle($komorkaDnia)->getFont()->setSize(8);
					$spreadsheet->getActiveSheet()->getStyle($komorkaDnia)->applyFromArray($stylRamkaDolBoki);
					
				} else {
					//$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->setValue($wartoscNaglosnienie);

					$komorkaOd=$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,$wiersz)->getCoordinate();
					$kolumna+=2;
					$komorkaDo=$spreadsheet->getActiveSheet()->getCellByColumnAndRow($kolumna,($wiersz + 1))->getCoordinate();

					$spreadsheet->getActiveSheet()->getCell($komorkaOd)->setValue($wartoscNaglosnienie);

					if ($wartoscNaglosnienie == '--'){
						$spreadsheet->getActiveSheet()->getStyle($komorkaOd)
							->getFont()->getColor()->setARGB('DDDDDD');
						$spreadsheet->getActiveSheet()->getStyle($komorkaOd)
							->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
					} else {
						if ($kolumna==9){ //jeśli jest dyżur na holu, to na żółtym tle
							$spreadsheet->getActiveSheet()->getStyle($komorkaOd)
								->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
						}
					}

					$spreadsheet->getActiveSheet()->mergeCells("$komorkaOd:$komorkaDo");
				}
				$kolumna++;
			}
			$kolumna=1;
			$wiersz+=2;
			echo "<br />";
		}
		$wierszNaglosnienieStop=$wiersz - 1;
		$spreadsheet->getActiveSheet()->getStyle("B$wierszNaglosnienieStart:M$wierszNaglosnienieStop")->applyFromArray($stylRamka);

		//FORMATOWANIE
		//SZEROKOŚĆ KOLUMN
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(17);
		foreach(range('B','M') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)
				->setWidth(7);
		}
		//WYŚRODKOWANE W PIONIE I POZIOMIE
		$spreadsheet->getActiveSheet()
			->getStyle("A1:M$wiersz")
				->getAlignment()
					->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
					->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)

			;
		//USTAWIENIA WYDRUKU
		$spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.5);
		$spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.25);
		$spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.25);
		$spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.75);
		$spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
		$spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
		$spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
		$spreadsheet->getActiveSheet()->getPageSetup()->setPrintArea("A1:M$wiersz");
		$spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);

		// Saving the document as OOXML file...
		$objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$nazwaZboru=iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE',$konfiguracja->get_zbor());
		$objWriter->save('./WYNIKI/'.$okres.' '.basename(__FILE__, '.php').' ('.$nazwaZboru.').xlsx');

	}
?>	
</body>
</html>