<?php
//KROPKA W KOLORZE SLUZBY
$formatKropki['color']=$kolorSluzba;

$section->addTextBreak(1,$stylPrzerwy);

$table = $section->addTable('czesci-tablica');

//STRAŻNICA - prowadzący]
$table->addRow($wWie);
$table->addCell($dlPoleTytulDlugi,array('valign' => 'center','bgcolor'=>$formatKropki['color']))->addText('Studium Strażnicy (60 min)',array('name'=>'Calibri','size'=>10,'color'=>'FFFFFF','bold'=>true,'allCaps'=>true),$akapitTytul);
$table->addCell($dlPoleProwadzacy-$dlPoleCzas,array('valign' => 'center'))->addText('Prowadzący:',$fontRola,$akapitRola);
$table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($zebranie->get_straznica()[0],$fontProwadzacy,$akapitTytul);

//STRAŻNICA - prowadzący]
$table->addRow($wWie);
$table->addCell($dlPoleTytulDlugi,array('valign' => 'center'))->addText('',array('name'=>'Calibri','size'=>10,'color'=>'FFFFFF','bold'=>true,'allCaps'=>true),$akapitTytul);
$table->addCell($dlPoleProwadzacy-$dlPoleCzas,array('valign' => 'center'))->addText('Lektor:',$fontRola,$akapitRola);
$table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($zebranie->get_straznica()[1],$fontProwadzacy,$akapitTytul);

//Modlitwa
$table->addRow($wWie);
$table->addCell($dlPoleTytulDlugi,array('valign' => 'center'))->addText('',array('name'=>'Calibri','size'=>10,'color'=>'FFFFFF','bold'=>true,'allCaps'=>true),$akapitTytul);
$table->addCell($dlPoleProwadzacy-$dlPoleCzas,array('valign' => 'center'))->addText('Modlitwa:',$fontRola,$akapitRola);
$komorkaModlitwy=$table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addTextRun($akapitTytul);
    $komorkaModlitwy->addText($zebranie->get_modlitwy()[1],$fontProwadzacy,$akapitTytul);
    if(!empty($zebranie->get_modlitwy()[2])){
        $komorkaModlitwy->addTextBreak();
        $komorkaModlitwy->addText("[".$zebranie->get_modlitwy()[2]."]",$fontRola,$akapitTytul);
    }


$section->addTextBreak(1,$stylPrzerwy);
