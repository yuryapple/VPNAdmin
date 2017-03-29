$(document).ready(function() {
    // load start page in main mindow 
    loadPage(1);


    function loadPage (page){               
        $("#compPage").load("/ajax/loadCurrentCompPage.php", "page=" + page, function(responseTxt, statusTxt, xhr){
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
               
            // get nember of page from url
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
                  
            $("#headerForm").text("Add company"); 
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
   
            $("#headerForm").text("Edit company");
            $("#form-submit").text("Edit");
            $("#form-submit").removeClass("btn-success  btn-danger");
            $("#form-submit").addClass("btn-warning");
    
            // Refresh form
             refrashForm();
             
             // get date from selected row of table and insert it in form 
             var parentTD = $(this).parent();
             
             var compId = $(parentTD).siblings("td:eq(0)").text();
             var nameComp = $(parentTD).siblings("td:eq(1)").text();
             var quotaComp = $(parentTD).siblings("td:eq(2)").text();
             
            // Fill fields of form 
            fillFields (compId, nameComp, quotaComp); 
            readOnlyFieldsOff();
            
            showModalForm();
         });
         
         //User click button Delete
         $(".btn-delete-record").click(function(){
         
            METHOD_HTTP = "DELETE";         
   
            $("#headerForm").text("Delete company");
            $("#form-submit").text("Delete");
            $("#form-submit").removeClass("btn-success  btn-warning ");
            $("#form-submit").addClass("btn-danger");
    
            // Refresh form
            refrashForm();
             
            // get date from selected row of table and insert it in form 
            var parentTD = $(this).parent();
             
            var compId = $(parentTD).siblings("td:eq(0)").text();
            var nameComp = $(parentTD).siblings("td:eq(1)").text();
            var quotaComp = $(parentTD).siblings("td:eq(2)").text();
    
            // Fill fields of form 
            fillFields (compId, nameComp, quotaComp);
            readOnlyFieldsOn();
             
            showModalForm();
         });
    }
        
    function refrashForm () {
        // Refresh form
       $("form")[0].reset();
       $("#compForm span").text("");
       $("#compForm").show();
       $("#massageFromServer").hide();
    }

    function fillFields (compId = "", nameComp = "", quotaComp = "") {
        $("#compId").attr("value", compId);  
        $("#company").attr("value", nameComp);
        $("#quota").attr("value", quotaComp);         
    }

    function readOnlyFieldsOn () {
        $("#company").attr("readonly", true);
        $("#quota").attr("readonly", true);
    }

    function readOnlyFieldsOff () {
        $("#company").attr("readonly", false);
        $("#quota").attr("readonly", false);
    } 
    
    
    function showModalForm(){                
        $("#myModal").modal({backdrop: "static"});
    }

 
    // FORMA
    
    //JQ Validate
    $("#compForm").validate({
        focusInvalid: false,
        focusCleanup: true,
        rules: {
            company: {
                required: true,
                minlength: 2,
                maxlength: 25,
                remote: {
                    url: "/ajax/unicCompanyName.php",
                    type: "post",
                    data: {
                        compId: function() { 
                            return $("#compId").val(); 
                        }
                    }
                }
            },
            quota: {
                required: true,
                number: true,
                min: 0.001,
                max: 99.999,
                rangelength: [1, 6]
            }
        },
        messages: {
            company: {
                required: "Enter name of company",
                minlength: "Min 2 char",
                maxlength: "Max 25 char",
                remote: "Another company uses this name"
            },
            quota: {
                required: "Enter quota",
                number: "Number only",
                min: "Number is very small. min - 0.001",
                max: "Number is very big. max - 99.999",
                rangelength : "Length of number 1 - 6  digits"
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
        var formDataToString = JSON.stringify($("#compForm").serializeArray());
            $.ajax({
                type: type,
                url: "/ajax/requestForModifyCompany.php",
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
                success : function(data) { 
                    $("#compForm").hide("slow");
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