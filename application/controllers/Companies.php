<?php
                  
class Companies extends AbstractController implements InterfaceController {
	
	//Main	window
	protected  $_myCompModel, $_totalComp, $_mySorter;
	 
	//AJAX page for users
	private static  $_pathForPage = '/Companies/showMainWindow/?page=';
     protected  $_currentPage, $_myPaginator ;
	
	function __construct() {
		//Get initial param from config.txt 
		ReadConfig::getInstance();
		$this->_perPage = ReadConfig::getValue ('per_page');
	 	
		$this->_myCompModel = new compModel();
		$this->setOrderBy();
		$this->_mySorter = new Sorter($this->_myCompModel, self::$_pathForPage);
		$this->totalNumbersCompaniesBD();
	}
	
	public function showMainWindow() {
		$mc = FrontController::getInstance();
		ob_start();
		
		// Template of main window
	    include 'application/views/companiesMainView.php';
		$documentHTML = ob_get_clean();
		$mc->setBoby($documentHTML);
	}
	
	public function listCompOnCurrentPage($currentPage = 1) {				
		$this->_currentPage = $this->calculateCurrentPage ($currentPage, $this->_totalComp);
          $this->_myPaginator = new Paginator(self::$_pathForPage, $this->_currentPage, $this->_totalComp);
		$listComp = $this->_myCompModel->getCompOnCurrentPage($this->_currentPage);
		
		// Prepare array of links for company
		while ($row = mysql_fetch_assoc($listComp)) {
			$key = $row["IdCompany"];
			$compLink["$key"]["IdCompany"]= $row["IdCompany"];
			$compLink["$key"]["CompanyName"]= $row["CompanyName"];
			$compLink["$key"]["Quota"]= $row["Quota"];
			$compLink["$key"]["QuotaTB"]= $this->convertTBorGB( $row["Quota"] );			
		} 
		
		ob_start();
		
		// Show result of work
	    include 'application/views/companiesView.php';
		$documentHTML = ob_get_clean();
		
		return $documentHTML;
	}
	
	public function getModel() {
		return $this->_myCompModel;
	}
	
	private function convertTBorGB($quota) {
		if (($quota / 1) >= 1) {
		   return (float)$quota . " TB";	
		} else {
		   return str_replace("0.", "", $quota) . " GB";
		}			
	}
	
	private function setOrderBy() {
		$order = trim($_REQUEST['orderBy']);
		if (!empty($order)){
		     $tableName = $this->_myCompModel->getTableName();
			 $_SESSION[$tableName] = $order;	
		}
	}
	
	private function totalNumbersCompaniesBD() {				
		// How many companies in BD
		$allCompanies = $this->_myCompModel->getAllCompanies();
		$this->_totalComp = mysql_num_rows($allCompanies);
	}	
}
?>