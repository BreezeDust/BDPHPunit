<?php

class MethodMesg {
	public $name;
	public $OKs=0;
	public $NOs=0;
	public $NOArray=null;
	public function __construct($name,$OKs,$NOs,$NOArray){
		$this->name=$name;
		$this->OKs=$OKs;
		$this->NOs=$NOs;
		$this->NOArray=$NOArray;
	}
}

?>