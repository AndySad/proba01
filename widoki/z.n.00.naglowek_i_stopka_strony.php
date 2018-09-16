<?php

//główka
$header = $section->createHeader();
$tableH = $header->addTable('naglowek-zbor-tablica');
$tableH->addRow();
    $tableH->addCell(3750,array('valign' => 'bottom'))->addText($konfiguracja->get_zbor(),array('name'=>'Calibri','size'=>11,'bold'=>true,'smallCaps'=>true),$akapitTytul);
    $tableH->addCell(7000,array('valign' => 'bottom'))->addText('Plan zebrań w weekend',array('name'=>'Cambria','size'=>18,'bold'=>true,'smallCaps'=>true),$akapitRola);

$section->addTextBreak(1,$stylPrzerwy);

// Add footer

$footer = $section->createFooter();
$tableF = $footer->addTable('stopka-zbor-tablica');
$tableF->addRow();
    $tableF->addCell(8000,array('valign' => 'bottom'))->addText('');
    $tableF->addCell(2750,array('valign' => 'bottom','borderLeftColor'=>'888888','borderLeftSize'=>20))->addText('',array('name'=>'Cambria','size'=>13,'smallCaps'=>true),$akapitRola);;

