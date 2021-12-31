<?php 
namespace Multitone;

class FileSave { 
	private $filePath;
	
	private static $_instance = [];
	
	private function __construct($str){
		$this->filePath = $str.'-'.md5(microtime()).'.txt';		
	}
	
	public static function getInstance($str) : FileSave {
				
		//instanceof if( !self::$_instance instanceof self )
        if(!isset(self::$_instance[$str])){
			self::$_instance[$str] = new static($str); //(Late Static Binding, LSB) 
		}
		return self::$_instance[$str];
	}
	
	public static function removeInstance($instanceName)
	{	
        if(array_key_exists($instanceName, static::$instances)){
			unset(static::$_instance[$instanceName]);
		}
	}
		
	public function save($dir){
		$content = " text ";
		if(file_exists($dir.'/'. $this->filePath)){
			$content = file_get_contents($dir.'/'. $this->filePath) . $content;
	
		}

		file_put_contents($dir.'/'. $this->filePath, $content);
	}
	
	private function __clone(){
		
	}

	private function __wakeup(){
		
	}	

}
