<?php
//KROPKA W KOLORZE SKARBÓW
$formatKropki['color']=$kolorSkarby;

$section->addTextBreak(1,$stylPrzerwy);
$table = $section->addTable('czesci-tablica');
    $table->addRow($wWie);
        //Nagłówek wykładu
        $table->addCell($dlPoleTytulDlugi,array('valign' => 'center','bgcolor'=>$formatKropki['color']))->addText('Wykład publiczny [30 min]',array('name'=>'Calibri','size'=>10,'color'=>'FFFFFF','bold'=>true,'allCaps'=>true),$akapitTytul);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontRola,$akapitRola);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontRola,$akapitTytul);

/*
        //Wykład
        $wyklad=$zebranie->get_wyklad();
        $table->addRow($wWie);
            //czas
            $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText('czas',$fontCzas,$akapitCzas);
            //tytuł
            $punktWyklad=$table->addCell($dlPoleTytulKrotki+$dlPoleProwadzacy,array('valign' => 'center'))->addTextRun();
                $punktWyklad->addText($wyklad[1],$fontTytul,$akapitTytul);
            //prowadzący
            $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($wyklad[2],$fontProwadzacy,$akapitTytul);
*/

$table->addRow($wWie);
    //czas
    $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText('czas',$fontCzas,$akapitCzas);
    //tytuł
    $punktSkarby=$table->addCell($dlPoleTytulKrotki+$dlPoleProwadzacy,array('valign' => 'center'))->addTextRun();
        $punktSkarby->addText(' ', $formatKropki);
        $punktSkarby->addText("tytuł"." ",$fontTytul,$akapitTytul);
        $punktSkarby->addText("("."10"." min)",$fontTytul,$akapitTytul);
    //prowadzący
    $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('uczestnik',$fontProwadzacy,$akapitTytul);

$section->addTextBreak(1,$stylPrzerwy);
