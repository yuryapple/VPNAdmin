<?php
                  
abstract class AbstractController {
 
    protected   $_perPage;
	
	// For example: We have total 5 pages in BD  but request 6 page
	//   (On 6 page was 1 record then it was removed.  So 6 page does not exist)
	protected function calculateCurrentPage ($currentPage, $totalCompInDB) {	
		 $lastNumberOfRecorsdOnCurrentPage = $currentPage * $this->_perPage;
		
		if ($lastNumberOfRecorsdOnCurrentPage > $totalCompInDB) {
		  $totalPagesInDB =  ceil($totalCompInDB / $this->_perPage);	
		  $currentPage = $totalPagesInDB;	
		  return $currentPage;
		} else {
		  return $currentPage;
		}
	}
}
?>