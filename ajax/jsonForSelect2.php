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
	
	parse_str($_SERVER['QUERY_STRING'], $arrArg);

	$myComp = new compModel();
	$listComp = $myComp->getCompaniesForSelectField($arrArg[q]);

	// Prepare array of links for company
	$companyJSON = '{"items": [';
	
	if ($listComp)  {
		while ($row = mysql_fetch_assoc($listComp)) {
			$compLink["id"] = $row["IdCompany"];
			$compLink["item"] = $row["CompanyName"];
			
			$companyJSON .= json_encode($compLink) . ',';
		} 			
		$companyJSON =	rtrim($companyJSON , ",");
	}
	
	$companyJSON .= ']}';
	
	header('Content-Type: application/json');
	echo $companyJSON;
?>