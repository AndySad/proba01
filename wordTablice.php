<?php
require_once 'bootstrap.php';
include "LIB/zebranie.php";
include "LIB/konfiguracja.php";
include "LIB/funkcje.php";

//dane do wyświetlenia
include "widoki/ch.z.is.dane.php";

// Creating the new document...
$phpWord = new \PhpOffice\PhpWord\PhpWord();
// New Word Document
echo date('H:i:s'), ' Create new PhpWord object';

//style
include "widoki/ch.z.is.style.php";

//nagłówek planu zebrań
include "widoki/ch.z.is.00.naglowek_strony.php";

//wprowadzenie: dzień zebrania, rozdziały do czyatnia i przewodniczący,
include "widoki/ch.z.is.01.wprowadzenie.php";

//wprowadzenie: pieśń nr 1, modlitwa i uwagi wstępne
include "widoki/ch.z.is.02.wstep.php";


//skarby
$section->addTextBreak(1,$stylPrzerwy);
$table = $section->addTable('czesci-tablica');
    $table->addRow($wWie);
        //SKARBY ZE SŁOWA BOŻEGO
        $table->addCell($dlPoleTytulDlugi,array('valign' => 'center','bgcolor'=>$kolorSkarby))->addText('Skarby ze Słowa Bożego',array('name'=>'Calibri','size'=>10,'color'=>'FFFFFF','bold'=>true,'allCaps'=>true),$akapitTytul);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontRola,$akapitRola);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('Sala główna',$fontRola,$akapitTytul);
    $table->addRow($wWie);
        $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText('0.00',$fontCzas,$akapitCzas);
        $punktSkarby=$table->addCell($dlPoleTytulKrotki,array('valign' => 'center'))->addTextRun();
            $punktSkarby->addText(' ', $formatKropki);
            $punktSkarby->addText('Pieśń XXX',$fontTytul,$akapitTytul);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontRola,$akapitRola);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('Imię i nazwisko',$fontProwadzacy,$akapitTytul);
    $table->addRow($wWie);
        $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText('0.00',$fontCzas,$akapitCzas);
        $punktSkarby=$table->addCell($dlPoleUwagiWstepne,array('valign' => 'center'))->addTextRun();
            $punktSkarby->addText(' ', $formatKropki);
            $punktSkarby->addText('Uwagi wstępne (3 min lub mniej)',$fontTytul,$akapitTytul);

// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('./WYNIKI/'.basename(__FILE__, '.php').'.docx');

// Saving the document as ODF file...
//$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
//$objWriter->save('helloWorld.odt');

// Saving the document as HTML file...
//$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
//$objWriter->save('helloWorld.html');

/* Note: we skip RTF, because it's not XML-based and requires a different example. */
/* Note: we skip PDF, because "HTML-to-PDF" approach is used to create PDF documents. */