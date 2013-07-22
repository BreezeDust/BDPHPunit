<?php
require_once ROOTDIR.'/Core/Entity/MethodMesg.php';
require_once ROOTDIR.'/Core/Entity/ClassMesg.php';
class BDPHPunit {
	public static $MesgArray=array();//类管理数组
	public static $classCON=0;
	public static function show(){
		require_once ROOTDIR.'/Core/views/show.phtml';
	}
	private static function loopTest($dir){
		$oldDir=$dir;
		//循环获得当前目录的测试类
		$dir = realpath(ROOTDIR."/UnitTest/".$dir);
		$dir=$dir."/";
		$phpArray=array();
		$cons=0;
		if (is_dir($dir))
		{
			if ($dh = opendir($dir))
			{
				while (($file = readdir($dh)) !== false)
				{

					if(filetype($dir . $file)=="file"){ //如果是文件
						$phpArray[$cons++]=$file;
					}
					if(filetype($dir . $file)=="dir"){ //如果是目录
						
					}
				}
				closedir($dh);
			}
			for($con=0;$con<count($phpArray);$con++){ //循环测试
				if($oldDir=="/"){
					self::testPHP($phpArray[$con]);
				}
				else{
					self::testPHP($oldDir.$phpArray[$con]);
				}
				
			}
		}		
	}
	public static function test($dir){
		if(preg_match("/\.php$/",$dir)){
			self::testPHP($dir);
		}
		else{
			self::loopTest($dir);
		}
				
	}
	private static function  testPHP($dir){
		ereg("([^\/]*)$", $dir, $regs);
		$class=preg_replace("/\.php/","",$regs[0]);
		$classMesg=new ClassMesg($class,$dir); //初始化类信息
		self::$MesgArray[self::$classCON++]=$classMesg; //添加到类管理数组
		require_once ROOTDIR.'/UnitTest/'.$dir;
		
		$testCase_class=new ReflectionClass($class); //加载类信息
		$testCase=$testCase_class->newInstance();
		$testCase->DIR=$dir;
		
		$methods=$testCase_class->getMethods(); //获取方法集
		
		$methodsCON=0;
		foreach ($methods as $method){ //遍历
			$methodNameStr=$method->getName();
			
			if(preg_match('/^test/', $methodNameStr)){//检测test方法;
				$testCase->setUp();
				$testCase->NOArray=array(); //初始化NO数组
				
				$method->invoke($testCase); //调用测试方法
				
				$messg=new MethodMesg($methodNameStr,$testCase->OKs,$testCase->NOs,$testCase->NOArray);
				
				$testCase->OKs=0; //还原记录信息
				$testCase->NOs=0;
				if(count($messg->NOArray)>0) $classMesg->isOK=false;
				
				$testCase->tearDown();
				
				$classMesg->MethodArray[$methodsCON]=$messg;//将方法添加到管理方法数组
				$methodsCON++;
			}
			
		}
	}
}
?>