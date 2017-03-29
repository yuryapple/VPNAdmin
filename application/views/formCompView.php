<?php
// Modal form for ADD-ING, DELET-ING  and EDIT-ING companies  data 
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
                    <form    id="compForm"  enctype="application/json"  autocomplete="off" >
                        
                        <div class="form-group">
                            <input type="hidden" name="compId"  class="form-control" id="compId">
                        </div>								
                        
                        <div class="form-group">
                            <label   for="company">Company: <span></span> </label>
                            <input name="company"  class="form-control" id="company" placeholder="Enter name of company">
                        </div>
                        
                        <div class="form-group">
                            <label for="quota" >Quota  0.001-99.999 TB : <span></span></label>
                            <input name="quota" class="form-control" id="quota" placeholder="Enter quota">
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