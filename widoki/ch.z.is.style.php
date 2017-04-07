<?php
$header = array('size' => 16, 'bold' => true);

//style
//    \_TABLICE
$phpWord->addTableStyle('naglowek-zbor-tablica', array('borderBottomSize' => 20, 'borderBottomColor' => '888888'));
$phpWord->addTableStyle('poczatek-tablica', array());
$phpWord->addTableStyle('czesci-tablica', array());
//    \_CZĘŚCI ZEBRANIA
//          \_FORMAT KROPEK
$formatKropki=array('name'=>'Symbol','size'=>12);
//          \_FORMAT CZCIONKI
$fontTytul=array('name'=>'Calibri','size'=>11);
$fontProwadzacy=array('name'=>'Calibri','size'=>10);
$fontCzas=array('name'=>'Calibri','size'=>9,'bold'=>true,'color'=>'AAAAAA');
$fontRola=array('name'=>'Calibri','size'=>8);
//          \_FORMATOWANIE AKAPITÓW
$akapitTytul=array('align'=>'left');
$akapitRola=array('align'=>'right');
$akapitCzas=array('align'=>'center');
//          \_KOLORY
$kolorSkarby='5A6A70';
//    \_CZĘŚCI WSPÓLNE (style i długości pól)
$stylPrzerwy=array('name'=>'Calibri','size'=>6);
$wWie=\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.51);
$dlPoleCzas=\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.14);
$dlPoleUwagiWstepne=\PhpOffice\PhpWord\Shared\Converter::cmToTwip(18.29);
$dlPoleTytulDlugi=\PhpOffice\PhpWord\Shared\Converter::cmToTwip(9.87);
$dlPoleTytulKrotki=\PhpOffice\PhpWord\Shared\Converter::cmToTwip(8.73);
$dlPoleProwadzacy=\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.76);

$phpWord->addParagraphStyle('punktSkarby', array('color' => 'FF0000','spaceAfter' => 195));

//konfiguracja dokumentu
$section = $phpWord->addSection();
$sectionStyle = $section->getStyle();
$sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.75));
$sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1));
$sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.25));
$sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.25));
