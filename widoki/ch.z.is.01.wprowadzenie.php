<?php
$table = $section->addTable('poczatek-tablica');
    $table->addRow($wWie);
        //prowadzący
        $table->addCell($dlPoleTytulDlugi,array('valign' => 'center'))->addText('['.$zebranie->get_dzien_zebrania().'] | ['.$zebranie->get_rozdzialy().']',array('name'=>'Calibri','size'=>11,'bold'=>true,'smallCaps'=>true),$akapitTytul);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('Przewodniczący:',$fontRola,$akapitRola);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($zebranie->get_przewodniczacy(),$fontProwadzacy,$akapitTytul);
    $table->addRow($wWie);
        $table->addCell($dlPoleTytulDlugi,array('valign' => 'center'))->addText('',array('name'=>'Calibri','size'=>11,'bold'=>true,'smallCaps'=>true),$akapitTytul);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontRola,$akapitRola);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontProwadzacy,$akapitTytul);

$section->addTextBreak(1,$stylPrzerwy);
