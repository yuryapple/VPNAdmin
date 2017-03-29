<?php
//Use Faker
require $_SERVER["DOCUMENT_ROOT"] .'/utilites/vendor/autoload.php';

//Use Carbon
require $_SERVER["DOCUMENT_ROOT"] . '/utilites/carbon/Carbon.php';

use Carbon\Carbon;

class Abusers implements InterfaceController {

	protected  $_myLogModel, $_cuttentDate, $_maxDateInLogForSelector , $_arrayForSelector, $_totalUsersLog;

	function __construct() {
		$this->_myLogModel = new logModel();
		
	    $this->totalUsersLogInBD();	
		// Carbon
		date_default_timezone_set("Europe/London");
		$this->_cuttentDate =  Carbon::now();
	}

	function showMainWindow($warning = 0) {
		//It will be used for selector of months
		$maxDateInLogForSelector = $this->_myLogModel->getMaxDateInLog();
	    $row = mysql_fetch_array($maxDateInLogForSelector); 
		$maxDateInLogForSelectorStr =  $row["MAX(Date)"];
		
		$this->_maxDateInLogForSelector = new Carbon($maxDateInLogForSelectorStr);  
		
		$this->prepareArrayForSelector();
		
		$mc = FrontController::getInstance();
		ob_start();
        include 'application/views/abusersView.php';
        $documentHTML = ob_get_clean();
		$mc->setBoby($documentHTML);
	}
		
	function generate($month = 0) {
	    //prepare log for new date
        if ($month == 0) {
			$this->_myLogModel->clearAllRecords();
		}
				
		$faker = Faker\Factory::create();
								
		//Get all users 
		$myUser = new usersModel();
		$listAllUsers = $myUser->totalUsers();
	
		$startDay = $this->_cuttentDate->copy()->subMonth($month)->startOfMonth();
		$endDay = $this->_cuttentDate->copy()->subMonth($month)->endOfMonth();
		
			//Days	
			for ($curDay= $startDay->copy() ; $curDay <= $endDay and $curDay <= $this->_cuttentDate; $curDay->addDay()) {
											
				//Users
				$values = null;
				mysql_data_seek($listAllUsers, 0);
				while ($row = mysql_fetch_assoc($listAllUsers)) {
					
					//visite per day
					$visitPerDay = $faker->numberBetween($min = 0, $max = 2);
	
					for ($j=1; $j <= $visitPerDay; $j++) {						
						$values .= "'" .  $row['IdUser'] . "', '" .   mysql_real_escape_string($row['Name'])  . "', '"
							. $faker->dateTimeBetween($startDate = $curDay->copy()->startOfDay(), $endDate = $curDay->copy()->endOfDay(), $timezone = date_default_timezone_get())->format('Y-m-d H:i:s')  . "', '"
							. $faker->url . "', '" . $faker->randomFloat($nbMaxDecimals = 10, $min = 0.0000000001, $max = 1) . "', '"
							.   mysql_real_escape_string($row['CompanyName']) . "', '" .  $row['Quota'] . "') , (";
					}
				}
				
				$values = rtrim($values,") , (") ;
				
				$this->_myLogModel->addNewUsersToLog($values);
			}
	
		 $this->totalUsersLogInBD();
	}
	

	private function prepareArrayForSelector () {				
		for ($i=0; $i <= 5; $i++) {
			$this->_arrayForSelector[$this->_maxDateInLogForSelector->copy()->subMonth($i)->startOfMonth()->format('F')]  =  "'" . $this->_maxDateInLogForSelector->copy()->subMonth($i)->startOfMonth()->format('Y-m-d H:i:s') . "' and '". $this->_maxDateInLogForSelector->copy()->subMonth($i)->endOfMonth()->format('Y-m-d H:i:s') ."'";
		}
	 }
	
	
	public function report($month) {
	    $nameView = "ReportOfMonth";
		$selectCond = "CompanyName, Quota";
		$selectCondFunction = ",  Sum(Transferred) AS TotalTransferred";
		$whereFields = "Date";
		$whereCond = $month;
		$orderField = "notField";
		$groupField = "CompanyName, Quota";
		
		$this->_myLogModel->createViewForBetweenDate($nameView, $selectCond, $selectCondFunction, $whereFields, $whereCond,  $orderField, $groupField);
	}
	
	public function getTotalRecords() {
		return $this->_totalUsersLog ;
	}	


	public function getModel() {
		return $this->_myLogModel;
	}
	
	public function showReport($between) {				
		$listAbuser = $this->_myLogModel->getAbusers();
		
		// Prepare array of linksAbusers for users
		while ($row = mysql_fetch_assoc($listAbuser)) {
			$key = $row["CompanyName"];
			$abuseLink["$key"]["CompanyName"]= $row["CompanyName"];
			$abuseLink["$key"]["Quota"]= $this->convertTBorGB($row["Quota"]);
			$abuseLink["$key"]["TotalTransferred"]= $this->convertTBorGB($row["TotalTransferred"]);
			$abuseLink["$key"]["Abuse"]= $this->convertTBorGB($row["TotalTransferred"] - $row["Quota"]);
		}
		
		ob_start();	
		// Show result of work
	        include 'application/views/reportView.php';
		$documentHTML = ob_get_clean();
		
		return $documentHTML;
	}
	
	private function convertTBorGB($trans) {
		$trans	= round($trans , 3);
			
		if (($trans / 1) >= 1) {
		   return (float)$trans . " TB";	
		} else {
		   return str_replace("0.", "", $trans) . " GB";
		}		
			
	}
	
	private function totalUsersLogInBD() {				
		// How many users log in BD
		$allUsersLog = $this->_myLogModel->totalUsersLog();
		$this->_totalUsersLog  =  mysql_num_rows($allUsersLog);
	}
}
?>