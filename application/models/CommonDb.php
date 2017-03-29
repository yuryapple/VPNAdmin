<?php
class commonDb {
	private $descriptor;
	private $databaseName;
	private $host;
	private $user;
	private $password;

	public function __construct() {
		ReadConfig::getInstance();
		$this->databaseName = ReadConfig::getValue ('dataBase');
		$this->host = ReadConfig::getValue ('host');
		$this->user = ReadConfig::getValue ('user');
		$this->password = ReadConfig::getValue ('password');
	
		$this->descriptor = mysql_connect($this->host, $this->user, $this->password); 
		mysql_select_db ($this->databaseName, $this->descriptor);
	}

	private function query($query) {
		return mysql_query($query); 
	}

	protected function show($tableName) {
		$query = "SHOW FIELDS FROM " . $tableName; 
		$result = $this->query($query);
		return $result;
	}
	
	protected function select($selectCond, $tableName, $whereCond, $orderField = 'notField', $groupField ='notField' , $limit = 'notNumber') {
		$query = "SELECT " . $selectCond;
		$query .= " FROM " . $tableName .  " WHERE "; 
		$query.= $whereCond;
		
		if ($groupField != 'notField') {
			$query.= " GROUP BY $groupField"; 
		}
		
		if ($orderField != 'notField') {
			$query.= " ORDER BY $orderField"; 
		}
		
		if ($limit != 'notNumber') {
			$query.= " LIMIT $limit"; 
		}
		
		$result = $this->query($query); //result is (false or resourse)
		if (!$result) {
			return false;
		}
		elseif (mysql_num_rows($result) == 0) {
			return 0;
		} else {
			return $result;
		}
	}
	
	protected function update ($tableName, $fields, $whereCond) {
		$query = "UPDATE " . $tableName .  " SET " ;  
		$query.= $fields . ' WHERE ' . $whereCond;
		$this->query($query);
		return mysql_affected_rows();	
	}
	
	protected function delete ($tableName, $whereCond) {
		$query = "DELETE FROM " . $tableName ;  
		$query.= " WHERE" . $whereCond;
		$this->query($query);
		return mysql_affected_rows();	
	}

	protected function insert ($tableName, $fields, $value) {
		$query = "INSERT INTO " . $tableName ;  
		$query.=" (" . $fields . ") ";
		$query.= "VALUES (" . $value . ")";	
		$this->query($query);
		return mysql_affected_rows();	
	}
	
	//id last add record	
	protected function getId ()	{
		return mysql_insert_id();
	}	
		
	function __destruct() {
		if (is_resource($this->descriptor)) {
			mysql_close($this->descriptor);
		}
	}
	
	// Prepare and use mysql_real_escape_string
	function strForTable($value) {
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}

		if (!is_numeric($value)) {
			$value = "'" . mysql_real_escape_string($value) . "'";
		}
		return $value;
	}
	
	protected function createView($nameView, $selectCond, $selectCondFunction, $tableName, $whereFields, $whereCond, $orderField = 'notField', $groupField ='notField' , $limit = 'notNumber') {
		$query = "CREATE OR REPLACE VIEW " . $nameView . " AS ";
		$query .= "SELECT DISTINCT " . $selectCond . $selectCondFunction;
		$query .= " FROM " . $tableName .  " WHERE "; 
		$query.= $whereFields . " BETWEEN " . $whereCond;
	
		if ($groupField != 'notField') {
			$query.= " GROUP BY $groupField"; 
		}
		
		if ($orderField != 'notField') {
			$query.= " ORDER BY $orderField"; 
		}
		
		if ($limit != 'notNumber') {
			$query.= " LIMIT $limit"; 
		}
		
		$result = $this->query($query); //result is (false or resourse)
		if ($result) {
			return $result;
		} else  {
			return false;
		}
	}
}
?>