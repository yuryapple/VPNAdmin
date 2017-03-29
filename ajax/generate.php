<?php
session_start();
//set_include_path(get_include_path()
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/'	 
//    .PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/application'
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/application/controllers'
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/application/models'
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/application/views'
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/ajax'
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/image'
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/styles'
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/utilites/bootstrap/css'
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/utilites/bootstrap/fonts'
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/utilites/bootstrap/js');

	
	
	function my_autoloader($class) {
	    require_once ($class.'.php');
	}

	//Composer will be add new autoload for Faker (later)
    spl_autoload_register('my_autoloader');

	$abusersController = new abusers();

    $between = trim($_REQUEST['between']);
    $month = trim($_REQUEST['month']);
	$showReportIn = trim($_REQUEST['showReportIn']);
	
	if (!empty($month)) {
		$abusersController->generate($month-1);

		$recordsTotal = $abusersController->getTotalRecords();
		$response = array( "$month",  "$recordsTotal");
		echo json_encode($response);
    }
	
	if (!empty($between)) {
		$abusersController->report($between); 
		echo $between;
    }	
	
	if (!empty($showReportIn)) {
		$bodyReport =  $abusersController->showReport($showReportIn);
		echo $bodyReport;
    }	
?>