<?php
class usersModel extends commonDb {
	private $_perPage;
	private static $_tableName = 'Users';

	function __construct() {
		parent::__construct();
	 	ReadConfig::getInstance();
		$this->_perPage = ReadConfig::getValue ('per_page');
	}
	
	public function getUsersOnCurrentPage($page = 1) {
		$selectCond = '*';
		$_tablesJoin =  self::$_tableName  . " INNER JOIN  Companies  ON Users.Company = Companies.IdCompany ";
		
	    $numberOfFirstRecorOnCurrentPage = (($page - 1) * $this->_perPage);
		$whereCond = '1';
		$orderField =  (isset($_SESSION[self::$_tableName])) ? $_SESSION[self::$_tableName] : "";
		$groupField = "notField";
		$limit = " " . $numberOfFirstRecorOnCurrentPage . " , " . $this->_perPage;

		$allUsersOnCurrentPage = $this->select($selectCond, $_tablesJoin, $whereCond, $orderField ,$groupField , $limit );
		return $allUsersOnCurrentPage;
	}

	
	public function getTableName() {
		return self::$_tableName;
	}
	
	public function getAllFieldsName() {
		$listOfFieldsTable  =  $this->show(self::$_tableName);
		return $listOfFieldsTable;
	}
	
	public function getEmailNotBelongUser( $email, $userId) {
		$selectCond = '*';
		$whereCond = 'Email = "' . $email . '" AND IdUser != ' .  $userId ; 
		
		$otherUserHasThisEmail = $this->select($selectCond, self::$_tableName, $whereCond);
		return $otherUserHasThisEmail;
	}
	
	public function totalUsers() {
		$selectCond = '*';
		$_tablesJoin =  self::$_tableName  . " INNER JOIN  Companies  ON Users.Company = Companies.IdCompany ";
		$whereCond = '1';
		$totalUser = $this->select($selectCond ,$_tablesJoin , $whereCond);
		return $totalUser;
	}
	
	public function updateUser ($userId,  $name, $email, $companyId) {
		$fields = "Name = " . $this->strForTable($name) . ", Email = " . $this->strForTable($email) . ", Company = " . $this->strForTable($companyId)  ;
		$whereCond = 'IdUser = ' . $userId ;
		$numUpdateRecords = $this->update(self::$_tableName, $fields, $whereCond );
		return $numUpdateRecords;
	}
		
	public function  addNewUser($name, $email, $companyId) {
		$fields = "Name, Email, Company";
		$value = $this->strForTable($name) . ' , ' . $this->strForTable($email) . ' , ' . $this->strForTable($companyId);	
		$res = $this->insert(self::$_tableName, $fields, $value);
		return $res;
	}
	
	public function  deleteUser($userId) {
		$whereCond = ' IdUser = ' . $userId ;	
		$res = $this->delete(self::$_tableName, $whereCond);
		return $res;
	}	

}
?>
