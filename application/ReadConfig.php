<?php
class ReadConfig {
	protected static $ini_array; 
	static $_instance;  
	
	public static function getInstance () {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self(); 
		}
		return self::$_instance;
	}
	
	private function __construct() {
		self::$ini_array = parse_ini_file("config.txt");
	}
	
	public static function getValue ($key) {
		if (array_key_exists($key, self::$ini_array)) {
			return self::$ini_array[$key];
		} else {
			return false;
		}
	}
}
?>