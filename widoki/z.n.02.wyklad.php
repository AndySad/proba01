<?php
//KROPKA W KOLORZE SKARBÓW
$formatKropki['color']=$kolorSkarby;

$section->addTextBreak(1,$stylPrzerwy);

$table = $section->addTable('czesci-tablica');

$table->addRow($wWie);
//WYKŁAD
$table->addCell($dlPoleTytulDlugi,array('valign' => 'center','bgcolor'=>$formatKropki['color']))->addText('Wykład publiczny (30 min)',array('name'=>'Calibri','size'=>10,'color'=>'FFFFFF','bold'=>true,'allCaps'=>true),$akapitTytul);
$table->addCell($dlPoleProwadzacy+dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontRola,$akapitRola);

//PRZEMÓWIENIE
$table->addRow($wWie);
    //czas
    $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText("",$fontCzas,$akapitCzas);
    //tytuł
    $punktSkarby=$table->addCell($dlPoleTytulKrotki+$dlPoleProwadzacy-$dlPoleCzas,array('valign' => 'center'))->addTextRun();
        $punktSkarby->addText(' ', $formatKropki);
        $punktSkarby->addText($zebranie->get_wyklad()[1],$fontTytul,$akapitTytul);
        $punktSkarby->addText("",$fontTytul,$akapitTytul);
    //prowadzący
    $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($zebranie->get_wyklad()[2],$fontProwadzacy,$akapitTytul);
