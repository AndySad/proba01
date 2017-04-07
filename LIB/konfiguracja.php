<?php
class konfiguracja{
	private $zbor;
	function __construct($nazwa){
		$this->zbor=$nazwa;
	}
	function get_zbor(){
		return $this->zbor;
	}
	
}