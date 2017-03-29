$(document).ready(function() {
        
         // Path of main menu
         var toLoad = "/ajax/main_menu.html #menu";
		 
	//  Load main menu to current window
	$("#main_menu").load(toLoad, function(responseTxt, statusTxt, xhr){
                  if(statusTxt == "success")
                           showMainMenu() ; 
		if(statusTxt == "error")
			alert("Error: " + xhr.status + ": " + xhr.statusText);
		 });
              
        // If main menu was success loaded then show it (with current item)
        function showMainMenu() {

                  var href = window.location.href;
                           
                  var posQuestionMark = href.indexOf("?");
                           
                  if (posQuestionMark == -1) {
                           // window.name  keep alive  when you move to another page (contains ID selected item)
                           //  (If posQuestionMark is absent you enter incorect URL from kyeboard )
                           window.name = "";
                  }
                         

                  if (window.name === "") {
                           // (If URL is incorect then select FIRST item of menu)
                            $(".nav-sidebar li a:first").parent().addClass("active"); 
                  } else {
                           $("#" + window.name).addClass("active");
                  }
                  
                  selectItem();
	}   
        
         function selectItem() {
                   $(".nav-sidebar li a").on("click", function() {
                            window.name = $(this).parent().attr("id");
                    });
         }
         
         
         $("#About").click(function(){
                  $("#aboutWindow").modal({backdrop: "static"});        
               
         });
         

 });