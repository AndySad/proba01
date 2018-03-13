<?php

$konfiguracja=new konfiguracja('Warszawa-Bielany',3,'18:30:00');

$zebranie=new zebranie();
$zebranie->set_tydzien_od(
	daj_tydzien('6-12 marca'),
	$konfiguracja->get_zebranie_w_tygodniu_dzien(),
	$konfiguracja->get_zebranie_w_tygodniu_godzina()
);

$zebranie->set_rozdzialy('JEREMIASZA 1-4');
$zebranie->set_piesni(array(23,149,74));
$zebranie->set_przewodniczacy('Andrzej Sadowski');
$zebranie->set_modlitwa('Marcin Polański');

$zebranie->set_punkt_skarby('Jestem z tobą, by cię wyzwolić',10,'Dawid Richter');
$zebranie->set_punkt_skarby('Wyszukujemy duchowe skarby',8,'Andrzej Wójcik');
$zebranie->set_punkt_skarby('Czytanie Biblii ',4,'Filip Sadowski');

$zebranie->set_punkt_sluzby('Drugie odwiedziny',3,"Milena Richter","Jadwiga Śliwińska");
$zebranie->set_punkt_sluzby('Trzecie odwiedziny',3,"Sylwia Rola","Anna Fopp");
$zebranie->set_punkt_sluzby('Studium biblijne',6,"Barbara Sadowska","Anna Stębnowska");

$zebranie->set_punkt_zycia('Pokrzepianie tych, ‛którzy się mozolą i są obciążeni’',15,"Maciej Fopp");
$zebranie->set_punkt_zycia('Zborowe studium Biblii',30,"Tomasz Stębnowski","Mateusz Wilczyński");
$zebranie->set_punkt_zycia('Powtórka i zapowiedź następnego zebrania',3,'Andrzej Sadowski');
