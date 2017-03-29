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
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/utilites/bootstrap/css'
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/utilites/bootstrap/fonts'
//	.PATH_SEPARATOR. $_SERVER["DOCUMENT_ROOT"] .  '/utilites/bootstrap/js');
	

	function __autoload ($class) {
		require_once  ($class . '.php');
	}

    $email = trim($_REQUEST['email']);
    $userId = trim($_REQUEST['userId']);

    $myUser = new usersModel();
	$emailExist = $myUser->getEmailNotBelongUser( $email, $userId);
    
    if ($emailExist) {
        echo "false";
    } else {
       echo "true";
    }
?>