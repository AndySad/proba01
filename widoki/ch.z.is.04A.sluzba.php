<?php
//KROPKA W KOLORZE SŁUŻBY
$formatKropki['color']=$kolorSluzba;
//skarby
$section->addTextBreak(1,$stylPrzerwy);
$table = $section->addTable('czesci-tablica');
    $table->addRow($wWie);
        //SKARBY ZE SŁOWA BOŻEGO
        $table->addCell($dlPoleTytulDlugi,array('valign' => 'center','bgcolor'=>$formatKropki['color']))->addText('Ulepszajmy swą służbę',array('name'=>'Calibri','size'=>10,'color'=>'FFFFFF','bold'=>true,'allCaps'=>true),$akapitTytul);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontRola,$akapitRola);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('Sala główna',$fontRola,$akapitTytul);

//Wiersz punktów SKARBY ZE SŁOWA BOŻEGO

    foreach ($zebranie->get_punkty_sluzby() as $punkt){
        $table->addRow($wWie);
            //czas
            $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText($zebranie->get_aktualny_czas(),$fontCzas,$akapitCzas);
            //tytuł
            $punktSkarby=$table->addCell($dlPoleTytulKrotki-$dlPoleTekstUczestnik,array('valign' => 'center'))->addTextRun();
                $punktSkarby->addText(' ', $formatKropki);
                $punktSkarby->addText($punkt['tytul']." ",$fontTytul,$akapitTytul);
                $tekstKonca=" min)";
                if ($punkt === end($zebranie->get_punkty_skarby())) $tekstKonca=" min lub mniej)";
                $punktSkarby->addText("(".$punkt['czas'].$tekstKonca,$fontTytul,$akapitTytul);
            //labelka UCZESTNIK:
            $etykieta=array("Uczestnik:");
            $uczestnik=array($punkt['uczestnik']);
            if (strrpos($punkt['tytul'],"Przemówienie")===false or $punkt['pomocnik'] != ''){ //2019 pojawia się omówienie broszury "Przykładaj się ...
                array_push($etykieta,"Pomocnik:");
                array_push($uczestnik,$punkt['pomocnik']);
            } 
            if (strrpos($punkt['tytul'],"film")){
                $etykieta=array();
                //$uczestnik=array($zebranie->get_przewodniczacy());
            }
            //$table->addCell($dlPoleTekstUczestnik,array('valign' => 'center'))->addText($etykieta,$fontRola,$akapitRola);
            $komorkaEtykiet=$table->addCell($dlPoleTekstUczestnik,array('valign' => 'center'))->addTextRun($akapitRola);
            $komorkaEtykiet->addText(array_shift($etykieta),$fontRola,$akapitRola);
            if (!empty($etykieta)){
                $komorkaEtykiet->addTextBreak();
                $komorkaEtykiet->addText(array_shift($etykieta),$fontRola,$akapitRola);
            }
            //Uczestnik w II klasie
            //$table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontProwadzacy,$akapitTytul);
            $komorkaKlasa2=$table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addTextRun($akapitTytul);
            $komorkaKlasa2->addText('',$fontProwadzacy,$akapitTytul);
            //uczestnik w sali głównej
            //$table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText("KTOŚ KTOSIOWATY",$fontProwadzacy,$akapitTytul);
            $komorkaKlasa1=$table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addTextRun($akapitTytul);
            $komorkaKlasa1->addText(array_shift($uczestnik),$fontProwadzacy,$akapitTytul);
            if (!empty($uczestnik)){
                $komorkaKlasa1->addTextBreak();
                $komorkaKlasa1->addText(array_shift($uczestnik),$fontProwadzacy,$akapitTytul);
            }
            
            $zebranie->set_aktualny_czas($punkt['czas']);
            if (!strrpos($punkt['tytul'],"film")){
                $zebranie->set_aktualny_czas(1);//czas na porady
            }
    }
    