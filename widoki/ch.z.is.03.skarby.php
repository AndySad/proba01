<?php
//KROPKA W KOLORZE SKARBÓW
$formatKropki['color']=$kolorSkarby;
//skarby
$section->addTextBreak(1,$stylPrzerwy);
$table = $section->addTable('czesci-tablica');
    $table->addRow($wWie);
        //SKARBY ZE SŁOWA BOŻEGO
        $table->addCell($dlPoleTytulDlugi,array('valign' => 'center','bgcolor'=>$formatKropki['color']))->addText('Skarby ze Słowa Bożego',array('name'=>'Calibri','size'=>10,'color'=>'FFFFFF','bold'=>true,'allCaps'=>true),$akapitTytul);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontRola,$akapitRola);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('Sala główna',$fontRola,$akapitTytul);

//Wiersz punktów SKARBY ZE SŁOWA BOŻEGO
//PRZEMÓWIENIE
    $punkt=$zebranie->get_punkty_skarby()[0];
    $table->addRow($wWie);
        //czas
        $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText($zebranie->get_aktualny_czas(),$fontCzas,$akapitCzas);
        //tytuł
        $punktSkarby=$table->addCell($dlPoleTytulKrotki+$dlPoleProwadzacy,array('valign' => 'center'))->addTextRun();
            $punktSkarby->addText(' ', $formatKropki);
            $punktSkarby->addText($punkt['tytul']." ",$fontTytul,$akapitTytul);
            $punktSkarby->addText("(".$punkt['czas']." min)",$fontTytul,$akapitTytul);
    //prowadzący
    $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($punkt['uczestnik'],$fontProwadzacy,$akapitTytul);
    $zebranie->set_aktualny_czas($punkt['czas']);
//Wyszukujemy duchowe skarby
    $punkt=$zebranie->get_punkty_skarby()[1];
    $table->addRow($wWie);
            //czas
            $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText($zebranie->get_aktualny_czas(),$fontCzas,$akapitCzas);
            //tytuł
            $punktSkarby=$table->addCell($dlPoleTytulKrotki+$dlPoleProwadzacy,array('valign' => 'center'))->addTextRun();
                $punktSkarby->addText(' ', $formatKropki);
                $punktSkarby->addText($punkt['tytul']." ",$fontTytul,$akapitTytul);
                $punktSkarby->addText("(".$punkt['czas']." min)",$fontTytul,$akapitTytul);
            //prowadzący
            $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($punkt['uczestnik'],$fontProwadzacy,$akapitTytul);
            $zebranie->set_aktualny_czas($punkt['czas']);
//czytanie Biblii
        $punkt=$zebranie->get_punkty_skarby()[2];
        $table->addRow($wWie);
            //czas
            $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText($zebranie->get_aktualny_czas(),$fontCzas,$akapitCzas);
            //tytuł
            $punktSkarby=$table->addCell($dlPoleTytulKrotki-$dlPoleTekstUczestnik,array('valign' => 'center'))->addTextRun();
                $punktSkarby->addText(' ', $formatKropki);
                $punktSkarby->addText($punkt['tytul']." ",$fontTytul,$akapitTytul);
                $punktSkarby->addText("(".$punkt['czas']." min lub mniej)",$fontTytul,$akapitTytul);
            //labelka UCZESTNIK:
            $table->addCell($dlPoleTekstUczestnik,array('valign' => 'center'))->addText("Uczestnik:",$fontRola,$akapitRola);
            //Uczestnik w II klasie
            $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontProwadzacy,$akapitTytul);
            //uczestnik w sali głównej
            $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($punkt['uczestnik'],$fontProwadzacy,$akapitTytul);
            $zebranie->set_aktualny_czas($punkt['czas']);

    $zebranie->set_aktualny_czas(1);//porada po CZYTANIE BIBLII
