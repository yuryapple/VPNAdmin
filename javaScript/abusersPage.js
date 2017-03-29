$(document).ready(function() {

    var persentPerPage;
    var totalMonth = 6;
    $(".progress").hide(); 
 
    // User ckick Generate button
    $("#generateButton").click( function () {
        $(".progress-bar-striped").attr("style", "width:0%");
        $(".progress").show(); 
        persentPerPage = Math.ceil(100 / 6);
       iterateMonths(1);
    });
         
    // Months 6
    function iterateMonths (month){
       if (month == 7) {
           hideProgressBar();
       } else {
          fillNewMonth(month);  
       }
    }
         
    function fillNewMonth (month){
        $.ajax({
            async: true,
            type: "GET",
            url: "/ajax/generate.php",
            data: "month=" + month,
            success : function(response){
                var responseArray = JSON.parse(response);
               
                var persentDone = parseInt(responseArray[0]) * persentPerPage;                           
                $(".progress-bar-striped").attr("style", "width:" + persentDone + "%").text("Complite months  " + responseArray[0] + "/" + totalMonth);
                  
                $(".badge").text(responseArray[1]);
                  
                iterateMonths(month + 1);
            }
        });
    }
          
    function hideProgressBar (){
        $(".progress").hide(8000); 
    }


    $("#report").click( function () {
       //WHERE BETWEEN  (SQL)
       var betweenCondition  =  $("#selMonth option:selected").attr("value");
       createViewReport(betweenCondition);   
    });
     
     
    function createViewReport (betweenCondition) {
        $.ajax({
            type: "GET",
            url: "/ajax/generate.php",
            data: "between=" + betweenCondition,
            success : function(report){
                $("#result h3").text("Report - " + report);
                showReport(betweenCondition);
            }
        });
    }
    
    function showReport (betweenCondition){
        $("#tableReport").load("/ajax/generate.php", "showReportIn=" + betweenCondition);                      
    }
            
 });