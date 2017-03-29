<?php
// Modal window about VPN 
echo '
    <!-- Modal -->
    <div class="modal fade" id="aboutWindow" role="dialog">
        <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
            
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="headerForm"  class="modal-title">About VPN admin.</h4>
                </div>
                
                <div class="modal-body"  id="bodyAbout">
                    <h4>Components and libraries.</h4>
                    
                    Faker - for random data generated. <br>
                    Carbon - for working with dates. <br>
                    Select2 - for the dropdown component. <br>
                    Bootstrap - for general UI. <br>
                    jQuery validate - for input validation on the client. <br>
                    Template - Dashboard basic structure for an admin dashboard with fixed sidebar and navbar.<br>
                    
                   <p class="small  text-right"> Version 1.0.1  2017</p>
                </div>       
            
            </div>
        </div>
    </div> ';
?>