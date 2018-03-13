<?php

use Carbon\Carbon;
//Carbon::setLocale('pl');

class zebranie{
	private $tydzien_od;
	private $rozdzialy;
	private $piesni;
	private $skarby;
	private $sluzba;
	private $zycie;
	private $przewodniczacy;
	private $modlitwa;
	private $aktualny_czas;
	
	function __construct(){
		;
	}
	/*
	function __construct($zebranie_tydzien_od){
		$this->tydzien_od = $zebranie_tydzien_od;
	}
	*/
	function get_tydzien_od_z_BAZY($tydzien_od){
		;//echo "<h3>Wybrany tydzień ma numer $tydzien_od</h3>";
	}
	function set_tydzien_od($nowy_tydzien_od,$chzis_dzien,$chzis_godzina,$chzis_minuta){
		//echo "set_tydzien_od($nowy_tydzien_od,$chzis_dzien,$chzis_godzina,$chzis_minuta)";
		$this->tydzien_od = $nowy_tydzien_od;
		$this->aktualny_czas=Carbon::parse($nowy_tydzien_od);
		$this->aktualny_czas->addDays(--$chzis_dzien)->setTime($chzis_godzina,$chzis_minuta,0);
		//echo "set_tydzien_od->aktualny_czas: $this->tydzien_od $this->aktualny_czas";
	}
	
	public function get_tydzien_od(){
		return $this->tydzien_od->format('Y-m-d');
	}

	public function get_dzien_zebrania(){
		return $this->aktualny_czas->format('d-m');
	}

	public function set_rozdzialy($rozdzialy){
		$this->rozdzialy = $rozdzialy;
	}
	public function get_rozdzialy(){
		return $this->rozdzialy;
	}

	
	public function set_piesni($piesni){
		$this->piesni = $piesni;
	}
	public function get_piesn1(){
		return $this->piesni[0];
	}
	public function get_piesn2(){
		return $this->piesni[1];
	}
	public function get_piesn3(){
		return $this->piesni[2];
	}

	public function set_punkt_skarby($tytul,$opis,$czas,$prowadzacy){
		if (empty($this->skarby)) {
			$this->skarby=array();
		}
		array_push(
			$this->skarby,
			array(
				"tytul"=>$tytul,
				"uczestnik"=>$prowadzacy,
				"czas"=>$czas,
				"opis"=>$opis
			)); 
	}
	public function get_punkty_skarby(){
		return $this->skarby;
	}
	public function set_punkt_sluzby($tytul,$opis,$czas,$prowadzacy,$pomocnik=""){
		if (empty($this->sluzba)) {
			$this->sluzba=array();
		}
		array_push(
			$this->sluzba,
			array(
				"tytul"=>$tytul,
				"uczestnik"=>$prowadzacy,
				"czas"=>$czas,
				"pomocnik"=>$pomocnik,
				"opis"=>$opis
			)); 
	}
	public function get_punkty_sluzby(){
		return $this->sluzba;
	}

	public function set_punkt_zycia($tytul,$opis,$czas,$prowadzacy,$pomocnik=""){
		if (empty($this->zycie)) {
			$this->zycie=array();
		}
		array_push(
			$this->zycie,
			array(
				"tytul"=>$tytul,
				"uczestnik"=>$prowadzacy,
				"czas"=>$czas,
				"pomocnik"=>$pomocnik,
				"opis"=>$opis
			)); 
	}
	public function get_punkty_zycia(){
		return $this->zycie;
	}

	public function set_przewodniczacy($przewodniczacy){
		$this->przewodniczacy=$przewodniczacy;
	}
	public function get_przewodniczacy(){
		return $this->przewodniczacy;
	}

	public function set_modlitwa($modlitwa){
		$this->modlitwa=$modlitwa;
	}
	public function get_modlitwa(){
		return $this->modlitwa;
	}
	
	public function get_aktualny_czas(){
		return $this->aktualny_czas->format('H:i');
	}
	public function set_aktualny_czas($czas_punktu){
		$this->aktualny_czas=$this->aktualny_czas->addMinutes($czas_punktu);
	}
	
}
?>