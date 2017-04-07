<?php

//nagłówek planu zebrań
$table = $section->addTable('naglowek-zbor-tablica');
    $table->addRow();
    $table->addCell(3750,array('valign' => 'bottom'))->addText($konfiguracja->get_zbor(),array('name'=>'Calibri','size'=>11,'bold'=>true,'smallCaps'=>true),$akapitTytul);
    $table->addCell(7000,array('valign' => 'bottom'))->addText('Plan zebrań w tygodniu',array('name'=>'Cambria','size'=>18,'bold'=>true,'smallCaps'=>true),$akapitRola);

$section->addTextBreak(1,$stylPrzerwy);
