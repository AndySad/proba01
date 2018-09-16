<?php
//KROPKA W KOLORZE ŻYCIA
$formatKropki['color']=$kolorZycie;
//skarby
$section->addTextBreak(1,$stylPrzerwy);
$table = $section->addTable('czesci-tablica');
    $table->addRow($wWie);
        //SKARBY ZE SŁOWA BOŻEGO
        $table->addCell($dlPoleTytulDlugi,array('valign' => 'center','bgcolor'=>$formatKropki['color']))->addText('Ulepszajmy swą służbę',array('name'=>'Calibri','size'=>10,'color'=>'FFFFFF','bold'=>true,'allCaps'=>true),$akapitTytul);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontRola,$akapitRola);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('Sala główna',$fontRola,$akapitTytul);

//Pieśń 2
    $table->addRow($wWie);
        $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText($zebranie->get_aktualny_czas(),$fontCzas,$akapitCzas);
        $punktSkarby=$table->addCell($dlPoleTytulKrotki+$dlPoleProwadzacy+$dlPoleProwadzacy,array('valign' => 'center'))->addTextRun();
            $punktSkarby->addText(' ', $formatKropki);
            $punktSkarby->addText('Pieśń '.$zebranie->get_piesn2(),$fontTytul,$akapitTytul);
        $zebranie->set_aktualny_czas(4);

//Wiersz punktów CHRZEŚCIJAŃSKIE ŻYCIE

    foreach ($zebranie->get_punkty_zycia() as $punkt){
        $table->addRow($wWie);
            $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText($zebranie->get_aktualny_czas(),$fontCzas,$akapitCzas);
            $uczestnik=array($punkt['uczestnik']);
            if ($punkt['pomocnik'] != '') {   //zborowe studium Biblii
                array_push($uczestnik,$punkt['pomocnik']);
                $punktZycie=$table->addCell($dlPoleTytulKrotki,array('valign' => 'center'))->addTextRun();
                    $punktZycie->addText(' ', $formatKropki);
                    $punktZycie->addText($punkt['tytul']." ",$fontTytul,$akapitTytul);
                    $tekstKonca=" min)";
                    if ($punkt === end($zebranie->get_punkty_skarby())) $tekstKonca=" min lub mniej)";
                    $punktZycie->addText("(".$punkt['czas'].$tekstKonca,$fontTytul,$akapitTytul);                
                    //$table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($etykieta,$fontRola,$akapitRola);
                    $komorkaEtykiet=$table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addTextRun($akapitRola);
                    $komorkaEtykiet->addText("Prowadzący:",$fontRola,$akapitRola);
                    $komorkaEtykiet->addTextBreak();
                    $komorkaEtykiet->addText("Lektor:",$fontRola,$akapitRola);
            } else {                        //pozostałe punkty
                $punktZycie=$table->addCell($dlPoleTytulKrotki+$dlPoleProwadzacy,array('valign' => 'center'))->addTextRun();
                    $punktZycie->addText(' ', $formatKropki);
                    $punktZycie->addText($punkt['tytul']." ",$fontTytul,$akapitTytul);
                    $tekstKonca=" min)";
                    if ($punkt === end($zebranie->get_punkty_skarby())) $tekstKonca=" min lub mniej)";
                    $punktZycie->addText("(".$punkt['czas'].$tekstKonca,$fontTytul,$akapitTytul);
                            
            }
            //$table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($uczestnik,$fontProwadzacy,$akapitTytul);
            $komorkaProwadzacy=$table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addTextRun($akapitTytul);
            $komorkaProwadzacy->addText(array_shift($uczestnik),$fontProwadzacy,$akapitTytul);
            if (!empty($uczestnik)){
                $komorkaProwadzacy->addTextBreak();
                $komorkaProwadzacy->addText(array_shift($uczestnik),$fontProwadzacy,$akapitTytul);
            }
            $zebranie->set_aktualny_czas($punkt['czas']);
    }
    

//Powtórka i zapowiedź następnego zebrania
    $table->addRow($wWie);
        $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText($zebranie->get_aktualny_czas(),$fontCzas,$akapitCzas);
        $punktSkarby=$table->addCell($dlPoleTytulKrotki,array('valign' => 'center'))->addTextRun();
            $punktSkarby->addText(' ', $formatKropki);
            $punktSkarby->addText('Powtórka i zapowiedź następnego zebrania',$fontTytul,$akapitTytul);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText("",$fontRola,$akapitRola);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($zebranie->get_przewodniczacy(),$fontProwadzacy,$akapitTytul);
        $zebranie->set_aktualny_czas(3);
//Pieśń 3
    $table->addRow($wWie);
        $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText($zebranie->get_aktualny_czas(),$fontCzas,$akapitCzas);
        $punktSkarby=$table->addCell($dlPoleTytulKrotki,array('valign' => 'center'))->addTextRun();
            $punktSkarby->addText(' ', $formatKropki);
            $punktSkarby->addText('Pieśń '.$zebranie->get_piesn3(),$fontTytul,$akapitTytul);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText("Modlitwa:",$fontRola,$akapitRola);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($zebranie->get_przewodniczacy(),$fontProwadzacy,$akapitTytul);
        $zebranie->set_aktualny_czas(4);
