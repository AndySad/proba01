<?php

use Carbon\Carbon;
//Carbon::setLocale('pl');

class zebranieWeekend{
	private $tydzien_od;
	private $aktualny_czas;
    
    private $przewodniczacy;
    private $modlitwaPoczatkowa;
    private $modlitwaKoncowa;
    private $modlitwaKoncowaRezerwa;
	private $wykladNr;
	private $wykladTytul;
	private $wykladMowca;
    private $straznicaProwadzacy;
    private $straznicaLektor;
    private $straznicaCzas;
    private $przemowienieSpecjalne;
	
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
	function set_tydzien_od($nowy_tydzien_od,$zn_dzien,$zn_godzina,$zn_minuta){
		//echo "set_tydzien_od($nowy_tydzien_od,$chzis_dzien,$chzis_godzina,$chzis_minuta)";
		$this->tydzien_od = $nowy_tydzien_od;
		$this->aktualny_czas=Carbon::parse($nowy_tydzien_od);
		$this->aktualny_czas=$this->aktualny_czas->addDays(--$zn_dzien)->setTime($zn_godzina,$zn_minuta,0);
		echo "set_tydzien_od->aktualny_czas: $this->tydzien_od $this->aktualny_czas";
	}
	
	public function get_tydzien_od(){
		return $this->tydzien_od->format('Y-m-d');
	}

	public function get_dzien_zebrania(){
		return $this->aktualny_czas->format('d-m');
	}

	public function set_wyklad($wyklad){
        $this->wykladNr = $wyklad[0];
        $this->wykladTytul = $wyklad[1];
        $this->wykladMowca = $wyklad[2];
	}
	public function get_wyklad(){
		return array($this->wykladNr,$this->wykladTytul,$this->wykladMowca);
	}

	public function set_straznica($straznica){
        $this->straznicaProwadzacy = $straznica[0];
        $this->straznicaLektor = $straznica[1];
        $this->straznicaCzas = $straznica[2];
	}
	public function get_straznica(){
		return array($this->straznicaProwadzacy,$this->straznicaLektor,$this->straznicaCzas);
	}

	public function set_przewodniczacy($przewodniczacy){
		$this->przewodniczacy=$przewodniczacy;
	}
	public function get_przewodniczacy(){
		return $this->przewodniczacy;
	}

	public function set_modlitwy($modlitwy){
        $this->modlitwaPoczatkowa=$modlitwy[0];
        $this->modlitwaKoncowa=$modlitwy[1];
        $this->modlitwaKoncowaRezerwa=$modlitwy[2];
	}
	public function get_modlitwy(){
		return array($this->modlitwaPoczatkowa,$this->modlitwaKoncowa,$this->modlitwaKoncowaRezerwa);
    }
    
    public function set_przemowienieSpecjalne($przemowienieSpecjalne=""){
        $this->set_przemowienieSpecjalne=$przemowienieSpecjalne;
    }
    public function get_przemowienieSpecjalne(){
        return $this->przemowienieSpecjalne;
    }
	
	public function get_aktualny_czas(){
		return $this->aktualny_czas->format('H:i');
	}
	public function set_aktualny_czas($czas_punktu){
		$this->aktualny_czas=$this->aktualny_czas->addMinutes($czas_punktu);
	}
	
}
?>