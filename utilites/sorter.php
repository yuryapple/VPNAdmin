<?php

class Sorter {

	private $_model, $_fields, $_pathForPage ;
	
	function __construct($model, $pathForPage) {
		$this->_model = $model;
		$this->_pathForPage = $pathForPage;
		$this->getFieldsName();
		$this->setFieldNameForOrderToSesion();
	}
  
	private function getFieldsName() {
		$this->_fields = Array();
		$listFields = $this->_model->getAllFieldsName();
		while ($row = mysql_fetch_assoc($listFields)) {
			if ($row["Key"]  != "PRI") {
		   	$this->_fields[] = $row["Field"];
		   }					
		}
	}
	
	
	 public function show() 
	{
		$tableName =  $this->_model->getTableName();
		
		$strPrint  = '<label for="sel1">Order by :</label> ';
		$strPrint .= '<select class="form-control" id="sel1" onchange="location = this.value;" >';
		
		foreach ($this->_fields as $item)
		{
			// Case relationship tables (User and Company)
			if ($_SESSION[$tableName] == $item or ($_SESSION[$tableName] == "CompanyName" and $item == "Company")) {	
				$strPrint .= ' <option selected value = "' . $this->_pathForPage . '1&orderBy=' . $item   . '">' .  $item . '</option>';
			} else {
				$strPrint .= ' <option  value = "' .  $this->_pathForPage .    '1&orderBy=' . $item   . '">' .  $item . '</option>';	
			}	  
		  
		}
		$strPrint .= ' </select>';
		echo $strPrint;
	}
	
	private function setFieldNameForOrderToSesion() 
	{
		$tableName =  $this->_model->getTableName();
		
		if (!isset($_SESSION[$tableName])) {
			$_SESSION[$tableName] = $this->_fields[0];
		}
	}	
}
?>