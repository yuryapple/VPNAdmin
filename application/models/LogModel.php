<?php
class logModel extends commonDb {
	private static $_tableName = 'TransferLogs';

	public function  addNewUsersToLog ($values) {
		$fields = "UserId, User, Date, Resource, Transferred, CompanyName, Quota";
		$res = $this->insert(self::$_tableName, $fields, $values);
		return $res;
	}

	public function  clearAllRecords () {
		$whereCond = ' 1';
		$res = $this->delete(self::$_tableName, $whereCond);
		return $res; 
	}
     
	public function  getMaxDateInLog () {
		$selectCond = ' MAX(Date) ';
		$whereCond = ' 1';
		$res = $this->select($selectCond, self::$_tableName, $whereCond);
		return $res; 
	}
	 	 
	public function createViewForBetweenDate($nameView, $selectCond, $selectCondFunction, $whereFields, $whereCond,  $orderField, $groupField) {
		$res = $this->createView($nameView, $selectCond, $selectCondFunction, self::$_tableName, $whereFields, $whereCond, $orderField, $groupField);
		return $res; 
	}
	 
	public function  getAbusers () {
		$selectCond = ' * ';
		$whereCond = ' Quota < TotalTransferred ';
		$tableName = "reportofmonth";
		$orderField =  " TotalTransferred DESC";
		$res = $this->select($selectCond, $tableName, $whereCond, $orderField);
		return $res; 
	}
	 
	public function totalUsersLog() {
		$selectCond = '*';
		$whereCond = '1';
		$totalUser = $this->select($selectCond ,self::$_tableName , $whereCond);
		return $totalUser;
	}
}
?>
