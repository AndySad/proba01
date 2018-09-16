<?php
class konfiguracja{
	private $zbor;
	private $zebranie_w_tygodniu_dzien;
	private $zebranie_w_tygodniu_godzina;
	private $zebranie_w_tygodniu_minuta;
	private $zebranie_w_weekend_dzien;
	private $zebranie_w_weekend_godzina;
	private $zebranie_w_weekend_minuta;

	function __construct($nazwa,$chzis,$zn){
		$this->zbor=$nazwa;
		//$chzis - array($chzis_dzien,$chzis_godzina,$chzis_minuta)
		$this->zebranie_w_tygodniu_dzien=$chzis[0];
		$this->zebranie_w_tygodniu_godzina=$chzis[1];
		$this->zebranie_w_tygodniu_minuta=$chzis[2];
		//$zn    - array($zn_dzien,$zn_godzina,$zn_minuta)
		$this->zebranie_w_weekend_dzien=$zn[0];
		$this->zebranie_w_weekend_godzina=$zn[1];
		$this->zebranie_w_weekend_minuta=$zn[2];
	}
	function get_zbor(){
		return $this->zbor;
	}

	function get_zebranie_w_tygodniu_dzien(){
		return $this->zebranie_w_tygodniu_dzien;
	}
	function get_zebranie_w_tygodniu_godzina(){
		return $this->zebranie_w_tygodniu_godzina;
	}
	function get_zebranie_w_tygodniu_minuta(){
		return $this->zebranie_w_tygodniu_minuta;
	}
	function get_zebranie_w_weekend_dzien(){
		return $this->zebranie_w_weekend_dzien;
	}
	function get_zebranie_w_weekend_godzina(){
		return $this->zebranie_w_weekend_godzina;
	}
	function get_zebranie_w_weekend_minuta(){
		return $this->zebranie_w_weekend_minuta;
	}
	
}