$(document).ready(function() {
    // load start page in main mindow 
    loadPage(1);


   function loadPage (page){               
        $("#usersPage").load("/ajax/loadCurrentUserPage.php", "page=" + page, function(responseTxt, statusTxt, xhr){
        if(statusTxt == "success")
            setEventOnLoadedElement();
        if(statusTxt == "error")
            alert("Error: " + xhr.status + ": " + xhr.statusText);
        });
    } 

    // Global variable  
    var METHOD_HTTP;

    function  setEventOnLoadedElement() {
         
        // User click paginator
        $(".pagination li a").click(function (event) {   
            event.preventDefault();
               
            // get number of page from url
            var link = $(this).attr("href");
            var posEquelMask = link.lastIndexOf("=");
            var page = link.substr(posEquelMask + 1);
               
            loadPage(page);
        });
         
        // User ckick CLOSE button
        $(".close").click( function () {
            // Get nunber current page from paginator  
            $numberPage = $(".pagination li.active").text();
                
            //Udate page (load)
            loadPage($numberPage);
         });
 
         //User click button ADD  user
        $(".btn-add-record").click(function(){
                  
            METHOD_HTTP = "PUT";
            
            $("#headerForm").text("Add user");
            $("#form-submit").text("Add");
            $("#form-submit").removeClass("btn-warning btn-danger");
            $("#form-submit").addClass("btn-success");
           
             refrashForm();
             
            // Empty values  (default)
            fillFields();
            readOnlyFieldsOff();
             
            showModalForm();   
        });        
         
         //User click button EDIT 
        $(".btn-edit-record").click(function(){
    
            METHOD_HTTP = "POST";         
    
            $("#headerForm").text("Edit user");
            $("#form-submit").text("Edit");
            $("#form-submit").removeClass("btn-success  btn-danger");
            $("#form-submit").addClass("btn-warning");
     
            // Refresh form
            refrashForm();
              
            // get date from selected row of table and insert it in form 
            var parentTD = $(this).parent();
              
            var userId = $(parentTD).siblings("td:eq(0)").text();
            var nameUser = $(parentTD).siblings("td:eq(1)").text();
            var emailUser = $(parentTD).siblings("td:eq(2)").text();
            var companyUser = $(parentTD).siblings("td:eq(3)").text();
            var companyId = $(parentTD).siblings("td:eq(4)").text();
              
            // Fill fields of form 
            fillFields (userId, nameUser, emailUser, companyUser, companyId); 
            readOnlyFieldsOff();
            showModalForm();
        });
         
         //User click button Delete
        $(".btn-delete-record").click(function(){
         
            METHOD_HTTP = "DELETE";         
   
            $("#headerForm").text("Delete user");
            $("#form-submit").text("Delete");
            $("#form-submit").removeClass("btn-success  btn-warning btn-danger");
            $("#form-submit").addClass("btn-danger");
        
            // Refresh form
             refrashForm();
             
             // get date from selected row of table and insert it in form 
             var parentTD = $(this).parent();
             
             var userId = $(parentTD).siblings("td:eq(0)").text();
             var nameUser = $(parentTD).siblings("td:eq(1)").text();
             var emailUser = $(parentTD).siblings("td:eq(2)").text();
             var companyUser = $(parentTD).siblings("td:eq(3)").text();
             var companyId = $(parentTD).siblings("td:eq(4)").text();
             
             
             // Fill fields of form 
            fillFields (userId, nameUser, emailUser, companyUser, companyId);
            readOnlyFieldsOn();
             
            showModalForm();
        });
    }
            
    function refrashForm () {
        // Refresh form
        $("form")[0].reset();
        $("#userForm span").text("");
        $("#userForm").show();
        $("#massageFromServer").hide();
    }

     function fillFields (userId = "", nameUser = "", emailUser = "", companyUser = "", companyId = "") {
        $("#userId").attr("value", userId);  
        $("#name").attr("value", nameUser);
        $("#email").attr("value", emailUser);
              
        $("#companySelector option").empty();
        $("#companySelector option").append(companyUser);         
        $("#companySelector option").attr("value", companyId);
     }

     function readOnlyFieldsOn () {
        $("#name").attr("readonly", true);
        $("#email").attr("readonly", true);
        $("#companySelector").attr("disabled", true);
     }

     function readOnlyFieldsOff () {
        $("#name").attr("readonly", false);
        $("#email").attr("readonly", false);
        $("#companySelector").attr("disabled", false);
     }    
    
    function showModalForm(){
         
        // JQ library Select2    We have only Company ID but we need Company name
        $("#companySelector").select2({   
            ajax: {
                url: "/ajax/jsonForSelect2.php",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: false
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatRepo, 
            templateSelection: formatRepoSelection 
       }); 
       
       $("#myModal").modal({backdrop: "static"}); 
    }
 
    function item_or_text(obj) {        
       if (typeof(obj.item)!='undefined') {
           return (obj.item.length ? obj.item : obj.text);
       }
       return obj.text;
    }
   
    function formatRepo(data) {
       if (data.loading) return data.text;
       var markup = item_or_text(data);
       console.log('formatRepo', data, markup);
       return markup;
    }
    
    function formatRepoSelection(repo) {
        if (typeof(repo.item) != 'undefined') {
          repo.text = repo.item ;
        } 
        return repo.text;
    }
         
    // FORMA  
    //JQ Validate
    $("#userForm").validate({
        focusInvalid: false,
        focusCleanup: true,
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 25,
                letterswithbasicpunc: true       
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: "/ajax/unicEmail.php",
                    type: "post",
                    data: {
                        userId: function() { 
                            return $("#userId").val(); 
                        }
                    }
                }
            }
        },
        messages: {
            name: {
                required: "Enter user name",
                minlength: "Min 2 char",
                maxlength: "Max 25 char",
                letterswithbasicpunc: "Letters and punctuation only "
            },
            email: {
                required: "Enter email",
                email: "Incorect email",
                remote: "Another user uses this email"
            }     
        },
        errorPlacement: function(error, element) {
            var er = element.attr("name");
            error.appendTo( element.parent().find("label[for='" + er + "']").find("span") );
        },
        success: function(label) {
            label.html("&nbsp;").addClass("checked");
        },
        submitHandler: function() {
            submitFormOfUser(METHOD_HTTP);
        },
    });

 
    // function for JQ Validate 
    function submitFormOfUser(type){
        var formDataToString = JSON.stringify($("#userForm").serializeArray());
            $.ajax({
                type: type,
                url: "/ajax/requestForModifyUser.php",
                contentType : "application/x-www-form-urlencoded",
                data: formDataToString,
                xhr: function(){
                    var myAjax = this;
                    xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            myAjax.success(this.responseText);
                            $("#massageFromServer").show();
                        }
                    };     
                    xmlhttp.open(myAjax.type ,myAjax.url, true);
                    xmlhttp.setRequestHeader("Content-type", myAjax.contentType );
                    xmlhttp.send("user=" + myAjax.data);  
                },
                success : function(data){
                    $("#userForm").hide("slow");
                    $("#massageFromServer").show("slow");
                             
                    var responseBD = JSON.parse(data);

                    if (responseBD[0] == 1) {         
                        $('#massageFromServer').removeClass("panel-warning").addClass("panel-success");
                        $('#totalUsers').text(responseBD[2]); 
                    } else {
                        $('#massageFromServer').removeClass("panel-success").addClass(" panel-warning");
                    }
                                                                                      
                    $('#reportFromBD').text(responseBD[1]) ;
               }
        });            
    }
});