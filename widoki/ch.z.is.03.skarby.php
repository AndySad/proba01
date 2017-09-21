<?php
//KROPKA W KOLORZE SKARBÓW
$formatKropki['color']=$kolorSkarby;
//skarby
$section->addTextBreak(1,$stylPrzerwy);
$table = $section->addTable('czesci-tablica');
    $table->addRow($wWie);
        //SKARBY ZE SŁOWA BOŻEGO
        $table->addCell($dlPoleTytulDlugi,array('valign' => 'center','bgcolor'=>$kolorSkarby))->addText('Skarby ze Słowa Bożego',array('name'=>'Calibri','size'=>10,'color'=>'FFFFFF','bold'=>true,'allCaps'=>true),$akapitTytul);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontRola,$akapitRola);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('Sala główna',$fontRola,$akapitTytul);
    $table->addRow($wWie);
        $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText('0.00',$fontCzas,$akapitCzas);
        $punktSkarby=$table->addCell($dlPoleTytulKrotki,array('valign' => 'center'))->addTextRun();
            $punktSkarby->addText(' ', $formatKropki);
            $punktSkarby->addText('Pieśń XXX',$fontTytul,$akapitTytul);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontRola,$akapitRola);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('Imię i nazwisko',$fontProwadzacy,$akapitTytul);
    $table->addRow($wWie);
        $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText('0.00',$fontCzas,$akapitCzas);
        $punktSkarby=$table->addCell($dlPoleUwagiWstepne,array('valign' => 'center'))->addTextRun();
            $punktSkarby->addText(' ', $formatKropki);
            $punktSkarby->addText('Uwagi wstępne (3 min lub mniej)',$fontTytul,$akapitTytul);
