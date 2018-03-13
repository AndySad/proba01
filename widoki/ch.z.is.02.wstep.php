<?php
//KROPKA W KOLORZE SKARBÓW
$formatKropki['color']=$kolorSkarby;
$table = $section->addTable('czesci-tablica');
    $table->addRow($wWie);
        $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText($zebranie->get_aktualny_czas(),$fontCzas,$akapitCzas);
        $punktSkarby=$table->addCell($dlPoleTytulKrotki,array('valign' => 'center'))->addTextRun();
            $punktSkarby->addText(' ', $formatKropki);
            $punktSkarby->addText('Pieśń '.$zebranie->get_piesn1(),$fontTytul,$akapitTytul);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText('Modlitwa:',$fontRola,$akapitRola);
        $table->addCell($dlPoleProwadzacy,array('valign' => 'center'))->addText($zebranie->get_modlitwa(),$fontProwadzacy,$akapitTytul);
        $zebranie->set_aktualny_czas(6);
    $table->addRow($wWie);
        $table->addCell($dlPoleCzas,array('valign' => 'center'))->addText($zebranie->get_aktualny_czas(),$fontCzas,$akapitCzas);
        $punktSkarby=$table->addCell($dlPoleUwagiWstepne,array('valign' => 'center'))->addTextRun();
            $punktSkarby->addText(' ', $formatKropki);
            $punktSkarby->addText('Uwagi wstępne (3 min lub mniej)',$fontTytul,$akapitTytul);
        $zebranie->set_aktualny_czas(3);