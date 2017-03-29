<?php
session_start();

//set_include_path(get_include_path() 
//	.PATH_SEPARATOR. 'application'
//	.PATH_SEPARATOR. 'application/controllers'
//	.PATH_SEPARATOR. 'application/models'
//	.PATH_SEPARATOR. 'application/views'
//	.PATH_SEPARATOR. 'ajax'
	//.PATH_SEPARATOR. 'image'
	//.PATH_SEPARATOR. 'styles'
	//.PATH_SEPARATOR. 'utilites'
	//.PATH_SEPARATOR. 'javaScript'
	//.PATH_SEPARATOR. 'utilites/vendor'
	//.PATH_SEPARATOR. 'utilites/bootstrap/css'
	//.PATH_SEPARATOR. 'utilites/bootstrap/fonts'
	//.PATH_SEPARATOR. 'utilites/bootstrap/js');
	


	function my_autoloader($class) {
	    require_once ($class.'.php');
	}

	//Composer will be add new autoload for Faker (later)
    spl_autoload_register('my_autoloader');
	
    require $_SERVER["DOCUMENT_ROOT"] .'/utilites/vendor/autoload.php';
	
	$front = FrontController::getInstance();
	$front->route();
	echo $front->getBody();
?>
