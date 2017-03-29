<?php
// Modal form for ADD-ING, DELET-ING  and EDIT-ING user's  data 
echo '
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="headerForm"  class="modal-title">Edit user</h4>
                </div>
                
                
            
                <div class="modal-body">
                    <form  id="userForm"  enctype="application/json"  autocomplete="off" >
                    
                        <div class="form-group">
                            <input type="hidden" name="userId"  class="form-control" id="userId">
                        </div>								
                    
                        <div class="form-group">
                            <label   for="name">Name: <span></span> </label>
                            <input name="name"  class="form-control" id="name" placeholder="Enter name">
                        </div>
                    
                        <div class="form-group">
                            <label for="email" >Email: <span></span></label>
                            <input name="email" type="email" class="form-control" id="email" placeholder="Enter email">
                        </div>
                        
                        <div class="form-group">
                            <label for="companySelector">Company:  <span> </span> </label>
                            <select  id="companySelector" name="companySelector" class="form-control js-data-example-ajax" style="width: 100%" required >
                                <option class="form-control"> </option>
                             </select> 
                        </div>

                        <div class="form-group"> 
                            <button type="submit" class="btn btn-block" id="form-submit" >Submit</button>
                        </div>
                    </form>
            
                    <div id="massageFromServer" style="display: none"  class="panel">
                        <div class="panel-heading">
                             <p id="reportFromBD"></p>
                        </div>
                    </div>        
                </div>
                    
            </div>
        </div>
    </div> ';
?>