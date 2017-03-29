<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    
    <link rel="icon" href="/image/favicon.ico">

    <title>VPN Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="/utilites/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/utilites/bootstrap/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    
    <!--  Styles for body of window "About program" -->
    <link href="/styles/bodyAbout.css" rel="stylesheet"></link>
	
    <!-- Custom styles for this template -->
    <link href="/styles/dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#" id="About">VPN Admin</a>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">

        <div id="main_menu" class="col-sm-3 col-md-2 sidebar">	
					<!-- 
             AJAX metod (load)  from maim_menu.js   will load a menu to here  
					-->
        </div>
  
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
					<!-- Show header of page -->
					<div class = "row  page-header">
						
						<!-- Name of current page	and total usersLog in BD -->
						<div  class="col-sm-6">
						 <h2>
							<span class="label label-info">Log of abusers
								<span class="badge"> 
									<?php
										echo  $this->_totalUsersLog;
									?>
								</span>
							</span>	
						 </h2>
						</div>
						
						<!--Show sorter -->
						<div class = "col-sm-2">
							<?php
						  	$strPrint  = '<label for="selMonth">Month :</label> ';
								$strPrint .= '<select class="form-control" id="selMonth">';
								
								foreach ($this->_arrayForSelector as $key => $value) {
									$strPrint .= ' <option  value = "' .  $value  . '">' .  $key . '</option>';		  
								}
								
								$strPrint .= ' </select>';
								echo $strPrint;
							?>
						</div>
						
						<!--Show report -->
						<div class = "col-sm-2">
							  <label for="report">Show :</label> 
								<button type="button"  id="report" class="btn btn-primary text-center form-control">Report</button>
						</div>
						
							<!--Show generate -->
						<div class = "col-sm-2">
							  <label for="generateButton">Report :</label> 
								<button type="button"  id="generateButton" class="btn btn-primary text-center form-control ">Generate</button>
						</div>			
					</div>

					<div class="progress">
							<div class="progress-bar progress-bar-striped active" role="progressbar"
										aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
										50%
							</div>
					</div>
											
					<div id="result">
						<h3></h3>
					</div>
					
				  <div id="tableReport">	
					</div>	
				
					<?php include 'aboutView.php';?>		
        </div>	
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="/utilites/bootstrap/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="/utilites/bootstrap/js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/utilites/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
		<script type="text/javascript" src="/javaScript/showMainMenu.js"></script>
		<script type="text/javascript" src="/javaScript/abusersPage.js"></script>
		
  </body>
</html>
