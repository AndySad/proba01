<?php
class konfiguracja{
	private $zbor;
	private $zebranie_w_tygodniu_dzien;
	private $zebranie_w_tygodniu_godzina;
	private $zebranie_w_tygodniu_minuta;

	function __construct($nazwa,$chzis_dzien,$chzis_godzina,$chzis_minuta){
		$this->zbor=$nazwa;
		$this->zebranie_w_tygodniu_dzien=$chzis_dzien;
		$this->zebranie_w_tygodniu_godzina=$chzis_godzina;
		$this->zebranie_w_tygodniu_minuta=$chzis_minuta;
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
	
}