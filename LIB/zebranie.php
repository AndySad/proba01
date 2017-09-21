<?php

class zebranie{
	private $tydzien_od;
	private $rozdzialy;
	private $piesni;
	private $skarby;
	private $sluzba;
	private $zycie;
	private $przewodniczacy;
	private $modlitwa;
	
	function __construct(){
		;
	}
	/*
	function __construct($zebranie_tydzien_od){
		$this->tydzien_od = $zebranie_tydzien_od;
	}
	*/
	function get_tydzien_od_z_BAZY($tydzien_od){
		echo "<h1>Wybrany tydzień ma numer $tydzien_od</h1>";

	}
	function set_tydzien_od($nowy_tydzien_od){
		$this->tydzien_od = $nowy_tydzien_od;
	}
	
	public function get_tydzien_od(){
		return $this->tydzien_od->format('Y-m-d');
	}

	public function get_dzien_zebrania(){
		return $this->tydzien_od->add(new DateInterval('P2D'))->format('d-m');
	}

	public function set_rozdzialy($rozdzialy){
		$this->rozdzialy = $rozdzialy;
	}
	public function get_rozdzialy(){
		return $this->rozdzialy;
	}

	public function set_przemowienie($przemowienie){
		$this->skarby=array();
		array_push($this->skarby,$przemowienie);
	}
	public function get_przemowienie(){
		return $this->skarby[0];
	}
	
	public function set_fragment_biblii($fragment_biblii){
		array_push($this->skarby,$fragment_biblii);
	}
	public function get_fragment_biblii(){
		return $this->skarby[1];
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

	public function set_punkt_sluzby($punkt_sluzby){
		if (empty($this->sluzba)) {
			$this->sluzba=array();
		}
		array_push($this->sluzba,$punkt_sluzby);
	}
	public function get_punkty_sluzby(){
		return $this->sluzba;
	}

	public function set_punkt_zycia($punkt_zycia){
		if (empty($this->zycie)) {
			$this->zycie=array();
		}
		array_push($this->zycie,$punkt_zycia);
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

}
?>