<?php

class Paginator
{
	
	// Paginator
	protected $_perPage, $_paginatorLength;
	
	protected $_path, $_currentPage, $_totalUsers;
	
	protected $_startPageOnPaginator, $_finishPageOnPaginator,  $_arraySF;  

	function __construct($path, $curPage, $totalUsers) {
	 	//Get initial param from config.txt 
		ReadConfig::getInstance();
		$this->_perPage = ReadConfig::getValue ('per_page');
		$this->_paginatorLength = ReadConfig::getValue ('paginatorLength');

		$this->_path = $path;
		$this->_currentPage = $curPage;
	    $this->_totalUsers = $totalUsers;
		
		$this->calculateEstimateOffsetStartFinishPageOnPaginator();
		$this->calculateStartFinishPage();
	}

	
	function show () {
		$this->build ($this->_path, $this->_startPageOnPaginator,  $this->_currentPage, $this->_finishPageOnPaginator); 
	}
	
	private function calculateEstimateOffsetStartFinishPageOnPaginator () {
		$middlePageOnPaginator = ceil ($this->_paginatorLength / 2);
		$offsetStartPageOnPaginator =   $middlePageOnPaginator - 1;   //Offset
		$offsetFinishPageOnPaginator =   $this->_paginatorLength - $middlePageOnPaginator; //Offset
		
		$this->_arraySF = array("offsetStart"=>$offsetStartPageOnPaginator,
					 "offsetFinish"=>$offsetFinishPageOnPaginator);
	}
	
	
	private function calculateStartFinishPage () {
		do {
			// Calculete and return redundant pages (if they exist else return 0)
			$addPagesToFinish = $this->calculateStartPage($this->_currentPage);
			$addPagesToStart = $this->calculateFinishPage($this->_currentPage, $this->_totalUsers );	
			// Change offset value for start and finish pages
			$this->_arraySF["offsetStart"] += $addPagesToStart;
			$this->_arraySF["offsetFinish"] += $addPagesToFinish;
		} while ($addPagesToFinish != 0 or  $addPagesToStart != 0); 
	}
	
	private function calculateStartPage ($currentPage) {
		static $lockChangeValueStartPageOnPaginator = false;
		$addPagesToFinish = 0;
			
		if (!$lockChangeValueStartPageOnPaginator) {	
			$totalRecorsBeforeCurrentPage =  ($currentPage - 1) * $this->_perPage;  
			$totalPagesBeforeCurrentPage = ceil($totalRecorsBeforeCurrentPage / $this->_perPage);
				
			if ($totalPagesBeforeCurrentPage >= $this->_arraySF["offsetStart"]) {
				// Calculate
				$this->_startPageOnPaginator = $currentPage - $this->_arraySF["offsetStart"];
				return $addPagesToFinish;
			} else {
				$lockChangeValueStartPageOnPaginator = true;
				$this->_startPageOnPaginator = $currentPage -  $totalPagesBeforeCurrentPage;
				$addPagesToFinish = $this->_arraySF["offsetStart"] - $totalPagesBeforeCurrentPage;
				return $addPagesToFinish;
			}		
		} else {
			return $addPagesToFinish;
		}
	}
	

	private function calculateFinishPage ($currentPage, $totalUsersInDB) {
		static $lockChangeValueFinishPageOnPaginator = false;
		$addPagesToStart = 0; 
		
		if (!$lockChangeValueFinishPageOnPaginator) {
			$totalRecorsdAfterCurrentPage = $totalUsersInDB - ($currentPage * $this->_perPage);  
			$totalPagesAfterCurrentPage = ceil($totalRecorsdAfterCurrentPage / $this->_perPage);
						
			if ($totalPagesAfterCurrentPage >= $this->_arraySF["offsetFinish"]) {
				//  Calculate
				$this->_finishPageOnPaginator = $currentPage + $this->_arraySF["offsetFinish"];
				return $addPagesToStart;
			} else {
				$lockChangeValueFinishPageOnPaginator = true;
				//  Calculate
				$this->_finishPageOnPaginator = $currentPage + $totalPagesAfterCurrentPage;
				$addPagesToStart = $this->_arraySF["offsetFinish"] - $totalPagesAfterCurrentPage;
				return $addPagesToStart;
			}
		} else {
			return $addPagesToStart;	
		}		
	}

	private function build ($pathController, $startPage = 1,  $currentPage = 1, $finishPage = 1) {
        $strPrint = ' <div class="panel-footer  text-center">';
        $strPrint .= '<ul class="pagination"> ';
        
        for ($p = $startPage; $p <= $finishPage; $p++) {
            if ($p == $currentPage ) {
                 $strPrint .= '<li class="active"><a href="'. $pathController . $p . '">' . $p .'</a></li>';
            } else {
                  $strPrint .= '<li><a href="'. $pathController . $p . '">' . $p .'</a></li>';
            }
        }
        
        $strPrint .= '</ul>';
        $strPrint .= '</div>';
       								
      echo $strPrint;             
	}
}   
?>