<?php
//KROPKA W KOLORZE SKARBÓW
$formatKropki['color']=$kolorSkarby;

$table = $section->addTable('czesci-tablica');

$table->addRow($wWie);
//WYKŁAD - nagłówek
    $table->addCell($dlPoleTytulDlugi,array('valign' => 'center','bgcolor'=>$formatKropki['color']))
        ->addText(  'Wykład publiczny (30 min)',
                    array('name'=>'Calibri','size'=>10,'color'=>'FFFFFF','bold'=>true,'allCaps'=>true),
                    $akapitTytul);
    $table->addCell($dlPoleProwadzacy+$dlPoleProwadzacy,array('valign' => 'center'))
        ->addText('',$fontRola,$akapitRola);

//WYKŁAD - informacje
$table->addRow($wWieWyklad);
    //czas
    $table->addCell($dlPoleCzas,array('valign' => 'center'))
        ->addText("",$fontCzas,$akapitCzas);
    //tytuł
    $table->addCell($dlPoleTytulKrotki+$dlPoleProwadzacy-$dlPoleCzas,array('valign' => 'center'))
        ->addText(  $zebranie->get_wyklad()[1],
                    $fontTytulWykladu,
                    $akapitTytul);
    //prowadzący
    $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))
        ->addText(  $zebranie->get_wyklad()[2],
                    $fontProwadzacy,
                    $akapitTytul);

$section->addTextBreak(1,$stylPrzerwy);