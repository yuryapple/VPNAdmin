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
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/utilites'
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/utilites/bootstrap/css'
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/utilites/bootstrap/fonts'
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/utilites/bootstrap/js');

	
    function __autoload ($class){
		require_once  ($class . '.php');
	}
	
	$compId;
	$company;
	$quota;
    $companiesTotal;
	   
	$companyController = new companies(); 
	$myModel = $companyController->getModel();
	$table = $myModel->getTableName();
	 
	// Edit company date   
	if ($_SERVER['REQUEST_METHOD'] == "POST") {		 	
		getDataFromPOST();  	
		$result =  $myModel->updateCompany ($compId, $company, $quota) ;
	
		totalCompInBD();
		 
		if ($result > 0) {
			$responseDB = array( "1" , "Company was updated", "$companiesTotal");
		} else {
			$responseDB = array( "2" , "Can't update!");	 		
		}
		
		echo json_encode($responseDB);
	}
	   
	// Add new company   
	if ($_SERVER['REQUEST_METHOD'] == "PUT") {		 	
		getDataFromFInput();
		$result =  $myModel->addNewCompany($company, $quota);
		
		totalCompInBD();
		
		if ($result > 0) {
			$responseDB = array( "1" , "Company was added", "$companiesTotal");
		} else {
			$responseDB = array( "2" , "Can't add company!");	 		
		}
		
		echo json_encode($responseDB);
	}
	   
	// Delete company   
	if ($_SERVER['REQUEST_METHOD'] == "DELETE") {		 	
		getDataFromFInput();
		$result =  $myModel->deleteCompany($compId);
		  
		totalCompInBD(); 
		  
		if ($result > 0) {
			$responseDB = array( "1" , "Company was deleted", "$companiesTotal");
		} else {
			$responseDB = array( "2" , "Can't delete company!");	 		
		}
		
		echo json_encode($responseDB);
	}
	   
	function getDataFromPOST () {
	  $data = json_decode($_POST["user"]);
  
	  global $compId, $company,  $quota;
	   
	   $compId = $data[0]->value;
	   $company = trim($data[1]->value);
	   $quota = $data[2]->value;
	}
 
	function getDataFromFInput () {
		$data = file_get_contents("php://input");
		$posEquilMark =  strpos($data,"=");
		$fields =  substr($data, $posEquilMark + 1);
		$array = json_decode($fields);
	  	  
		global $compId, $company,  $quota;
	   
		$compId = $array[0]->value;
		$company = trim($array[1]->value);
		$quota = $array[2]->value;
	}	   

	function totalCompInBD() {  
		global $myModel,  $companiesTotal;
	  
		// How many companies in BD
		$allComp = $myModel->getAllCompanies();  
		$companiesTotal = mysql_num_rows($allComp);
	}
?>