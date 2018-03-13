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
            $etykieta="Uczestnik:";
            $uczestnik=$punkt['uczestnik'];
            if (strrpos($punkt['tytul'],"Przemówienie")===false or $punkt['pomocnik'] != ''){
                $etykieta.="\nPomocnik:";
                $uczestnik.="\n".$punkt['pomocnik'];
            } 
            if (strrpos($punkt['tytul'],"film")){
                $etykieta='';
                $uczestnik=$zebranie->get_przewodniczacy();
            }
            $table->addCell($dlPoleTekstUczestnik,array('valign' => 'center'))->addText($etykieta,$fontRola,$akapitRola);
            //Uczestnik w II klasie
            $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('',$fontRola,$akapitRola);
            //uczestnik w sali głównej
            $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($uczestnik,$fontProwadzacy,$akapitTytul);
            $zebranie->set_aktualny_czas($punkt['czas']);
            if (!strrpos($punkt['tytul'],"film")){
                $zebranie->set_aktualny_czas(1);//czas na porady
            }
    }
    