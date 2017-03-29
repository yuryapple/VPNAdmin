<?php

class compModel extends commonDb {
	private $_perPage;
	private static $_tableName = 'Companies';
		
	function __construct() {
		parent::__construct();
	 	ReadConfig::getInstance();
		$this->_perPage = ReadConfig::getValue ('per_page');
	}
	
	public function getAllCompanies() {
		$selectCond = '*';
		$whereCond = '1';
		$orderField =  (isset($_SESSION[self::$_tableName])) ? $_SESSION[self::$_tableName] : "";
		$allComp = $this->select($selectCond, self::$_tableName, $whereCond, $orderField);
		
		return $allComp;
	}

    public function getCompOnCurrentPage($page = 1) {
		$selectCond = '*';
	    $numberOfFirstRecorOnCurrentPage = (($page - 1) * $this->_perPage);
		$whereCond = '1';
		$orderField =  (isset($_SESSION[self::$_tableName])) ? $_SESSION[self::$_tableName] : "";
		$groupField = "notField";
		$limit = " " . $numberOfFirstRecorOnCurrentPage . " , " . $this->_perPage;

		$allCompOnCurrentPage = $this->select($selectCond, self::$_tableName, $whereCond, $orderField ,$groupField , $limit );
		return $allCompOnCurrentPage;
	}
		
	//Result for   Select2  (JQuery lib   see utilites directory)	
	public function getCompaniesForSelectField($partOfCompName) {
		$selectCond = '*';
		$whereCond =  " CompanyName LIKE '" . $partOfCompName . "%' ";
		$allComp = $this->select($selectCond, self::$_tableName, $whereCond);
		return $allComp;
	}
	
	public function getTableName() {
		return self::$_tableName;
	}
	
	public function getAllFieldsName() {
		$listOfFieldsTable  =  $this->show(self::$_tableName);
		return $listOfFieldsTable;
	}
	
	public function getNameNotBelongCompany($company, $compId) {
		$selectCond = '*';
		$whereCond = 'CompanyName = "' . $company . '" AND IdCompany != ' .  $compId ; 
		$otherCompaniesHasThisName = $this->select($selectCond, self::$_tableName, $whereCond);
		return $otherCompaniesHasThisName;
	}
	
	public function updateCompany ($compId,  $company, $quota) {
		$fields = "IdCompany = " . $compId . ", CompanyName = " . $this->strForTable($company) . ", Quota = " . $quota ;
		$whereCond = 'IdCompany = ' . $compId ;
		$numUpdateRecords = $this->update(self::$_tableName, $fields, $whereCond );
		return $numUpdateRecords;
	}	
	
	public function  addNewCompany($company, $quota) {
		$fields = "CompanyName, Quota";
		$value = $this->strForTable($company) . ' , ' . $quota;	
		$res = $this->insert(self::$_tableName, $fields, $value);
		return $res;
	}

	public function  deleteCompany($compId) {
		$whereCond = ' IdCompany = ' . $compId ; ;	
		$res = $this->delete(self::$_tableName, $whereCond);
		return $res;
	}	
}
?>