<?php

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

    function __autoload ($class)
	{
		require_once  ($class . '.php');
	}

	$userId;
	$name;
	$email;
	$companyId;

	$userControler = new users();
	$myModel = $userControler->getModel();
	$table = $myModel->getTableName();
	
	$usersTotal;
   
	// Edit user
	if ($_SERVER['REQUEST_METHOD'] == "POST") {		 	
		getDataFromPOST();  	
		$result =  $myModel->updateUser ($userId,  $name, $email, $companyId);
	
		totalUsersInBD();
	
		 if ($result > 0) {
			$responseDB = array( "1" , "User was updated", "$usersTotal");
		} else {
			$responseDB = array( "2" , "Can't update!");	 		
		}
			echo json_encode($responseDB);
	}
   
   //Add new user
	if ($_SERVER['REQUEST_METHOD'] == "PUT") {		 	
		getDataFromFInput();
		$result =  $myModel->addNewUser ($name, $email, $companyId);
		
		totalUsersInBD();
		
		if ($result > 0) {
			$responseDB = array( "1" , "User was added", "$usersTotal");
		} else {
			$responseDB = array( "2" , "Can't add user!");	 		
		}
			echo json_encode($responseDB);
	}
	  
	// Delete user   
	if ($_SERVER['REQUEST_METHOD'] == "DELETE") {		 	
		getDataFromFInput();
		$result =  $myModel->deleteUser($userId);
		  
		 totalUsersInBD(); 
		  
		if ($result > 0) {
			$responseDB = array( "1" , "User was deleted", "$usersTotal");
		} else {
			$responseDB = array( "2" , "Can't delete user!");	 		
		}
		
		echo json_encode($responseDB);
	}
	   
	   
	   
	function getDataFromPOST () {
		$data = json_decode($_POST["user"]);
  
		global  $userId, $name, $email, $companyId;
	   
		$userId = $data[0]->value;
		$name = $data[1]->value;
		$email = $data[2]->value;
		$companyId = $data[3]->value;
	}
   
	function getDataFromFInput () {
		$data = file_get_contents("php://input");
		$posEquilMark =  strpos($data,"=");
		$fields =  substr($data, $posEquilMark + 1);
		$array = json_decode($fields);
	    
		global  $userId, $name, $email, $companyId;
	   
		$userId = $array[0]->value;
		$name = $array[1]->value;
		$email = $array[2]->value;
		$companyId = $array[3]->value;
	}	   

	function totalUsersInBD() {
		global $myModel,  $usersTotal;
		
		// How many users in BD
		$allUsers = $myModel->totalUsers();  
		$usersTotal = mysql_num_rows($allUsers);
	}

    

?>