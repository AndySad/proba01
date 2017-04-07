<?php
$konfiguracja=new konfiguracja('Warszawa-Bielany');
$zebranie=new zebranie();
$zebranie->set_tydzien_od(daj_tydzien('6-12 marca'));
$zebranie->set_rozdzialy('JEREMIASZA 1-4');
$zebranie->set_piesni(array(23,149,74));
$zebranie->set_przewodniczacy('Andrzej Sadowski');
$zebranie->set_modlitwa('Marcin Polański');
$zebranie->set_przemowienie('Jestem z tobą, by cię wyzwolić');

$zebranie->set_fragment_biblii('Jer 4:1-10');
