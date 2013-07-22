<?php
class BDunit {
	public $OKs=0;
	public $NOs=0;
	public $NOArray;
	public $DIR;
	public function setUp(){}
	public function tearDown(){}
	/***
	 * 得到测试类对象
	 */
	protected  function  getTestObjet(){
		
		$testName=get_class($this);
		$testDir=preg_replace("/".$testName."\.php/","",$this->DIR);
		$testName=preg_replace("/Test/","",$testName);
		$testDir=PROJECT."/".$testDir.$testName.".php";
		require_once $testDir;
		$testClass=new ReflectionClass($testName);
		return $testClass->newInstance();
		
	}
	protected function getMesg($values){
		if(is_bool($values)){
			if($values) return "true";
			else return "false";
		}
		if(is_null($values)){
			return  "null";
		}
		if(is_integer($values) || is_double($values) || is_string($values)){
			return  $values;
		}
	}
	public function assertEquals($expected,$actual){
		if($this->assert($expected,$actual)){
			$this->OKs++;
			
		}
		else{

			$this->NOArray[$this->NOs]="Expected : <span class='noMessg'>".$this->getMesg($expected)."</span>  Actual : <span class='noMessg'>".$this->getMesg($actual)."</span>";
			$this->NOs++;
			
		}
	}
	protected function assert($expected,$actual){
		/**
		 * 判断是NULL的时候
		 */
		if(is_null($expected)){ 
			if(is_null($actual)){
				return true;
			}
			return false;
		}
		/**
		 * 判断boolean的时候
		 */
		if(is_bool($expected)){
			if(is_bool($actual)){
				if($expected==$actual){
					return true;
				}
				return false;
			}
			return false;
		}
		/**
		 * 判断是integer的时候
		 */
		if(is_integer($expected)){
			if(is_integer($actual)){
				if($expected==$actual){
					return true;
				}
				return false;
			}
			return false;
		}
		/**
		 * 判断是double的时候
		 */		
		if(is_double($expected)){
			if(is_double($actual)){
				if($expected==$actual){
					return true;
				}
				return false;
			}
			return false;
		}
		/**
		 * 判断是string的时候
		 */	
		if(is_string($expected)){
			if(is_string($actual)){
				if($expected==$actual){
					return true;
				}
				return false;
			}
			return false;
		}
	}
}

?>