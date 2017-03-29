<?php

class Users extends AbstractController implements InterfaceController {
	
	//Main	window
	 protected  $_myUserModel, $_totalUsers, $_mySorter;
	
	//AJAX page for users
     private static  $_pathForPage = '/Users/showMainWindow/?page=';             
	protected  $_currentPage, $_myPaginator;
		
	function __construct() {
		//Get initial param from config.txt 
		ReadConfig::getInstance();
		$this->_perPage = ReadConfig::getValue ('per_page');
		
		$this->_myUserModel = new usersModel();
		$this->setOrderBy();
		$this->_mySorter = new Sorter($this->_myUserModel, self::$_pathForPage);
		$this->totalUsersInBD();
	}
	
	public function showMainWindow() {
		$mc = FrontController::getInstance();
		ob_start();
		
		// Template of main window
	     include 'application/views/usersMainView.php';
		$documentHTML = ob_get_clean();
		$mc->setBoby($documentHTML);
	}
	
	public function getModel() {
		return $this->_myUserModel;
	}

	public function listUsersOnCurrentPage($currentPage = 1) {				
		$this->_currentPage = $this->calculateCurrentPage ($currentPage, $this->_totalUsers);	
          $this->_myPaginator = new Paginator(self::$_pathForPage, $this->_currentPage, $this->_totalUsers);
		
		$listUser = $this->_myUserModel->getUsersOnCurrentPage($this->_currentPage);
		// Prepare array of links for users
		while ($row = mysql_fetch_assoc($listUser)) {
			$key = $row["IdUser"];
			$userLink["$key"]["IdUser"]= $row["IdUser"];
			$userLink["$key"]["Name"]= $row["Name"];
			$userLink["$key"]["Email"]= $row["Email"];			
		 	$userLink["$key"]["IdCompany"]= $row["IdCompany"];
			$userLink["$key"]["CompanyName"]= $row["CompanyName"];
		}
		
		ob_start();
		
		// Show result of work
	     include 'application/views/usersView.php';
		$documentHTML = ob_get_clean();
		
		return $documentHTML;
	}
	
	private function setOrderBy() {
		$order = trim($_REQUEST['orderBy']);
		if (!empty($order)){
			 $tableName = $this->_myUserModel->getTableName();
			if ($order == "Company") {
				// order for Company name but not Company ID (relationship tables)
				$_SESSION[$tableName] = "CompanyName";
			} else {
				$_SESSION[$tableName] = $order;
			}	
		}
	}
	
	private function totalUsersInBD() {				
		// How many users in BD
		$allUsers = $this->_myUserModel->totalUsers();
		$this->_totalUsers = mysql_num_rows($allUsers);
	}
}
?>