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

//wyszukujemy duchowe skarby
include "widoki/ch.z.is.03.skarby.php";


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