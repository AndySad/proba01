<?php
$table = $section->addTable('poczatek-tablica');
    $table->addRow($wWie);
        //prowadzący
        $table->addCell($dlPoleTytulKrotki,array('valign' => 'center'))->addText('['.$zebranie->get_dzien_zebrania().']',array('name'=>'Calibri','size'=>11,'bold'=>true,'smallCaps'=>true),$akapitTytul);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('Modlitwa i prowadzenie:',$fontRola,$akapitRola);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($zebranie->get_przewodniczacy(),$fontProwadzacy,$akapitTytul);

$section->addTextBreak(1,$stylPrzerwy);