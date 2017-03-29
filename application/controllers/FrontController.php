<?php
class FrontController 
{
	protected $_controller, $_action, $_param, $_body;
	static $_instance;  
	
	public static function getInstance () {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self(); 
		}
		return self::$_instance;
	}
	
	private function __construct() {
		$uri = $_SERVER['REQUEST_URI'];
		// Fill variables $_controller, $_action, $_param
		$markQuestionPosition = strpos($uri,'?'); // Is this uri contians param?
				
		// uri contians param;
		if ($markQuestionPosition !== false) {  
			$this->extractContrellerAndAction($uri, $markQuestionPosition);
		} else {
			//uri not contians param
			$this->defaultValueForRoute();
		}	
	}
	
	private function extractContrellerAndAction($uri, $markQuestionPosition) {
		$path = substr($uri, 0, $markQuestionPosition - 1 );  //separate path from uri  
		list($this->_controller, $this->_action) = explode("/", trim($path,'/'));
		$this->_param = $_SERVER['QUERY_STRING'];	
	}
	
	private function defaultValueForRoute() {
		$this->_controller = 'Companies';
		$this->_action = 'showMainWindow';
		$this->_param = '';
	}
	
	private function actionExist() {
		$currentController = new $this->_controller();	
		$action = (string)$this->_action;
		
		$actionExist = method_exists($currentController , $action); 
		return $actionExist;	
	}
	
	public function Route() {
		$currentController = new $this->_controller();	
		$action = (string)$this->_action;

		if ($this->_param !== '') {
			// select value param
		    parse_str($this->_param, $arrArg);  // parse QUERY_STRING in array
			call_user_func_array(array($currentController, $action), $arrArg);
		} else  {
			$arg = '';
		    $currentController->$action ($arg);
		}
	}
	
	public function setBoby($body) {
		$this->_body = $body;
	}
	
	public function getBody() {
		return $this->_body ;
	}
}
?>