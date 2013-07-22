<?php
class ClassMesg {
	public $name;
	public $dir;
	public $isOK=true;
	public $MethodArray=array();
	public function __construct($name,$dir){
		$this->name=$name;
		$this->dir=$dir;
	}
}

?>