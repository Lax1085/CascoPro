<?php 
ini_set('session.gc_maxlifetime', 3600);session_set_cookie_params(3600);session_start();
$loggedIn = $_SESSION['loggedOn'];
$currentUser = $_SESSION['currUser'];
$currCompany = $_SESSION['currCompany'];
$isLeader = $_SESSION['isLeader'];
$isCasco = $_SESSION['isCasco'];
if($loggedIn == 'true'){
}else{
    header('Location: http://quotes.cascoonline.com/login.php');
    die();
}
$servername = "localhost";
$username = "*****";
$password = "****";
$dbname = "******";
$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_SESSION['test'])){
}else{
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Casco Quote Tool</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link href="/css/newindex.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css">-->
    <!-- Latest compiled and minified JavaScript -->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js"></script>-->
    <!-- Latest compiled and minified CSS -->
    
    <!--<link rel="stylesheet" href="/css/bootstrap-lumen.min.css">
     <Optional theme>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">-->
    <script type="text/javascript" src="/bootstrap-waitingfor-master/bootstrap-waitingfor-master/bootstrap-waitingfor.js"></script>
    <script type="text/javascript" src="/fraction.js-master/array_mixins.js"></script>
    <script type="text/javascript" src="/fraction.js-master/index.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
  <style>
  .lT{
    text-decoration: line-through;
  }
  </style>
  </head>
  <body>
  <!--Quotes Modal-->
    <div class="modal" id="quotesModal" tabindex="-1" role="dialog" aria-labelledby="View Quotes Modal" aria-hidden="true">
            <div class="modal-dialog modal-lg"  id = "quoteModalDialog">
                <div class="modal-content" style="width:950px" id='quoteContent'>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="myModalLabel">Quotes</h3>
                    </div>
                    <div class="modal-body">
                    <input type="checkbox" id="stopWarning" style="cursor:pointer"><label for="stopWarning" style="cursor:pointer">&nbsp;Do not ask before deleting quotes.</label>
                    <p></p>
                        <div class="input-group"> <span class="input-group-addon">Filter</span>
                          <input id="filter" type="text" class="form-control" placeholder="Type here...">
                        </div>
                        
                        <div style="max-height:700px;overflow:auto;">
                          <table class="table table-hover">
                            <thead>
                                <tr>
                                  <th style="border-bottom:#ffffff;">Quote Number</th>
                                  <th style="border-bottom:#ffffff;">P.O.</th>
                                  <th style="border-bottom:#ffffff;">Product</th>
                                  <th style="border-bottom:#ffffff;">Customer</th>
                                  <th style="border-bottom:#ffffff;">Salesmen</th>
                                  <th style="border-bottom:#ffffff;">Price</th>
                                  <th style="border-bottom:#ffffff;">Date</th>
                                  <th style="border-bottom:#ffffff;width:50px;">Edit</th>
                                  <th style="border-bottom:#ffffff;width:50px;">Delete&nbsp;&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody id="quoteTBody" class ="searchable sortable">
                              
                            </tbody>
                        </table>
                        </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="getElementById('quotesButton').blur" id="closeQuotes">Close</button>
                        </div>
                    </div>
                </div>
        </div><!--End Quotes Modal-->
        <!--Customer Modal-->
    <div class="modal" id="custModal" tabindex="-1" role="dialog" aria-labelledby="View Customer Modal" aria-hidden="true">
      <div class="modal-dialog modal-lg"  id = "custModalDialog">
        <div class="modal-content" id=' custContent'>
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="custModalLabel">Customers</h3>
          </div>
    <div class="modal-body">
      <p></p>
      <div class="input-group"> <span class="input-group-addon">Filter</span>
        <input id="filter2" type="text" class="form-control" placeholder="Type here...">
      </div>
        <div style="max-height:700px;overflow:auto;">
          <table class="table table-hover">
            <thead>
              <tr>
                <th style="border-bottom:#ffffff;">Name</th>
                <th style="border-bottom:#ffffff;">Address</th>
                <th style="border-bottom:#ffffff;">City</th>
                <th style="border-bottom:#ffffff;">State</th>
                <th style="border-bottom:#ffffff;">Zip</th>
                <th style="border-bottom:#ffffff;">Contact</th>
                <th style="border-bottom:#ffffff;">Phone #</th>
              </tr>
            </thead>
              <tbody id="custTBody" class ="searchable sortable" style="cursor:pointer">
                
              </tbody>
            </table>
          </div>
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="getElementById('custSearch').blur" id="closeCustModal">Close</button>
              </div>
            </div>
          </div>
        </div><!--End Customer Modal-->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="/">
      <img id="logo" src="cascoproTransparent.png" width="200px" height="42px"> 
      </a> 
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <a style="margin-left:28%;" class="hidden-md hidden-sm" href="http://www.cascoonline.com"><img width="400px" height="65px" src="cascoHeaderTransparent.png"></a>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown" data-toggle="dropdown"> Quotes <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a><input type = 'button' style ="background:none;border:none;font-size:16px;width:164px" class="showopacity" id = 'quotesButton' data-toggle="modal" data-target="#quotesModal" value = 'Search'></input></a></li>
          </ul>
        </li>
        <!--<li class="dropdown">
          <a href="#" class="dropdown" data-toggle="dropdown"> Customers <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="/customers.php">Search</a></li>
          </ul>
        </li>-->
        <li class="dropdown">
            <a href="#" class="dropdown" data-toggle="dropdown"> Account <b class ="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="/changePassword.php">Change Password</a></li>
                <li><a href="/logout.php">Sign Out</a></li>
            </ul>
        </li>
    </div><!-- /.navbar-collapse -->
     </div><!-- /.-fluid -->
          <ol class="breadcrumb">
        <div style="margin-left:50px;"class="alignRight">
            <strong>Customer #: <span id ='getUser'><?php echo $currCompany; ?></span></strong>
        </div>
        <div style="margin-left:50px;"class="alignRight">
            <strong>Signed In As: <?php echo $currentUser;?></strong>
        </div>
        <div id="dateTopBar" class="alignRight">
        </div>
        <li><a href="/logout.php">Sign Out</a></li>
        <li><a href="/newUser.php"><?php if($currentUser =='dev' || $currentUser =='kb'){
            echo "Add User";
            }else if($isLeader == true){
            echo 'Add User';
            }else{
                echo "";
                } ?>
            </a></li>
        <li><a href="/acctMaint.php"><?php if($currentUser =='dev' || $currentUser =='kb' || $currentUser == 'tcastoro' || $currentUser == 'nmatthews'){
              echo "Account Maintenance";
            }else{
              echo "";
               } ?>
            </a></li>
        
        <!--<li><a href='#'>Global Options</a></li>
        <li><a href='#'>Configuration</a></li>
        <li><a href='#'>Review</a></li>-->
      </ol>
  </nav>
  
  <div class="lpadding">
    <div class="lpadding col-lg-12">
     <div class="col-lg-12 lpadding" style="margin-top:98px">
         <div class= "col-sm-3 col-md-2 lpadding">
<nav class="navbar navbar-default sidebar" id="stickySidebar" style="display: none;" role="navigation">
    <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>      
    </div>
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1" border-style="1px solid black">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" id="windowLi" class="dropdown-toggle" style="margin-left:7px;color:black" data-toggle="dropdown"><font style="font-size: 16px">Windows</font><span class="caret"></span><span class="pull-right hidden-xs showopacity"></span></a>
          <ul class="dropdown-menu-sidebar dropdown-menu forAnimate" role="menu">
            <li style="border:1px solid #e5e5e5;border-right:white;background-color:#e7e7e7"><a style="cursor:pointer" id="cdh" onclick="changeWindow(this)"><font style="font-size:16px">Double Hung</font></a></li>
            <li style="border:1px solid #e5e5e5;border-right:white;background-color:#e7e7e7"><a style="cursor:pointer" id="cdhpicture" onclick="changeWindow(this)"><font style="font-size:16px">Double Hung Picture</font></a></li>
            <li style="border-left:1px solid #e5e5e5;background-color:#e7e7e7"><a style="cursor:pointer" id ="casement" onclick="changeWindow(this)"><font style="font-size:16px">Casement</font></a></li>
            <li style="border:1px solid #e5e5e5;border-right:white;background-color:#e7e7e7"><a style="cursor:pointer" id="awning" onclick="changeWindow(this)"><font style="font-size:16px">Awning</font></a></li>
            <li style="border:1px solid #e5e5e5;border-right:white;background-color:#e7e7e7"><a style="cursor:pointer" id="slider" onclick="changeWindow(this)"><font style="font-size:16px">Sliders</font></a></li>
          </ul>
        </li>
        <!--glyphicon glyphicon-chevron-right-->
        <li style="display:none"><a><input type='button' style="background:none;border:none;font-size:16px;display:none;" onclick="javascript:createPdf()" class="showopacity" id = "sideBarPrint" value="Generate PDF" disabled="disabled" /></a></li>
        <li><a><input type = 'button' style="background:none;border:1px;font-size:16px;color:black" id='glassButton' onclick="changeWindow(this)" value = 'Glass'></input></a></li>
        <li id="glazeLi" style="border-top:1px"><a><input type = 'button' style="background:none;border:1px;font-size:16px;color:black;border-top:1px" id='glazeAcc' onclick="changeWindow(this)" value = 'Glazing Accessories'></input></a></li>
        <li style="border-top:1px"><a><input type = 'button' style="background:none;border:1px;font-size:16px;color:black;border-top:1px" id='custSearch' data-toggle="modal" data-target="#custModal" value = 'Customer Lookup'><span id="custSearchSpan" class="glyphicon glyphicon-chevron-right" style="cursor:pointer"></span></input></a></li>
      </ul>
    </div>
  </div>
</nav>
</div>
<div id="pageLoadText" style="margin-top:50px;margin-left:250px;font-size: 2em ">Loading...</div>
      <div class = "col-lg-6 col-md-6 col-lg-offset-1 stardust" style="display:none;" id ="custInfoDiv">
        <br>
        <p><div id="returnToConfigure"><button class="btn btn-warning" onclick="javascript:returnToConfigure()">Return to Glass Options</button></div></p>
          <div class="panel panel-primary"style='margin-top:20px' id = 'bidInfoPanel'>
             <div class="panel-heading"><h3 class="panel-title">Bid/Customer Information</h3>
              <span class="pull-right clickable panel-collapsed" id = "spanBidInfo"><i class="glyphicon glyphicon-chevron-down"></i></span></div>
             <div class="panel-body" id='bidInfoCollapse' style="display:none">
              <div id = 'bidInfo' align="center">
                <text id = 'jobNum' value ='000000'><strong>Job #:</strong>
                  <?php
                    $sql = "SELECT id FROM saved_quotes ORDER BY id DESC LIMIT 1";
                    $result = $conn->query($sql);
                    $row = mysqli_fetch_row($result);
                    echo $row[0];  
                  ?>
                </text>&nbsp; 
               <!--<label for ='jobIdInput' class = 'in'>Job ID:&nbsp;</label><input type="text" class = "form-control in height30 squareCorners" placeholder="Job ID" style="width:30%;margin-bottom:10px" name = "jobIdName" id="jobIdInput"></input>&nbsp;-->
               <label for = 'dateInput' class = 'in'>Date:&nbsp;&nbsp;</label><input type='date' class="form-control in height30 squareCorners" disabled= true style="width:30%;margin-bottom:10px" id='dateInput' placeholder="Date"></input>&nbsp;
               <label for = 'preparedInput' class = 'in'>Prepared By:&nbsp;</label><input type='text' class="form-control in height30 squareCorners" value='' style="width:25%;margin-bottom:10px" id='preparedInput' placeholder="Prepared By"></input>&nbsp;
               <button id="searchCustButton">Customer Lookup</button>
               
               
              <!--<input type = 'button' class = 'btn btn-default' id = 'searchCustomers' data-toggle="modal" data-target="#customerModal" value = 'Search Customers'></input>-->
               </div> 
               <div class= 'form-group lpadding'>
                <label for = 'descInput'>Description:&nbsp;</label><input type="text" class = "form-control height30 squareCorners" placeholder="Description" style="margin-bottom:10px" id="descInput"></input>
               </div>
              <div id ='custInfo' class ="lpadding">
              <label for='clientInput'>Client ID:&nbsp;</label><input type="text" class = "form-control squareCorners height30" style='margin-top:0px;' placeholder="Client ID" id="clientInput"></input><br>
         <form role="form">
             <div class= 'form-group'>
              <label for = 'nameInput' class ='addressLabel'>Name:&nbsp;</label><input type='text' class="form-control height30 squareCorners" id='nameInput' placeholder="Name"></input>
             </div>
          <!-- Text input-->
            <div class= 'form-group'>
            <label class="addressLabel1" for="address1">Address 1:&nbsp;</label>
              <textarea rows ='1' id ='address1' placeholder="Address" class="form-control squareCorners"></textarea>
            </div>
            <div class= 'form-group'>
            <label class="addressLabel2" for="address2">Address 2:&nbsp;</label>
              <textarea rows ='1' id ='address2' placeholder="Address" class="form-control squareCorners"></textarea>
            </div>
            <div class= 'form-group'>
            <label class="addressLabel3" for="address3">Address 3:&nbsp;</label>
              <textarea rows ='1' id ='address3' placeholder="Address" class="form-control squareCorners"></textarea>
            </div>
          <!-- Text input-->
            <div class= 'form-group' style='float:left'>
            <label for="city">City:&nbsp;</label>
              <input type="text" id ='city' placeholder="City" class="form-control height30 squareCorners" style='width:95%'></input>
            </div>
          <!-- Text input-->
           <div class= 'form-group' style='float:left'>
            <label for="state">State:&nbsp</label>
              <input type="text" id='state' placeholder="State" class="form-control squareCorners height30" style='width:95%;'></input>
           </div>
           <div class= 'form-group'>
            <label  for="zipCode">ZIP Code:&nbsp;</label>
              <input type="text" id='zipCode' placeholder="ZIP Code" class="form-control height30 squareCorners" style='width:30%'></input>
           </div>
          <div class= 'form-group' style='float:left;'>
            <label for="contact">Contact:</label>
              <input type="text" id='contact' placeholder="Contact" class="form-control height30 squareCorners" style='width:95%'></input>
             </div>
          <div class= 'form-group' style='float:left'>
            <label for="phoneNumber">Phone Number:</label>
              <input type="text" id ='phoneNumber' placeholder="Phone Number" class="form-control height30 squareCorners" style='width:95%'></input>
           </div>
          <div class= 'form-group'>
            <label for="faxNumber">Fax Number:</label>
              <input type="text" id ='faxNumber' placeholder="Fax Number" class="form-control height30 squareCorners" style='width:55.9%'></input>
           </div>
          <!-- Text input-->
           <div class= 'form-group'>
            <label for="eMail">Email:&nbsp</label>
              <input type="email" id='eMail' placeholder="Email" class="form-control height30 squareCorners" style='width:100%'></input>
           </div>
          </form>
        </div>
               <input type="button" class = "btn btn-success alignRight" id = "startQuote0" style='margin-top:15px' value= "&nbsp;&nbsp;Next&nbsp;&nbsp;">
             </div>
          </div>
      <div class="panel panel-primary" style='margin-top:20px' id ='jobSiteInfoPanel'>
         <div class="panel-heading"><h3 class="panel-title">Jobsite Information</h3>
          <span class="pull-right clickable" id = "spanJobSite"><i class="glyphicon glyphicon-chevron-up"></i></span>         
          </div>
            <div class="panel-body" id='jobSiteInfoCollapse'>
            <div class= 'form-group'>
              <label for = 'poIdInput'>PO/ID:&nbsp;</label>
              <input type="text" class = "form-control squareCorners" placeholder="PO/ID" style="width:29.2%" id="poIdInput"></input>
            </div>
            <div class= 'form-group'>
              <label class="address1Label" for="address1JobS">Address 1:&nbsp;</label>
              <textarea rows ='1' id ='address1JobS' placeholder="Address 1" class="form-control squareCorners"></textarea>
            </div>
            <div class= 'form-group'>
              <label class="address2Label" for="address2JobS">Address 2:&nbsp;</label>
              <textarea rows ='1' id ='address2JobS' placeholder="Address 2" class="form-control squareCorners"></textarea>
            </div>
            <div class= 'form-group'>
              <label class="address3Label" for="address3JobS">Address 3:&nbsp;</label>
              <textarea rows ='1' id ='address3JobS' placeholder="Address 3" class="form-control squareCorners"></textarea>
            </div>
            <div class= 'form-group' style='float:left'>
            <label for="cityJobS">City:&nbsp;</label>
              <input type="text" id ='cityJobS' placeholder="City" class="form-control height30 squareCorners" style='width:95%'></input>
             </div>
           <div class= 'form-group' style='float:left'>
            <label for="stateJobS">State:&nbsp;</label>
              <input type="text" id='stateJobS' placeholder="State" class="form-control squareCorners height30" style='width:95%;'></input>
           </div>
           <div class= 'form-group'>
            <label  for="zipCodeJobS">ZIP Code:&nbsp;</label>
              <input type="text" id='zipCodeJobS' placeholder="ZIP Code" class="form-control height30 squareCorners" style='width:30%'></input>
           </div>
          
          <div class= 'form-group' style='float:left;'>
            <label for="contactJobS">Contact:</label>
              <input type="text" id='contactJobS' placeholder="Contact" class="form-control height30 squareCorners" style='width:95%'></input>
             </div>
          <div class= 'form-group' style='float:left'>
            <label for="phoneNumberJobS">Phone Number:</label>
              <input type="text" id ='phoneNumberJobS' placeholder="Phone Number" class="form-control height30 squareCorners" style='width:95%'></input>
           </div>
          <div class= 'form-group'>
            <label for="altNumber">Alt. Phone Number:</label>
              <input type="text" id ='altNumberNumber' placeholder="Alt. Phone Number" class="form-control height30 squareCorners" style='width:55%'></input>
           </div>
           <div class= 'form-group'>
              <label class="addressLabel" for="notesJobS">Notes:&nbsp;</label>
              <textarea rows ='3' id ='notesJobS' placeholder="Notes" class="form-control squareCorners"></textarea>
           </div>  
          <input type="button" class = "btn btn-success alignRight" id = "startQuote1" style='margin-top:15px' value= "&nbsp;&nbsp;Next&nbsp;&nbsp;">         
          </div>
        </div>
       <div class="panel panel-primary" style='margin-top:20px' id ='shipToInfoPanel'>
         <div class="panel-heading"><h3 class="panel-title">Ship-To Information</h3>
          <span class="pull-right clickable panel-collapsed" id = "spanShipTo"><i class="glyphicon glyphicon-chevron-down"></i></span>         
          </div>
            <div class="panel-body" style="display:none" id='shipToInfoCollapse'>
               <label class="radio-inline" style='margin-top:5px;'>
                   <input type="radio" name="shipToRadioOptions" id="shipToRadio1" value="option1" checked="true"> Use Customer Info.
               </label>
               <label class="radio-inline" style='margin-top:5px;'>
                   <input type="radio" name="shipToRadioOptions" id="shipToRadio2" value="option2"> Use Jobsite Info.
               </label>
               <br>
               <br>
               <b class="in" style="margin-bottom:5px">Ship Via:</b>
               <br>
               <label class="radio-inline" style="margin-bottom:5px;">
                    <input type="radio" name = "shipViaOpts" id="shipViaPickup" value="option1">Pick-up
               </label>
                <label class="radio-inline" style="margin-bottom:5px">
                    <input type="radio" name = "shipViaOpts" id="shipViaDelivery" value="option2">Delivery
                </label>    
              <br>           
              <div class= 'form-group'>
              <p>
              <label class="address1Label" for="address1ShipTo">Address 1:&nbsp;</label>
              <textarea rows ='1' id ='address1ShipTo' placeholder="Address" class="form-control squareCorners"></textarea>
              </p>
              <p>
              <label class="address2Label" for="address2ShipTo">Address 2:&nbsp;</label>
              <textarea rows ='1' id ='address2ShipTo' placeholder="Address" class="form-control squareCorners"></textarea>
              </p>
              <p>
              <label class="address3Label" for="address3ShipTo">Address 3:&nbsp;</label>
              <textarea rows ='1' id ='address3ShipTo' placeholder="Address" class="form-control squareCorners"></textarea>
              </p>
            </div>
          <!-- Text input-->
            <div class= 'form-group' style='float:left'>
            <label for="cityShipTo">City:&nbsp;</label>
              <input type="text" id ='cityShipTo' placeholder="City" class="form-control height30 squareCorners" style='width:95%'></input>
             </div>
          <!-- Text input-->
           <div class= 'form-group' style='float:left'>
            <label for="stateShipTo">State:&nbsp</label>
              <input type="text" id='stateShipTo' placeholder="State" class="form-control squareCorners height30" style='width:95%;'></input>
           </div>
           <div class= 'form-group'>
            <label  for="zipCodeShipTo">ZIP Code:&nbsp;</label>
              <input type="text" id='zipCodeShipTo' placeholder="ZIP Code" class="form-control height30 squareCorners" style='width:30%'></input>
           </div>
          <div class= 'form-group' style='float:left;'>
            <label for="contactShipTo">Contact:</label>
              <input type="text" id='contactShipTo' placeholder="Contact" class="form-control height30 squareCorners" style='width:95%'></input>
             </div>
           
          <div class= 'form-group'>
            <label for="phoneNumberShipTo">Phone Number:</label>
              <input type="text" id ='phoneNumberShipTo' placeholder="Phone Number" class="form-control height30 squareCorners" style='width:76%'></input>
           </div>
           <div class= 'form-group'>
              <label for="notesShipTo">Special Shipping Instructions:&nbsp;</label>
              <textarea rows ='3' id ='notesShipTo' placeholder="Special Shipping Instructions" class="form-control squareCorners"></textarea>
           </div>  
          <input type="button" class = "btn btn-success alignRight" id = "startQuote" style='margin-top:15px' value= "&nbsp;&nbsp;Next&nbsp;&nbsp;">
            </div> 
        </div>
     </div>
  
      <div class = "col-lg-8 stardust lpadding" style="display:none" id = "topHalf">
        
        <div class="col-lg-7" id = "windowPanels">
        <div id ='doubleHungPanels'>
          <div class="panel-body lpadding npadbot" id = "panel1">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Configuration - Clad Double Hung</h3>
                      <span class="pull-right clickable" id = "span1"><i class="glyphicon glyphicon-chevron-up"></i></span>
                </div>
                <div class="panel-body" id="collapse1">
                
                  Label:<br>
                  <input type="text" class = "form-control squareCorners" placeholder="Enter Label Here..." style="width:60%;" name = "windowLabelName" id="windowLabel"></input>
                  <input type="hidden" id ="hiddenWinQuant" value='1'></input>
                 <div class = "form-group" style="margin-bottom:3px;" id ='custDimsRadio' name="custDimsRadioName">
                  <div class="radio in">
                       <label>
                          <input type="radio" name="options" id="custDimsFt" checked="checked">Feet and Inches
                       </label>
                     </div>
                     <div class = "radio in" style = 'padding-left: 8px'> 
                       <label>   
                          <input type="radio" name="options" id="custDimsInch">Inches
                       </label>
                     </div>
                  </div>
                  <div id="custDimsTextW">Width <font size = '1px'>(Glass Size) Unit Dimension</font></div>
                  <?php
                         
                            $sql = "SELECT BMS_SIZE01 AS BMS_SIZE1, BMS_SIZE02 AS BMS_SIZE2, BMS_SIZE03 AS BMS_SIZE3, BMS_SIZE04 AS BMS_SIZE4, BMS_SIZE05 AS BMS_SIZE5, BMS_SIZE06 AS BMS_SIZE6, BMS_SIZE07 AS BMS_SIZE7, BMS_SIZE08 AS BMS_SIZE8, BMS_SIZE09 AS BMS_SIZE9, BMS_SIZE10, BMS_SIZE11, BMS_SIZE12,BMS_SIZE13, BMS_SIZE14, BMS_SIZE15,  BMS_SIZE16, BMS_SIZE17, BMS_SIZE18, BMS_SIZE19, BMS_SIZE20, BMS_SIZE21, BMS_SIZE22, BMS_SIZE23, BMS_SIZE24, BMS_SIZE25, BMS_SIZE26, BMS_SIZE27,BMS_SIZE28,BMS_SIZE29,BMS_SIZE30,BMS_SIZE31,BMS_SIZE32, BMS_SIZE33, BMS_SIZE34, BMS_SIZE35, BMS_SIZE36, BMS_SIZE37, BMS_SIZE38, BMS_SIZE39, BMS_SIZE40, BMS_SIZE41, BMS_SIZE42, BMS_SIZE43, BMS_SIZE44, BMS_SIZE45,BMS_SIZE46,BMS_SIZE47,BMS_SIZE48,BMS_SIZE49,BMS_SIZE50 AS BMS_SIZE50  FROM BOMMSIZ WHERE BMS_STKPRE = 'CDH' AND BMS_STRCNO ='1'";
                            $result = $conn->query($sql);
                              $sixteenCount = 0;
                              $twentyCount = 0;
                              $twentyFourCount = 0;
                              $twentyEightCount = 0;
                              $thirtyTwoCount = 0;
                              $thirtySixCount = 0;
                              $fortyCount = 0;
                              if ($result->num_rows > 0){
                              echo "<select class='form-control lpadding' style='border-radius:4px;' name='dimsWName' id = 'dimsW'>";
                                while($row = $result->fetch_assoc()){
                                    for($x=1;$x<sizeof($row);$x++){
                                    $tempVal = substr($row['BMS_SIZE'.$x],0,2);
                                    if($tempVal == 16 && $sixteenCount == 0){
                                    $unitDimW16 = ($tempVal + (47/8)) - (1/2);
                                    $uDW16Str = floor($unitDimW16/12) . '&#039;-' . floor($unitDimW16%12) . ' ' . 8 * fmod(fmod($unitDimW16,12),1) .'/8"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW16Str. '</option>';
                                    $sixteenCount++;
                                    }
                                    if($tempVal == 20 && $twentyCount == 0){
                                    $unitDimW20 = ($tempVal + (47/8)) - (1/2);
                                    $uDW20Str = floor($unitDimW20/12) . '&#039;-' . floor($unitDimW20%12) . ' ' . 8 * fmod(fmod($unitDimW20,12),1) .'/8"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW20Str. '</option>';
                                    $twentyCount++;
                                    }
                                    if($tempVal == 24 && $twentyFourCount == 0){
                                    $unitDimW24 = ($tempVal + (47/8)) - (1/2);
                                    $uDW24Str = floor($unitDimW24/12) . '&#039;-' . floor($unitDimW24%12) . ' ' . 8 * fmod(fmod($unitDimW24,12),1) .'/8"';
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW24Str. '</option>';
                                    $twentyFourCount++;
                                    }
                                    if($tempVal == 28 && $twentyEightCount == 0){
                                    $unitDimW28 = ($tempVal + (47/8)) - (1/2);
                                    $uDW28Str = floor($unitDimW28/12) . '&#039;-' . floor($unitDimW28%12) . ' ' . 8 * fmod(fmod($unitDimW28,12),1) .'/8"';
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW28Str. '</option>';
                                    $twentyEightCount++;
                                    }
                                    if($tempVal == 32 && $thirtyTwoCount == 0){
                                    $unitDimW32 = ($tempVal + (47/8)) - (1/2);
                                    $uDW32Str = floor($unitDimW32/12) . '&#039;-' . floor($unitDimW32%12) . ' ' . 8 * fmod(fmod($unitDimW32,12),1) .'/8"';
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW32Str. '</option>';
                                    $thirtyTwoCount++;
                                    }
                                    if($tempVal == 36 && $thirtySixCount == 0){
                                    $unitDimW36 = ($tempVal + (47/8)) - (1/2);
                                    $uDW36Str = floor($unitDimW36/12) . '&#039;-' . floor($unitDimW36%12) . ' ' . 8 * fmod(fmod($unitDimW36,12),1) .'/8"';
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW36Str. '</option>';
                                    $thirtySixCount++;
                                    }
                                    if($tempVal == 40 && $fortyCount == 0){
                                    $unitDimW40 = ($tempVal + (47/8)) - (1/2);
                                    $uDW40Str = floor($unitDimW40/12) . '&#039;-' . floor($unitDimW40%12) . ' ' . 8 * fmod(fmod($unitDimW40,12),1) .'/8"';
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW40Str. '</option>';
                                    $fortyCount++;
                                    }                                    
                                    
                                    }
                                    
                              
                              
                              echo '</select>';
                              
                              echo "<div id='custDimsTextH'>Height <font size = '1px'>(Glass Size) Unit Dimension</font></div>";
                              $sixteenCount = 0;
                              $twentyCount = 0;
                              $twentyFourCount = 0;
                              $twentyEightCount = 0;
                              $thirtyTwoCount = 0;
                              $thirtySixCount = 0;
                              $twelveCount = 0;
                              echo "<select class='form-control lpadding' style='border-radius:4px;' name='dimsHName' id = 'dimsH'>";
                                    for($y=1;$y<sizeof($row);$y++){
                                    $tempVal = substr($row['BMS_SIZE'.$y],2,2);
                                    if($tempVal == 12 && $twelveCount == 0){
                                    $unitDimH12 = (2*$tempVal + 9) - (13/16);
                                    $uDH12Str = floor($unitDimH12/12) . "'-" . floor($unitDimH12%12) . ' ' . 16 * fmod(fmod($unitDimH12,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH12Str . '</option>';
                                    $twelveCount++;
                                    }
                                    if($tempVal == 16 && $sixteenCount == 0){
                                    $unitDimH16 = (2*$tempVal + 9) - (13/16);
                                    $uDH16Str = floor($unitDimH16/12) . "'-" . floor($unitDimH16%12) . ' ' . 16 * fmod(fmod($unitDimH16,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH16Str . '</option>';
                                    $sixteenCount++;
                                    }
                                    if($tempVal == 20 && $twentyCount == 0){
                                    $unitDimH20 = (2*$tempVal + 9) - (13/16);
                                    $uDH20Str = floor($unitDimH20/12) . "'-" . floor($unitDimH20%12) . ' ' . 16 * fmod(fmod($unitDimH20,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH20Str . '</option>';
                                    $twentyCount++;
                                    }
                                    if($tempVal == 24 && $twentyFourCount == 0){
                                    $unitDimH24 = (2*$tempVal + 9) - (13/16);
                                    $uDH24Str = floor($unitDimH24/12) . "'-" . floor($unitDimH24%12) . ' ' . 16 * fmod(fmod($unitDimH24,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH24Str . '</option>';
                                    $twentyFourCount++;
                                    }
                                    if($tempVal == 28 && $twentyEightCount == 0){
                                    $unitDimH28 = (2*$tempVal + 9) - (13/16);
                                    $uDH28Str = floor($unitDimH28/12) . "'-" . floor($unitDimH28%12) . ' ' . 16 * fmod(fmod($unitDimH28,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH28Str . '</option>';
                                    $twentyEightCount++;
                                    }
                                    if($tempVal == 32 && $thirtyTwoCount == 0){
                                    $unitDimH32 = (2*$tempVal + 9) - (13/16);
                                    $uDH32Str = floor($unitDimH32/12) . "'-" . floor($unitDimH32%12) . ' ' . 16 * fmod(fmod($unitDimH32,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH32Str . '</option>';
                                    $thirtyTwoCount++;
                                    }
                                    if($tempVal == 36 && $thirtySixCount == 0){
                                    $unitDimH36 = (2*$tempVal + 9) - (13/16);
                                    $uDH36Str = floor($unitDimH36/12) . "'-" . floor($unitDimH36%12) . ' ' . 16 * fmod(fmod($unitDimH36,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.')  ' . $uDH36Str . '</option>';
                                    $thirtySixCount++;
                                    }
                                    }
                               echo '</select>';
                               
                                  }
                                } else {
                                    echo "0";
                                    }
                         $sql = "SELECT BMS_SIZE01 AS BMS_SIZE1, BMS_SIZE02 AS BMS_SIZE2, BMS_SIZE03 AS BMS_SIZE3, BMS_SIZE04 AS BMS_SIZE4, BMS_SIZE05 AS BMS_SIZE5, BMS_SIZE06 AS BMS_SIZE6, BMS_SIZE07 AS BMS_SIZE7, BMS_SIZE08 AS BMS_SIZE8 FROM BOMMSIZ WHERE BMS_STKPRE = 'CDH' AND BMS_STRCNO ='2'";
                         $result = $conn->query($sql);
                              $splitCheck = 0; 
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    for($x=1;$x<sizeof($row);$x++){
                                    $splitValue =  (string)substr($row['BMS_SIZE'.$x],2,5);
                                    if($splitCheck == 0){
                                      echo "<script type='text/javascript'>$('#dimsH').append($('<option>' , {value: '24/36', text: '(24/36) 5-8 3/16' }))</script>";
                                      $splitCheck++;
                                    }
                                    }
                              }
                             }else{ echo "0";
                             }
                       ?>
                 
                        
                  </select>
              
                Units Wide:
                 <select class="form-control lpadding searchDesc" style="border-radius:4px;" name='installMulls1Name' id = "installMulls1">
                        <?php
                            $sql = "SELECT OPV_VALUE, OPV_EXTDES FROM OPTVALNEW WHERE OPV_OPTION = 'Mulled Units' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                   if($row['OPV_VALUE'] == 'Single'){
                                    echo "<option data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>1</option>";
                                   } 
                                   else if($row['OPV_VALUE'] == 'Twin'){
                                    echo "<option data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>2</option>";
                                   }
                                   else if($row['OPV_VALUE'] == 'Triple'){
                                    echo "<option data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>3</option>";
                                   }
                                   else if($row['OPV_VALUE'] == 'Quad'){
                                    echo "<option data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>4</option>";
                                   }else if($row['OPV_VALUE'] == '5 Wide'){
                                    echo "<option data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>5</option>";
                                   }  
                                 }
                                 }else {
                                    echo "0 results";
                                    }
                        ?>
                 </select>
                 <script type="text/javascript">
                    var selectList = $('#installMulls1 option');
                    selectList = selectList.sort(function(a,b){
                        var valA, valB;
                        valA = a.innerHTML;
                        valB = b.innerHTML;
                        if(valA < valB){
                          return -1;
                        }else if(valA > valB){
                          return 1;
                        }
                          return 0;
                        });    
                    $('#installMulls1').html(selectList);
                    $('#installMulls1').val('Single');
                 </script> 
                  Balances:
                 <select class="form-control lpadding searchDesc" style="border-radius:4px;" name='installBalancesName' id = "installBalances">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_EXTDES FROM OPTVALNEW WHERE OPV_OPTION = 'Balances' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                  if($row['OPV_VALUE'] == "Tilt Latch"){
                                    echo "<option data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                  }else{
                                    echo "<option data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                  }
                                }
                              } else {
                                    echo "0 results";
                              }
                        ?>
                 </select>
                  
                  <br>
                
                  <input type="button" class = "btn btn-default" id = "customDimsButton" value= "Custom Dimensions" style ="margin-bottom:10px">
                  
                  <div class="input-group" id="customDims" style="display:none">
                     
                  <div id='customDimsLabel'><strong>Custom Size:</strong><br></div>
               <div class ='form-group' id = "custDimsInchs" style = "display:none"> 
                  Width:&nbsp;<input type="text" style="width:100%" id ='custDimW' placeholder ="Width" class="dims in"/>  
                         <br>
                         
                  Height:&nbsp;<input type="text" style="width:100%" id ='custDimH' placeholder ="Height" class="dims in"/> 
                </div>
                
                <div class ="form-group" id='ftInCustDims' style = "display:none">
                 Width:
                 <input type="text" id ='custDimWFt' placeholder ="Feet" class="dims in"/> +
                 <input type="text" id ='custDimWInch' placeholder ="Inches" class="dims in"/> 
                 <br>
                 <br>
                 Height:  
                 <input type="text" id ='custDimHFt' placeholder ="Feet" class="dims in"/> +
                 <input type="text" id ='custDimHInch' placeholder ="Inches" class="dims in"/> 
                </div>
                </div>
                <br>
                <button type = "button" class ="btn magik" name="addTransomName"  id="addTransom1">Add Transom Window</button>  
                <input type="button" class="btn btn-success alignRight " name="click1Name" id='click1' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <button type="button" data-loading-text="Loading..." class="btn btn-info alignRight" name="quickAddName" id='quickAdd' autocomplete="off" style ='margin-right:5px;'>Quick Add</button>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "panel2" style="display: none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Exterior</h3>
                      <span class="pull-right clickable" id="span2"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="collapse2">
                
                <div id="exColorLabel">Standard Colors:</div>
                <div class='input-group'>
                  <select class="form-control lpadding in searchDesc" name='extColorChoiceName' id = "extColorChoice">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Clad Color' and OPV_PRODCT = '' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                  </select>
                <span class='input-group-btn'><button class='btn btn-default' type='button' id = 'showColors' data-toggle="modal" title ='View Colors' data-target="#colorModal">
                <span class ='glyphicon glyphicon-search' style ='width:100%'></span></button></span>
                </div>
               
                  <div id ="extColorLabelEstate" style = "display:none">Estate Color:</div>
                   <select class="form-control lpadding in searchDesc" name='extColorChoiceEstateName'  id = "extColorChoiceEstate" style = "display:none; border-radius:4px;">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Estate Colors' and OPV_PRODCT = '' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
                                
                                while($row = $result->fetch_assoc()){
                                    echo "<option data-seq ='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                               echo "<option value='Standard'>Standard Colors</option>";
                        ?>
                  </select>
                <div class="modal" id="colorModal" tabindex="-1" role="dialog" aria-labelledby="Color Modal" aria-hidden="true">
                  <div class="modal-dialog" id='colorModalDialog'>
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" id= "closeColors1" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="myModalLabel">Standard Colors</h2>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Almond.png" alt ="label" id="almond"/>
                         <p><h4>Almond</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Beige.png" alt ="label" id = "beige"/>
                         <p><h4>Beige</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Black.png" alt ="label" id="black"/>
                         <p><h4>Black</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Brick.png" alt ="label" id="brick"/>
                         <p><h4>Brick</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/DarkBronze.png" alt ="label" id = "dBronze"/>
                         <p><h4>Dark Bronze</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/ForestGreen.png" alt ="label" id="fGreen"/>
                         <p><h4>Forest Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Vanilla.png" alt ="label" id ="vanilla"/>
                         <p><h4>Vanilla</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/White.png" alt ="label" id="white"/>
                         <p><h4>White</h4></p>
                         </div>
                     </div>
                     <div class="modal-body">
                        <h2 class="modal-title" id="stColModLabel">Estate Colors</h2>
                         
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Cashmere.png" alt ="label" id="cashmere"/>
                         <p><h4>Cashmere</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Chalk.png" alt ="label" id="chalk"/>
                         <p><h4>Chalk</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Fern.png" alt ="label" id="fern"/>
                         <p><h4>Fern</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Glacier.png" alt ="label" id="glacier"/>
                         <p><h4>Glacier</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Gunmetal.png" alt ="label" id="gunmetal"/>
                         <p><h4>Gunmetal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Harbor.png" alt ="label" id="harbor"/>
                         <p><h4>Harbor</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Heather.png" alt ="label" id="heather"/>
                         <p><h4>Heather</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/IceBlue.png" alt ="label" id="iBlue"/>
                         <p><h4>Blue Ice</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Khaki.png" alt ="label" id="khaki"/>
                         <p><h4>Khaki</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Mocha.png" alt ="label" id="mocha"/>
                         <p><h4>Mocha</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Musket.png" alt ="label" id="musket"/>
                         <p><h4>Musket</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Olive.png" alt ="label" id="olive"/>
                         <p><h4>Olive</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Pebble.png" alt ="label" id="pebble"/>
                         <p><h4>Pebble</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Platinum.png" alt ="label" id="platinum"/>
                         <p><h4>Platinum</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Sienna.png" alt ="label" id="sienna"/>
                         <p><h4>Sienna</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Smoke.png" alt ="label" id="smoke"/>
                         <p><h4>Smoke</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SpringGreen.png" alt ="label" id="sGreen"/>
                         <p><h4>Spring Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Suede.png" alt ="label" id="suede"/>
                         <p><h4>Suede</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Teal.png" alt ="label" id ="teal"/>
                         <p><h4>Teal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Wicker.png" alt ="label" id="wicker"/>
                         <p><h4>Wicker</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/BronzeVein.png " width="100px" height="100px" alt ="label" id="bVein"/>
                         <p><h4>Bronze Vein</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SilverVein.png " width="100px" height="100px" alt ="label" id="sVein"/>
                         <p><h4>Silver Vein</h4></p>
                          </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id = "closeColors2" data-dismiss="modal">Close</button>
                        
                      </div>
                     </div>
                   </div>
                  </div>
                </div>
                <div class="input-group" style="display: none" id = "custExtColorInput">
                   <br>
                      Custom Color:   
                      <input type="text" class = "form-control squareCorners" id ="customExtInput" placeholder ="Custom Color" class="in" /> 
                </div>
                  <br>
                  <br>
                <input type="button" class="btn btn-success alignRight" name="click2Name"  id='click2' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName2" id='backClick2' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "panel3" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Glass</h3>
                      <span class="pull-right clickable" id = "span3"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="collapse3">
                <div class = "form-group">
                  Insulated Glass Type:
                  <select class="form-control lpadding in searchDesc" name='glass1Name' id = "glass1" style="border-radius:4px;">
                          <?php
                            $sql = "SELECT OPV_VALUE,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Glass Type' and OPV_PRODCT = '' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'Insulated'){
                                    }
                                    else if($row['OPV_VALUE'] == 'SSB'){
                                     
                                    }else{       
                                    echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                     }
                                    }
                                }else{
                                    echo "0 results";
                                }      
                        ?>
                  </select>
                  <br>
                  
                  Obscured Type:
                  <select class="form-control lpadding in searchDesc" style="border-radius:4px;" name="glass2Name" id = "glass2">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Obscure/Tint' and OPV_PRODCT='' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                  echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                }
                              }else{
                                  echo "0 results";
                              }
                        ?>
                  </select>
                  </div>
                  Add-Ons:
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="glass_i89Name"  id ="glass_i89"> I89 Coating (Roomside Lo-E)
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="glassTempName" id = "glassTemp"> Tempered
                    </label>
                  </div>
                <div id ="temperedSash" style='display:none'> 
                 <div class="radio"  style ="display:inline-block;margin-right:5px;margin-top:0px;">
                   <label>
                     <input type="radio" name ='tempSashLoc' id ="bothSashTemp" style="padding-left:0px">Both Sashes
                   </label>
                 </div>
                 <div class="radio"  style ="display:inline-block;margin-right:5px;margin-top:0px;">
                  <label>
                    <input type="radio"  id ="topSashTemp" name = 'tempSashLoc' style="padding-left:0px">Top Sash
                  </label>
                 </div>
                 <div class="radio"  style ="display:inline-block;margin-top:0px;">
                   <label>
                     <input type="radio" name ='tempSashLoc' id ="botSashTemp" style="padding-left:0px">Bottom Sash
                   </label>
                 </div>
                </div>
                <br>
                <input type="button" class="btn btn-success alignRight"  name="click3Name" id='click3' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName3"  id='backClick3' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "panel4" style="display:none">
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Grille</h3>
                      <span class="pull-right clickable" id ="span4"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="collapse4">
                  <div id = "grillePatternDiv">                     
                     <div id ="grilleLabelPattern">Pattern:</div>
                     <!--<select class="form-control lpadding in" name="grillePatternName" id="grillePattern">
                        <option value='None'>None</option>;
                        <option value='standardColonial'>Standard Colonial</option>;
                        <option value='custColonial'>Custom Colonial</option>;
                        <option value='standardPrairie6'>Standard Prairie, 6 Lite</option>;
                        <option value='standardPrairie9'>Standard Prairie, 9 Lite</option>;
                        <option value='custPrairie'>Custom Prairie</option>;
                        <option value='custPattern'>Custom Pattern</option>;                         
                     </select>-->
                     <select class="form-control lpadding in searchDesc" style="border-radius:4px;" name="grillePatternName" id = "grillePattern">
                    <?php
                      $sql = "SELECT OPV_INVDES,OPV_VALUE,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Grille Pattern' and OPV_PRODCT = '' ORDER BY OPV_DSPSEQ ASC";
                        $result = $conn->query($sql);
                          if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                if($row['OPV_INVDES'] == 'Standard'){
                                  echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_INVDES'] . "</option>";
                                }else{
                                  echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_INVDES'] . "</option>";
                                }
                              }
                            } else {
                                echo "0 results";
                                }
                    ?>
                  </select>
                   <p></p>
                  </div>
                  <div id ="grilleLabelType"> Grille Type:</div>
                  <select class="form-control lpadding in searchDesc" style="border-radius:4px;" name="grilleTypeName" id = "grilleType">
                    <?php
                      $sql = "SELECT OPV_INVDES,OPV_VALUE,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Grille' and OPV_PRODCT = '' ORDER BY OPV_DSPSEQ ASC";
                        $result = $conn->query($sql);
                          if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                if($row['OPV_INVDES'] == 'No Grills'){
                                  echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_INVDES'] . "</option>";
                                }else{
                                  echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_INVDES'] . "</option>";
                                }
                              }
                            } else {
                                echo "0 results";
                                }
                    ?>
                  </select>
                  <!--<div id = "spacerOptsDiv" style="display:none">
                    <br>
                     <label class="radio-inline">
                       <input type="radio" name="spcrOptsRdo" id="withSpacer">With Internal Spacer
                     </label>
                     <label class="radio-inline">
                       <input type="radio" name="spcrOptsRdo" id="withoutSpacer">Without Internal Spacer
                     </label>
                  </div>-->
                  <div id = "grilleColorDiv" style="display:none">
                     <br>   
                     <div id ="grilleLabelColor" style = "display:none">Solid Color:</div>
                     <div id ="grilleLabelColor2" style = "display:none">Two-Tone Color:</div>
                     <select class="form-control lpadding in searchDesc" id = "grilleColor" name="grilleColorName" style = "display:none">                      
                     </select>
                  </div>
                  <br>
                  <div id ="grilleLabelSash" style="display:none">Sash Selection:</div>
                  <select class="form-control lpadding in searchDesc" style="border-radius:4px;display:none" name="grilleSashName" id ="grilleSash">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Grille Sash Option' and OPV_PRODCT = 'CDH' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                 </select>
                 <br>
                 <div id = 'custGrilleDiv' style = "display:none">
                  <br>
                 <div id ='custColonialGrilleDiv' style = "display:none">
                    Custom Colonial Grille:<br><br>
                    <label for = "custColoWide" class ='in' style="font-weight:normal;width:80px">Units Wide:</label><input type="text" class ="form-control squareCorners height30 in" placeholder = 'Units Wide' style='width:20%;margin-bottom:10px' id ="custColoWide"/><br>
                    <label for = "custColoHigh" class ='in' style="font-weight:normal;width:80px;">Units High:</label><input type="text" class ="form-control squareCorners height30 in" placeholder ='Units High' style='width:20%' id ="custColoHigh"/>
                 </div>
                 <div style="display:none">
                    Custom Grille:
                    <input type="text" class = "form-control squareCorners" placeholder ="Custom Grille" id ="custGrilleIn"/> 
                 </div>
                 </div>   
                  <br>
                  <br>
                <input type="button" class="btn btn-success alignRight"  name="click4Name" id='click4' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;"  name="backClickName4" id='backClick4' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "panel5" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Jamb Size</h3>
                      <span class="pull-right clickable" id="span5"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="collapse5">
                  <div id ="jambSizeLabel">Jamb Size:</div>
                  <select class="form-control lpadding in searchDesc" style="border-radius:4px;" name="jambSizeName" id = "jambSize">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Jamb Size' and OPV_PRODCT = '' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'Other'){
                                      echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>Custom</option>";
                                    }else{ 
                                      echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] .'"'. "</option>";
                                    }
                                }
                                         
                                }else{
                                    echo "0 results";
                                    }  
                        ?>
                  </select>
                  
                  <div class="input-group" style="display: none" id = "customJambDiv">
                  
                  Custom Jamb Size:   
                  <input type="text" class = "form-control squareCorners" placeholder ="Custom Size" class="in" /> 
                </div>
                <br>
                <br>
                <input type="button" class="btn btn-success alignRight"  name="click5Name" id='click5' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;"  name="backClickName5"  id='backClick5' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "panel6" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Screens</h3>
                      <span class="pull-right clickable" id="span6"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="collapse6">            
                 <div id = 'screenColorLabel'> 
                 Color:              
                 </div>
                  <div class= "input-group" >
                  <select class="form-control lpadding in searchDesc" name="screenColorName" id ="screenColor">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Screen Color' and OPV_PRODCT = '' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                   if($row['OPV_VALUE'] == 'Other'){
                                    echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>Custom</option>";
                                    }else{ 
                                    echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                         }
                                         }
                                } else {
                                    echo "0 results";
                                    }
                           
                        ?>
                  </select>
                <span class='input-group-btn' id = 'viewColors2Button'><button class='btn btn-default' type='button' id = 'showColors2' data-toggle="modal" title ='View Colors' data-target="#colorModal3">
                <span class ='glyphicon glyphicon-search' style ='width:100%'></span></button></span>
                </div>  
                <div id ="screenColorLabelEstate" style = "display:none">Estate Color:</div>
                   <select class="form-control lpadding in searchDesc" id = "screenColorChoiceEstate" name="screenColorChoiceEstateName" style = "display:none; border-radius:4px;">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Estate Colors' and OPV_PRODCT = '' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
                                
                                while($row = $result->fetch_assoc()){
                                    echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                               echo "<option value='Standard'>Standard Colors</option>";
                        ?>
                  </select>
                <div class="modal" id="colorModal3" tabindex="-1" role="dialog" aria-labelledby="Color Modal" aria-hidden="true">
                  <div class="modal-dialog" id = "screenColorModalDialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" id= "closeColors3" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="myModalLabel">Standard Colors</h2>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Almond.png" alt ="label" id="almond"/>
                         <p><h4>Almond</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Beige.png" alt ="label" id = "beige"/>
                         <p><h4>Beige</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Black.png" alt ="label" id="black"/>
                         <p><h4>Black</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Brick.png" alt ="label" id="brick"/>
                         <p><h4>Brick</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/DarkBronze.png" alt ="label" id = "dBronze"/>
                         <p><h4>Dark Bronze</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/ForestGreen.png" alt ="label" id="fGreen"/>
                         <p><h4>Forest Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Vanilla.png" alt ="label" id ="vanilla"/>
                         <p><h4>Vanilla</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/White.png" alt ="label" id="white"/>
                         <p><h4>White</h4></p>
                         </div>
                     </div>
                     <div class="modal-body">
                        <h2 class="modal-title" id="stColModLabel">Estate Colors</h2>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Cashmere.png" alt ="label" id="cashmere"/>
                         <p><h4>Cashmere</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Chalk.png" alt ="label" id="chalk"/>
                         <p><h4>Chalk</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Fern.png" alt ="label" id="fern"/>
                         <p><h4>Fern</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Glacier.png" alt ="label" id="glacier"/>
                         <p><h4>Glacier</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Gunmetal.png" alt ="label" id="gunmetal"/>
                         <p><h4>Gunmetal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Harbor.png" alt ="label" id="harbor"/>
                         <p><h4>Harbor</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Heather.png" alt ="label" id="heather"/>
                         <p><h4>Heather</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/IceBlue.png" alt ="label" id="iBlue"/>
                         <p><h4>Blue Ice</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Khaki.png" alt ="label" id="khaki"/>
                         <p><h4>Khaki</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Mocha.png" alt ="label" id="mocha"/>
                         <p><h4>Mocha</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Musket.png" alt ="label" id="musket"/>
                         <p><h4>Musket</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Olive.png" alt ="label" id="olive"/>
                         <p><h4>Olive</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Pebble.png" alt ="label" id="pebble"/>
                         <p><h4>Pebble</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Platinum.png" alt ="label" id="platinum"/>
                         <p><h4>Platinum</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Sienna.png" alt ="label" id="sienna"/>
                         <p><h4>Sienna</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Smoke.png" alt ="label" id="smoke"/>
                         <p><h4>Smoke</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SpringGreen.png" alt ="label" id="sGreen"/>
                         <p><h4>Spring Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Suede.png" alt ="label" id="suede"/>
                         <p><h4>Suede</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Teal.png" alt ="label" id ="teal"/>
                         <p><h4>Teal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Wicker.png" alt ="label" id="wicker"/>
                         <p><h4>Wicker</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/BronzeVein.png " width="100px" height="100px" alt ="label" id="bVein"/>
                         <p><h4>Bronze Vein</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SilverVein.png " width="100px" height="100px" alt ="label" id="sVein"/>
                         <p><h4>Silver Vein</h4></p>
                          </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id = "closeColors3" data-dismiss="modal">Close</button>
                        
                      </div>
                     </div>
                   </div>
                  </div>
                </div>              
                  <br>
                  <div id = 'screenSelectLabel'>
                  Screen Type:
                  </div>
                  <select class="form-control lpadding in searchDesc" style="border-radius:4px;" name="screenPatternName" id = "screenPattern">
                    <?php
                            $sql = "SELECT OPV_VALUE,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Screen Type' and OPV_PRODCT = 'CDH' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                         }
                                } else {
                                    echo "0 results";
                                    }
                           
                        ?>
                 </select>
                <p>
                <div id ="shipRadios">
                    <label class="radio-inline">
                        <input type="radio"  id ="shipHardware" checked = "checked" name = 'hardwareShip'>Ship With Product.
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name = 'hardwareShip' id ="shipScreens3">Ship loose.
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name ='hardwareShip' id ="holdRelease">Hold for delivery.
                    </label>
                </div>
                </p>
                 <div class="checkbox" style= "margin-bottom: 0px;">
                    <label>
                      <input type="checkbox" id ="screens_required" name="screens_requiredName"><strong>Screens Not Required</strong>
                    </label>
                  </div>
                  <br>
                  <br>
                  <input type="button" class="btn btn-success alignRight"  name="click6Name" id='click6' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                  <input type="button" class="btn btn-danger alignRight"  style="margin-right: 5px;"  name="backClickName6" id='backClick6' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "panel7" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title ">Hardware</h3>
                      <span class="pull-right clickable" id="span7"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="collapse7">
                
                      <div id ="labelHardStand">Hardware Color:</div>
                      <select class="form-control lpadding in searchDesc" style="border-radius:4px;" name="hardColorStandName" id = "hardColorStand">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Hardware Color' and OPV_PRODCT = '' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'None'){
                                 
                                    }else if($row['OPV_VALUE'] == 'Coppertone'){
                                        echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    else{
                                        echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                          
                 </select>
                <br>
                <br>
                 <input type="button" class="btn btn-success alignRight"  name="click7Name" id='click7' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                 <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName7"  id='backClick7' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "panel8" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Interior Prefinishing</h3>
                      <span class="pull-right clickable" id="span8"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="collapse8">
              <div id="labelPaint" >Interior Finish</div>
              <select class="form-control lpadding in searchDesc" style="border-radius:4px;" name="intPrimeName" id = "intPrime">
                        <?php
                           /* echo "<option value ='None'>None</option>";
                            echo "<option value ='Mahogany'>Mahogany</option>";
                            echo "<option value ='Cider'>Cider</option>";
                            echo "<option value ='Homestead'>Homestead</option>";
                            echo "<option value ='Clear'>Clear</option>";
                            echo "<option value ='Prime'>Prime Only</option>";
                            echo "<option value ='PrimePaint'>Prime and Paint</option>";*/
                            $sql = "SELECT OPV_VALUE,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Interior Finish' and OPV_PRODCT = 'CDH' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'None'){
                                    echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value=".$row['OPV_VALUE']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                   else if(substr($row['OPV_VALUE'],0,5) == 'Light'){
                                        
                                    }else{
                                    echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>   
              </select>
              <div id="interiorPaintPrime" style="display:none">
              <br>
              Paint Color:
              <select class = "form-control lpadding in" style="border-radius:4px;" name="intPaintColorName" id='intPaintColor'>
                <option value='White'>White</option>
                <option value='Custom'>Custom</option>
              </select>
              </div>
              <div class="input-group" style="display: none" name="customIntPaintName" id = "customIntPaint">
               <br>
                  Custom Color:   
                  <input type="text" class = "form-control squareCorners" id ="customIntInput" placeholder ="Custom Color" class="in" /> 
                </div>
                 <br>
                 <br>
                <input type="button" class="btn btn-success alignRight"  name="click8Name"  id='click8' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName8" id='backClick8' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "panel9" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Additional Items</h3>
                      <span class="pull-right clickable" id ="span9"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="collapse9">
            
                    Accessories:
                    <select class="form-control lpadding in searchDesc" style="border-radius:4px;" id = "install1" name="install1Name">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_INVDES,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Accessories' and OPV_PRODCT = 'CDH' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'None'){
                                    echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value=".$row['OPV_VALUE']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                    echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_INVDES'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    Installation Method 
                    <select class="form-control lpadding in searchDesc" id = "nailFinSelect" name="nailFinSelectName">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_INVDES,OPV_EXTDES,OPV_DSPSEQ FROM OPTVALNEW WHERE OPV_OPTION = 'Installation' and OPV_PRODCT = 'CDH' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'None'){
                                    echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value=".$row['OPV_VALUE']. " selected='selected'>" . $row['OPV_INVDES'] . "</option>";
                                    }else{
                                    echo "<option data-seq='".$row['OPV_DSPSEQ']."' data-desc='".$row['OPV_EXTDES']."' value='".$row['OPV_VALUE']."'>" . $row['OPV_INVDES'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
            
                    <br>
                    <br>
                  <button type = "button" class ="btn magik" name="addTransomName" id="addTransom2">Add Transom Window</button>  
                  <button type = "button" data-loading-text="Loading..." autocomplete="off" class = "btn btn-success alignRight" name="addToOrderName" id ="add_row">Add to Order</button>
                  <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName9" id='backClick9' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
      </div>
    <div id ='doubleHungPicturePanels' style="display:none"> 
          <div class="panel-body lpadding npadbot" id = "cdhpwpanel1" >
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Configuration - Clad Double Hung Picture Window</h3>
                      <span class="pull-right clickable" id = "cdhpwspan1"><i class="glyphicon glyphicon-chevron-up"></i></span>
                </div>
                <div class="panel-body" id="cdhpwcollapse1">
                
                  Label:<br>
                  <input type="text" class = "form-control squareCorners" placeholder="Enter Label Here..." style="width:60%;" name = "windowLabelName" id="cdhpwwindowLabel"></input>
                  <input type="hidden" id ="cdhpwhiddenWinQuant" value='1'></input>
                 <div class = "form-group" style="margin-bottom:3px;" id ='cdhpwcustDimsRadio' name="custDimsRadioName">
                  <div class="radio in">
                       <label>
                          <input type="radio" name="cdhpoptions" id="cdhpwcustDimsFt" checked="checked">Feet and Inches
                       </label>
                     </div>
                     <div class = "radio in" style = 'padding-left: 8px'> 
                       <label>   
                          <input type="radio" name="cdhpoptions" id="cdhpwcustDimsInch">Inches
                       </label>
                     </div>
                  </div>
                  <div id="cdhpwcustDimsTextW">Width <font size = '1px'>(Glass Size) Unit Dimension</font></div>
                  <?php
                         
                            $sql = "SELECT BMS_SIZE01 AS BMS_SIZE1, BMS_SIZE02 AS BMS_SIZE2, BMS_SIZE03 AS BMS_SIZE3, BMS_SIZE04 AS BMS_SIZE4, BMS_SIZE05 AS BMS_SIZE5, BMS_SIZE06 AS BMS_SIZE6, BMS_SIZE07 AS BMS_SIZE7, BMS_SIZE08 AS BMS_SIZE8, BMS_SIZE09 AS BMS_SIZE9, BMS_SIZE10, BMS_SIZE11, BMS_SIZE12,BMS_SIZE13, BMS_SIZE14, BMS_SIZE15,  BMS_SIZE16, BMS_SIZE17, BMS_SIZE18, BMS_SIZE19, BMS_SIZE20, BMS_SIZE21, BMS_SIZE22, BMS_SIZE23, BMS_SIZE24, BMS_SIZE25 AS BMS_SIZE25  FROM BOMMSIZ WHERE BMS_STKPRE = 'CDHPW' AND BMS_STRCNO ='1'";
                            $result = $conn->query($sql);
                              $thirtyFourCount = 0;
                              $fortyCount = 0;
                              $fortySixCount = 0;
                              $fiftyEightCount = 0;
                              $seventyCount = 0;
                              if ($result->num_rows > 0){
                              echo "<select class='form-control lpadding' style='border-radius:4px;' name='dimsWName' id = 'cdhpwdimsW'>";
                                while($row = $result->fetch_assoc()){
                                    for($x=1;$x<sizeof($row);$x++){
                                        //echo "<option value='".substr($row['BMS_SIZE'.$x],0,5)."'>".substr($row['BMS_SIZE'.$x],0,2)." ".substr($row['BMS_SIZE'.$x],2,3)."</option>"; 
                                    $tempVal = substr($row['BMS_SIZE'.$x],0,2);
                                    if($tempVal == 34 && $thirtyFourCount == 0){
                                    $unitDimW34 = ($tempVal + (47/8)) - (1/2);
                                    $uDW34Str = floor($unitDimW34/12) . '&#039;-' . floor($unitDimW34%12) . ' ' . 8 * fmod(fmod($unitDimW34,12),1) .'/8"'; 
                                    echo "<option value='".substr($row['BMS_SIZE'.$x],0,5)."'>(".substr($row['BMS_SIZE'.$x],0,2)." ".substr($row['BMS_SIZE'.$x],2,3).") ".$uDW34Str."</option>";
                                    $thirtyFourCount++;
                                    }
                                    if($tempVal == 40 && $fortyCount == 0){
                                    $unitDimW40 = ($tempVal + (47/8)) - (1/2);
                                    $uDW40Str = floor($unitDimW40/12) . '&#039;-' . floor($unitDimW40%12) . ' ' . 8 * fmod(fmod($unitDimW40,12),1) .'/8"'; 
                                    echo "<option value='".substr($row['BMS_SIZE'.$x],0,5)."'>(".substr($row['BMS_SIZE'.$x],0,2)." ".substr($row['BMS_SIZE'.$x],2,3).") ".$uDW40Str."</option>";
                                    $fortyCount++;
                                    }
                                    if($tempVal == 46 && $fortySixCount == 0){
                                    $unitDimW46 = ($tempVal + (47/8)) - (1/2);
                                    $uDW46Str = floor($unitDimW46/12) . '&#039;-' . floor($unitDimW46%12) . ' ' . 8 * fmod(fmod($unitDimW46,12),1) .'/8"';
                                    echo "<option value='".substr($row['BMS_SIZE'.$x],0,5)."'>(".substr($row['BMS_SIZE'.$x],0,2)." ".substr($row['BMS_SIZE'.$x],2,3).") ".$uDW46Str."</option>";
                                    $fortySixCount++;
                                    }
                                    if($tempVal == 58 && $fiftyEightCount == 0){
                                    $unitDimW58 = ($tempVal + (47/8)) - (1/2);
                                    $uDW58Str = floor($unitDimW58/12) . '&#039;-' . floor($unitDimW58%12) . ' ' . 8 * fmod(fmod($unitDimW58,12),1) .'/8"';
                                    echo "<option value='".substr($row['BMS_SIZE'.$x],0,5)."'>(".substr($row['BMS_SIZE'.$x],0,2)." ".substr($row['BMS_SIZE'.$x],2,3).") ".$uDW58Str."</option>";
                                    $fiftyEightCount++;
                                    }
                                    if($tempVal == 70 && $seventyCount == 0){
                                    $unitDimW70 = ($tempVal + (47/8)) - (1/2);
                                    $uDW70Str = floor($unitDimW70/12) . '&#039;-' . floor($unitDimW70%12) . ' ' . 8 * fmod(fmod($unitDimW70,12),1) .'/8"';
                                    echo "<option value='".substr($row['BMS_SIZE'.$x],0,5)."'>(".substr($row['BMS_SIZE'.$x],0,2)." ".substr($row['BMS_SIZE'.$x],2,3).") ".$uDW70Str."</option>";
                                    $seventyCount++;
                                    }                   
                                    
                                    }
                              
                              
                              echo '</select>';
                              
                              echo "<div id='cdhpwcustDimsTextH'>Height <font size = '1px'>(Glass Size) Unit Dimension</font></div>";
                              $fortyCount = 0;
                              $fortyEightCount = 0;
                              $fiftySixCount = 0;
                              $sixtyFourCount = 0;
                              $seventyTwoCount = 0;
                              echo "<select class='form-control lpadding' style='border-radius:4px;' name='dimsWName' id = 'cdhpwdimsH'>";
                                    for($x=1;$x<sizeof($row);$x++){
                                        //echo "<option value='".substr($row['BMS_SIZE'.$x],0,5)."'>".substr($row['BMS_SIZE'.$x],0,2)." ".substr($row['BMS_SIZE'.$x],2,3)."</option>"; 
                                    $tempVal = substr($row['BMS_SIZE'.$x],6,2);
                                    if($tempVal == 40 && $fortyCount == 0){
                                    $unitDimH40 = ($tempVal + (47/8)) - (1/2);
                                    $uDH40Str = floor($unitDimH40/12) . '&#039;-' . floor($unitDimH40%12) . ' ' . 8 * fmod(fmod($unitDimH40,12),1) .'/8"'; 
                                    echo "<option value='".substr($row['BMS_SIZE'.$x],6,5)."'>(".substr($row['BMS_SIZE'.$x],6,2)." ".substr($row['BMS_SIZE'.$x],8,3).") ".$uDH40Str."</option>";
                                    $fortyCount++;
                                    }
                                    if($tempVal == 48 && $fortyEightCount == 0){
                                    $unitDimH48 = ($tempVal + (47/8)) - (1/2);
                                    $uDH48Str = floor($unitDimH48/12) . '&#039;-' . floor($unitDimH48%12) . ' ' . 8 * fmod(fmod($unitDimH48,12),1) .'/8"'; 
                                    echo "<option value='".substr($row['BMS_SIZE'.$x],6,5)."'>(".substr($row['BMS_SIZE'.$x],6,2)." ".substr($row['BMS_SIZE'.$x],8,3).") ".$uDH48Str."</option>";
                                    $fortyEightCount++;
                                    }
                                    if($tempVal == 56 && $fiftySixCount == 0){
                                    $unitDimH56 = ($tempVal + (47/8)) - (1/2);
                                    $uDH56Str = floor($unitDimH56/12) . '&#039;-' . floor($unitDimH56%12) . ' ' . 8 * fmod(fmod($unitDimH56,12),1) .'/8"';
                                    echo "<option value='".substr($row['BMS_SIZE'.$x],6,5)."'>(".substr($row['BMS_SIZE'.$x],6,2)." ".substr($row['BMS_SIZE'.$x],8,3).") ".$uDH56Str."</option>";
                                    $fiftySixCount++;
                                    }
                                    if($tempVal == 64 && $sixtyFourCount == 0){
                                    $unitDimH64 = ($tempVal + (47/8)) - (1/2);
                                    $uDH64Str = floor($unitDimH64/12) . '&#039;-' . floor($unitDimH64%12) . ' ' . 8 * fmod(fmod($unitDimH64,12),1) .'/8"';
                                    echo "<option value='".substr($row['BMS_SIZE'.$x],6,5)."'>(".substr($row['BMS_SIZE'.$x],6,2)." ".substr($row['BMS_SIZE'.$x],8,3).") ".$uDH64Str."</option>";
                                    $sixtyFourCount++;
                                    }
                                    if($tempVal == 72 && $seventyTwoCount == 0){
                                    $unitDimH72 = ($tempVal + (47/8)) - (1/2);
                                    $uDH72Str = floor($unitDimH72/12) . '&#039;-' . floor($unitDimH72%12) . ' ' . 8 * fmod(fmod($unitDimH72,12),1) .'/8"';
                                    echo "<option value='".substr($row['BMS_SIZE'.$x],6,5)."'>(".substr($row['BMS_SIZE'.$x],6,2)." ".substr($row['BMS_SIZE'.$x],8,3).") ".$uDH72Str."</option>";
                                    $seventyTwoCount++;
                                    }                   
                                    
                                         }
                               echo '</select>';
                               
                                  }
                                } else {
                                    echo "0";
                                    }
                    
                       ?>
                 
                        
                  </select>
              
                Units Wide:
                 <select class="form-control lpadding " style="border-radius:4px;" name='installMulls1Name' id = "cdhpwinstallMulls1">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Mulled Units' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                    echo "<option value='none' selected>1</option>";
                                while($row = $result->fetch_assoc()){
                                   if($row['OPV_VALUE'] == 'Single'){
                                    echo "<option value='".$row['OPV_VALUE']."'>2</option>";
                                   } 
                                   else if($row['OPV_VALUE'] == 'Twin'){
                                    echo "<option value='".$row['OPV_VALUE']."'>3</option>";
                                   }
                                   else if($row['OPV_VALUE'] == 'Triple'){
                                    echo "<option value='".$row['OPV_VALUE']."'>4</option>";
                                   }
                                   else if($row['OPV_VALUE'] == 'Quad'){
                                    echo "<option value='".$row['OPV_VALUE']."'>5</option>";
                                   } 
                                 }
                                 }else {
                                    echo "0 results";
                                    }
                                
                             
                        ?>
                 </select>
                 <script type="text/javascript">
                    var selectList = $('#cdhpwinstallMulls1 option');
                    selectList.sort(function(a,b){
                       a = a.text;
                       b = b.text; 
                       return a-b;
                    });
                    
                    $('#cdhpwinstallMulls1').html(selectList);
                    $('#cshpwinstallMulls1').val('none');
                 </script> 
                  Balances:
                 <select class="form-control lpadding" style="border-radius:4px;" name='installBalancesName' id = "cdhpwinstallBalances">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Balances' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                  if($row['OPV_VALUE'] == "Tilt Latch"){
                                         echo "<option value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                  }else{
                                         echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                         
                                       }
                                }
                              } else {
                                    echo "0 results";
                                     }
                        ?>
                 </select>
                  
                  <br>
                
                  <input type="button" class = "btn btn-default" id = "cdhpwcustomDimsButton" value= "Custom Dimensions" style ="margin-bottom:10px">
                  
                  <div class="input-group" id="cdhpwcustomDims" style="display:none">
                     
                  <div id='cdhpwcustomDimsLabel'><strong>Custom Size:</strong><br></div>
               <div class ='form-group' id = "cdhpwcustDimsInchs" style = "display:none"> 
                  Width:&nbsp;<input type="text" style="width:100%" id ='cdhpwcustDimW' placeholder ="Width" class="dims in"/>  
                         <br>
                         
                  Height:&nbsp;<input type="text" style="width:100%" id ='cdhpwcustDimH' placeholder ="Height" class="dims in"/> 
                </div>
                
                <div class ="form-group" id='cdhpwftInCustDims' style = "display:none">
                 Width:
                 <input type="text" id ='cdhpwcustDimWFt' placeholder ="Feet" class="dims in"/> +
                 <input type="text" id ='cdhpwcustDimWInch' placeholder ="Inches" class="dims in"/> 
                 <br>
                 <br>
                 Height:  
                 <input type="text" id ='cdhpwcustDimHFt' placeholder ="Feet" class="dims in"/> +
                 <input type="text" id ='cdhpwcustDimHInch' placeholder ="Inches" class="dims in"/> 
                </div>
                </div>
                <br>
                <button type = "button" class ="btn magik" name="addTransomName"  id="cdhpwaddTransom1">Add Transom Window</button>
                <input type="button" class="btn btn-success alignRight " name="click1Name" id='cdhpwclick1' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <button type="button" data-loading-text="Loading..." class="btn btn-info alignRight" name="quickAddName" id='cdhpwquickAdd' autocomplete="off" style ='margin-right:5px;'>Quick Add</button>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cdhpwpanel2" style="display: none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Exterior</h3>
                      <span class="pull-right clickable" id="cdhpwspan2"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cdhpwcollapse2">
                
                <div id="cdhpwexColorLabel">Standard Colors:</div>
                <div class='input-group'>
                  <select class="form-control lpadding in" name='extColorChoiceName' id = "cdhpwextColorChoice">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Clad Color' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                  </select>
                <span class='input-group-btn'><button class='btn btn-default' type='button' id = 'cdhpwshowColors' data-toggle="modal" title ='View Colors' data-target="#colorModal">
                <span class ='glyphicon glyphicon-search' style ='width:100%'></span></button></span>
                </div>
                  <div id ="cdhpwextColorLabelEstate" style = "display:none">Estate Color:</div>
                   <select class="form-control lpadding in" name='extColorChoiceEstateName'  id = "cdhpwextColorChoiceEstate" style = "display:none; border-radius:4px;">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Estate Colors' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
                                
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                               echo "<option value='Standard'>Standard Colors</option>";
                        ?>
                  </select>
                <div class="modal" id="cdhpwcolorModal" tabindex="-1" role="dialog" aria-labelledby="Color Modal" aria-hidden="true">
                  <div class="modal-dialog" id='cdhpwcolorModalDialog'>
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" id= "cdhpwcloseColors1" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="cdhpwmyModalLabel">Standard Colors</h2>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Almond.png" alt ="label" id="almond"/>
                         <p><h4>Almond</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Beige.png" alt ="label" id = "beige"/>
                         <p><h4>Beige</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Black.png" alt ="label" id="black"/>
                         <p><h4>Black</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Brick.png" alt ="label" id="brick"/>
                         <p><h4>Brick</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/DarkBronze.png" alt ="label" id = "dBronze"/>
                         <p><h4>Dark Bronze</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/ForestGreen.png" alt ="label" id="fGreen"/>
                         <p><h4>Forest Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Vanilla.png" alt ="label" id ="vanilla"/>
                         <p><h4>Vanilla</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/White.png" alt ="label" id="white"/>
                         <p><h4>White</h4></p>
                         </div>
                     </div>
                     <div class="modal-body">
                        <h2 class="modal-title" id="stColModLabel">Estate Colors</h2>
                         
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Cashmere.png" alt ="label" id="cashmere"/>
                         <p><h4>Cashmere</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Chalk.png" alt ="label" id="chalk"/>
                         <p><h4>Chalk</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Fern.png" alt ="label" id="fern"/>
                         <p><h4>Fern</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Glacier.png" alt ="label" id="glacier"/>
                         <p><h4>Glacier</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Gunmetal.png" alt ="label" id="gunmetal"/>
                         <p><h4>Gunmetal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Harbor.png" alt ="label" id="harbor"/>
                         <p><h4>Harbor</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Heather.png" alt ="label" id="heather"/>
                         <p><h4>Heather</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/IceBlue.png" alt ="label" id="iBlue"/>
                         <p><h4>Blue Ice</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Khaki.png" alt ="label" id="khaki"/>
                         <p><h4>Khaki</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Mocha.png" alt ="label" id="mocha"/>
                         <p><h4>Mocha</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Musket.png" alt ="label" id="musket"/>
                         <p><h4>Musket</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Olive.png" alt ="label" id="olive"/>
                         <p><h4>Olive</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Pebble.png" alt ="label" id="pebble"/>
                         <p><h4>Pebble</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Platinum.png" alt ="label" id="platinum"/>
                         <p><h4>Platinum</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Sienna.png" alt ="label" id="sienna"/>
                         <p><h4>Sienna</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Smoke.png" alt ="label" id="smoke"/>
                         <p><h4>Smoke</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SpringGreen.png" alt ="label" id="sGreen"/>
                         <p><h4>Spring Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Suede.png" alt ="label" id="suede"/>
                         <p><h4>Suede</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Teal.png" alt ="label" id ="teal"/>
                         <p><h4>Teal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Wicker.png" alt ="label" id="wicker"/>
                         <p><h4>Wicker</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/BronzeVein.png " width="100px" height="100px" alt ="label" id="bVein"/>
                         <p><h4>Bronze Vein</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SilverVein.png " width="100px" height="100px" alt ="label" id="sVein"/>
                         <p><h4>Silver Vein</h4></p>
                          </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id = "cdhpwcloseColors2" data-dismiss="modal">Close</button>
                        
                      </div>
                     </div>
                   </div>
                  </div>
                </div>
                <div class="input-group" style="display: none" id = "cdhpwcustExtColorInput">
                   <br>
                      Custom Color:   
                      <input type="text" class = "form-control squareCorners" id ="cdhpwcustomExtInput" placeholder ="Custom Color" class="in" /> 
                </div>
                  <br>
                  <br>
                <input type="button" class="btn btn-success alignRight" name="click2Name"  id='cdhpwclick2' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName2" id='cdhpwbackClick2' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cdhpwpanel3" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Glass</h3>
                      <span class="pull-right clickable" id = "cdhpwspan3"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cdhpwcollapse3">
                <div class = "form-group">
                  Insulated Glass Type:
                  <select class="form-control lpadding in" name='glass1Name' id = "cdhpwglass1" style="border-radius:4px;">
                          <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Type' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'Insulated'){
                                    }
                                    else if($row['OPV_VALUE'] == 'SSB'){
                                     
                                    }
                                    else{       
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                     }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                                    
                        ?>
                  </select>
                  <br>
                  
                  Obscured Type:
                  <select class="form-control lpadding in" style="border-radius:4px;" name="glass2Name" id = "cdhpwglass2">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Option' and OPV_PRODCT=''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                                echo "<option value='Pattern62'>Pattern 62</option>";
                        ?>
                  </select>
                  </div>
                  Add-Ons:
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="glass_i89Name"  id ="glass_i89"> I89 Coating (Roomside Lo-E)
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="glassTempName" id = "cdhpwglassTemp"> Tempered
                    </label>
                  </div>
                <div id ="cdhpwtemperedSash" style='display:none'> 
                 <div class="radio"  style ="display:inline-block;margin-right:5px;margin-top:0px;">
                   <label>
                     <input type="radio" name ='tempSashLoc' id ="cdhpwbothSashTemp" style="padding-left:0px">Both Sashes
                   </label>
                 </div>
                 <div class="radio"  style ="display:inline-block;margin-right:5px;margin-top:0px;">
                  <label>
                    <input type="radio"  id ="cdhpwtopSashTemp" name = 'tempSashLoc' style="padding-left:0px">Top Sash
                  </label>
                 </div>
                 <div class="radio"  style ="display:inline-block;margin-top:0px;">
                   <label>
                     <input type="radio" name ='tempSashLoc' id ="cdhpwbotSashTemp" style="padding-left:0px">Bottom Sash
                   </label>
                 </div>
                </div>
                <br>
                <input type="button" class="btn btn-success alignRight"  name="click3Name" id='cdhpwclick3' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName3"  id='cdhpwbackClick3' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cdhpwpanel4" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Grille</h3>
                      <span class="pull-right clickable" id ="cdhpwspan4"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cdhpwcollapse4">
                  <div id = "cdhpwgrillePatternDiv">                     
                     <div id ="cdhpwgrilleLabelPattern">Pattern:</div>
                     <select class="form-control lpadding in" name="grillePatternName" id="cdhpwgrillePattern">
                        echo "<option value='None'>None</option>";
                        echo "<option value='standardColonial'>Standard Colonial</option>";
                        echo "<option value='custColonial'>Custom Colonial</option>";
                        echo "<option value='standardPrairie6'>Standard Prairie, 6 Lite</option>";
                        echo "<option value='standardPrairie9'>Standard Prairie, 9 Lite</option>";
                        echo "<option value='custPrairie'>Custom Prairie</option>";
                        echo "<option value='artsCraft'>Arts & Craft</option>";
                        echo "<option value='custPattern'>Custom Pattern</option>";                         
                     </select>
                   <p></p>
                  </div>
                  <div id ="cdhpwgrilleLabelType"> Grille Type:</div>
                  <select class="form-control lpadding in" style="border-radius:4px;" name="grilleTypeName" id = "cdhpwgrilleType">
                    <?php
                          $sql = "SELECT OPV_INVDES,OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_INVDES'] == 'No Grills'){
                                    echo "<option value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_INVDES'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_INVDES'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                               /* echo "<option value='None'>None</option>";
                                echo '<option value="58Flat">5/8" Flat</option>';
                                echo '<option value="58FlatTT">5/8" Flat-Two Tone</option>';
                                echo '<option value="1316Flat">13/16" Flat</option>';
                                echo '<option value="1316FlatTT">13/16" Flat-Two Tone</option>';
                                echo '<option value="34Prof">3/4" Profile</option>';
                                echo '<option value="34ProfTT">3/4" Profile-Two Tone</option>';
                                echo '<option value="1Prof">1" Profile</option>';
                                echo '<option value="1ProfTT">1" Profile-Two Tone</option>';
                                echo '<option value="34SDL">1-1/4" SDL</option>';
                                echo '<option value="1SDL">7/8" SDL</option>';*/
                        ?>
                  </select>
                  <div id = "cdhpwspacerOptsDiv" style="display:none">
                    <br>
                     <label class="radio-inline">
                       <input type="radio" name="spcrOptsRdo" id="cdhpwwithSpacer">With Internal Spacer
                     </label>
                     <label class="radio-inline">
                       <input type="radio" name="spcrOptsRdo" id="cdhpwwithoutSpacer">Without Internal Spacer
                     </label>
                  </div>
                  <div id = "cdhpwgrilleColorDiv" style="display:none">
                     
                     <br>   
                     <div id ="cdhpwgrilleLabelColor" style = "display:none">Solid Color:</div>
                     <div id ="cdhpwgrilleLabelColor2" style = "display:none">Two-Tone Color:</div>
                     <select class="form-control lpadding in" id = "cdhpwgrilleColor" name="grilleColorName" style = "display:none">                      
                     </select>
                  </div>
                  
                  <br>
                  <div id ="cdhpwgrilleLabelSash" style="display:none">Sash Selection:</div>
                  <select class="form-control lpadding in" style="border-radius:4px;display:none" name="grilleSashName" id ="cdhpwgrilleSash">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille Sash Option' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                 </select>
                 <br>
                 <div id = 'cdhpwcustGrilleDiv' style = "display:none">
                  <br>
                 <div id ='cdhpwcustColonialGrilleDiv' style = "display:none">
                    Custom Colonial Grille:<br><br>
                    <label for = "custColoWide" class ='in' style="font-weight:normal;width:80px">Units Wide:</label><input type="text" class ="form-control squareCorners height30 in" placeholder = 'Units Wide' style='width:20%;margin-bottom:10px' id ="cdhpwcustColoWide"/><br>
                    <label for = "custColoHigh" class ='in' style="font-weight:normal;width:80px;">Units High:</label><input type="text" class ="form-control squareCorners height30 in" placeholder ='Units High' style='width:20%' id ="cdhpwcustColoHigh"/>
                 </div>
                 <div style="display:none">
                    Custom Grille:
                    <input type="text" class = "form-control squareCorners" placeholder ="Custom Grille" id ="cdhpwcustGrilleIn"/> 
                 </div>
                 </div>   
                  <br>
                  <br>
                  
                <input type="button" class="btn btn-success alignRight"  name="click4Name" id='cdhpwclick4' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;"  name="backClickName4" id='cdhpwbackClick4' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cdhpwpanel5" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Jamb Size</h3>
                      <span class="pull-right clickable" id="cdhpwspan5"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cdhpwcollapse5">
                  <div id ="cdhpwjambSizeLabel">Jamb Size:</div>
                  <select class="form-control lpadding in" style="border-radius:4px;" name="jambSizeName" id = "cdhpwjambSize">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Jamb Size' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'Other'){
                                    echo "<option value='".$row['OPV_VALUE']."'>Custom</option>";
                                    }else{ 
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] .'"'. "</option>";
                                         }
                                         }
                                         
                                } else {
                                    echo "0 results";
                                    }
                                
                        ?>
                  </select>
                  
                  <div class="input-group" style="display: none" id = "cdhpwcustomJambDiv">
                  
                  Custom Jamb Size:   
                  <input type="text" class = "form-control squareCorners" placeholder ="Custom Size" class="in" /> 
                </div>
                <br>
                <br>
                <input type="button" class="btn btn-success alignRight"  name="click5Name" id='cdhpwclick5' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;"  name="backClickName5"  id='cdhpwbackClick5' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cdhpwpanel6" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Screens</h3>
                      <span class="pull-right clickable" id="cdhpwspan6"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cdhpwcollapse6">            
                 <div id = 'cdhpwscreenColorLabel'> 
                 Color:              
                 </div>
                  <div class= "input-group" >
                  <select class="form-control lpadding in" name="screenColorName" id ="cdhpwscreenColor">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Screen Color' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                   if($row['OPV_VALUE'] == 'Other'){
                                    echo "<option value='".$row['OPV_VALUE']."'>Custom</option>";
                                    }else{ 
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                         }
                                         }
                                } else {
                                    echo "0 results";
                                    }
                           
                        ?>
                  </select>
                <span class='input-group-btn' id = 'cdhpwviewColors2Button'><button class='btn btn-default' type='button' id = 'cdhpwshowColors2' data-toggle="modal" title ='View Colors' data-target="#colorModal3">
                <span class ='glyphicon glyphicon-search' style ='width:100%'></span></button></span>
                </div>  
                <div id ="cdhpwscreenColorLabelEstate" style = "display:none">Estate Color:</div>
                   <select class="form-control lpadding in" id = "cdhpwscreenColorChoiceEstate" name="screenColorChoiceEstateName" style = "display:none; border-radius:4px;">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Estate Colors' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
                                
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                               echo "<option value='Standard'>Standard Colors</option>";
                        ?>
                  </select>
<div class="modal" id="cdhpwcolorModal3" tabindex="-1" role="dialog" aria-labelledby="Color Modal" aria-hidden="true">
                  <div class="modal-dialog" id = "cdhpwscreenColorModalDialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" id= "cdhpwcloseColors3" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="cdhpwmyModalLabel">Standard Colors</h2>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Almond.png" alt ="label" id="almond"/>
                         <p><h4>Almond</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Beige.png" alt ="label" id = "beige"/>
                         <p><h4>Beige</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Black.png" alt ="label" id="black"/>
                         <p><h4>Black</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Brick.png" alt ="label" id="brick"/>
                         <p><h4>Brick</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/DarkBronze.png" alt ="label" id = "dBronze"/>
                         <p><h4>Dark Bronze</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/ForestGreen.png" alt ="label" id="fGreen"/>
                         <p><h4>Forest Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Vanilla.png" alt ="label" id ="vanilla"/>
                         <p><h4>Vanilla</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/White.png" alt ="label" id="white"/>
                         <p><h4>White</h4></p>
                         </div>
                     </div>
                     <div class="modal-body">
                        <h2 class="modal-title" id="stColModLabel">Estate Colors</h2>
                         
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Cashmere.png" alt ="label" id="cashmere"/>
                         <p><h4>Cashmere</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Chalk.png" alt ="label" id="chalk"/>
                         <p><h4>Chalk</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Fern.png" alt ="label" id="fern"/>
                         <p><h4>Fern</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Glacier.png" alt ="label" id="glacier"/>
                         <p><h4>Glacier</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Gunmetal.png" alt ="label" id="gunmetal"/>
                         <p><h4>Gunmetal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Harbor.png" alt ="label" id="harbor"/>
                         <p><h4>Harbor</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Heather.png" alt ="label" id="heather"/>
                         <p><h4>Heather</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/IceBlue.png" alt ="label" id="iBlue"/>
                         <p><h4>Blue Ice</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Khaki.png" alt ="label" id="khaki"/>
                         <p><h4>Khaki</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Mocha.png" alt ="label" id="mocha"/>
                         <p><h4>Mocha</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Musket.png" alt ="label" id="musket"/>
                         <p><h4>Musket</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Olive.png" alt ="label" id="olive"/>
                         <p><h4>Olive</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Pebble.png" alt ="label" id="pebble"/>
                         <p><h4>Pebble</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Platinum.png" alt ="label" id="platinum"/>
                         <p><h4>Platinum</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Sienna.png" alt ="label" id="sienna"/>
                         <p><h4>Sienna</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Smoke.png" alt ="label" id="smoke"/>
                         <p><h4>Smoke</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SpringGreen.png" alt ="label" id="sGreen"/>
                         <p><h4>Spring Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Suede.png" alt ="label" id="suede"/>
                         <p><h4>Suede</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Teal.png" alt ="label" id ="teal"/>
                         <p><h4>Teal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Wicker.png" alt ="label" id="wicker"/>
                         <p><h4>Wicker</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/BronzeVein.png " width="100px" height="100px" alt ="label" id="bVein"/>
                         <p><h4>Bronze Vein</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SilverVein.png " width="100px" height="100px" alt ="label" id="sVein"/>
                         <p><h4>Silver Vein</h4></p>
                          </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id = "cdhpwcloseColors3" data-dismiss="modal">Close</button>
                        
                      </div>
                     </div>
                   </div>
                  </div>
                </div>              
                  <br>
                  <div id = 'cdhpwscreenSelectLabel'>
                  Screen Type:
                  </div>
                  <select class="form-control lpadding in" style="border-radius:4px;" name="screenPatternName" id = "cdhpwscreenPattern">
                    <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Screen Type' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                         }
                                } else {
                                    echo "0 results";
                                    }
                           
                        ?>
                 </select>
                <p>
                <div id ="cdhpwshipRadios">
                    <label class="radio-inline">
                        <input type="radio"  id ="cdhpwshipHardware" checked = "checked" name = 'hardwareShip'>Ship With Product.
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name = 'hardwareShip' id ="cdhpwshipScreens3">Ship loose.
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name ='hardwareShip' id ="cdhpwholdRelease">Hold for delivery.
                    </label>
                </div>
                </p>
                 <div class="checkbox" style= "margin-bottom: 0px;">
                    <label>
                      <input type="checkbox" id ="cdhpwscreens_required" name="screens_requiredName"><strong>Screens Not Required</strong>
                    </label>
                  </div>
                  <br>
                  <br>
                  <input type="button" class="btn btn-success alignRight"  name="click6Name" id='cdhpwclick6' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                  <input type="button" class="btn btn-danger alignRight"  style="margin-right: 5px;"  name="backClickName6" id='cdhpwbackClick6' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cdhpwpanel7" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title ">Hardware</h3>
                      <span class="pull-right clickable" id="cdhpwspan7"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cdhpwcollapse7">
                
                      <div id ="cdhpwlabelHardStand">Hardware Color:</div>
                      <select class="form-control lpadding in" style="border-radius:4px;" name="hardColorStandName" id = "cdhpwhardColorStand">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Hardware Color' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'None'){
                                 
                                    }else if($row['OPV_VALUE'] == 'Coppertone'){
                                        echo "<option value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    else{
                                        echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                          
                 </select>
                <br>
                <br>
                 <input type="button" class="btn btn-success alignRight"  name="click7Name" id='cdhpwclick7' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                 <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName7"  id='cdhpwbackClick7' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cdhpwpanel8" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Interior Prefinishing</h3>
                      <span class="pull-right clickable" id="cdhpwspan8"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cdhpwcollapse8">
              <div id="cdhpwlabelPaint" >Interior Finish</div>
              <select class="form-control lpadding in" style="border-radius:4px;" name="intPrimeName" id = "cdhpwintPrime">
                        <?php
                           /* echo "<option value ='None'>None</option>";
                            echo "<option value ='Mahogany'>Mahogany</option>";
                            echo "<option value ='Cider'>Cider</option>";
                            echo "<option value ='Homestead'>Homestead</option>";
                            echo "<option value ='Clear'>Clear</option>";
                            echo "<option value ='Prime'>Prime Only</option>";
                            echo "<option value ='PrimePaint'>Prime and Paint</option>";*/
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Interior Finish' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'None'){
                                    echo "<option value=".$row['OPV_VALUE']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                   else if(substr($row['OPV_VALUE'],0,5) == 'Light'){
                                        
                                    }else{
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>   
              </select>
              <div id="cdhpwinteriorPaintPrime" style="display:none">
              <br>
              Paint Color:
              <select class = "form-control lpadding in" style="border-radius:4px;" name="intPaintColorName" id='cdhpwintPaintColor'>
                <option value='White'>White</option>
                <option value='Custom'>Custom</option>
              </select>
              </div>
              <div class="input-group" style="display: none" name="customIntPaintName" id = "cdhpwcustomIntPaint">
               <br>
                  Custom Color:   
                  <input type="text" class = "form-control squareCorners" id ="cdhpwcustomIntInput" placeholder ="Custom Color" class="in" /> 
                </div>
                 <br>
                 <br>
                <input type="button" class="btn btn-success alignRight"  name="click8Name"  id='cdhpwclick8' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName8" id='cdhpwbackClick8' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cdhpwpanel9" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Additional Items</h3>
                      <span class="pull-right clickable" id ="cdhpwspan9"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cdhpwcollapse9">
            
                    Accessories:
                    <select class="form-control lpadding in" style="border-radius:4px;" id = "cdhpwinstall1" name="install1Name">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_INVDES FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Accessories' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'None'){
                                    echo "<option value=".$row['OPV_VALUE']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_INVDES'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    Installation Method 
                    <select class="form-control lpadding in" id = "cdhpwnailFinSelect" name="nailFinSelectName">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_INVDES FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Installation' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'None'){
                                    echo "<option value=".$row['OPV_VALUE']. " selected='selected'>" . $row['OPV_INVDES'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_INVDES'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
            
                    <br>
                    <br>
                  <button type = "button" class ="btn magik" name="addTransomName" id="cdhpwaddTransom2">Add Transom Window</button>  
                  <button type = "button" data-loading-text="Loading..." autocomplete="off" class = "btn btn-success alignRight" name="addToOrderName" id ="cdhpwadd_row">Add to Order</button>
                  <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName9" id='backClick9' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
      </div>          
    <div id ='casementPanels' style="display:none"> 
        
          <div class="panel-body lpadding npadbot" id = "ccpanel1">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Configuration - Clad Casement</h3>
                      <span class="pull-right clickable" id = "ccspan1"><i class="glyphicon glyphicon-chevron-up"></i></span>
                </div>
                <div class="panel-body" id="cccollapse1">
                
                  Label:<br>
                  <input type="text" class = "form-control squareCorners" placeholder="Enter Label Here..." style="width:60%;" name = "windowLabelName" id="ccwindowLabel"></input>
                  <input type="hidden" id ="cchiddenWinQuant" value='1'></input>
                 <div class = "form-group" style="margin-bottom:3px;" id ='cccustDimsRadio' name="custDimsRadioName">
                  <div class="radio in">
                       <label>
                          <input type="radio" name="ccoptions" id="cccustDimsFt" checked="checked">Feet and Inches
                       </label>
                     </div>
                     <div class = "radio in" style = 'padding-left: 8px'> 
                       <label>   
                          <input type="radio" name="ccoptions" id="cccustDimsInch">Inches
                       </label>
                     </div>
                  </div>
                  <div id="cccustDimsTextW">Width <font size = '1px'>(Glass Size) Unit Dimension</font></div>
                  <?php
                         
                            $sql = "SELECT BMS_SIZE01 AS BMS_SIZE1, BMS_SIZE02 AS BMS_SIZE2, BMS_SIZE03 AS BMS_SIZE3, BMS_SIZE04 AS BMS_SIZE4, BMS_SIZE05 AS BMS_SIZE5, BMS_SIZE06 AS BMS_SIZE6, BMS_SIZE07 AS BMS_SIZE7, BMS_SIZE08 AS BMS_SIZE8, BMS_SIZE09 AS BMS_SIZE9, BMS_SIZE10, BMS_SIZE11, BMS_SIZE12,BMS_SIZE13, BMS_SIZE14, BMS_SIZE15,  BMS_SIZE16, BMS_SIZE17, BMS_SIZE18, BMS_SIZE19, BMS_SIZE20, BMS_SIZE21, BMS_SIZE22, BMS_SIZE23, BMS_SIZE24, BMS_SIZE25, BMS_SIZE26, BMS_SIZE27,BMS_SIZE28,BMS_SIZE29,BMS_SIZE30,BMS_SIZE31,BMS_SIZE32 AS BMS_SIZE32  FROM BOMMSIZ WHERE BMS_STKPRE = 'CC' AND BMS_STRCNO ='1'";
                            $result = $conn->query($sql);
                              $sixteenCount = 0;
                              $twentyCount = 0;
                              $twentyFourCount = 0;
                              $twentyEightCount = 0;
                              if ($result->num_rows > 0){
                              echo "<select class='form-control lpadding' style='border-radius:4px;' name='dimsWName' id = 'ccdimsW'>";
                                while($row = $result->fetch_assoc()){
                                    for($x=1;$x<sizeof($row);$x++){
                                    $tempVal = substr($row['BMS_SIZE'.$x],0,2);
                                    if($tempVal == 16 && $sixteenCount == 0){
                                    $unitDimW16 = $tempVal + 5.0625;
                                    $uDW16Str = floor($unitDimW16/12) . '&#039;-' . floor($unitDimW16%12) . ' ' . 16 * fmod(fmod($unitDimW16,12),1) .'/16"';  
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW16Str. '</option>';
                                    $sixteenCount++;
                                    }
                                    if($tempVal == 20 && $twentyCount == 0){
                                    $unitDimW20 = $tempVal + 5.0625;
                                    $uDW20Str = floor($unitDimW20/12) . '&#039;-' . floor($unitDimW20%12) . ' ' . 16 * fmod(fmod($unitDimW20,12),1) .'/16"';  
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW20Str. '</option>';
                                    $twentyCount++;
                                    }
                                    if($tempVal == 24 && $twentyFourCount == 0){
                                    $unitDimW24 = $tempVal + 5.0625;
                                    $uDW24Str = floor($unitDimW24/12) . '&#039;-' . floor($unitDimW24%12) . ' ' . 16 * fmod(fmod($unitDimW24,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW24Str. '</option>';
                                    $twentyFourCount++;
                                    }
                                    if($tempVal == 28 && $twentyEightCount == 0){
                                    $unitDimW28 = $tempVal + 5.0625;
                                    $uDW28Str = floor($unitDimW28/12) . '&#039;-' . floor($unitDimW28%12) . ' ' . 16 * fmod(fmod($unitDimW28,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW28Str. '</option>';
                                    $twentyEightCount++;
                                    }
                                    }
                              echo '</select>';
                              
                              echo "<div id='cccustDimsTextH'>Height <font size = '1px'>(Glass Size) Unit Dimension</font></div>";
                              $twentyFourCount = 0;
                              $thirtyTwoCount = 0;
                              $thirtySixCount = 0;
                              $fortyTwoCount = 0;
                              $fortyEightCount = 0;
                              $fiftyFourCount = 0;
                              $sixtyCount = 0;
                              $sixtyEightCount = 0;
                              echo "<select class='form-control lpadding' style='border-radius:4px;' name='dimsHName' id = 'ccdimsH'>";
                                    for($y=1;$y<sizeof($row);$y++){
                                    $tempVal = substr($row['BMS_SIZE'.$y],2,2);
                                    if($tempVal == 24 && $twentyFourCount == 0){
                                    $unitDimH24 = $tempVal + 5.0625;
                                    $uDH24Str = floor($unitDimH24/12) . "'-" . floor($unitDimH24%12) . ' ' . 16 * fmod(fmod($unitDimH24,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH24Str . '</option>';
                                    $twentyFourCount++;
                                    }
                                    if($tempVal == 32 && $thirtyTwoCount == 0){
                                    $unitDimH32 = $tempVal + 5.0625;
                                    $uDH32Str = floor($unitDimH32/12) . "'-" . floor($unitDimH32%12) . ' ' . 16 * fmod(fmod($unitDimH32,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH32Str . '</option>';
                                    $thirtyTwoCount++;
                                    }
                                    if($tempVal == 36 && $thirtySixCount == 0){
                                    $unitDimH36 = $tempVal + 5.0625;
                                    $uDH36Str = floor($unitDimH36/12) . "'-" . floor($unitDimH36%12) . ' ' . 16 * fmod(fmod($unitDimH36,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH36Str . '</option>';
                                    $thirtySixCount++;
                                    }
                                    if($tempVal == 42 && $fortyTwoCount == 0){
                                    $unitDimH42 = $tempVal + 5.0625;
                                    $uDH42Str = floor($unitDimH42/12) . "'-" . floor($unitDimH42%12) . ' ' . 16 * fmod(fmod($unitDimH42,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH42Str . '</option>';
                                    $fortyTwoCount++;
                                    }
                                    if($tempVal == 48 && $fortyEightCount == 0){
                                    $unitDimH48 = $tempVal + 5.0625;
                                    $uDH48Str = floor($unitDimH48/12) . "'-" . floor($unitDimH48%12) . ' ' . 16 * fmod(fmod($unitDimH48,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH48Str . '</option>';
                                    $fortyEightCount++;
                                    }
                                    if($tempVal == 54 && $fiftyFourCount == 0){
                                    $unitDimH54 = $tempVal + 5.0625;
                                    $uDH54Str = floor($unitDimH54/12) . "'-" . floor($unitDimH54%12) . ' ' . 16 * fmod(fmod($unitDimH54,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH54Str . '</option>';
                                    $fiftyFourCount++;
                                    }
                                    if($tempVal == 60 && $sixtyCount == 0){
                                    $unitDimH60 = $tempVal + 5.0625;
                                    $uDH60Str = floor($unitDimH60/12) . "'-" . floor($unitDimH60%12) . ' ' . 16 * fmod(fmod($unitDimH60,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.')  ' . $uDH60Str . '</option>';
                                    $sixtyCount++;
                                    }
                                    if($tempVal == 68 && $sixtyEightCount == 0){
                                    $unitDimH68 = $tempVal + 5.0625;
                                    $uDH68Str = floor($unitDimH68/12) . "'-" . floor($unitDimH68%12) . ' ' . 16 * fmod(fmod($unitDimH68,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.')  ' . $uDH68Str . '</option>';
                                    $sixtyEightCount++;
                                    }
                                    }
                               echo '</select>';
                               
                                  }
                                } else {
                                    echo "0";
                                    }
                      ?>
                 
                        
                  </select>
              
                Units Wide:
                 <select class="form-control lpadding " style="border-radius:4px;" name="installMulls1Name" id = "ccinstallMulls1">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Mulled Units' and OPV_PRODCT = 'CC'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == '1 Wide'){
                                        echo "<option value='".$row['OPV_VALUE']."' selected>1</option>";
                                    }else if($row['OPV_VALUE'] == '2 Wide'){
                                        echo "<option value='".$row['OPV_VALUE']."'>2</option>";
                                    }else if($row['OPV_VALUE'] == '3 Wide'){
                                        echo "<option value='".$row['OPV_VALUE']."'>3</option>";
                                    }else if($row['OPV_VALUE'] == '4 Wide'){
                                        echo "<option value='".$row['OPV_VALUE']."'>4</option>";
                                    }else if($row['OPV_VALUE'] == '5 Wide'){
                                        echo "<option value='".$row['OPV_VALUE']."'>5</option>";
                                    } 
                                }
                                 }else {
                                    echo "0 results";
                                    }
                                
                             
                        ?>
                 </select>
                 <p></p>
                <strong>Handing</strong><br>
                 <!--<select class="form-control lpadding" style="border-radius:4px;" name="installBalancesName" id = "ccinstallBalances">
                        <?php 
                            /*$sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Handing' and OPV_PRODCT = 'CC'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                  if($row['OPV_VALUE'] == "Tilt Latch"){
                                         echo "<option value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                  }else{
                                         echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                         
                                       }
                                }
                              } else {
                                    echo "0 results";
                                     }*/
                       ?>
                 </select>-->
                <label for="ccunit1Handing" class="in notbold handing" id="ccunit1Label">&nbsp;Unit 1</label>
                <label for="ccunit2Handing" class="in notbold handing" id="ccunit2Label" style="display:none">&nbsp;Unit 2</label>
                <label for="ccunit3Handing" class="in notbold handing" id="ccunit3Label" style="display:none">&nbsp;Unit 3</label> 
                <label for="ccunit4Handing" class="in notbold handing" id="ccunit4Label" style="display:none">&nbsp;Unit 4</label>
                <label for="ccunit5Handing" class="in notbold handing" id="ccunit5Label" style="display:none">Unit 5</label><br>
                <select class="form-control lpadding in handing" id="ccunit1Handing" name="unit1HandingName">
                    <option value ="left">Left</option>
                    <option value ="right">Right</option>
                    <option value ="stationary">Stationary</option>
                </select>  
                <select class="form-control lpadding in handing" style="display:none" id="ccunit2Handing" name="unit2HandingName">
                    <option value ="left">Left</option>
                    <option value ="right">Right</option>
                    <option value ="stationary">Stationary</option>
                </select>
                   
                <select class="form-control lpadding in handing" style="display:none" id="ccunit3Handing" name="unit3HandingName">
                    <option value ="left">Left</option>
                    <option value ="right">Right</option>
                    <option value ="stationary">Stationary</option>
                </select>
                
                <select class="form-control lpadding in handing" style="display:none" id="ccunit4Handing" name="unit4HandingName">
                    <option value ="left">Left</option>
                    <option value ="right">Right</option>
                    <option value ="stationary">Stationary</option>
                </select>
                    
                <select class="form-control lpadding in handing" style="display:none" id="ccunit5Handing" name="unit5HandingName">
                    <option value ="left">Left</option>
                    <option value ="right">Right</option>
                    <option value ="stationary">Stationary</option>
                </select>    
                        
                    
                  
                <br>
                <br>
                  <input type="button" class = "btn btn-default" id = "cccustomDimsButton" value= "Custom Dimensions" style ="margin-bottom:10px">
                  
                  <div class="input-group" id="cccustomDims" name="customDimsName" style="display:none">
                     
                  <div id='cccustomDimsLabel'><strong>Custom Size:</strong><br></div>
               <div class ='form-group' id = "cccustDimsInchs" style = "display:none"> 
                  Width:&nbsp;<input type="text" style="width:100%" id ='cccustDimW' name="custDimWName" placeholder ="Width" class="dims in"/>  
                         <br>
                         
                  Height:&nbsp;<input type="text" style="width:100%" id ='cccustDimH' name="custDimHName" placeholder ="Height" class="dims in"/> 
                </div>
                
                <div class ="form-group" id='ccftInCustDims' style = "display:none">
                 Width:
                 <input type="text" id ='cccustDimWFt' name="custDimWftName" placeholder ="Feet" class="dims in"/> +
                 <input type="text" id ='cccustDimWInch' name="custDimWInchName" placeholder ="Inches" class="dims in"/> 
                 <br>
                 <br>
                 Height:  
                 <input type="text" id ='cccustDimHFt' name="custDimHFtName" placeholder ="Feet" class="dims in"/> +
                 <input type="text" id ='cccustDimHInch' name="custDimHInchName" placeholder ="Inches" class="dims in"/> 
                </div>
                </div>
                <br>
                <button type = "button" class ="btn magik" name="addTransomName"  id="ccaddTransom1">Add Transom Window</button>  
                <input type="button" class="btn btn-success alignRight " name="click1Name" id='ccclick1' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <button type="button" data-loading-text="Loading..." class="btn btn-info alignRight" name="quickAddName" id='ccquickAdd' autocomplete="off" style ='margin-right:5px;'>Quick Add</button>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "ccpanel2" style="display: none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Exterior</h3>
                      <span class="pull-right clickable" id="ccspan2"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cccollapse2">
                
                <div id="ccexColorLabel">Standard Colors:</div>
                <div class='input-group'>
                  <select class="form-control lpadding in" id = "ccextColorChoice" name="extColorChoiceName">
                        <?php 
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Clad Color' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                  </select>
                <span class='input-group-btn'><button class='btn btn-default' type='button' id = 'ccshowColors' data-toggle="modal" title ='View Colors' data-target="#cccolorModal">
                <span class ='glyphicon glyphicon-search' style ='width:100%'></span></button></span>
                </div>
               
                  <div id ="ccextColorLabelEstate" style = "display:none">Estate Color:</div>
                   <select class="form-control lpadding in" id = "ccextColorChoiceEstate" style = "display:none; border-radius:4px;" name="extColorChoiceEstateName">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Estate Colors' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
                                
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                               echo "<option value='Standard'>Standard Colors</option>";
                        ?>
                  </select>
                <div class="modal" id="cccolorModal" tabindex="-1" role="dialog" aria-labelledby="Color Modal" aria-hidden="true">
                  <div class="modal-dialog" id='cccolorModalDialog'>
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" id= "cccloseColors1" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="ccmyModalLabel">Standard Colors</h2>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Almond.png" alt ="label" id="almond"/>
                         <p><h4>Almond</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Beige.png" alt ="label" id = "beige"/>
                         <p><h4>Beige</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Black.png" alt ="label" id="black"/>
                         <p><h4>Black</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Brick.png" alt ="label" id="brick"/>
                         <p><h4>Brick</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/DarkBronze.png" alt ="label" id = "dBronze"/>
                         <p><h4>Dark Bronze</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/ForestGreen.png" alt ="label" id="fGreen"/>
                         <p><h4>Forest Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Vanilla.png" alt ="label" id ="vanilla"/>
                         <p><h4>Vanilla</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/White.png" alt ="label" id="white"/>
                         <p><h4>White</h4></p>
                         </div>
                     </div>
                     <div class="modal-body">
                        <h2 class="modal-title" id="stColModLabel">Estate Colors</h2>
                         
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Cashmere.png" alt ="label" id="cashmere"/>
                         <p><h4>Cashmere</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Chalk.png" alt ="label" id="chalk"/>
                         <p><h4>Chalk</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Fern.png" alt ="label" id="fern"/>
                         <p><h4>Fern</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Glacier.png" alt ="label" id="glacier"/>
                         <p><h4>Glacier</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Gunmetal.png" alt ="label" id="gunmetal"/>
                         <p><h4>Gunmetal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Harbor.png" alt ="label" id="harbor"/>
                         <p><h4>Harbor</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Heather.png" alt ="label" id="heather"/>
                         <p><h4>Heather</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/IceBlue.png" alt ="label" id="iBlue"/>
                         <p><h4>Blue Ice</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Khaki.png" alt ="label" id="khaki"/>
                         <p><h4>Khaki</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Mocha.png" alt ="label" id="mocha"/>
                         <p><h4>Mocha</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Musket.png" alt ="label" id="musket"/>
                         <p><h4>Musket</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Olive.png" alt ="label" id="olive"/>
                         <p><h4>Olive</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Pebble.png" alt ="label" id="pebble"/>
                         <p><h4>Pebble</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Platinum.png" alt ="label" id="platinum"/>
                         <p><h4>Platinum</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Sienna.png" alt ="label" id="sienna"/>
                         <p><h4>Sienna</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Smoke.png" alt ="label" id="smoke"/>
                         <p><h4>Smoke</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SpringGreen.png" alt ="label" id="sGreen"/>
                         <p><h4>Spring Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Suede.png" alt ="label" id="suede"/>
                         <p><h4>Suede</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Teal.png" alt ="label" id ="teal"/>
                         <p><h4>Teal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Wicker.png" alt ="label" id="wicker"/>
                         <p><h4>Wicker</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/BronzeVein.png " width="100px" height="100px" alt ="label" id="bVein"/>
                         <p><h4>Bronze Vein</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SilverVein.png " width="100px" height="100px" alt ="label" id="sVein"/>
                         <p><h4>Silver Vein</h4></p>
                          </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id = "cccloseColors2" data-dismiss="modal">Close</button>
                        
                      </div>
                     </div>
                   </div>
                  </div>
                </div>
                <div class="input-group" style="display: none" id = "cccustExtColorInput" name="custExtColorInputName">
                   <br>
                      Custom Color:   
                      <input type="text" class = "form-control squareCorners" id ="cccustomExtInput" placeholder ="Custom Color" class="in" /> 
                </div>
                  <br>
                  <br>
                <input type="button" class="btn btn-success alignRight" name="click2Name" id='ccclick2' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName2" id='ccbackClick2' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "ccpanel3" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Glass</h3>
                      <span class="pull-right clickable" id = "ccspan3"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cccollapse3">
                <div class = "form-group">
                  Insulated Glass Type:
                  <select class="form-control lpadding in" id = "ccglass1" style="border-radius:4px;" name="glass1Name">
                          <?php 
                            echo "<option value='clear'>Clear (No Lo-E)</option>";
                            echo "<option value='loE366'>Lo-E 366 (Triple Silver)</option>";
                            echo "<option value='loE340'>Lo-E 340 (Triple Silver)</option>";
                            echo "<option value='loE240'>Lo-E 240 (Dual Silver)</option>";
                            echo "<option value='loE272'>Lo-E 272 (Dual Silver)</option>";   
                            /*$sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Type' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'Insulated'){
                                     echo "<option value='Clear'>Clear Glass</option>";
                                    }
                                    else if($row['OPV_VALUE'] == 'SSB'){
                                     
                                    }
                                    else{       
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                     }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                                    */
                        ?>
                  </select>
                  <br>
                  
                  Obscured Type:
                  <select class="form-control lpadding in" style="border-radius:4px;" id = "ccglass2" name="glass2Name">
                        <?php 
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Option' and OPV_PRODCT=''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                                echo "<option value='Pattern62'>Pattern 62</option>";
                       ?>
                  </select>
                  </div>
                  Add-Ons:
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id ="ccglass_i89" name="glass_i89Name"> I89 Coating (Roomside Lo-E)
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id = "ccglassTemp" name="glassTempName"> Tempered
                    </label>
                  </div>
                <div id ="cctemperedSash" style='display:none'> 
                 <div class="radio"  style ="display:inline-block;margin-right:5px;margin-top:0px;">
                   <label>
                     <input type="radio" name ='tempSashLoc' id ="ccbothSashTemp" style="padding-left:0px">Both Sashes
                   </label>
                 </div>
                 <div class="radio"  style ="display:inline-block;margin-right:5px;margin-top:0px;">
                  <label>
                    <input type="radio"  id ="cctopSashTemp" name = 'tempSashLoc' style="padding-left:0px">Top Sash
                  </label>
                 </div>
                 <div class="radio"  style ="display:inline-block;margin-top:0px;">
                   <label>
                     <input type="radio" name ='tempSashLoc' id ="ccbotSashTemp" style="padding-left:0px">Bottom Sash
                   </label>
                 </div>
                </div>
                <br>
                <input type="button" class="btn btn-success alignRight" name="click3Name" id='ccclick3' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;"  name="backClickName3" id='ccbackClick3' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "ccpanel4" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Grille</h3>
                      <span class="pull-right clickable" id ="ccspan4"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cccollapse4">
                  <div id = "ccgrillePatternDiv">                     
                     <div id ="ccgrilleLabelPattern">Pattern:</div>
                     <select class="form-control lpadding in" id="ccgrillePattern" name="grillePatternName">
                        echo "<option value='None'>None</option>";
                        echo "<option value='standardColonial'>Standard Colonial</option>";
                        echo "<option value='custColonial'>Custom Colonial</option>";
                        echo "<option value='standardPrairie6'>Standard Prairie, 6 Lite</option>";
                        echo "<option value='standardPrairie9'>Standard Prairie, 9 Lite</option>";
                        echo "<option value='custPrairie'>Custom Prairie</option>";
                        echo "<option value='artsCraft'>Arts & Craft</option>";
                        echo "<option value='custPattern'>Custom Pattern</option>";                         
                     </select>
                   <p></p>
                  </div>
                  <div id ="ccgrilleLabelType"> Grille Type:</div>
                  <select class="form-control lpadding in" style="border-radius:4px;" id = "ccgrilleType" name="grilleTypeName">
                    <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille' and OPV_PRODCT = 'CC'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'None'){
                                    echo "<option value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                                /*echo "<option value==>None</option>";
                                echo '<option value="58Flat">5/8" Flat</option>';
                                echo '<option value="58FlatTT">5/8" Flat-Two Tone</option>';
                                echo '<option value="1316Flat">13/16" Flat</option>';
                                echo '<option value="1316FlatTT">13/16" Flat-Two Tone</option>';
                                echo '<option value="34Prof">3/4" Profile</option>';
                                echo '<option value="34ProfTT">3/4" Profile-Two Tone</option>';
                                echo '<option value="1Prof">1" Profile</option>';
                                echo '<option value="1ProfTT">1" Profile-Two Tone</option>';
                                echo '<option value="34SDL">1-1/4" SDL</option>';
                                echo '<option value="1SDL">7/8" SDL</option>';
                                */
                        ?>
                  </select>
                  <div id = "ccspacerOptsDiv" style="display:none">
                    <br>
                     <label class="radio-inline">
                       <input type="radio" name="spcrOptsRdo" id="ccwithSpacer">With Internal Spacer
                     </label>
                     <label class="radio-inline">
                       <input type="radio" name="spcrOptsRdo" id="ccwithoutSpacer">Without Internal Spacer
                     </label>
                  </div>
                  <div id = "ccgrilleColorDiv" style="display:none">
                     
                     <br>   
                     <div id ="ccgrilleLabelColor" style = "display:none">Solid Color:</div>
                     <div id ="ccgrilleLabelColor2" style = "display:none">Two-Tone Color:</div>
                     <select class="form-control lpadding in" id = "ccgrilleColor" name="grilleColorName" style = "display:none">                      
                     </select>
                  </div>
                  
                  <br>
                  <div id ="ccgrilleLabelSash" style="display:none">Sash Selection:</div>
                  <select class="form-control lpadding in" style="border-radius:4px;display:none" id ="ccgrilleSash" name="grilleSashName">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille Sash Option' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == "Top Sash Only"){
                                    }else if($row['OPV_VALUE'] == "Bottom Sash Only"){
                                    }else{
                                        echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                 </select>
                 <br>
                 <div id = 'cccustGrilleDiv' style = "display:none">
                  <br>
                 <div id ='cccustColonialGrilleDiv' style = "display:none">
                    Custom Colonial Grille:<br><br>
                    <label for = "custColoWide" class ='in' style="font-weight:normal;width:80px">Units Wide:</label><input type="text" class ="form-control squareCorners height30 in" placeholder = 'Units Wide' style='width:20%;margin-bottom:10px' id ="cccustColoWide"/><br>
                    <label for = "custColoHigh" class ='in' style="font-weight:normal;width:80px;">Units High:</label><input type="text" class ="form-control squareCorners height30 in" placeholder ='Units High' style='width:20%' id ="cccustColoHigh"/>
                 </div>
                 <div style="display:none">
                    Custom Grille:
                    <input type="text" class = "form-control squareCorners" placeholder ="Custom Grille" id ="cccustGrilleIn"/> 
                 </div>
                 </div>   
                  <br>
                  <br>
                <input type="button" class="btn btn-success alignRight "  name="click4Name" id='ccclick4' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName4"  id='ccbackClick4' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "ccpanel5" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Jamb Size</h3>
                      <span class="pull-right clickable" id="ccspan5"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cccollapse5">
                  <div id ="ccjambSizeLabel">Jamb Size:</div>
                  <select class="form-control lpadding in" style="border-radius:4px;" id = "ccjambSize" name="jambSizeName">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Jamb Size' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'Other'){
                                    echo "<option value='".$row['OPV_VALUE']."'>Custom</option>";
                                    }else{ 
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] .'"'. "</option>";
                                         }
                                         }
                                         
                                } else {
                                    echo "0 results";
                                    }
                                
                        ?>
                  </select>
                  
                  <div class="input-group" style="display: none" id = "cccustomJambDiv">
                  
                  Custom Jamb Size:   
                  <input type="text" class = "form-control squareCorners" placeholder ="Custom Size" class="in" /> 
                </div>
                <br>
                <br>
                <input type="button" class="btn btn-success alignRight "  name="click5Name" id='ccclick5' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName5" id='ccbackClick5' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "ccpanel6" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Screens</h3>
                      <span class="pull-right clickable" id="ccspan6"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cccollapse6">            
                 <div id = 'ccscreenColorLabel'> 
                 Color:              
                 </div>
                  <div class= "input-group" >
                  <select class="form-control lpadding in" id ="ccscreenColor" name="screenColorName">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Screen Color' and OPV_PRODCT = 'CC'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                   if($row['OPV_VALUE'] == 'Other'){
                                    echo "<option value='".$row['OPV_VALUE']."'>Custom</option>";
                                    }else{ 
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                         }
                                         }
                                } else {
                                    echo "0 results";
                                    }
                                echo "<option value='Custom'>Custom</option>";
                        ?>
                  </select>
                <span class='input-group-btn' id = 'ccviewColors2Button'><button class='btn btn-default' type='button' id = 'ccshowColors2' data-toggle="modal" title ='View Colors' data-target="#cccolorModal3">
                <span class ='glyphicon glyphicon-search' style ='width:100%'></span></button></span>
                </div>  
                <div id ="ccscreenColorLabelEstate" style = "display:none">Estate Color:</div>
                    <select class="form-control lpadding in" id = "ccscreenColorChoiceEstate" style = "display:none; border-radius:4px;" name="screenColorChoiceEstateName">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Estate Colors' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
                                
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                               echo "<option value='Standard'>Standard Colors</option>";
                        ?>
                    </select>
<div class="modal" id="cccolorModal3" tabindex="-1" role="dialog" aria-labelledby="Color Modal" aria-hidden="true">
                  <div class="modal-dialog" id = "ccscreenColorModalDialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" id= "cccloseColors3" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="ccmyModalLabel">Standard Colors</h2>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Almond.png" alt ="label" id="almond"/>
                         <p><h4>Almond</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Beige.png" alt ="label" id = "beige"/>
                         <p><h4>Beige</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Black.png" alt ="label" id="black"/>
                         <p><h4>Black</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Brick.png" alt ="label" id="brick"/>
                         <p><h4>Brick</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/DarkBronze.png" alt ="label" id = "dBronze"/>
                         <p><h4>Dark Bronze</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/ForestGreen.png" alt ="label" id="fGreen"/>
                         <p><h4>Forest Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Vanilla.png" alt ="label" id ="vanilla"/>
                         <p><h4>Vanilla</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/White.png" alt ="label" id="white"/>
                         <p><h4>White</h4></p>
                         </div>
                     </div>
                     <div class="modal-body">
                        <h2 class="modal-title" id="stColModLabel">Estate Colors</h2>
                         
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Cashmere.png" alt ="label" id="cashmere"/>
                         <p><h4>Cashmere</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Chalk.png" alt ="label" id="chalk"/>
                         <p><h4>Chalk</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Fern.png" alt ="label" id="fern"/>
                         <p><h4>Fern</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Glacier.png" alt ="label" id="glacier"/>
                         <p><h4>Glacier</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Gunmetal.png" alt ="label" id="gunmetal"/>
                         <p><h4>Gunmetal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Harbor.png" alt ="label" id="harbor"/>
                         <p><h4>Harbor</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Heather.png" alt ="label" id="heather"/>
                         <p><h4>Heather</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/IceBlue.png" alt ="label" id="iBlue"/>
                         <p><h4>Blue Ice</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Khaki.png" alt ="label" id="khaki"/>
                         <p><h4>Khaki</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Mocha.png" alt ="label" id="mocha"/>
                         <p><h4>Mocha</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Musket.png" alt ="label" id="musket"/>
                         <p><h4>Musket</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Olive.png" alt ="label" id="olive"/>
                         <p><h4>Olive</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Pebble.png" alt ="label" id="pebble"/>
                         <p><h4>Pebble</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Platinum.png" alt ="label" id="platinum"/>
                         <p><h4>Platinum</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Sienna.png" alt ="label" id="sienna"/>
                         <p><h4>Sienna</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Smoke.png" alt ="label" id="smoke"/>
                         <p><h4>Smoke</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SpringGreen.png" alt ="label" id="sGreen"/>
                         <p><h4>Spring Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Suede.png" alt ="label" id="suede"/>
                         <p><h4>Suede</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Teal.png" alt ="label" id ="teal"/>
                         <p><h4>Teal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Wicker.png" alt ="label" id="wicker"/>
                         <p><h4>Wicker</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/BronzeVein.png " width="100px" height="100px" alt ="label" id="bVein"/>
                         <p><h4>Bronze Vein</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SilverVein.png " width="100px" height="100px" alt ="label" id="sVein"/>
                         <p><h4>Silver Vein</h4></p>
                          </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id = "cccloseColors3" data-dismiss="modal">Close</button>
                        
                      </div>
                     </div>
                   </div>
                  </div>
                </div>              
                  <br>
                  <div id = 'ccscreenSelectLabel'>
                  Screen Type:
                  </div>
                  <select class="form-control lpadding in" style="border-radius:4px;" id = "ccscreenPattern" name="screenPatterName">
                          <option value="Standard">Standard Fiberglass</option>
                          <option value="Bettervue">Bettervue</option>
                          <option value="PetScreen">PetScreen</option>
                 </select>
                <p>
                <div id ="ccshipRadios">
                    <label class="radio-inline">
                        <input type="radio"  id ="ccshipHardware" checked = "checked" name = 'hardwareShip'>Ship With Product.
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name = 'hardwareShip' id ="ccshipScreens3">Ship loose.
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name ='hardwareShip' id ="ccholdRelease">Hold for delivery.
                    </label>
                </div>
                </p>
                 <div class="checkbox" style= "margin-bottom: 0px;">
                    <label>
                      <input type="checkbox" id ="ccscreens_required" name="screensRequiredName"><strong>Screens Not Required</strong>
                    </label>
                  </div>
                  <br>
                  <br>
                  <input type="button" class="btn btn-success alignRight "  name="click6Name" id='ccclick6' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                  <input type="button" class="btn btn-danger alignRight"  style="margin-right: 5px;"  name="backClickName6" id='ccbackClick6' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "ccpanel7" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title ">Hardware</h3>
                      <span class="pull-right clickable" id="ccspan7"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cccollapse7">
                <div id ="cclabelHardStand">Hardware Color:</div>
                      <select class="form-control lpadding in" style="border-radius:4px;" id = "cchardColorStand" name="hardColorStandName">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Hardware Color' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'None'){
                                 
                                    }else if($row['OPV_VALUE'] == 'Coppertone'){
                                        echo "<option value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    else{
                                        echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                          
                 </select>
                 <p></p>
                 <input type="button" class="btn btn-success alignRight "  name="click7Name" id='ccclick7' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                 <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName7" id='ccbackClick7' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "ccpanel8" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Interior Prefinishing</h3>
                      <span class="pull-right clickable" id="ccspan8"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cccollapse8">
              <div id="cclabelPaint" >Interior Finish</div>
              <select class="form-control lpadding in" style="border-radius:4px;" name="intPrimeName" id = "ccintPrime">
                        <?php
                            echo "<option value ='None'>None</option>";
                            echo "<option value ='Mahogany'>Mahogany</option>";
                            echo "<option value ='Cider'>Cider</option>";
                            echo "<option value ='Homestead'>Homestead</option>";
                            echo "<option value ='Clear'>Clear</option>";
                            echo "<option value ='Prime'>Prime Only</option>";
                            echo "<option value ='PrimePaint'>Prime and Paint</option>";
                            /*$sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Interior Finish' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'None'){
                                    echo "<option value=".$row['OPV_VALUE']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                   else if(substr($row['OPV_VALUE'],0,5) == 'Light'){
                                        
                                    }else{
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }*/
                        ?>   
              </select>
              <div id="interiorPaintPrime" style="display:none">
              <br>
              Paint Color:
              <select class = "form-control lpadding in" style="border-radius:4px;" name="intPaintColorName" id='ccintPaintColor'>
                <option value='White'>White</option>
                <option value='Custom'>Custom</option>
              </select>
              </div>
              <div class="input-group" style="display: none" name="customIntPaintName" id = "cccustomIntPaint">
               <br>
                  Custom Color:   
                  <input type="text" class = "form-control squareCorners" id ="cccustomIntInput" placeholder ="Custom Color" class="in" /> 
                </div>
                 <br>
                 <br>
                <input type="button" class="btn btn-success alignRight"  name="click8Name"  id='ccclick8' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName8" id='ccbackClick8' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "ccpanel9" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Additional Items</h3>
                      <span class="pull-right clickable" id ="ccspan9"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cccollapse9">
            
                Accessories:
                <select class="form-control lpadding in" style="border-radius:4px;" id = "ccinstall1" name="install1Name">
                    <option value="None">None</option>
                    <option value="Brickmold w/Fin">Brickmold w/Fin</option>
                    <option value="Brickmold w/out Fin">Brickmold w/out Fin</option>
                    <option value='4" Panning'>4" Panning</option>
                    <option value='1-7/8" Panning'>1-7/8" Panning</option>  
                </select> 
                <p></p>
                Installation Method 
                <select class="form-control lpadding in" id = "ccnailFinSelect" name="nailFinSelectName">
                    <option value="none">None</option>
                    <option value="Nail">Nail Fin</option>
                    <option value="Mason7">7" Masonry Strap</option>
                    <option value="Mason9">9" Masonry Strap</option>
                    <option value='Mason11'>11" Masonry Strap</option>
                </select>
                <br>
                <br>
                  <button type = "button" data-loading-text="Loading..." autocomplete="off" class = "btn btn-success alignRight" name="addToOrderName" id ="ccadd_row">Add to Order</button>
                  <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName9" id='ccbackClick9' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
      </div>
      <div id ='awningPanels' style="display:none"> 
        
          <div class="panel-body lpadding npadbot" id = "capanel1">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Configuration - Clad Awning</h3>
                      <span class="pull-right clickable" id = "caspan1"><i class="glyphicon glyphicon-chevron-up"></i></span>
                </div>
                <div class="panel-body" id="cacollapse1">
                
                  Label:<br>
                  <input type="text" class = "form-control squareCorners" placeholder="Enter Label Here..." style="width:60%;" name = "windowLabelName" id="cawindowLabel"></input>
                  <input type="hidden" id ="cahiddenWinQuant" value='1'></input>
                 <div class = "form-group" style="margin-bottom:3px;" id ='cacustDimsRadio' name="custDimsRadioName">
                  <div class="radio in">
                       <label>
                          <input type="radio" name="caoptions" id="cacustDimsFt" checked="checked">Feet and Inches
                       </label>
                     </div>
                     <div class = "radio in" style = 'padding-left: 8px'> 
                       <label>   
                          <input type="radio" name="caoptions" id="cacustDimsInch">Inches
                       </label>
                     </div>
                  </div>
                  <div id="cacustDimsTextW">Width <font size = '1px'>(Glass Size) Unit Dimension</font></div>
                  <?php
                         
                            $sql = "SELECT BMS_SIZE01 AS BMS_SIZE1, BMS_SIZE02 AS BMS_SIZE2, BMS_SIZE03 AS BMS_SIZE3, BMS_SIZE04 AS BMS_SIZE4, BMS_SIZE05 AS BMS_SIZE5, BMS_SIZE06 AS BMS_SIZE6, BMS_SIZE07 AS BMS_SIZE7, BMS_SIZE08 AS BMS_SIZE8, BMS_SIZE09 AS BMS_SIZE9, BMS_SIZE10, BMS_SIZE11, BMS_SIZE12 AS BMS_SIZE12 FROM BOMMSIZ WHERE BMS_STKPRE = 'CA' AND BMS_STRCNO ='1'";
                            $result = $conn->query($sql);
                              $twentyFourCount = 0;
                              $thirtyTwoCount = 0;
                              $thirtySixCount = 0;
                              $fortyTwoCount = 0;
                              if ($result->num_rows > 0){
                              echo "<select class='form-control lpadding' style='border-radius:4px;' name='dimsWName' id = 'cadimsW'>";
                                while($row = $result->fetch_assoc()){
                                    for($x=1;$x<sizeof($row);$x++){
                                        $tempVal = substr($row['BMS_SIZE'.$x],0,2);
                                        if($tempVal == 24 && $twentyFourCount == 0){
                                            $unitDimW24 = $tempVal + 5.0625;
                                            $uDW24Str = floor($unitDimW24/12) . '&#039;-' . floor($unitDimW24%12) . ' ' . 16 * fmod(fmod($unitDimW24,12),1) .'/16"';  
                                            echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW24Str. '</option>';
                                            $twentyFourCount++;
                                        }
                                        if($tempVal == 32 && $thirtyTwoCount == 0){
                                            $unitDimW32 = $tempVal + 5.0625;
                                            $uDW32Str = floor($unitDimW32/12) . '&#039;-' . floor($unitDimW32%12) . ' ' . 16 * fmod(fmod($unitDimW32,12),1) .'/16"';  
                                            echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW20Str. '</option>';
                                            $thirtyTwoCount++;
                                        }
                                        if($tempVal == 36 && $thirtySixCount == 0){
                                            $unitDimW36 = $tempVal + 5.0625;
                                            $uDW36Str = floor($unitDimW36/12) . '&#039;-' . floor($unitDimW36%12) . ' ' . 16 * fmod(fmod($unitDimW36,12),1) .'/16"'; 
                                            echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW36Str. '</option>';
                                            $thirtySixCount++;
                                        }
                                        if($tempVal == 42 && $fortyTwoCount == 0){
                                            $unitDimW42 = $tempVal + 5.0625;
                                            $uDW42Str = floor($unitDimW42/12) . '&#039;-' . floor($unitDimW42%12) . ' ' . 16 * fmod(fmod($unitDimW42,12),1) .'/16"'; 
                                            echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW42Str. '</option>';
                                            $fortyTwoCount++;
                                        }
                                    }
                              echo '</select>';
                              
                              echo "<div id='cacustDimsTextH'>Height <font size = '1px'>(Glass Size) Unit Dimension</font></div>";
                              $sixteenCount = 0;
                              $twentyCount = 0;
                              $twentyFourCount = 0;
                              echo "<select class='form-control lpadding' style='border-radius:4px;' name='dimsHName' id = 'cadimsH'>";
                                    for($y=1;$y<sizeof($row);$y++){
                                        $tempVal = substr($row['BMS_SIZE'.$y],2,2);
                                        if($tempVal == 16 && $sixteenCount == 0){
                                            $unitDimH16 = $tempVal + 5.0625;
                                            $uDH16Str = floor($unitDimH16/12) . "'-" . floor($unitDimH16%12) . ' ' . 16 * fmod(fmod($unitDimH16,12),1) .'/16"'; 
                                            echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH16Str . '</option>';
                                            $sixteenCount++;
                                        }
                                        if($tempVal == 20 && $twentyCount == 0){
                                            $unitDimH20 = $tempVal + 5.0625;
                                            $uDH20Str = floor($unitDimH20/12) . "'-" . floor($unitDimH20%12) . ' ' . 16 * fmod(fmod($unitDimH20,12),1) .'/16"'; 
                                            echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH20Str . '</option>';
                                            $twentyCount++;
                                        }
                                        if($tempVal == 24 && $twentyFourCount == 0){
                                            $unitDimH24 = $tempVal + 5.0625;
                                            $uDH24Str = floor($unitDimH24/12) . "'-" . floor($unitDimH24%12) . ' ' . 16 * fmod(fmod($unitDimH24,12),1) .'/16"'; 
                                            echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH24Str . '</option>';
                                            $twentyFourCount++;
                                        }
                                    }
                               echo '</select>';
                               
                                  }
                                } else {
                                    echo "0";
                                    }
                      ?>
                 
                        
                  </select>
                <p></p>
                <label for="cainstallMulls2" class="notbold in" style="width:49%;font-size:1em">Units Wide:</label>
                <label for="cainstallMulls2" class="notbold in" style="width:49%;font-size:1em">Units High:</label><br>
                 <select class="form-control lpadding in" style="border-radius:4px; width:49%" name="installMulls1Name" id = "cainstallMulls1">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                 </select>
                
                 <select class="form-control lpadding in " style="border-radius:4px; width:49%" name="installMulls2Name" id = "cainstallMulls2">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                 </select>
                 <p></p>
                <strong>Handing</strong><br>
                 <!--<select class="form-control lpadding" style="border-radius:4px;" name="installBalancesName" id = "cainstallBalances">
                        <?php 
                            /*$sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Handing' and OPV_PRODCT = 'CA'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                  if($row['OPV_VALUE'] == "Tilt Latch"){
                                         echo "<option value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                  }else{
                                         echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                         
                                       }
                                }
                              } else {
                                    echo "0 results";
                                     }*/
                       ?>
                 </select>-->
                <label for="caunit1Handing" class="in notbold handing" id="caunit1Label">&nbsp;Unit 1</label>
                <label for="caunit2Handing" class="in notbold handing" id="caunit2Label" style="display:none">&nbsp;Unit 2</label>
                <label for="caunit3Handing" class="in notbold handing" id="caunit3Label" style="display:none">&nbsp;Unit 3</label><br>
                <select class="form-control lpadding in handing" id="caunit1Handing" name="unit1HandingName">
                    <option value ="stationary">Stationary</option>
                    <option value ="venting">Venting</option>
                    
                </select>  
                <select class="form-control lpadding in handing" style="display:none" id="caunit2Handing" name="unit2HandingName">
                    <option value ="stationary">Stationary</option>
                    <option value ="venting">Venting</option>
                    
                </select> 
                <select class="form-control lpadding in handing" style="display:none" id="caunit3Handing" name="unit3HandingName">
                    <option value ="stationary">Stationary</option>
                    <option value ="venting">Venting</option>
                   
                </select><br>
            <div id="caextraHanding" style="display:none">
                <label for="caunit4Handing" class="in notbold handing" id="caunit4Label" style="display:none">&nbsp;Unit 4</label>
                <label for="caunit5Handing" class="in notbold handing" id="caunit5Label" style="display:none">&nbsp;Unit 5</label>
                <label for="caunit6Handing" class="in notbold handing" id="caunit6Label" style="display:none">&nbsp;Unit 6</label><br>
                <select class="form-control lpadding in handing" style="display:none" id="caunit4Handing" name="unit4HandingName">
                    <option value ="stationary">Stationary</option>
                    <option value ="venting">Venting</option>
                   
                </select>
                <select class="form-control lpadding in handing" style="display:none" id="caunit5Handing" name="unit5HandingName">
                    <option value ="stationary">Stationary</option>
                    <option value ="venting">Venting</option>
                   
                </select>
                <select class="form-control lpadding in handing" style="display:none" id="caunit6Handing" name="unit6HandingName">
                    <option value ="stationary">Stationary</option>
                    <option value ="venting">Venting</option>
                    
                </select><br>
                <label for="caunit7Handing" class="in notbold handing" id="caunit7Label" style="display:none">&nbsp;Unit 7</label>
                <label for="caunit8Handing" class="in notbold handing" id="caunit8Label" style="display:none">&nbsp;Unit 8</label>
                <label for="caunit9Handing" class="in notbold handing" id="caunit9Label" style="display:none">&nbsp;Unit 9</label><br>    
                <select class="form-control lpadding in handing" style="display:none" id="caunit7Handing" name="unit7HandingName">
                    <option value ="stationary">Stationary</option>
                    <option value ="venting">Venting</option>
                    
                </select>
                <select class="form-control lpadding in handing" style="display:none" id="caunit8Handing" name="unit8HandingName">
                    <option value ="stationary">Stationary</option>
                    <option value ="venting">Venting</option>
                    
                </select>
                <select class="form-control lpadding in handing" style="display:none" id="caunit9Handing" name="unit9HandingName">
                    <option value ="stationary">Stationary</option>
                    <option value ="venting">Venting</option>
                    
                </select><br>    
            </div>    
                  
                <br>
                <br>
                  <input type="button" class = "btn btn-default" id = "cacustomDimsButton" value= "Custom Dimensions" style ="margin-bottom:10px">
                  
                  <div class="input-group" id="cacustomDims" name="customDimsName" style="display:none">
                     
                  <div id='cacustomDimsLabel'><strong>Custom Size:</strong><br></div>
               <div class ='form-group' id = "cacustDimsInchs" style = "display:none"> 
                  Width:&nbsp;<input type="text" style="width:100%" id ='cacustDimW' name="custDimWName" placeholder ="Width" class="dims in"/>  
                         <br>
                         
                  Height:&nbsp;<input type="text" style="width:100%" id ='cacustDimH' name="custDimHName" placeholder ="Height" class="dims in"/> 
                </div>
                
                <div class ="form-group" id='caftInCustDims' style = "display:none">
                 Width:
                 <input type="text" id ='cacustDimWFt' name="custDimWftName" placeholder ="Feet" class="dims in"/> +
                 <input type="text" id ='cacustDimWInch' name="custDimWInchName" placeholder ="Inches" class="dims in"/> 
                 <br>
                 <br>
                 Height:  
                 <input type="text" id ='cacustDimHFt' name="custDimHFtName" placeholder ="Feet" class="dims in"/> +
                 <input type="text" id ='cacustDimHInch' name="custDimHInchName" placeholder ="Inches" class="dims in"/> 
                </div>
                </div>
                <br>
                <button type = "button" class ="btn magik" name="addTransomName"  id="caaddTransom1">Add Transom Window</button>  
                <input type="button" class="btn btn-success alignRight " name="click1Name" id='caclick1' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <button type="button" data-loading-text="Loading..." class="btn btn-info alignRight" name="quickAddName" id='caquickAdd' autocomplete="off" style ='margin-right:5px;'>Quick Add</button>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "capanel2" style="display: none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Exterior</h3>
                      <span class="pull-right clickable" id="caspan2"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cacollapse2">
                
                <div id="caexColorLabel">Standard Colors:</div>
                <div class='input-group'>
                  <select class="form-control lpadding in" id = "caextColorChoice" name="extColorChoiceName">
                        <?php 
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Clad Color' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                  </select>
                <span class='input-group-btn'><button class='btn btn-default' type='button' id = 'cashowColors' data-toggle="modal" title ='View Colors' data-target="#cacolorModal">
                <span class ='glyphicon glyphicon-search' style ='width:100%'></span></button></span>
                </div>
               
                  <div id ="caextColorLabelEstate" style = "display:none">Estate Color:</div>
                   <select class="form-control lpadding in" id = "caextColorChoiceEstate" style = "display:none; border-radius:4px;" name="extColorChoiceEstateName">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Estate Colors' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
                                
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                               echo "<option value='Standard'>Standard Colors</option>";
                        ?>
                  </select>
                <div class="modal" id="cacolorModal" tabindex="-1" role="dialog" aria-labelledby="Color Modal" aria-hidden="true">
                  <div class="modal-dialog" id='cacolorModalDialog'>
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" id= "cacloseColors1" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="camyModalLabel">Standard Colors</h2>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Almond.png" alt ="label" id="almond"/>
                         <p><h4>Almond</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Beige.png" alt ="label" id = "beige"/>
                         <p><h4>Beige</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Black.png" alt ="label" id="black"/>
                         <p><h4>Black</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Brick.png" alt ="label" id="brick"/>
                         <p><h4>Brick</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/DarkBronze.png" alt ="label" id = "dBronze"/>
                         <p><h4>Dark Bronze</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/ForestGreen.png" alt ="label" id="fGreen"/>
                         <p><h4>Forest Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Vanilla.png" alt ="label" id ="vanilla"/>
                         <p><h4>Vanilla</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/White.png" alt ="label" id="white"/>
                         <p><h4>White</h4></p>
                         </div>
                     </div>
                     <div class="modal-body">
                        <h2 class="modal-title" id="stColModLabel">Estate Colors</h2>
                         
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Cashmere.png" alt ="label" id="cashmere"/>
                         <p><h4>Cashmere</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Chalk.png" alt ="label" id="chalk"/>
                         <p><h4>Chalk</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Fern.png" alt ="label" id="fern"/>
                         <p><h4>Fern</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Glacier.png" alt ="label" id="glacier"/>
                         <p><h4>Glacier</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Gunmetal.png" alt ="label" id="gunmetal"/>
                         <p><h4>Gunmetal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Harbor.png" alt ="label" id="harbor"/>
                         <p><h4>Harbor</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Heather.png" alt ="label" id="heather"/>
                         <p><h4>Heather</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/IceBlue.png" alt ="label" id="iBlue"/>
                         <p><h4>Blue Ice</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Khaki.png" alt ="label" id="khaki"/>
                         <p><h4>Khaki</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Mocha.png" alt ="label" id="mocha"/>
                         <p><h4>Mocha</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Musket.png" alt ="label" id="musket"/>
                         <p><h4>Musket</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Olive.png" alt ="label" id="olive"/>
                         <p><h4>Olive</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Pebble.png" alt ="label" id="pebble"/>
                         <p><h4>Pebble</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Platinum.png" alt ="label" id="platinum"/>
                         <p><h4>Platinum</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Sienna.png" alt ="label" id="sienna"/>
                         <p><h4>Sienna</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Smoke.png" alt ="label" id="smoke"/>
                         <p><h4>Smoke</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SpringGreen.png" alt ="label" id="sGreen"/>
                         <p><h4>Spring Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Suede.png" alt ="label" id="suede"/>
                         <p><h4>Suede</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Teal.png" alt ="label" id ="teal"/>
                         <p><h4>Teal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Wicker.png" alt ="label" id="wicker"/>
                         <p><h4>Wicker</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/BronzeVein.png " width="100px" height="100px" alt ="label" id="bVein"/>
                         <p><h4>Bronze Vein</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SilverVein.png " width="100px" height="100px" alt ="label" id="sVein"/>
                         <p><h4>Silver Vein</h4></p>
                          </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id = "cacloseColors2" data-dismiss="modal">Close</button>
                        
                      </div>
                     </div>
                   </div>
                  </div>
                </div>
                <div class="input-group" style="display: none" id = "cacustExtColorInput" name="custExtColorInputName">
                   <br>
                      Custom Color:   
                      <input type="text" class = "form-control squareCorners" id ="cacustomExtInput" placeholder ="Custom Color" class="in" /> 
                </div>
                  <br>
                  <br>
                <input type="button" class="btn btn-success alignRight" name="click2Name" id='caclick2' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName2" id='cabackClick2' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "capanel3" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Glass</h3>
                      <span class="pull-right clickable" id = "caspan3"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cacollapse3">
                <div class = "form-group">
                  Insulated Glass Type:
                  <select class="form-control lpadding in" id = "caglass1" style="border-radius:4px;" name="glass1Name">
                          <?php 
                            echo "<option value='clear'>Clear (No Lo-E)</option>";
                            echo "<option value='loE366'>Lo-E 366 (Triple Silver)</option>";
                            echo "<option value='loE340'>Lo-E 340 (Triple Silver)</option>";
                            echo "<option value='loE240'>Lo-E 240 (Dual Silver)</option>";
                            echo "<option value='loE272'>Lo-E 272 (Dual Silver)</option>";   
                            /*$sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Type' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'Insulated'){
                                     echo "<option value='Clear'>Clear Glass</option>";
                                    }
                                    else if($row['OPV_VALUE'] == 'SSB'){
                                     
                                    }
                                    else{       
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                     }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                                    */
                        ?>
                  </select>
                  <br>
                  
                  Obscured Type:
                  <select class="form-control lpadding in" style="border-radius:4px;" id = "caglass2" name="glass2Name">
                        <?php 
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Option' and OPV_PRODCT=''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                                echo "<option value='Pattern62'>Pattern 62</option>";
                       ?>
                  </select>
                  </div>
                  Add-Ons:
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id ="caglass_i89" name="glass_i89Name"> I89 Coating (Roomside Lo-E)
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id = "caglassTemp" name="glassTempName"> Tempered
                    </label>
                  </div>
                <div id ="catemperedSash" style='display:none'> 
                 <div class="radio"  style ="display:inline-block;margin-right:5px;margin-top:0px;">
                   <label>
                     <input type="radio" name ='tempSashLoc' id ="cabothSashTemp" style="padding-left:0px">Both Sashes
                   </label>
                 </div>
                 <div class="radio"  style ="display:inline-block;margin-right:5px;margin-top:0px;">
                  <label>
                    <input type="radio"  id ="catopSashTemp" name = 'tempSashLoc' style="padding-left:0px">Top Sash
                  </label>
                 </div>
                 <div class="radio"  style ="display:inline-block;margin-top:0px;">
                   <label>
                     <input type="radio" name ='tempSashLoc' id ="cabotSashTemp" style="padding-left:0px">Bottom Sash
                   </label>
                 </div>
                </div>
                <br>
                <input type="button" class="btn btn-success alignRight" name="click3Name" id='caclick3' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;"  name="backClickName3" id='cabackClick3' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "capanel4" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Grille</h3>
                      <span class="pull-right clickable" id ="caspan4"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cacollapse4">
                  <div id = "cagrillePatternDiv">                     
                     <div id ="cagrilleLabelPattern">Pattern:</div>
                     <select class="form-control lpadding in" id="cagrillePattern" name="grillePatternName">
                        echo "<option value='None'>None</option>";
                        echo "<option value='standardColonial'>Standard Colonial</option>";
                        echo "<option value='custColonial'>Custom Colonial</option>";
                        echo "<option value='standardPrairie6'>Standard Prairie, 6 Lite</option>";
                        echo "<option value='standardPrairie9'>Standard Prairie, 9 Lite</option>";
                        echo "<option value='custPrairie'>Custom Prairie</option>";
                        echo "<option value='artsCraft'>Arts & Craft</option>";
                        echo "<option value='custPattern'>Custom Pattern</option>";                         
                     </select>
                   <p></p>
                  </div>
                  <div id ="cagrilleLabelType"> Grille Type:</div>
                  <select class="form-control lpadding in" style="border-radius:4px;" id = "cagrilleType" name="grilleTypeName">
                    <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille' and OPV_PRODCT = 'CA'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'None'){
                                    echo "<option value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                                /*echo "<option value='None'>None</option>";
                                echo '<option value="58Flat">5/8" Flat</option>';
                                echo '<option value="58FlatTT">5/8" Flat-Two Tone</option>';
                                echo '<option value="1316Flat">13/16" Flat</option>';
                                echo '<option value="1316FlatTT">13/16" Flat-Two Tone</option>';
                                echo '<option value="34Prof">3/4" Profile</option>';
                                echo '<option value="34ProfTT">3/4" Profile-Two Tone</option>';
                                echo '<option value="1Prof">1" Profile</option>';
                                echo '<option value="1ProfTT">1" Profile-Two Tone</option>';
                                echo '<option value="34SDL">1-1/4" SDL</option>';
                                echo '<option value="1SDL">7/8" SDL</option>';
                                */
                        ?>
                  </select>
                  <div id = "caspacerOptsDiv" style="display:none">
                    <br>
                     <label class="radio-inline">
                       <input type="radio" name="spcrOptsRdo" id="cawithSpacer">With Internal Spacer
                     </label>
                     <label class="radio-inline">
                       <input type="radio" name="spcrOptsRdo" id="cawithoutSpacer">Without Internal Spacer
                     </label>
                  </div>
                  <div id = "cagrilleColorDiv" style="display:none">
                     
                     <br>   
                     <div id ="cagrilleLabelColor" style = "display:none">Solid Color:</div>
                     <div id ="cagrilleLabelColor2" style = "display:none">Two-Tone Color:</div>
                     <select class="form-control lpadding in" id = "cagrilleColor" name="grilleColorName" style = "display:none">                      
                     </select>
                  </div>
                  
                  <br>
                  <div id ="cagrilleLabelSash" style="display:none">Sash Selection:</div>
                  <select class="form-control lpadding in" style="border-radius:4px;display:none" id ="cagrilleSash" name="grilleSashName">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille Sash Option' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == "Top Sash Only"){
                                    }else if($row['OPV_VALUE'] == "Bottom Sash Only"){
                                    }else{
                                        echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                 </select>
                 <br>
                 <div id = 'cacustGrilleDiv' style = "display:none">
                  <br>
                 <div id ='cacustColonialGrilleDiv' style = "display:none">
                    Custom Colonial Grille:<br><br>
                    <label for = "custColoWide" class ='in' style="font-weight:normal;width:80px">Units Wide:</label><input type="text" class ="form-control squareCorners height30 in" placeholder = 'Units Wide' style='width:20%;margin-bottom:10px' id ="cacustColoWide"/><br>
                    <label for = "custColoHigh" class ='in' style="font-weight:normal;width:80px;">Units High:</label><input type="text" class ="form-control squareCorners height30 in" placeholder ='Units High' style='width:20%' id ="cacustColoHigh"/>
                 </div>
                 <div style="display:none">
                    Custom Grille:
                    <input type="text" class = "form-control squareCorners" placeholder ="Custom Grille" id ="cacustGrilleIn"/> 
                 </div>
                 </div>   
                  <br>
                  <br>
                <input type="button" class="btn btn-success alignRight "  name="click4Name" id='caclick4' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName4"  id='cabackClick4' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "capanel5" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Jamb Size</h3>
                      <span class="pull-right clickable" id="caspan5"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cacollapse5">
                  <div id ="cajambSizeLabel">Jamb Size:</div>
                  <select class="form-control lpadding in" style="border-radius:4px;" id = "cajambSize" name="jambSizeName">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Jamb Size' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'Other'){
                                    echo "<option value='".$row['OPV_VALUE']."'>Custom</option>";
                                    }else{ 
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] .'"'. "</option>";
                                         }
                                         }
                                         
                                } else {
                                    echo "0 results";
                                    }
                                
                        ?>
                  </select>
                  
                  <div class="input-group" style="display: none" id = "cacustomJambDiv">
                  
                  Custom Jamb Size:   
                  <input type="text" class = "form-control squareCorners" placeholder ="Custom Size" class="in" /> 
                </div>
                <br>
                <br>
                <input type="button" class="btn btn-success alignRight "  name="click5Name" id='caclick5' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName5" id='cabackClick5' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "capanel6" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Screens</h3>
                      <span class="pull-right clickable" id="caspan6"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cacollapse6">            
                 <div id = 'cascreenColorLabel'> 
                 Color:              
                 </div>
                  <div class= "input-group" >
                  <select class="form-control lpadding in" id ="cascreenColor" name="screenColorName">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Screen Color' and OPV_PRODCT = 'CA'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                   if($row['OPV_VALUE'] == 'Other'){
                                    echo "<option value='".$row['OPV_VALUE']."'>Custom</option>";
                                    }else{ 
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                         }
                                         }
                                } else {
                                    echo "0 results";
                                    }
                                echo "<option value='Custom'>Custom</option>";
                        ?>
                  </select>
                <span class='input-group-btn' id = 'caviewColors2Button'><button class='btn btn-default' type='button' id = 'cashowColors2' data-toggle="modal" title ='View Colors' data-target="#cacolorModal3">
                <span class ='glyphicon glyphicon-search' style ='width:100%'></span></button></span>
                </div>  
                <div id ="cascreenColorLabelEstate" style = "display:none">Estate Color:</div>
                    <select class="form-control lpadding in" id = "cascreenColorChoiceEstate" style = "display:none; border-radius:4px;" name="screenColorChoiceEstateName">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Estate Colors' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
                                
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                               echo "<option value='Standard'>Standard Colors</option>";
                        ?>
                    </select>
<div class="modal" id="cacolorModal3" tabindex="-1" role="dialog" aria-labelledby="Color Modal" aria-hidden="true">
                  <div class="modal-dialog" id = "cascreenColorModalDialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" id= "cacloseColors3" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="camyModalLabel">Standard Colors</h2>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Almond.png" alt ="label" id="almond"/>
                         <p><h4>Almond</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Beige.png" alt ="label" id = "beige"/>
                         <p><h4>Beige</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Black.png" alt ="label" id="black"/>
                         <p><h4>Black</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Brick.png" alt ="label" id="brick"/>
                         <p><h4>Brick</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/DarkBronze.png" alt ="label" id = "dBronze"/>
                         <p><h4>Dark Bronze</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/ForestGreen.png" alt ="label" id="fGreen"/>
                         <p><h4>Forest Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Vanilla.png" alt ="label" id ="vanilla"/>
                         <p><h4>Vanilla</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/White.png" alt ="label" id="white"/>
                         <p><h4>White</h4></p>
                         </div>
                     </div>
                     <div class="modal-body">
                        <h2 class="modal-title" id="stColModLabel">Estate Colors</h2>
                         
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Cashmere.png" alt ="label" id="cashmere"/>
                         <p><h4>Cashmere</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Chalk.png" alt ="label" id="chalk"/>
                         <p><h4>Chalk</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Fern.png" alt ="label" id="fern"/>
                         <p><h4>Fern</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Glacier.png" alt ="label" id="glacier"/>
                         <p><h4>Glacier</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Gunmetal.png" alt ="label" id="gunmetal"/>
                         <p><h4>Gunmetal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Harbor.png" alt ="label" id="harbor"/>
                         <p><h4>Harbor</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Heather.png" alt ="label" id="heather"/>
                         <p><h4>Heather</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/IceBlue.png" alt ="label" id="iBlue"/>
                         <p><h4>Blue Ice</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Khaki.png" alt ="label" id="khaki"/>
                         <p><h4>Khaki</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Mocha.png" alt ="label" id="mocha"/>
                         <p><h4>Mocha</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Musket.png" alt ="label" id="musket"/>
                         <p><h4>Musket</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Olive.png" alt ="label" id="olive"/>
                         <p><h4>Olive</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Pebble.png" alt ="label" id="pebble"/>
                         <p><h4>Pebble</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Platinum.png" alt ="label" id="platinum"/>
                         <p><h4>Platinum</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Sienna.png" alt ="label" id="sienna"/>
                         <p><h4>Sienna</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Smoke.png" alt ="label" id="smoke"/>
                         <p><h4>Smoke</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SpringGreen.png" alt ="label" id="sGreen"/>
                         <p><h4>Spring Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Suede.png" alt ="label" id="suede"/>
                         <p><h4>Suede</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Teal.png" alt ="label" id ="teal"/>
                         <p><h4>Teal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Wicker.png" alt ="label" id="wicker"/>
                         <p><h4>Wicker</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/BronzeVein.png " width="100px" height="100px" alt ="label" id="bVein"/>
                         <p><h4>Bronze Vein</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SilverVein.png " width="100px" height="100px" alt ="label" id="sVein"/>
                         <p><h4>Silver Vein</h4></p>
                          </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id = "cacloseColors3" data-dismiss="modal">Close</button>
                        
                      </div>
                     </div>
                   </div>
                  </div>
                </div>              
                  <br>
                  <div id = 'cascreenSelectLabel'>
                  Screen Type:
                  </div>
                  <select class="form-control lpadding in" style="border-radius:4px;" id = "cascreenPattern" name="screenPatterName">
                          <option value="Standard">Standard Fiberglass</option>
                          <option value="Bettervue">Bettervue</option>
                          <option value="PetScreen">PetScreen</option>
                 </select>
                <p>
                <div id ="cashipRadios">
                    <label class="radio-inline">
                        <input type="radio"  id ="cashipHardware" checked = "checked" name = 'hardwareShip'>Ship With Product.
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name = 'hardwareShip' id ="cashipScreens3">Ship loose.
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name ='hardwareShip' id ="caholdRelease">Hold for delivery.
                    </label>
                </div>
                </p>
                 <div class="checkbox" style= "margin-bottom: 0px;">
                    <label>
                      <input type="checkbox" id ="cascreens_required" name="screensRequiredName"><strong>Screens Not Required</strong>
                    </label>
                  </div>
                  <br>
                  <br>
                  <input type="button" class="btn btn-success alignRight "  name="click6Name" id='caclick6' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                  <input type="button" class="btn btn-danger alignRight"  style="margin-right: 5px;"  name="backClickName6" id='cabackClick6' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "capanel7" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title ">Hardware</h3>
                      <span class="pull-right clickable" id="caspan7"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cacollapse7">
                <div id ="calabelHardStand">Hardware Color:</div>
                      <select class="form-control lpadding in" style="border-radius:4px;" id = "cahardColorStand" name="hardColorStandName">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Hardware Color' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'None'){
                                 
                                    }else if($row['OPV_VALUE'] == 'Coppertone'){
                                        echo "<option value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    else{
                                        echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                          
                 </select>
                 <p></p>
                 <input type="button" class="btn btn-success alignRight "  name="click7Name" id='caclick7' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                 <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName7" id='cabackClick7' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "capanel8" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Interior Prefinishing</h3>
                      <span class="pull-right clickable" id="caspan8"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cacollapse8">
              <div id="calabelPaint" >Interior Finish</div>
              <select class="form-control lpadding in" style="border-radius:4px;" name="intPrimeName" id = "caintPrime">
                        <?php
                            echo "<option value ='None'>None</option>";
                            echo "<option value ='Mahogany'>Mahogany</option>";
                            echo "<option value ='Cider'>Cider</option>";
                            echo "<option value ='Homestead'>Homestead</option>";
                            echo "<option value ='Clear'>Clear</option>";
                            echo "<option value ='Prime'>Prime Only</option>";
                            echo "<option value ='PrimePaint'>Prime and Paint</option>";
                            /*$sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Interior Finish' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'None'){
                                    echo "<option value=".$row['OPV_VALUE']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                   else if(substr($row['OPV_VALUE'],0,5) == 'Light'){
                                        
                                    }else{
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }*/
                        ?>   
              </select>
              <div id="interiorPaintPrime" style="display:none">
              <br>
              Paint Color:
              <select class = "form-control lpadding in" style="border-radius:4px;" name="intPaintColorName" id='caintPaintColor'>
                <option value='White'>White</option>
                <option value='Custom'>Custom</option>
              </select>
              </div>
              <div class="input-group" style="display: none" name="customIntPaintName" id = "cacustomIntPaint">
               <br>
                  Custom Color:   
                  <input type="text" class = "form-control squareCorners" id ="cacustomIntInput" placeholder ="Custom Color" class="in" /> 
                </div>
                 <br>
                 <br>
                <input type="button" class="btn btn-success alignRight"  name="click8Name"  id='caclick8' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName8" id='cabackClick8' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "capanel9" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Additional Items</h3>
                      <span class="pull-right clickable" id ="caspan9"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cacollapse9">
            
                Accessories:
                <select class="form-control lpadding in" style="border-radius:4px;" id = "cainstall1" name="install1Name">
                    <option value="None">None</option>
                    <option value="Brickmold w/Fin">Brickmold w/Fin</option>
                    <option value="Brickmold w/out Fin">Brickmold w/out Fin</option>
                    <option value='4" Panning'>4" Panning</option>
                    <option value='1-7/8" Panning'>1-7/8" Panning</option>  
                </select> 
                <p></p>
                Installation Method 
                <select class="form-control lpadding in" id = "canailFinSelect" name="nailFinSelectName">
                    <option value="none">None</option>
                    <option value="Nail">Nail Fin</option>
                    <option value="Mason7">7" Masonry Strap</option>
                    <option value="Mason9">9" Masonry Strap</option>
                    <option value='Mason11'>11" Masonry Strap</option>
                </select>
                <br>
                <br>
                  <button type = "button" data-loading-text="Loading..." autocomplete="off" class = "btn btn-success alignRight" name="addToOrderName" id ="caadd_row">Add to Order</button>
                  <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName9" id='cabackClick9' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
      </div>
      <div id ='sliderPanels' style="display:none">
          <div class="panel-body lpadding npadbot" id = "cspanel1">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Configuration - Clad Sliders</h3>
                      <span class="pull-right clickable" id = "csspan1"><i class="glyphicon glyphicon-chevron-up"></i></span>
                </div>
                <div class="panel-body" id="cscollapse1">
                
                  Label:<br>
                  <input type="text" class = "form-control squareCorners" placeholder="Enter Label Here..." style="width:60%;" name = "windowLabelName" id="cswindowLabel"></input>
                  <input type="hidden" id ="cshiddenWinQuant" value='1'></input>
                 <div class = "form-group" style="margin-bottom:3px;" id ='cscustDimsRadio' name="custDimsRadioName">
                  <div class="radio in">
                       <label>
                          <input type="radio" name="csoptions" id="cscustDimsFt" checked="checked">Feet and Inches
                       </label>
                     </div>
                     <div class = "radio in" style = 'padding-left: 8px'> 
                       <label>   
                          <input type="radio" name="csoptions" id="cscustDimsInch">Inches
                       </label>
                     </div>
                  </div>
                  <div id="cscustDimsTextW">Width <font size = '1px'>(Glass Size) Unit Dimension</font></div>
                  <?php
                         
                            $sql = "SELECT BMS_SIZE01 AS BMS_SIZE1, BMS_SIZE02 AS BMS_SIZE2, BMS_SIZE03 AS BMS_SIZE3, BMS_SIZE04 AS BMS_SIZE4, BMS_SIZE05 AS BMS_SIZE5, BMS_SIZE06 AS BMS_SIZE6, BMS_SIZE07 AS BMS_SIZE7, BMS_SIZE08 AS BMS_SIZE8, BMS_SIZE09 AS BMS_SIZE9, BMS_SIZE10, BMS_SIZE11, BMS_SIZE12,BMS_SIZE13, BMS_SIZE14, BMS_SIZE15,  BMS_SIZE16, BMS_SIZE17, BMS_SIZE18, BMS_SIZE19, BMS_SIZE20, BMS_SIZE21, BMS_SIZE22, BMS_SIZE23, BMS_SIZE24, BMS_SIZE25, BMS_SIZE26, BMS_SIZE27,BMS_SIZE28,BMS_SIZE29,BMS_SIZE30,BMS_SIZE31,BMS_SIZE32, BMS_SIZE33, BMS_SIZE34, BMS_SIZE35, BMS_SIZE36, BMS_SIZE37, BMS_SIZE38, BMS_SIZE39, BMS_SIZE40, BMS_SIZE41, BMS_SIZE42, BMS_SIZE43, BMS_SIZE44, BMS_SIZE45,BMS_SIZE46,BMS_SIZE47,BMS_SIZE48,BMS_SIZE49,BMS_SIZE50 AS BMS_SIZE50  FROM BOMMSIZ WHERE BMS_STKPRE = 'CS' AND BMS_STRCNO ='1'";
                            $result = $conn->query($sql);
                              $sixteenCount = 0;
                              $twentyCount = 0;
                              $twentyFourCount = 0;
                              $twentyEightCount = 0;
                              $thirtyTwoCount = 0;
                              if ($result->num_rows > 0){
                              echo "<select class='form-control lpadding' style='border-radius:4px;' name='dimsWName' id = 'csdimsW'>";
                                while($row = $result->fetch_assoc()){
                                    for($x=1;$x<sizeof($row);$x++){
                                        $tempVal = substr($row['BMS_SIZE'.$x],0,2);
                                        if($tempVal == 16 && $sixteenCount == 0){
                                            $unitDimW16 = ($tempVal + (47/8)) - (1/2);
                                            $uDW16Str = floor($unitDimW16/12) . '&#039;-' . floor($unitDimW16%12) . ' ' . 8 * fmod(fmod($unitDimW16,12),1) .'/8"'; 
                                            echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW16Str. '</option>';
                                            $sixteenCount++;
                                        }
                                        if($tempVal == 20 && $twentyCount == 0){
                                            $unitDimW20 = ($tempVal + (47/8)) - (1/2);
                                            $uDW20Str = floor($unitDimW20/12) . '&#039;-' . floor($unitDimW20%12) . ' ' . 8 * fmod(fmod($unitDimW20,12),1) .'/8"'; 
                                            echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW20Str. '</option>';
                                            $twentyCount++;
                                        }
                                        if($tempVal == 24 && $twentyFourCount == 0){
                                            $unitDimW24 = ($tempVal + (47/8)) - (1/2);
                                            $uDW24Str = floor($unitDimW24/12) . '&#039;-' . floor($unitDimW24%12) . ' ' . 8 * fmod(fmod($unitDimW24,12),1) .'/8"';
                                            echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW24Str. '</option>';
                                            $twentyFourCount++;
                                        }
                                        if($tempVal == 28 && $twentyEightCount == 0){
                                            $unitDimW28 = ($tempVal + (47/8)) - (1/2);
                                            $uDW28Str = floor($unitDimW28/12) . '&#039;-' . floor($unitDimW28%12) . ' ' . 8 * fmod(fmod($unitDimW28,12),1) .'/8"';
                                            echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW28Str. '</option>';
                                            $twentyEightCount++;
                                        }
                                        if($tempVal == 32 && $thirtyTwoCount == 0){
                                            $unitDimW32 = ($tempVal + (47/8)) - (1/2);
                                            $uDW32Str = floor($unitDimW32/12) . '&#039;-' . floor($unitDimW32%12) . ' ' . 8 * fmod(fmod($unitDimW32,12),1) .'/8"';
                                            echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW32Str. '</option>';
                                            $thirtyTwoCount++;
                                        }                                    
                                    
                                    }
                                    
                              
                              
                              echo '</select>';
                              
                              echo "<div id='custDimsTextH'>Height <font size = '1px'>(Glass Size) Unit Dimension</font></div>";
                              $twentyEightCount = 0;
                              $thirtyTwoCount = 0;
                              $thirtySixCount = 0;
                              $fortyCount = 0;
                              $fortyEightCount = 0;
                              echo "<select class='form-control lpadding' style='border-radius:4px;' name='dimsHName' id = 'csdimsH'>";
                                    for($y=1;$y<sizeof($row);$y++){
                                    $tempVal = substr($row['BMS_SIZE'.$y],2,2);
                                    if($tempVal == 28 && $twentyEightCount == 0){
                                            $unitDimW28 = ($tempVal + (47/8)) - (1/2);
                                            $uDW28Str = floor($unitDimW28/12) . '&#039;-' . floor($unitDimW28%12) . ' ' . 8 * fmod(fmod($unitDimW28,12),1) .'/8"';
                                            echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW28Str. '</option>';
                                            $twentyEightCount++;
                                    }
                                    if($tempVal == 32 && $thirtyTwoCount == 0){
                                            $unitDimW32 = ($tempVal + (47/8)) - (1/2);
                                            $uDW32Str = floor($unitDimW32/12) . '&#039;-' . floor($unitDimW32%12) . ' ' . 8 * fmod(fmod($unitDimW32,12),1) .'/8"';
                                            echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW32Str. '</option>';
                                            $thirtyTwoCount++;
                                    }
                                    if($tempVal == 36 && $thirtySixCount == 0){
                                        $unitDimH36 = (2*$tempVal + 9) - (13/16);
                                        $uDH36Str = floor($unitDimH36/12) . "'-" . floor($unitDimH36%12) . ' ' . 16 * fmod(fmod($unitDimH36,12),1) .'/16"'; 
                                        echo '<option value='.$tempVal.'>(' .$tempVal.')  ' . $uDH36Str . '</option>';
                                        $thirtySixCount++;
                                    }
                                    if($tempVal == 40 && $fortyCount == 0){
                                        $unitDimW40 = ($tempVal + (47/8)) - (1/2);
                                        $uDW40Str = floor($unitDimW40/12) . '&#039;-' . floor($unitDimW40%12) . ' ' . 8 * fmod(fmod($unitDimW40,12),1) .'/8"';
                                        echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW40Str. '</option>';
                                        $fortyCount++;
                                    } 
                                    if($tempVal == 48 && $fortyEightCount == 0){
                                        $unitDimH48 = $tempVal + 5.0625;
                                        $uDH48Str = floor($unitDimH48/12) . "'-" . floor($unitDimH48%12) . ' ' . 16 * fmod(fmod($unitDimH48,12),1) .'/16"'; 
                                        echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH48Str . '</option>';
                                        $fortyEightCount++;
                                    }
                                    }
                               echo '</select>';
                               
                                  }
                                } else {
                                    echo "0";
                                }
                       ?>
                 
                        
                  </select>
              
                Units Wide:
                 <select class="form-control lpadding " style="border-radius:4px;" name='installMulls1Name' id = "csinstallMulls1">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Mulled Units' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                    echo "<option value='none' selected>1</option>";
                                while($row = $result->fetch_assoc()){
                                   if($row['OPV_VALUE'] == 'Single'){
                                    echo "<option value='".$row['OPV_VALUE']."'>2</option>";
                                   }
                                   else if($row['OPV_VALUE'] == 'Twin'){
                                    echo "<option value='".$row['OPV_VALUE']."'>3</option>";
                                   }
                                   else if($row['OPV_VALUE'] == 'Triple'){
                                    echo "<option value='".$row['OPV_VALUE']."'>4</option>";
                                   }
                                   else if($row['OPV_VALUE'] == 'Quad'){
                                    echo "<option value='".$row['OPV_VALUE']."'>5</option>";
                                   } 
                                 }
                                 }else {
                                    echo "0 results";
                                    }
                                
                             
                        ?>
                 </select>
                  <script type="text/javascript">
                    var selectList = $('#csinstallMulls1 option');
                    selectList.sort(function(a,b){
                       a = a.text;
                       b = b.text; 
                       return a-b;
                    });
                    
                    $('#csinstallMulls1').html(selectList);
                    $('#csinstallMulls1').val('none');
                 </script> 
                 <select class="form-control lpadding" style="border-radius:4px;display:none" name='installBalancesName' id = "csinstallBalances">
                        
                 </select>
                  
                  <br>
                
                  <input type="button" class = "btn btn-default" id = "cscustomDimsButton" value= "Custom Dimensions" style ="margin-bottom:10px">
                  
                  <div class="input-group" id="cscustomDims" style="display:none">
                     
                  <div id='cscustomDimsLabel'><strong>Custom Size:</strong><br></div>
               <div class ='form-group' id = "cscustDimsInchs" style = "display:none"> 
                  Width:&nbsp;<input type="text" style="width:100%" id ='cscustDimW' placeholder ="Width" class="dims in"/>  
                         <br>
                         
                  Height:&nbsp;<input type="text" style="width:100%" id ='cscustDimH' placeholder ="Height" class="dims in"/> 
                </div>
                
                <div class ="form-group" id='csftInCustDims' style = "display:none">
                 Width:
                 <input type="text" id ='cscustDimWFt' placeholder ="Feet" class="dims in"/> +
                 <input type="text" id ='cscustDimWInch' placeholder ="Inches" class="dims in"/> 
                 <br>
                 <br>
                 Height:  
                 <input type="text" id ='cscustDimHFt' placeholder ="Feet" class="dims in"/> +
                 <input type="text" id ='cscustDimHInch' placeholder ="Inches" class="dims in"/> 
                </div>
                </div>
                <br>
                <button type = "button" class ="btn magik" name="addTransomName"  id="csaddTransom1">Add Transom Window</button>  
                <input type="button" class="btn btn-success alignRight " name="click1Name" id='csclick1' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <button type="button" data-loading-text="Loading..." class="btn btn-info alignRight" name="quickAddName" id='csquickAdd' autocomplete="off" style ='margin-right:5px;'>Quick Add</button>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cspanel2" style="display: none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Exterior</h3>
                      <span class="pull-right clickable" id="csspan2"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cscollapse2">
                
                <div id="csexColorLabel">Standard Colors:</div>
                <div class='input-group'>
                  <select class="form-control lpadding in" name='extColorChoiceName' id = "csextColorChoice">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Clad Color' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                  </select>
                <span class='input-group-btn'><button class='btn btn-default' type='button' id = 'csshowColors' data-toggle="modal" title ='View Colors' data-target="#colorModal">
                <span class ='glyphicon glyphicon-search' style ='width:100%'></span></button></span>
                </div>
               
                  <div id ="csextColorLabelEstate" style = "display:none">Estate Color:</div>
                   <select class="form-control lpadding in" name='extColorChoiceEstateName'  id = "csextColorChoiceEstate" style = "display:none; border-radius:4px;">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Estate Colors' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
                                
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                               echo "<option value='Standard'>Standard Colors</option>";
                        ?>
                  </select>
                <div class="modal" id="cscolorModal" tabindex="-1" role="dialog" aria-labelledby="Color Modal" aria-hidden="true">
                  <div class="modal-dialog" id='cscolorModalDialog'>
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" id= "cscloseColors1" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="csmyModalLabel">Standard Colors</h2>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Almond.png" alt ="label" id="almond"/>
                         <p><h4>Almond</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Beige.png" alt ="label" id = "beige"/>
                         <p><h4>Beige</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Black.png" alt ="label" id="black"/>
                         <p><h4>Black</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Brick.png" alt ="label" id="brick"/>
                         <p><h4>Brick</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/DarkBronze.png" alt ="label" id = "dBronze"/>
                         <p><h4>Dark Bronze</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/ForestGreen.png" alt ="label" id="fGreen"/>
                         <p><h4>Forest Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Vanilla.png" alt ="label" id ="vanilla"/>
                         <p><h4>Vanilla</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/White.png" alt ="label" id="white"/>
                         <p><h4>White</h4></p>
                         </div>
                     </div>
                     <div class="modal-body">
                        <h2 class="modal-title" id="csstColModLabel">Estate Colors</h2>
                         
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Cashmere.png" alt ="label" id="cashmere"/>
                         <p><h4>Cashmere</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Chalk.png" alt ="label" id="chalk"/>
                         <p><h4>Chalk</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Fern.png" alt ="label" id="fern"/>
                         <p><h4>Fern</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Glacier.png" alt ="label" id="glacier"/>
                         <p><h4>Glacier</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Gunmetal.png" alt ="label" id="gunmetal"/>
                         <p><h4>Gunmetal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Harbor.png" alt ="label" id="harbor"/>
                         <p><h4>Harbor</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Heather.png" alt ="label" id="heather"/>
                         <p><h4>Heather</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/IceBlue.png" alt ="label" id="iBlue"/>
                         <p><h4>Blue Ice</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Khaki.png" alt ="label" id="khaki"/>
                         <p><h4>Khaki</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Mocha.png" alt ="label" id="mocha"/>
                         <p><h4>Mocha</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Musket.png" alt ="label" id="musket"/>
                         <p><h4>Musket</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Olive.png" alt ="label" id="olive"/>
                         <p><h4>Olive</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Pebble.png" alt ="label" id="pebble"/>
                         <p><h4>Pebble</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Platinum.png" alt ="label" id="platinum"/>
                         <p><h4>Platinum</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Sienna.png" alt ="label" id="sienna"/>
                         <p><h4>Sienna</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Smoke.png" alt ="label" id="smoke"/>
                         <p><h4>Smoke</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SpringGreen.png" alt ="label" id="sGreen"/>
                         <p><h4>Spring Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Suede.png" alt ="label" id="suede"/>
                         <p><h4>Suede</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Teal.png" alt ="label" id ="teal"/>
                         <p><h4>Teal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Wicker.png" alt ="label" id="wicker"/>
                         <p><h4>Wicker</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/BronzeVein.png " width="100px" height="100px" alt ="label" id="bVein"/>
                         <p><h4>Bronze Vein</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SilverVein.png " width="100px" height="100px" alt ="label" id="sVein"/>
                         <p><h4>Silver Vein</h4></p>
                          </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id = "cscloseColors2" data-dismiss="modal">Close</button>
                        
                      </div>
                     </div>
                   </div>
                  </div>
                </div>
                <div class="input-group" style="display: none" id = "cscustExtColorInput">
                   <br>
                      Custom Color:   
                      <input type="text" class = "form-control squareCorners" id ="cscustomExtInput" placeholder ="Custom Color" class="in" /> 
                </div>
                  <br>
                  <br>
                <input type="button" class="btn btn-success alignRight" name="click2Name"  id='csclick2' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName2" id='csbackClick2' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cspanel3" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Glass</h3>
                      <span class="pull-right clickable" id = "csspan3"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cscollapse3">
                <div class = "form-group">
                  Insulated Glass Type:
                  <select class="form-control lpadding in" name='glass1Name' id = "csglass1" style="border-radius:4px;">
                          <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Type' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){     
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                                    
                        ?>
                  </select>
                  <br>
                  
                  Obscured Type:
                  <select class="form-control lpadding in" style="border-radius:4px;" name="glass2Name" id = "csglass2">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Option' and OPV_PRODCT=''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                                echo "<option value='Pattern62'>Pattern 62</option>";
                        ?>
                  </select>
                  </div>
                  Add-Ons:
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="glass_i89Name"  id ="csglass_i89"> I89 Coating (Roomside Lo-E)
                    </label>
                  </div> 
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="glassTempName" id = "csglassTemp"> Tempered
                    </label>
                  </div>
                <div id ="cstemperedSash" style='display:none'> 
                 <div class="radio"  style ="display:inline-block;margin-right:5px;margin-top:0px;">
                   <label>
                     <input type="radio" name ='tempSashLoc' id ="csbothSashTemp" style="padding-left:0px">Both Sashes
                   </label>
                 </div>
                 <div class="radio"  style ="display:inline-block;margin-right:5px;margin-top:0px;">
                  <label>
                    <input type="radio"  id ="cstopSashTemp" name = 'tempSashLoc' style="padding-left:0px">Top Sash
                  </label>
                 </div>
                 <div class="radio"  style ="display:inline-block;margin-top:0px;">
                   <label>
                     <input type="radio" name ='tempSashLoc' id ="csbotSashTemp" style="padding-left:0px">Bottom Sash
                   </label>
                 </div>
                </div>
                <br>
                <input type="button" class="btn btn-success alignRight"  name="click3Name" id='csclick3' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName3"  id='csbackClick3' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cspanel4" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Grille</h3>
                      <span class="pull-right clickable" id ="csspan4"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cscollapse4">
                  <div id = "csgrillePatternDiv">                     
                     <div id ="csgrilleLabelPattern">Pattern:</div>
                     <select class="form-control lpadding in" name="grillePatternName" id="csgrillePattern">
                        echo "<option value='None'>None</option>";
                        echo "<option value='standardColonial'>Standard Colonial</option>";
                        echo "<option value='custColonial'>Custom Colonial</option>";
                        echo "<option value='standardPrairie6'>Standard Prairie, 6 Lite</option>";
                        echo "<option value='standardPrairie9'>Standard Prairie, 9 Lite</option>";
                        echo "<option value='custPrairie'>Custom Prairie</option>";
                        echo "<option value='artsCraft'>Arts & Craft</option>";
                        echo "<option value='custPattern'>Custom Pattern</option>";                         
                     </select>
                   <p></p>
                  </div>
                  <div id ="csgrilleLabelType"> Grille Type:</div>
                  <select class="form-control lpadding in" style="border-radius:4px;" name="grilleTypeName" id = "csgrilleType">
                    <?php
                         $sql = "SELECT OPV_INVDES,OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille' and OPV_PRODCT = 'CS'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_INVDES'] == 'None'){
                                    echo "<option value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_INVDES'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_INVDES'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                  </select>
                  <div id = "csspacerOptsDiv" style="display:none">
                    <br>
                     <label class="radio-inline">
                       <input type="radio" name="spcrOptsRdo" id="cswithSpacer">With Internal Spacer
                     </label>
                     <label class="radio-inline">
                       <input type="radio" name="spcrOptsRdo" id="cswithoutSpacer">Without Internal Spacer
                     </label>
                  </div>
                  <div id = "csgrilleColorDiv" style="display:none">
                     
                     <br>   
                     <div id ="csgrilleLabelColor" style = "display:none">Solid Color:</div>
                     <div id ="csgrilleLabelColor2" style = "display:none">Two-Tone Color:</div>
                     <select class="form-control lpadding in" id = "csgrilleColor" name="grilleColorName" style = "display:none">                      
                     </select>
                  </div>
                  
                  <br>
                  <div id ="csgrilleLabelSash" style="display:none">Sash Selection:</div>
                  <select class="form-control lpadding in" style="border-radius:4px;display:none" name="grilleSashName" id ="csgrilleSash">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille Sash Option' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                 </select>
                 <br>
                 <div id = 'cscustGrilleDiv' style = "display:none">
                  <br>
                 <div id ='cscustColonialGrilleDiv' style = "display:none">
                    Custom Colonial Grille:<br><br>
                    <label for = "custColoWide" class ='in' style="font-weight:normal;width:80px">Units Wide:</label><input type="text" class ="form-control squareCorners height30 in" placeholder = 'Units Wide' style='width:20%;margin-bottom:10px' id ="cscustColoWide"/><br>
                    <label for = "custColoHigh" class ='in' style="font-weight:normal;width:80px;">Units High:</label><input type="text" class ="form-control squareCorners height30 in" placeholder ='Units High' style='width:20%' id ="cscustColoHigh"/>
                 </div>
                 <div style="display:none">
                    Custom Grille:
                    <input type="text" class = "form-control squareCorners" placeholder ="Custom Grille" id ="cscustGrilleIn"/> 
                 </div>
                 </div>   
                  <br>
                  <br>
                  
                <input type="button" class="btn btn-success alignRight"  name="click4Name" id='csclick4' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;"  name="backClickName4" id='csbackClick4' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cspanel5" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Jamb Size</h3>
                      <span class="pull-right clickable" id="csspan5"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cscollapse5">
                  <div id ="csjambSizeLabel">Jamb Size:</div>
                  <select class="form-control lpadding in" style="border-radius:4px;" name="jambSizeName" id = "csjambSize">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Jamb Size' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'Other'){
                                    echo "<option value='".$row['OPV_VALUE']."'>Custom</option>";
                                    }else{ 
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] .'"'. "</option>";
                                         }
                                         }
                                         
                                } else {
                                    echo "0 results";
                                    }
                                
                        ?>
                  </select>
                  
                  <div class="input-group" style="display: none" id = "cscustomJambDiv">
                  
                  Custom Jamb Size:   
                  <input type="text" class = "form-control squareCorners" placeholder ="Custom Size" class="in" /> 
                </div>
                <br>
                <br>
                <input type="button" class="btn btn-success alignRight"  name="click5Name" id='csclick5' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;"  name="backClickName5"  id='csbackClick5' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cspanel6" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Screens</h3>
                      <span class="pull-right clickable" id="csspan6"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cscollapse6">            
                 <div id = 'csscreenColorLabel'> 
                 Color:              
                 </div>
                  <div class= "input-group" >
                  <select class="form-control lpadding in" name="screenColorName" id ="csscreenColor">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Screen Color' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                   if($row['OPV_VALUE'] == 'Other'){
                                    echo "<option value='".$row['OPV_VALUE']."'>Custom</option>";
                                    }else{ 
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                         }
                                         }
                                } else {
                                    echo "0 results";
                                    }
                           
                        ?>
                  </select>
                <span class='input-group-btn' id = 'csviewColors2Button'><button class='btn btn-default' type='button' id = 'csshowColors2' data-toggle="modal" title ='View Colors' data-target="#colorModal3">
                <span class ='glyphicon glyphicon-search' style ='width:100%'></span></button></span>
                </div>  
                <div id ="csscreenColorLabelEstate" style = "display:none">Estate Color:</div>
                   <select class="form-control lpadding in" id = "csscreenColorChoiceEstate" name="screenColorChoiceEstateName" style = "display:none; border-radius:4px;">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Estate Colors' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                          
                              if ($result->num_rows > 0){
                                
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                               echo "<option value='Standard'>Standard Colors</option>";
                        ?>
                  </select>
<div class="modal" id="cscolorModal3" tabindex="-1" role="dialog" aria-labelledby="Color Modal" aria-hidden="true">
                  <div class="modal-dialog" id = "csscreenColorModalDialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" id= "cscloseColors3" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="csmyModalLabel">Standard Colors</h2>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Almond.png" alt ="label" id="almond"/>
                         <p><h4>Almond</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Beige.png" alt ="label" id = "beige"/>
                         <p><h4>Beige</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Black.png" alt ="label" id="black"/>
                         <p><h4>Black</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Brick.png" alt ="label" id="brick"/>
                         <p><h4>Brick</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/DarkBronze.png" alt ="label" id = "dBronze"/>
                         <p><h4>Dark Bronze</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/ForestGreen.png" alt ="label" id="fGreen"/>
                         <p><h4>Forest Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Vanilla.png" alt ="label" id ="vanilla"/>
                         <p><h4>Vanilla</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/White.png" alt ="label" id="white"/>
                         <p><h4>White</h4></p>
                         </div>
                     </div>
                     <div class="modal-body">
                        <h2 class="modal-title" id="csstColModLabel">Estate Colors</h2>
                         
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Cashmere.png" alt ="label" id="cashmere"/>
                         <p><h4>Cashmere</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Chalk.png" alt ="label" id="chalk"/>
                         <p><h4>Chalk</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Fern.png" alt ="label" id="fern"/>
                         <p><h4>Fern</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Glacier.png" alt ="label" id="glacier"/>
                         <p><h4>Glacier</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Gunmetal.png" alt ="label" id="gunmetal"/>
                         <p><h4>Gunmetal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Harbor.png" alt ="label" id="harbor"/>
                         <p><h4>Harbor</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Heather.png" alt ="label" id="heather"/>
                         <p><h4>Heather</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/IceBlue.png" alt ="label" id="iBlue"/>
                         <p><h4>Blue Ice</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Khaki.png" alt ="label" id="khaki"/>
                         <p><h4>Khaki</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Mocha.png" alt ="label" id="mocha"/>
                         <p><h4>Mocha</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Musket.png" alt ="label" id="musket"/>
                         <p><h4>Musket</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Olive.png" alt ="label" id="olive"/>
                         <p><h4>Olive</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Pebble.png" alt ="label" id="pebble"/>
                         <p><h4>Pebble</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Platinum.png" alt ="label" id="platinum"/>
                         <p><h4>Platinum</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Sienna.png" alt ="label" id="sienna"/>
                         <p><h4>Sienna</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Smoke.png" alt ="label" id="smoke"/>
                         <p><h4>Smoke</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SpringGreen.png" alt ="label" id="sGreen"/>
                         <p><h4>Spring Green</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Suede.png" alt ="label" id="suede"/>
                         <p><h4>Suede</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Teal.png" alt ="label" id ="teal"/>
                         <p><h4>Teal</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/Wicker.png" alt ="label" id="wicker"/>
                         <p><h4>Wicker</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/BronzeVein.png " width="100px" height="100px" alt ="label" id="bVein"/>
                         <p><h4>Bronze Vein</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <input type = "image" img src = "colors/Estate/SilverVein.png " width="100px" height="100px" alt ="label" id="sVein"/>
                         <p><h4>Silver Vein</h4></p>
                          </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id = "cscloseColors3" data-dismiss="modal">Close</button>
                        
                      </div>
                     </div>
                   </div>
                  </div>
                </div>              
                  <br>
                  <div id = 'csscreenSelectLabel'>
                  Screen Type:
                  </div>
                  <select class="form-control lpadding in" style="border-radius:4px;" name="screenPatternName" id = "csscreenPattern">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Screen Type' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                         }
                                } else {
                                    echo "0 results";
                                    }
                           
                        ?>
                 </select>
                <p>
                <div id ="csshipRadios">
                    <label class="radio-inline">
                        <input type="radio"  id ="csshipHardware" checked = "checked" name = 'hardwareShip'>Ship With Product.
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name = 'hardwareShip' id ="csshipScreens3">Ship loose.
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name ='hardwareShip' id ="csholdRelease">Hold for delivery.
                    </label>
                </div>
                </p>
                 <div class="checkbox" style= "margin-bottom: 0px;">
                    <label>
                      <input type="checkbox" id ="csscreens_required" name="screens_requiredName"><strong>Screens Not Required</strong>
                    </label>
                  </div>
                  <br>
                  <br>
                  <input type="button" class="btn btn-success alignRight"  name="click6Name" id='csclick6' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                  <input type="button" class="btn btn-danger alignRight"  style="margin-right: 5px;"  name="backClickName6" id='csbackClick6' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cspanel7" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title ">Hardware</h3>
                      <span class="pull-right clickable" id="csspan7"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cscollapse7">
                
                      <div id ="cslabelHardStand">Hardware Color:</div>
                      <select class="form-control lpadding in" style="border-radius:4px;" name="hardColorStandName" id = "cshardColorStand">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Hardware Color' and OPV_PRODCT = ''";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
    
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'None'){
                                 
                                    }else if($row['OPV_VALUE'] == 'Coppertone'){
                                        echo "<option value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    else{
                                        echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                          
                 </select>
                <br>
                <br>
                 <input type="button" class="btn btn-success alignRight"  name="click7Name" id='csclick7' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                 <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName7"  id='csbackClick7' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cspanel8" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Interior Prefinishing</h3>
                      <span class="pull-right clickable" id="csspan8"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cscollapse8">
              <div id="cslabelPaint" >Interior Finish</div>
              <select class="form-control lpadding in" style="border-radius:4px;" name="intPrimeName" id = "csintPrime">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Interior Finish' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'None'){
                                    echo "<option value=".$row['OPV_VALUE']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                   else if(substr($row['OPV_VALUE'],0,5) == 'Light'){
                                        
                                    }else{
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>   
              </select>
              <div id="csinteriorPaintPrime" style="display:none">
              <br>
              Paint Color:
              <select class = "form-control lpadding in" style="border-radius:4px;" name="intPaintColorName" id='csintPaintColor'>
                <option value='White'>White</option>
                <option value='Custom'>Custom</option>
              </select>
              </div>
              <div class="input-group" style="display: none" name="customIntPaintName" id = "cscustomIntPaint">
               <br>
                  Custom Color:   
                  <input type="text" class = "form-control squareCorners" id ="cscustomIntInput" placeholder ="Custom Color" class="in" /> 
                </div>
                 <br>
                 <br>
                <input type="button" class="btn btn-success alignRight"  name="click8Name"  id='csclick8' value="&nbsp;&nbsp;&nbsp;&nbsp; Next &nbsp;&nbsp;&nbsp;&nbsp;"/>
                <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName8" id='csbackClick8' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
        <div class="panel-body lpadding npadtop npadbot" id = "cspanel9" style="display:none">
          
              <div class="panel panel-primary">
                <div class="panel-heading">
                      <h3 class="panel-title">Additional Items</h3>
                      <span class="pull-right clickable" id ="csspan9"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="cscollapse9">
            
                    Accessories:
                    <select class="form-control lpadding in" style="border-radius:4px;" id = "csinstall1" name="install1Name">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_INVDES FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Accessories' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'None'){
                                    echo "<option value=".$row['OPV_VALUE']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_INVDES'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    Installation Method 
                    <select class="form-control lpadding in" id = "csnailFinSelect" name="nailFinSelectName">
                        <?php
                            $sql = "SELECT OPV_VALUE,OPV_INVDES FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Installation' and OPV_PRODCT = 'CDH'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'None'){
                                    echo "<option value=".$row['OPV_VALUE']. " selected='selected'>" . $row['OPV_INVDES'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_INVDES'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
            
                    <br>
                    <br>
                  <button type = "button" data-loading-text="Loading..." autocomplete="off" class = "btn btn-success alignRight" name="addToOrderName" id ="csadd_row">Add to Order</button>
                  <input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName9" id='csbackClick9' value="Back"/>
              </div>
            </div>
        </div><!--end collapse-->
      </div>
      
      <div id="mainGlassDiv" style="display:none">
        <div class="panel-body lpadding npadbot" id = "glasspanel1">
             <div id="glassOrderPOInput"> PO/Order Name: <input class="in" id="topGlassPOInput" style="width: 40%" maxlength="15" type="text" placeholder="Enter PO here..." />&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="javascript:editHeader()" class="btn btn-default in">Edit Customer Info</button></div><br>
              <div class="panel panel-primary" id="glassPanelPrimary">
                <div class="panel-heading" id="glassPanelHeading">
                      <h3 class="panel-title">Glass Order</h3>
                      <span class="pull-right clickable" id ="glasspan1"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="glasscollapse1">
                    <div class="glassInput" id="glassProductLabel">Product:</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;" id = "glassOrderProduct" name="glassOrderProduct">
                        <option value="Default">Select...</option>
                        <option value="RECT IG">Rectangle IG Unit</option>
                        <option value="SHAPE IG">Shape IG Unit</option>
                        <option value="TRIPLE RECT">Triple Rectangle IG Unit</option>
                        <option value="TRIPLE SHAPE">Triple Shape IG Unit</option>
                        <option value="MONO RECT">Mono Rectangle Glass</option>
                        <option value="MONO SHAPE">Mono Shape Glass</option>
                    </select>
                    <p></p>
                    <div class="glassInput in">Width (In.):</div> &nbsp;<input type="text" class = "in glassInput" value="" style="width:10%" id ="glassWidth1"/> 
                    <div class ="in" id='squareFeetDisplayDiv'></div>
                    <br><br>
                    <div  class="glassInput in ">Height (In.):</div> &nbsp;<input type="text" class = "squareCorners in glassInput" value="" style="width:10%" id ="glassHeight1"/>
                    <br><br>
                    <div class="glassInput in" id="glassOverallLabel"> Overall Thickness (In.):</div> &nbsp;<input type="text" value= "" class = "squareCorners in glassInput" style="width:10%" id ="glassThickness1"/>
                    <p></p>
                    <input type="hidden" id="hiddenGlassLabel"/>
                    <div id="glassShapeLabel" class="glassInput in" style="display:none">Shape:&#160;</div><font id ="viewsFromTheSix" class="in" style="font-size:.8em;display:none"> (View from exterior)</font>
                    <div class='input-group' style="display:none" id="glassShapeInputGroup">  
                    <select class="form-control lpadding in glassInput" id = "glassOrderShape" style="border-top-left-radius:4px;border-bottom-left-radius:4px;" name="glassShapeName">
                        <?php
                            //$custTrapCount = 0;
                            //$custCurveCount = 0;
                            //$custHexCount = 0;
                            //$custPentCount = 0;
                            $sql = "SELECT GSH_DESC, GSH_TYPE, GSH_SHAPE FROM GLASSSHAPE";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                  $tempArrVal = $row['GSH_DESC'];
                                  if($row['GSH_DESC'] == ""){
                                  }else{
                                    echo "<option value='".$row['GSH_TYPE']."' id='".$row['GSH_SHAPE']."'>#" .$row['GSH_SHAPE']." " . ucwords(strtolower($row['GSH_DESC'])) . "</option>";
                                    }
                                  }
                                  }else{
                                    echo "0 results";
                                  }
                        ?>
                    </select>
                    <span class='input-group-btn'><button class='btn btn-default' style="display:none" type='button' id = 'showGlassShapes' data-toggle="modal" title ='View Shapes' data-target="#glassShapeModal">
                    <span class ='glyphicon glyphicon-search' style ='width:100%'></span></button></span>
                  </div> 
                <div class="modal" id="glassShapeModal" tabindex="-1" role="dialog" aria-labelledby="Glass Shape Modal" aria-hidden="true" width="100%">
                  <div class="modal-dialog modal-lg" id = "glassModalDialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" id= "glassModalClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title" id="glassModalLabel">Glass Shapes (VIEWED FROM EXTERIOR)</h2>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/1.PNG" alt ="label" id="shape1"/>
                         <p><h4>#1</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/2.PNG" alt ="label" id="shape2"/>
                         <p><h4>#2</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/3.PNG" alt ="label" id="shape3"/>
                         <p><h4>#3</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/4.PNG" alt ="label" id="shape4"/>
                         <p><h4>#4</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/5.PNG" alt ="label" id="shape5"/>
                         <p><h4>#5</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/6.PNG" alt ="label" id="shape6"/>
                         <p><h4>#6</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/7.PNG" alt ="label" id="shape7"/>
                         <p><h4>#7</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/8.PNG" alt ="label" id="shape8"/>
                         <p><h4>#8</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/9.PNG" alt ="label" id="shape9"/>
                         <p><h4>#9</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/10.PNG" alt ="label" id="shape10"/>
                         <p><h4>#10</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/11.PNG" alt ="label" id="shape11"/>
                         <p><h4>#11</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/12.PNG" alt ="label" id="shape12"/>
                         <p><h4>#12</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/13.PNG" alt ="label" id="shape13"/>
                         <p><h4>#13</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/14.PNG" alt ="label" id="shape14"/>
                         <p><h4>#14</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/15.PNG" alt ="label" id="shape15"/>
                         <p><h4>#15</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/16.PNG" alt ="label" id="shape16"/>
                         <p><h4>#16</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/17.PNG" alt ="label" id="shape17"/>
                         <p><h4>#17</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/18.PNG" alt ="label" id="shape18"/>
                         <p><h4>#18</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/19.PNG" alt ="label" id="shape19"/>
                         <p><h4>#19</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/20.PNG" alt ="label" id="shape20"/>
                         <p><h4>#20</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/21.PNG" alt ="label" id="shape21"/>
                         <p><h4>#21</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/22.PNG" alt ="label" id="shape22"/>
                         <p><h4>#22</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/23.PNG" alt ="label" id="shape23"/>
                         <p><h4>#23</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/24.PNG" alt ="label" id="shape24"/>
                         <p><h4>#24</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/25.PNG" alt ="label" id="shape25"/>
                         <p><h4>#25</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/26.PNG" alt ="label" id="shape26"/>
                         <p><h4>#26</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/27.PNG" alt ="label" id="shape27"/>
                         <p><h4>#27</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/28.PNG" alt ="label" id="shape28"/>
                         <p><h4>#28</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/29.PNG" alt ="label" id="shape29"/>
                         <p><h4>#29</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/30.PNG" alt ="label" id="shape30"/>
                         <p><h4>#30</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/31.PNG"  alt ="label" id="shape31"/>
                         <p><h4>#31</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/32.PNG" alt ="label" id="shape32"/>
                         <p><h4>#32</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/33.PNG" alt ="label" id="shape33"/>
                         <p><h4>#33</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/34.PNG" alt ="label" id="shape34"/>
                         <p><h4>#34</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/35.PNG" alt ="label" id="shape35"/>
                         <p><h4>#35</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/36.PNG" alt ="label" id="shape36"/>
                         <p><h4>#36</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/37.PNG" alt ="label" id="shape37"/>
                         <p><h4>#37</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/38.PNG" alt ="label" id="shape38"/>
                         <p><h4>#38</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/39.PNG" alt ="label" id="shape39"/>
                         <p><h4>#39</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/40.PNG" alt ="label" id="shape40"/>
                         <p><h4>#40</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/51.PNG" alt ="label" id="shape51"/>
                         <p><h4>#51</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/52.PNG" style="height: 94px;width:183px" alt ="label" id="shape52"/>
                         <p><h4>#52</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/53.PNG" style="height:160px;width:160px;" alt ="label" id="shape53"/>
                         <p><h4>#53</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/54.PNG" style="height:160px;width:160px;" alt ="label" id="shape54"/>
                         <p><h4>#54</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/55.PNG" style="height:160px;width:160px;" alt ="label" id="shape55"/>
                         <p><h4>#55</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/56.PNG" style="height:160px;width:160px;" alt ="label" id="shape56"/>
                         <p><h4>#56</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/57.PNG" style="height:160px;width:160px;" alt ="label" id="shape57"/>
                         <p><h4>#57</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/58.PNG" style="height:160px;width:160px;" alt ="label" id="shape58"/>
                         <p><h4>#58</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/59.PNG" style="height:160px;width:160px;" alt ="label" id="shape59"/>
                         <p><h4>#59</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/60.PNG" style="height:160px;width:160px;" alt ="label" id="shape60"/>
                         <p><h4>#60</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/61.PNG" style="height: 176px; width:105px" alt ="label" id="shape61"/>
                         <p><h4>#61</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/62.PNG" style="height: 187px;width:156px" alt ="label" id="shape62"/>
                         <p><h4>#62</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/63.PNG" style="height:176px;width:143px;" alt ="label" id="shape63"/>
                         <p><h4>#63</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/64.PNG" style="height: 77px;width:182px" alt ="label" id="shape64"/>
                         <p><h4>#64</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/65.PNG" style="height: 58px;width:178px" alt ="label" id="shape65"/>
                         <p><h4>#65</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/66.PNG" style="height:160px;width:160px;" alt ="label" id="shape66"/>
                         <p><h4>#66</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/67.PNG" style="height:160px;width:160px;" alt ="label" id="shape67"/>
                         <p><h4>#67</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/68.PNG" style="height: 180px;width:92px" alt ="label" id="shape68"/>
                         <p><h4>#68</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/69.PNG" style="height: 180px;width:92px" alt ="label" id="shape69"/>
                         <p><h4>#69</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/70.PNG" style="height:160px;width:160px;" alt ="label" id="shape70"/>
                         <p><h4>#70</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/71.PNG" style="height:160px;width:160px;" alt ="label" id="shape71"/>
                         <p><h4>#71</h4></p>
                         </div>
                         <div class="img-with-text in">
                         <img class="shapePic" src = "Cardinal%20Window%20Pictures/72.PNG" style="height: 181px;width:136px" alt ="label" id="shape72"/>
                         <p><h4>#72</h4></p>
                         </div>
                      
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id = "glassCloseModal" data-dismiss="modal">Close</button>
                        
                      </div>
                     </div>
                   </div>
                  </div>
                </div>
                <p></p>
                <div class="col-lg-12" id ="shapeDimsWithImgs">
                  <div class="col-lg-6" id ="shapeDimInputs" style="display:none">
                      <p>
                        <label class="glassInput" id="baseLabel">Base:</label> 
                        <input type="text" class = "glassInput" maxlength="10" size="8" id ="shapeDimBase" placeholder="Base"/>
                      </p>
                      <p>
                        <label class="glassInput" id="leftLabel">Left:</label> 
                        <input type="text" class = "glassInput" maxlength="10" size="8" id ="shapeDimLeft" placeholder="Left"/>
                      </p>
                      <p>
                        <label class="glassInput" id="rightLabel">Right:</label> 
                        <input type="text" class = "glassInput" maxlength="10" size="8" id ="shapeDimRight" placeholder="Right "/>
                      </p>
                      <p>
                        <label class="glassInput" id="topLabel">Top:</label>
                        <input type="text" class = "glassInput" maxlength="10" size="8" id ="shapeDimTop" placeholder="Top"/>
                      </p>
                      <p>
                        <label class="glassInput" style="display:none" id="s1Label">S1:</label>
                        <input type="text" class = "glassInput" style="display:none" maxlength="10" size="8" id ="shapeDimS1" placeholder="S1"/>
                      </p>
                      <p>
                        <label class="glassInput" style="display:none" id="s2Label">S2:</label> 
                        <input type="text" class = "glassInput" style="display:none" maxlength="10" size="8" id ="shapeDimS2" placeholder="S2"/>
                      </p>
                      <p>
                        <label class="glassInput" style="display:none" id="radiusLabel">Radius:</label> 
                        <input type="text" class = "glassInput" style="display:none" maxlength="10" size="8" id ="shapeDimRadius" placeholder="Radius"/>
                      </p>
                  </div>
                  <div class="col-lg-6" id="shapeDimsImgs">
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/1d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape1Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/2d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape2Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/3d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape3Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/4d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape4Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/5d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape5Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/6d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape6Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/7d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape7Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/8d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape8Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/9d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape9Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/10d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape10Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/11d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape11Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/12d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape12Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/13d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape13Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/14d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape14Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/15d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape15Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/16d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape16Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/17d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape17Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/18d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape18Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/19d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape19Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/20d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape20Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/21d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape21Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/22d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape22Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/23d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape23Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/24d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape24Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/25d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape25Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/26d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape26Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/27d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape27Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/28d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape28Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/29d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape29Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/30d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape30Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/31d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape31Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/32d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape32Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/33d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape33Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/34d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape34Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/35d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape35Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/36d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape36Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/37d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape37Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/38d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape38Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/39d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape39Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/40d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape40Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/51d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape51Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/52d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape52Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/53d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape33Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/54d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape54Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/55d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape55Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/56d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape56Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/57d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape57Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/58d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape58Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/59d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape59Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/60d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape60Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/61d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape61Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/62d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape62Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/63d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape63Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/64d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape64Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/65d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape65Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/66d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape66Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/67d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape67Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/68d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape68Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/69d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape69Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/70d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape70Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/71d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape71Dims"/>
                      <img class="shapeDimsPic"  img src = "Cardinal%20Window%20Pictures/withDims/72d.PNG" style="height:200px;width:200px;display:none" alt ="label" id="shape72Dims"/>
                  </div>
                </div>  
                  <div id="glassSwitch">
                    <p></p>
                    <div id="glassTypeLabel" class="glassInput" style="display:none">Glass Type:</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderTypeRIG" name="glassOrderTypeName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Type' and OPV_PRODCT = 'RECT IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'Clear'){
                                    echo "<option value=".$row['OPV_EXTDES']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderTypeSIG" name="glassOrderTypeName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Type' and OPV_PRODCT = 'SHAPE IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'Clear'){
                                    echo "<option value=".$row['OPV_EXTDES']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderTypeTR" name="glassOrderTypeName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Type' and OPV_PRODCT = 'TRIPLE RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'Clear'){
                                    echo "<option value=".$row['OPV_EXTDES']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderTypeTS" name="glassOrderTypeName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Type' and OPV_PRODCT = 'TRIPLE SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'Clear'){
                                    echo "<option value=".$row['OPV_EXTDES']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderTypeMR" name="glassOrderTypeName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Type' and OPV_PRODCT = 'MONO RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'Clear'){
                                    echo "<option value=".$row['OPV_EXTDES']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderTypeMS" name="glassOrderTypeName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Type' and OPV_PRODCT = 'MONO SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'Clear'){
                                    echo "<option value=".$row['OPV_EXTDES']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    <div  id="glassSurface5Label" class="glassInput" style="display:none">Glass Type - Surface 5:</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderTypeSurface" name="glassOrderTypeSurfaceName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Type-Surface 5' and OPV_PRODCT = '' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                     if($row['OPV_VALUE'] == 'Clear'){
                                    echo "<option value=".$row['OPV_EXTDES']. " selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    <div id="glassQuantLabel" class="glassInput" style="display:none">Quantity:</div>
                    <input type="text" class = "form-control squareCorners glassInput" style="width:15%;display:none" id ="glassOrderQuant" value="1" /> 
                    <p></p>
                    <div id="glassStrengthLabel" class="glassInput" style="display:none">Glass Strength:</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderStrengthRIG" name="glassOrderStrengthName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Strength' and OPV_PRODCT = 'RECT IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderStrengthSIG" name="glassOrderStrengthName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Strength' and OPV_PRODCT = 'SHAPE IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderStrengthTR" name="glassOrderStrengthName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Strength' and OPV_PRODCT = 'TRIPLE RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderStrengthTS" name="glassOrderStrengthName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Strength' and OPV_PRODCT = 'TRIPLE SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderStrengthMR" name="glassOrderStrengthName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Strength' and OPV_PRODCT = 'MONO RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderStrengthMS" name="glassOrderStrengthName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Strength' and OPV_PRODCT = 'MONO SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    <div  id="glassThicknessLabel" class="glassInput" style="display:none">Glass Thickness:</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderThicknessRIG" name="glassOrderThicknessName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Thickness' and OPV_PRODCT = 'RECT IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                  if($row['OPV_VALUE'] == '3.0 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."' selected='selected'>" . $row['OPV_VALUE'] . " (1/8\") - 15 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '2.2 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (3/32\") - 10 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '3.9 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (5/32\") - 20 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '4.7 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (3/16\") - 25 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '5.7 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (1/4\") - 30 Sq. Feet Max</option>";
                                  }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                  } 
                                }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderThicknessSIG" name="glassOrderThicknessName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Thickness' and OPV_PRODCT = 'SHAPE IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == '3.0 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."' selected='selected'>" . $row['OPV_VALUE'] . " (1/8\") - 15 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '2.2 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (3/32\") - 10 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '3.9 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (5/32\") - 20 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '4.7 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (3/16\") - 25 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '5.7 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (1/4\") - 30 Sq. Feet Max</option>";
                                  }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                  }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderThicknessTR" name="glassOrderThicknessName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Thickness' and OPV_PRODCT = 'TRIPLE RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == '3.0 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."' selected='selected'>" . $row['OPV_VALUE'] . " (1/8\") - 15 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '2.2 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (3/32\") - 10 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '3.9 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (5/32\") - 20 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '4.7 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (3/16\") - 25 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '5.7 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (1/4\") - 30 Sq. Feet Max</option>";
                                  }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                  }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderThicknessTS" name="glassOrderThicknessName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Thickness' and OPV_PRODCT = 'TRIPLE SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == '3.0 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."' selected='selected'>" . $row['OPV_VALUE'] . " (1/8\") - 15 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '2.2 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (3/32\") - 10 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '3.9 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (5/32\") - 20 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '4.7 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (3/16\") - 25 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '5.7 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (1/4\") - 30 Sq. Feet Max</option>";
                                  }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                  }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderThicknessMR" name="glassOrderThicknessName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Thickness' and OPV_PRODCT = 'MONO RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == '3.0 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."' selected='selected'>" . $row['OPV_VALUE'] . " (1/8\") - 15 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '2.2 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (3/32\") - 10 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '3.9 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (5/32\") - 20 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '4.7 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (3/16\") - 25 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '5.7 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (1/4\") - 30 Sq. Feet Max</option>";
                                  }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                  }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderThicknessMS" name="glassOrderThicknessName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Thickness' and OPV_PRODCT = 'MONO SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == '3.0 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."' selected='selected'>" . $row['OPV_VALUE'] . " (1/8\") - 15 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '2.2 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (3/32\") - 10 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '3.9 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (5/32\") - 20 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '4.7 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (3/16\") - 25 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '5.7 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (1/4\") - 30 Sq. Feet Max</option>";
                                  }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                  }                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    <div  id="glassTemperLabel" class="glassInput" style="display:none">Glass Thick - Temper:</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderTemper" name="glassOrderTemperName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Glass Thick - Temper' and OPV_PRODCT = '' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == '3.1 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."' selected='selected'>" . $row['OPV_VALUE'] . " (1/8\") - 15 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '3.9 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (5/32\") - 20 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '4.7 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (3/16\") - 25 Sq. Feet Max</option>";
                                  }else if($row['OPV_VALUE'] == '5.7 mm'){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . " (1/4\") - 30 Sq. Feet Max</option>";
                                  }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    
                    <div  id="glassGrilleLabel" class="glassInput" name="glassGrilleLabelName" style="display:none">Grille:</div>
                    <div class='input-group' style="display:none" id="glassGrilleInputGroup">                      
                    <select class="form-control lpadding in glassInput" style="display:none;border-top-left-radius:4px;border-bottom-left-radius:4px;" id = "glassOrderGrilleRIG" name="glassOrderGrilleName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille' and OPV_PRODCT = 'RECT IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="display:none;border-top-left-radius:4px;border-bottom-left-radius:4px;" id = "glassOrderGrilleSIG" name="glassOrderGrilleName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille' and OPV_PRODCT = 'SHAPE IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="display:none;border-top-left-radius:4px;border-bottom-left-radius:4px;" id = "glassOrderGrilleTR" name="glassOrderGrilleName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille' and OPV_PRODCT = 'TRIPLE RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="display:none;border-top-left-radius:4px;border-bottom-left-radius:4px;" id = "glassOrderGrilleTS" name="glassOrderGrilleName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille' and OPV_PRODCT = 'TRIPLE SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <span class='input-group-btn'><button class='btn btn-default' style="display:none" type='button' id = 'showGrilleShapes' data-toggle="modal" title ='view grilles' data-target="#grilleModal">
                    <span class ='glyphicon glyphicon-search' style ='width:100%'></span></button></span>
                    
                  </div>
                  <div class="modal" id="grilleModal" tabindex="-1" role="dialog" aria-labelledby="Grille Modal" aria-hidden="true">
                      <div class="modal-dialog modal-sm" id="grilleModalDialog">
                         <div class="modal-content">
                            <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel">Grille Types</h3>
                         </div>
                         <div class="modal-body">
                            <div class="img-with-text">
                               <p class="obscureImgLabel">5/8" Flat Grille </p>
                              <img src="Cardinal%20Window%20Pictures/grilles/58flat.PNG"/><br><br>
                            </div>
                            <div class="img-with-text">
                              <p class="obscureImgLabel">13/16" Flat Grille </p>
                              <img src="Cardinal%20Window%20Pictures/grilles/1flat.PNG"/><br><br>
                            </div>
                            <div class="img-with-text">
                              <p class="obscureImgLabel">3/4" Contour Grille </p>
                              <img src="Cardinal%20Window%20Pictures/grilles/58cont.PNG"/><br><br>
                            </div>
                            <div class="img-with-text"> 
                              <p class="obscureImgLabel">13/16" Contour Grille </p> 
                              <img src="Cardinal%20Window%20Pictures/grilles/1cont.PNG"/><br><br>
                            </div> 
                            <div class="img-with-text">
                              <p class="obscureImgLabel">SDL</p>
                              <img src="Cardinal%20Window%20Pictures/grilles/58flat.PNG"/>
                            </div> 
                         </div>
                       </div>
                      </div>
                    </div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderGrilleMR" name="glassOrderGrilleName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille' and OPV_PRODCT = 'MONO RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderGrilleMS" name="glassOrderGrilleName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille' and OPV_PRODCT = 'MONO SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    <div  id="glassPatternLabel" class="glassInput" style="display:none">Grille Pattern:</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderGrillePattRIG" name="glassOrderGrillePattName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille Pattern' and OPV_PRODCT = 'RECT IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderGrillePattSIG" name="glassOrderGrillePattName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille Pattern' and OPV_PRODCT = 'SHAPE IG' AND OPV_EXTDES='#GPATT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderGrillePattTR" name="glassOrderGrillePattName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille Pattern' and OPV_PRODCT = 'TRIPLE RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderGrillePattTS" name="glassOrderGrillePattName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille Pattern' and OPV_PRODCT = 'TRIPLE SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderGrillePattMR" name="glassOrderGrillePattName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille Pattern' and OPV_PRODCT = 'MONO RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderGrillePattMS" name="glassOrderGrillePattName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille Pattern' and OPV_PRODCT = 'MONO SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    <div id ="glassColonialWide" class="glassInput in" style="display:none">Boxes Wide:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderColonialWide"/>
                    <div id ="glassColonialHigh" class="glassInput in" style="display:none">Boxes High:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderColonialHigh"/>
                    <div id ="glassCustColonialNum" class="glassInput in" style="display:none">Number of Boxes:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderColonialCust"/>
                    <div id ="glassPrairieWide" class="glassInput in" style="display:none">Boxes Wide:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderPrairieWide"/>
                    <div id ="glassPrairieHigh" class="glassInput in" style="display:none">Boxes High:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderPrairieHigh"/>
                    <div id ="glassPrairieOff" class="glassInput in" style="display:none">Offset:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderPrairieOff"/>
                    <div id ="glassCustPrairieWide" class="glassInput in" style="display:none">Boxes Wide:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderCustPrairieWide"/>
                    <div id ="glassCustPrairieHigh" class="glassInput in" style="display:none">Boxes High:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderCustPrairieHigh"/>
                    <div id ="glassCustPrairieHoriOff" class="glassInput in" style="display:none">Horizontal Offset:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderCustPrairieHoriOff"/>
                    <div id ="glassCustPrairieVeriOff" class="glassInput in" style="display:none">Vertical Offset:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderCustPrairieVertOff"/>
                    <div id ="glassCustRectLites" class="glassInput in" style="display:none">Rectangular Lites:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderCustRectLites"/>
                    <div id ="glassCustCurveLites" class="glassInput in" style="display:none">Curved Lites:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderCustCurvLites"/>
                    <div id ="glassCustAngLites" class="glassInput in" style="display:none">Angular Lites:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderCustAngLites"/>
                    <p></p>
                    <div  id="glassGrilleColorLabel" class="glassInput" style="display:none">Inter. Grille Color:</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderIntGrilleRIG" name="glassOrderIntGrilleName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Inter. Grille Color' and OPV_PRODCT = 'RECT IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderIntGrilleSIG" name="glassOrderIntGrilleName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Inter. Grille Color' and OPV_PRODCT = 'RECT IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderIntGrilleTR" name="glassOrderIntGrilleName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Inter. Grille Color' and OPV_PRODCT = 'TRIPLE RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderIntGrilleTS" name="glassOrderIntGrilleName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Inter. Grille Color' and OPV_PRODCT = 'TRIPLE SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderIntGrilleMR" name="glassOrderIntGrilleName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Inter. Grille Color' and OPV_PRODCT = 'MONO RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    <div id ="glassCustGrilleColor" class="glassInput in" style="display:none">Custom Color:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderCustGColor"/>
                    <p></p>
                    <div  id="glass2ToneLabel" class="glassInput" style="display:none">Int Grl 2-Tone Color:</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrder2Tone" name="glassOrder2ToneName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Int Grl 2-Tone Color' and OPV_PRODCT = '' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>  
                    <div id ="glassCust2ToneIn" class="glassInput in" style="display:none">Custom Interior Color:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderCust2ToneIn"/>
                    <div id ="glassCust2ToneExt" class="glassInput in" style="display:none">Custom Exterior Color:</div>
                    <input type="text" class = "squareCorners in glassInput" style="width:7%;display:none" id ="glassOrderCust2ToneExt"/> 
                    <p></p>
                    <div  id="glassSDLLabel" class="glassInput" style="display:none">SDL Color:</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderSDLRIG" name="glassOrderSDLName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'SDL Color' and OPV_PRODCT = 'RECT IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderSDLSIG" name="glassOrderSDLName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'SDL Color' and OPV_PRODCT = 'SHAPE IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderSDLTR" name="glassOrderSDLName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'SDL Color' and OPV_PRODCT = 'TRIPLE RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderSDLTS" name="glassOrderSDLName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'SDL Color' and OPV_PRODCT = 'TRIPLE SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderSDLMR" name="glassOrderSDLName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'SDL Color' and OPV_PRODCT = 'MONO RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderSDLMS" name="glassOrderSDLName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'SDL Color' and OPV_PRODCT = 'MONO SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    <button type = "button" class = "btn btn-default" id ="showOtherOptions">Other Options</button>  
                    <div id ='otherGlassOptions2' style="display:none;">
                    <p></p>
                    <div  id="glassSpacerLabel" class="glassInput" style="display:none">Spacer Options:</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderSpacer" name="glassOrderSpacerName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Spacer Option' and OPV_PRODCT = '' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                  if($row['OPV_EXTDES']=='no'){
                                      echo "<option value='".$row['OPV_EXTDES']."' selected='selected'>Standard (XL Edge)</option>";
                                    }else{
                                      echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";     
                                    }
                                  }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    <div  id="glassPreserveLabel" class="glassInput" style="display:none">Preserve:</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderPreserveRIG" name="glassOrderPreserveName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Preserve' and OPV_PRODCT = 'RECT IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                  if($row['OPV_VALUE']=='Yes'){
                                      echo "<option value='".$row['OPV_EXTDES']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                      echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";     
                                    }
                                  }  
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderPreserveSIG" name="glassOrderPreserveName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Preserve' and OPV_PRODCT = 'SHAPE IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE']=='Yes'){
                                      echo "<option value='".$row['OPV_EXTDES']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                      echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";     
                                    }
                                  }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderPreserveTR" name="glassOrderPreserveName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Preserve' and OPV_PRODCT = 'TRIPLE RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE']=='Yes'){
                                      echo "<option value='".$row['OPV_EXTDES']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                      echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";     
                                    }
                                  }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderPreserveTS" name="glassOrderPreserveName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Preserve' and OPV_PRODCT = 'TRIPLE SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE']=='Yes'){
                                      echo "<option value='".$row['OPV_EXTDES']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                      echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";     
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderPreserveMR" name="glassOrderPreserveName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Preserve' and OPV_PRODCT = 'MONO RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE']=='Yes'){
                                      echo "<option value='".$row['OPV_EXTDES']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                      echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";     
                                    }
                                  }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderPreserveMS" name="glassOrderPreserveName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Preserve' and OPV_PRODCT = 'MONO SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE']=='Yes'){
                                      echo "<option value='".$row['OPV_EXTDES']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                      echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";     
                                    }
                                  }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    <div id="glassTintLabel" class="glassInput" style="display:none">Tint:</div>
                    <div id="noTintWarning" style="display:none;color:red">Tint option not available with Lo-E selection.</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderTintRIG" name="glassOrderTintName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Tint' and OPV_PRODCT = 'RECT IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderTintSIG" name="glassOrderTintName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Tint' and OPV_PRODCT = 'SHAPE IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderTintTR" name="glassOrderTintName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Tint' and OPV_PRODCT = 'TRIPLE RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderTintTS" name="glassOrderTintName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Tint' and OPV_PRODCT = 'TRIPLE SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderTintMR" name="glassOrderTintName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Tint' and OPV_PRODCT = 'MONO RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderTintMS" name="glassOrderTintName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Tint' and OPV_PRODCT = 'MONO SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    <div  id="glassHardLabel" class="glassInput" style="display:none">Hard Coat:</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderHardRIG" name="glassOrderHardName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Hard Coat' and OPV_PRODCT = 'RECT IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if(strpos($row['OPV_VALUE'], 'I') !== false){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . strtolower($row['OPV_VALUE']). "</option>";
                                  }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE']. "</option>";
                                  }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderHardSIG" name="glassOrderHardName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Hard Coat' and OPV_PRODCT = 'SHAPE IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                  if(strpos($row['OPV_VALUE'], 'I') !== false){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . strtolower($row['OPV_VALUE']). "</option>";
                                  }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE']. "</option>";
                                  }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderHardTR" name="glassOrderHardName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Hard Coat' and OPV_PRODCT = 'TRIPLE RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                  if(strpos($row['OPV_VALUE'], 'I') !== false){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . strtolower($row['OPV_VALUE']). "</option>";
                                  }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE']. "</option>";
                                  }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderHardTS" name="glassOrderHardName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Hard Coat' and OPV_PRODCT = 'TRIPLE SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                  if(strpos($row['OPV_VALUE'], 'I') !== false){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . strtolower($row['OPV_VALUE']). "</option>";
                                  }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE']. "</option>";
                                  }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderHardMR" name="glassOrderHardName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Hard Coat' and OPV_PRODCT = 'MONO RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                  if(strpos($row['OPV_VALUE'], 'I') !== false){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . strtolower($row['OPV_VALUE']). "</option>";
                                  }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE']. "</option>";
                                  }
                                 } 
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderHardMS" name="glassOrderHardName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Hard Coat' and OPV_PRODCT = 'MONO SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                  if(strpos($row['OPV_VALUE'], 'I') !== false){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . strtolower($row['OPV_VALUE']). "</option>";
                                  }else{
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE']. "</option>";
                                  }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <p></p>
                    <div  id="glassObscureLabel" class="glassInput" style="display:none">Obscure:</div>
                    <div class='input-group' style="display:none" id="glassObscureInputGroup">
                    <select class="form-control lpadding in glassInput" style="border-top-left-radius:4px;border-bottom-left-radius:4px;display:none" id = "glassOrderObscureRIG" name="glassOrderObscureName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Obscure' and OPV_PRODCT = 'RECT IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-top-left-radius:4px;border-bottom-left-radius:4px;display:none" id = "glassOrderObscureSIG" name="glassOrderObscureName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Obscure' and OPV_PRODCT = 'SHAPE IG' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-top-left-radius:4px;border-bottom-left-radius:4px;display:none" id = "glassOrderObscureTR" name="glassOrderObscureName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Obscure' and OPV_PRODCT = 'TRIPLE RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-top-left-radius:4px;border-bottom-left-radius:4px;display:none" id = "glassOrderObscureTS" name="glassOrderObscureName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Obscure' and OPV_PRODCT = 'TRIPLE SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-top-left-radius:4px;border-bottom-left-radius:4px;display:none" id = "glassOrderObscureMR" name="glassOrderObscureName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Obscure' and OPV_PRODCT = 'MONO RECT' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <select class="form-control lpadding in glassInput" style="border-top-left-radius:4px;border-bottom-left-radius:4px;display:none" id = "glassOrderObscureMS" name="glassOrderObscureName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Obscure' and OPV_PRODCT = 'MONO SHAPE' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <span class='input-group-btn'><button class='btn btn-default' type='button' id = 'showObscureImgs' data-toggle="modal" title ='view obscure images' data-target="#obscureModal">
                    <span class ='glyphicon glyphicon-search' style ='width:100%'></span></button></span>
                    
                  </div>
                  <div class="modal" id="obscureModal" tabindex="-1" role="dialog" aria-labelledby="Obscure Modal" aria-hidden="true">
                      <div class="modal-dialog modal-sm" id="obscureModalDialog">
                         <div class="modal-content">
                            <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel">Obscure Types</h3>
                         </div>
                         <div class="modal-body">
                            <div class="img-with-text">
                              <p class ="obscureImgLabel">Pattern 62/Stipolite</p>
                              <img style='height:125px;width:265px' src="Cardinal%20Window%20Pictures/obscures/stipolite.png"/><br>
                            </div>
                            <br>
                            <div class="img-with-text">
                              <p class="obscureImgLabel">Single Glue</p>
                              <img style='height:125px;width:265px' src="Cardinal%20Window%20Pictures/obscures/singleglue.png"/><br>  
                            </div>
                            <br>
                            <div class="img-with-text">
                              <p class="obscureImgLabel">Seedy Reemy</p> 
                              <img style='height:125px;width:265px' src="Cardinal%20Window%20Pictures/obscures/seedyreemy.png"/><br>
                            </div>
                            <br>
                            <div class="img-with-text">
                              <p class="obscureImgLabel">Reeded</p>  
                              <img style='height:125px;width:265px' src="Cardinal%20Window%20Pictures/obscures/reeded.png"/><br>
                            </div>
                            <br>
                            <div class="img-with-text">  
                              <p class="obscureImgLabel">Rain</p>
                              <img style='height:125px;width:265px' src="Cardinal%20Window%20Pictures/obscures/rain.png"/><br>
                            </div>
                            <br>
                            <div class="img-with-text">  
                              <p class="obscureImgLabel">Frosted/Acid Etched</p>
                              <img style='height:125px;width:265px' src="Cardinal%20Window%20Pictures/obscures/satinetch.png"/><br>
                            </div>
                            <br>
                            <div class="img-with-text">  
                              <p class="obscureImgLabel">Spraylite</p>
                              <img style='height:125px;width:265px' src="Cardinal%20Window%20Pictures/obscures/spraylite.png"/><br>
                            </div>     
                         </div>
                       </div>
                      </div>
                    </div>
                    <p></p>
                    <div  id="glassLogoLabel" class="glassInput" style="display:none">IG Logo Required:</div>
                    <select class="form-control lpadding in glassInput" style="border-radius:4px;display:none" id = "glassOrderLogo" name="glassOrderLogoName">
                        <?php
                            $sql = "SELECT OPV_EXTDES,OPV_VALUE,OPV_DSPSEQ FROM CURR_OPTVALUES WHERE OPV_OPTION = 'IG Logo Required' and OPV_PRODCT = '' ORDER BY OPV_DSPSEQ ASC";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option value='".$row['OPV_EXTDES']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                } else {
                                    echo "0 results";
                                    }
                        ?>
                    </select>
                    <!--<p></p>
                    <button type = "button" id="addAddItems" class = "btn btn-default" data-toggle = "modal" data-target ="#additionalItemsModal">Add Additional Items</button>&nbsp;-->
                    <p></p>
                    <button type = "button" class = "btn btn-default"  id ="showOtherGOpts">Add File</button>
                    <div id ='otherGlassOptions' style="display:none;">
                    <p></p>
                    <b>Upload File:</b><br>
                    <input type="file" style="display:inline" accept=".jpg,.jpeg,.png" id="filechooser1"></input>&nbsp;<button id="addFileBtn1" name="addFileBtn" class="btn btn-sm btn-success">Add</button>
                    <button id="deleteFileBtn1" name="deleteFileBtn" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>  
                    <div id='chooserDiv' stlye="display:none">
                        <div style="display:none" id="imageHere1"></div>
                        <input type="file" style="display:none" accept=".jpg,.jpeg,.png" id="filechooser2"></input><button id="addFileBtn2" name="addFileBtn" style="display:none" class="btn btn-sm btn-success">Add</button>
                        <button id="deleteFileBtn2" style ="display:none" name="deleteFileBtn" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>  
                        <div style="display:none" id="imageHere2"></div>
                        <input type="file" style="display:none" accept=".jpg,.jpeg,.png" id="filechooser3"></input><button id="addFileBtn3" name="addFileBtn" style="display:none" class="btn btn-sm btn-success">Add</button>
                        <button id="deleteFileBtn3" style ="display:none" name="deleteFileBtn" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>  
                        <div style="display:none" id="imageHere3"></div>
                        <input type="file" style="display:none" accept=".jpg,.jpeg,.png" id="filechooser4"></input><button id="addFileBtn4" name="addFileBtn" style="display:none" class="btn btn-sm btn-success">Add</button>
                        <button id="deleteFileBtn4" style ="display:none" name="deleteFileBtn" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>  
                        <div style="display:none" id="imageHere4"></div>
                        <input type="file" style="display:none" accept=".jpg,.jpeg,.png" id="filechooser5"></input><button id="addFileBtn5" name="addFileBtn" style="display:none" class="btn btn-sm btn-success">Add</button>
                        <button id="deleteFileBtn5" style ="display:none" name="deleteFileBtn" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>  
                        <div style="display:none" id="imageHere5"></div>
                    </div>
                  </div>   
                <!--<div class="modal" id="additionalItemsModal2" tabindex="-1" role="dialog" aria-labelledby="Color Modal" aria-hidden="true">
                  <div class="modal-dialog" id="additionalItemsModalDialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="myModalLabel">Additional Items</h3>
                     </div>
                     <div class="modal-body">
                      Description:
                      <p><input type = "text" class = "form-control height30 squareCorners" id ="addDesc"  placeholder="Description"></input></p>
                      Price:
                      <p><input type = "text" class = "form-control height30 squareCorners" id ="additionalPrice" placeholder="Price"></input></p>
                      <div class="checkbox"  style ="display:inline-block; border-right: 1px solid black; padding-right: 5px; padding-left: 5px;">
                       <label>
                        <input type="checkbox"  id ="additionalMultiplier">Apply Multiplier
                       </label>
                      </div>
                      <div class="checkbox"  style ="display:inline-block; border-right: 1px solid black; padding-right: 5px; padding-left: 5px;">
                       <label>
                        <input type="checkbox"  id ="additionalMarkup" >Apply Markup Percent
                       </label>
                      </div>
                      <div class="checkbox"  style ="display:inline-block;">
                       <label>
                        <input type="checkbox"  id ="additionalTax">Apply Tax
                       </label>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal" id="additionalConfirm" style="width:20%">Add</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="additionalCancel">Cancel</button>
                      </div>
                     </div>
                   </div>
                  </div>
                  </div>-->
                </div><!--otherglassoptions-->             
              </div><!--glassSwitch-->
                  <p></p>
                  <button type = "button" data-loading-text="Loading..." autocomplete="off" class = "btn btn-primary alignRight" id ="glassadd_row">Add to Order</button>
                  <button type = "button" autocomplete="off" class = "btn btn-danger alignRight" style="display:none" id ="exitGlassEdit">Cancel</button>
                  <button type = "button" autocomplete="off" class = "btn btn-primary alignRight" style="display:none" id ="glassedit_row">Update Item</button>
                  
                  <!--<input type="button" class="btn btn-danger alignRight" style="margin-right: 5px;" name="backClickName9" id='glassbackClick9' value="Back"/>-->
                  <p></p>
                  <!--<button type = "button" data-loading-text="Loading..." autocomplete="off" disabled ='disabled' class = "btn btn-success" onclick="sendOrder()" id ="glasssendOrder">Send Order</button>-->
              </div>
            </div>
        </div><!--end collapse-->
      </div>
      <div id="mainAccessoriesDiv" style="display:none">
        <div class="panel-body lpadding npadbot" id = "accesspanel1">
            <div class="panel panel-primary" id="accessPanelPrimary">
              <div class="panel-heading" id="accessPanelHeading">
                <h3 class="panel-title">Glazing Accessories</h3>
                      <span class="pull-right clickable" id ="accessspan1"><i class="glyphicon glyphicon-chevron-down"></i></span>
                </div>
                <div class="panel-body" id="accesscollapse1">
                <p><label for="accessoriesCatSelect" id="accessCatSelectLabel">Glazing/Sealant Accessories</label><select class="form-control lpadding" style="border-radius: 4px" id="accessoriesCatSelect">
                <option value="none">Select...</option>
                <option value='osiSealantCat'>OSI Window and Door Sealant</option>  
                <option value='qsiFoamCat'>QSI Window and Door Installation Foam/Flashing</option>
                <option value='dowGlazingCat'>Dow Corning Glazing Sealant (Cardinal IG Recommended)</option>
                <option value="glassBlock">Glass Setting Block</option>
                </select></p>
                <?php
                  $sql = "SELECT ITM_ITEM,ITM_DESC1,ITM_MFGLST FROM ITEMMAST WHERE ITM_ITEM IN('QM433','QM305','QM003','Q932','QM424','QM209','Q764','QM736','QM002','QM551','QM857','QM239','QM855','Q274','QM218','QM208','QM778','QM438','QM943','QM595','QM711','Q498','QM466','Q944')";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0){
                    echo "<label for='osiSealantSelectId' style='display:none' id='osiSealantSelectIdLabel'>OSI Window and Door Sealant</label><select class='form-control lpadding accessoriesInput' style='border-radius:4px' name='osiSealantSelect' id = 'osiSealantSelectId'><option value='None' data-price='0' data-caseprice = '0'>None</option>";
                    while($row = $result->fetch_assoc()){
                      echo "<option value='".$row['ITM_ITEM']."' data-price='".$row['ITM_MFGLST']."' data-caseprice='90'>".ucwords(strtolower($row['ITM_DESC1']))."</option>";
                    }
                    echo "</select>";
                  }
                  $sql = "SELECT ITM_ITEM,ITM_DESC1,ITM_MFGLST FROM ITEMMAST WHERE ITM_ITEM IN('QF16S','QBFT4X75')";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0){
                    echo "<label for='foamSelectId' style='display:none' id='foamSelectIdLabel'>QSI Window and Door Installation Foam/Flashing</label><select class='form-control lpadding accessoriesInput' style='border-radius:4px' name='foamSelect' id = 'foamSelectId'><option value='None' data-price='0' data-caseprice = '0'>None</option>";
                    while($row = $result->fetch_assoc()){
                      echo "<option value='".$row['ITM_ITEM']."' data-price='".$row['ITM_MFGLST']."' data-caseprice = '53'>".ucwords(strtolower($row['ITM_DESC1']))."</option>";
                    }
                    echo "</select>";
                  }
                  $sql = "SELECT ITM_ITEM,ITM_DESC1,ITM_MFGLST FROM ITEMMAST WHERE ITM_ITEM IN('SPP1199')";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0){
                    echo "<label for='glazingSelectId' style='display:none' id='glazingSelectIdLabel'>Dow Corning Glazing Sealant (Cardinal IG Recommended)</label><select class='form-control lpadding accessoriesInput' style='border-radius:4px' name='glazingSelect' id = 'glazingSelectId'><option value='None' data-price='0' data-caseprice = '0'>None</option>";
                    while($row = $result->fetch_assoc()){
                      echo "<option value='".$row['ITM_ITEM']."' data-price='".$row['ITM_MFGLST']."' data-caseprice = '55'>".ucwords(strtolower($row['ITM_DESC1']))."</option>";
                    }
                    echo "</select>";
                  }
                  ?>
                   <label for='settingBlockSelectId' style='display:none' id='settingBlockSelectIdLabel'>Glass Setting Block</label><select class='form-control lpadding accessoriesInput' style='border-radius:4px;display: none;' name='blockSelect' id = 'settingBlockSelectId'>
                   <option value='None' data-price='0' data-thousand = '0' data-twothousand = '0'>None</option>
                   <option value='GSBLK034' data-price='30' data-thousand = '300' data-twothousand = '423.5'>Glass Setting Block (1/8" x 3/4" x 4")</option>
                   <option value='GSBLK114' data-price='44' data-thousand = '374' data-twothousand = '841.5'>Glass Setting Block (1/8" x 1-1/4" x 4")</option>
                   </select>
                    
                <br>
                <input type="radio" name="caseSelectRadio"  id="pieceQuantRadio" checked="checked"><label id='pieceQuantRadioLabel' style="margin-right: 15px" for='pieceQuantRadio'>Individual Pieces</label>
                <input type="radio" name="caseSelectRadio" id="caseQuantRadio"><label id='caseQuantRadioLabel' for='caseQuantRadio'>Cases (12 Pack)</label>
                <input type="radio" name="caseSelectRadioBlock" style="display: none" id="block100"><label id='block100Label' style="margin-right: 15px;display: none;" for='block100'>Case of 100 Pieces</label>
                <input type="radio" name="caseSelectRadioBlock" style="display: none" id="block1000"><label id='block1000Label' style="margin-right: 15px;display: none;" for='block1000'>Cases of 1000 Pieces</label>
                <input type="radio" name="caseSelectRadioBlock" style="display: none" id="block2500"><label id='block2500Label' style="display: none;" for='block2500'>Cases of 2500 Pieces</label>
                <br>
                <br>
                <label id='accessQuantLabel' for='osiSealantSelectQuant'>Quantity:&nbsp;</label><input type='number' id='accessQuantInput' placeholder='Quantity'/>
                <button class = "btn btn-primary" style="float:right;margin-top: 15px;" id="addAccessories">Add to Order</button>
                </div>
            </div>
        </div>
      </div>
    <div class="panel-body lpadding npadtop" id="transomPanel" style="display:none;margin-bottom:80px !important">
        <div class="panel panel-info lpadding">
            <div class="panel-heading">
            <h3 class="panel-title">Transom Window</h3>
            </div>
            <div class="panel-body" id="transomPanelBody">
            <h4>Dimensions</h4>
            <div id="transomDimsTextW" style="display:none">Width <font size = '1px'>(Glass Size) Unit Dimension</font></div>
            <?php
                         
                            $sql = "SELECT BMS_SIZE01 AS BMS_SIZE1, BMS_SIZE02 AS BMS_SIZE2, BMS_SIZE03 AS BMS_SIZE3, BMS_SIZE04 AS BMS_SIZE4, BMS_SIZE05 AS BMS_SIZE5, BMS_SIZE06 AS BMS_SIZE6, BMS_SIZE07 AS BMS_SIZE7, BMS_SIZE08 AS BMS_SIZE8, BMS_SIZE09 AS BMS_SIZE9, BMS_SIZE10, BMS_SIZE11, BMS_SIZE12,BMS_SIZE13, BMS_SIZE14, BMS_SIZE15,  BMS_SIZE16, BMS_SIZE17, BMS_SIZE18, BMS_SIZE19, BMS_SIZE20, BMS_SIZE21 AS BMS_SIZE21  FROM BOMMSIZ WHERE BMS_STKPRE = 'CDHTR' AND BMS_STRCNO ='1'";
                            $result = $conn->query($sql);
                              $sixteenCount = 0;
                              $twentyCount = 0;
                              $twentyFourCount = 0;
                              $twentyEightCount = 0;
                              $thirtyTwoCount = 0;
                              $thirtySixCount = 0;
                              $fortyCount = 0;
                              if ($result->num_rows > 0){
                              echo "<select class='form-control lpadding' style='border-radius:4px;display:none' name='transomDimsWName' id = 'transomDimsW'>";
                                while($row = $result->fetch_assoc()){
                                    for($x=1;$x<sizeof($row);$x++){
                                    $tempVal = substr($row['BMS_SIZE'.$x],0,2);
                                    if($tempVal == 16 && $sixteenCount == 0){
                                    $unitDimW16 = $tempVal + 5.0625;
                                    $uDW16Str = floor($unitDimW16/12) . '&#039;-' . floor($unitDimW16%12) . ' ' . 16 * fmod(fmod($unitDimW16,12),1) .'/16"';  
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW16Str. '</option>';
                                    $sixteenCount++;
                                    }
                                    if($tempVal == 20 && $twentyCount == 0){
                                    $unitDimW20 = $tempVal + 5.0625;
                                    $uDW20Str = floor($unitDimW20/12) . '&#039;-' . floor($unitDimW20%12) . ' ' . 16 * fmod(fmod($unitDimW20,12),1) .'/16"';  
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW20Str. '</option>';
                                    $twentyCount++;
                                    }
                                    if($tempVal == 24 && $twentyFourCount == 0){
                                    $unitDimW24 = $tempVal + 5.0625;
                                    $uDW24Str = floor($unitDimW24/12) . '&#039;-' . floor($unitDimW24%12) . ' ' . 16 * fmod(fmod($unitDimW24,12),1) .'/16"';
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW24Str. '</option>';
                                    $twentyFourCount++;
                                    }
                                    if($tempVal == 28 && $twentyEightCount == 0){
                                    $unitDimW28 = $tempVal + 5.0625;
                                    $uDW28Str = floor($unitDimW28/12) . '&#039;-' . floor($unitDimW28%12) . ' ' . 16 * fmod(fmod($unitDimW28,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW28Str. '</option>';
                                    $twentyEightCount++;
                                    }
                                    if($tempVal == 32 && $thirtyTwoCount == 0){
                                    $unitDimW32 = $tempVal + 5.0625;
                                    $uDW32Str = floor($unitDim32/12) . '&#039;-' . floor($unitDimW32%12) . ' ' . 16 * fmod(fmod($unitDimW32,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW32Str. '</option>';
                                    $thirtyTwoCount++;
                                    }
                                    if($tempVal == 36 && $thirtySixCount == 0){
                                    $unitDimW28 = $tempVal + 5.0625;
                                    $uDW36Str = floor($unitDimW36/12) . '&#039;-' . floor($unitDimW36%12) . ' ' . 16 * fmod(fmod($unitDimW36,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW36Str. '</option>';
                                    $thirtySixCount++;
                                    }
                                    if($tempVal == 40 && $fortyCount == 0){
                                    $unitDimW40 = $tempVal + 5.0625;
                                    $uDW40Str = floor($unitDimW40/12) . '&#039;-' . floor($unitDimW40%12) . ' ' . 16 * fmod(fmod($unitDimW40,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDW40Str. '</option>';
                                    $fortyCount++;
                                    }
                                    }
                              echo '</select>';
                              echo "<div id='transomDimsTextH'>Height <font size = '1px'>(Glass Size) Unit Dimension</font></div>";
                              $twelveCount = 0;
                              $eighteenCount = 0;
                              $twentyFourCount = 0;
                              echo "<select class='form-control lpadding' style='border-radius:4px;' name='transomDimsHName' id = 'transomDimsH'>";
                                    for($y=1;$y<sizeof($row);$y++){
                                    $tempVal = substr($row['BMS_SIZE'.$y],2,2);
                                    if($tempVal == 12 && $twelveCount == 0){
                                    $unitDimH12 = $tempVal + 5.0625;
                                    $uDH12Str = floor($unitDimH24/12) . "'-" . floor($unitDimH12%12) . ' ' . 16 * fmod(fmod($unitDimH12,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH12Str . '</option>';
                                    $twelveCount++;
                                    }
                                    if($tempVal == 18 && $eighteenCount == 0){
                                    $unitDimH32 = $tempVal + 5.0625;
                                    $uDH32Str = floor($unitDimH32/12) . "'-" . floor($unitDimH32%12) . ' ' . 16 * fmod(fmod($unitDimH32,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH32Str . '</option>';
                                    $eighteenCount++;
                                    }
                                    if($tempVal == 24 && $twentyFourCount == 0){
                                    $unitDimH24 = $tempVal + 5.0625;
                                    $uDH24Str = floor($unitDimH24/12) . '&#039;-' . floor($unitDimH24%12) . ' ' . 16 * fmod(fmod($unitDimH24,12),1) .'/16"'; 
                                    echo '<option value='.$tempVal.'>(' .$tempVal.') ' . $uDH24Str. '</option>';
                                    $twentyFourCount++;
                                    }
                                    
                                    }
                               echo '</select>';
                               
                                  }
                                } else {
                                    echo "0";
                                    }
                      ?>
                 
                        
                  </select>
                  Units Wide:
                 <select class="form-control lpadding " style="border-radius:4px;" name='transomUnitsWideName' id = "transomUnitsWide">
                        <?php
                            $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Mulled Units' and OPV_PRODCT = 'CDHTR'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                   if($row['OPV_VALUE'] == '1 Wide'){
                                    echo "<option value='".$row['OPV_VALUE']."'>1</option>";
                                   } 
                                   else if($row['OPV_VALUE'] == '2 Wide'){
                                    echo "<option value='".$row['OPV_VALUE']."'>2</option>";
                                   }
                                   else if($row['OPV_VALUE'] == '3 Wide'){
                                    echo "<option value='".$row['OPV_VALUE']."'>3</option>";
                                   }
                                 }
                                 }else {
                                    echo "0 results";
                                    }
                                echo "<option value='4 Wide'>4</option>";
                                echo "<option value='5 Wide'>5</option>";    
                                
                             
                        ?>
                 </select>
                <p></p> 
                <div id ="transomDivide">
                <label class="radio-inline">
                  <input type="radio" id="Single Unit" name="transomDivide" value="singleUnit">Single Unit
                </label>
                <label class="radio-inline">
                  <input type="radio" id="Divided Units" name="transomDivide" value="dividedUnits">Divided Units
                </label> 
                </div>
                 <h4>Grille</h4>
                 <div id = "transomgrillePatternDiv">                     
                     <div id ="transomgrilleLabelPattern">Pattern:</div>
                     <select class="form-control lpadding in" name="grillePatternName" id="transomgrillePattern">
                     <?php
                          $sql = "SELECT OPV_VALUE FROM CURR_OPTVALUES WHERE OPV_OPTION = 'Grille Pattern' and OPV_PRODCT = 'CDHTR'";
                            $result = $conn->query($sql);
                              if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    if($row['OPV_VALUE'] == 'None'){
                                    echo "<option value='".$row['OPV_VALUE']."' selected='selected'>" . $row['OPV_VALUE'] . "</option>";
                                    }else{
                                    echo "<option value='".$row['OPV_VALUE']."'>" . $row['OPV_VALUE'] . "</option>";
                                    }
                                    }
                                } else {
                                    echo "0 results";
                                    }
                               /* echo "<option value='None'>None</option>";
                                echo '<option value="58Flat">5/8" Flat</option>';
                                echo '<option value="58FlatTT">5/8" Flat-Two Tone</option>';
                                echo '<option value="1316Flat">13/16" Flat</option>';
                                echo '<option value="1316FlatTT">13/16" Flat-Two Tone</option>';
                                echo '<option value="34Prof">3/4" Profile</option>';
                                echo '<option value="34ProfTT">3/4" Profile-Two Tone</option>';
                                echo '<option value="1Prof">1" Profile</option>';
                                echo '<option value="1ProfTT">1" Profile-Two Tone</option>';
                                echo '<option value="34SDL">1-1/4" SDL</option>';
                                echo '<option value="1SDL">7/8" SDL</option>';*/
                        ?>
                       <!--  echo "<option value='None'>None</option>";
                        echo "<option value='standardColonial'>Standard Colonial</option>";
                        echo "<option value='custColonial'>Custom Colonial</option>";
                        echo "<option value='standardPrairie6'>Standard Prairie, 6 Lite</option>";
                        echo "<option value='standardPrairie9'>Standard Prairie, 9 Lite</option>";
                        echo "<option value='custPrairie'>Custom Prairie</option>";
                        echo "<option value='artsCraft'>Arts & Craft</option>";
                        echo "<option value='custPattern'>Custom Pattern</option>"; -->                         
                     </select>
                   <p></p>
                  </div>
                  
                  <div id = "transomspacerOptsDiv" style="display:none">
                    <br>
                     <label class="radio-inline">
                       <input type="radio" name="spcrOptsRdo" id="transomwithSpacer">With Internal Spacer
                     </label>
                     <label class="radio-inline">
                       <input type="radio" name="spcrOptsRdo" id="transomwithoutSpacer">Without Internal Spacer
                     </label>
                  </div>
                  <div id = "transomgrilleColorDiv" style="display:none">
                     
                     <br>   
                     <div id ="transomgrilleLabelColor" style = "display:none">Solid Color:</div>
                     <div id ="transomgrilleLabelColor2" style = "display:none">Two-Tone Color:</div>
                     <select class="form-control lpadding in" id = "transomgrilleColor" name="grilleColorName" style = "display:none">                      
                     </select>
                  </div>
                 <br>
                 <div id = 'transomcustGrilleDiv' style = "display:none">
                  <br>
                 <div id ='transomcustColonialGrilleDiv' style = "display:none">
                    Custom Colonial Grille:<br><br>
                    <label for = "custColoWide" class ='in' style="font-weight:normal;width:80px">Units Wide:</label><input type="text" class ="form-control squareCorners height30 in" placeholder = 'Units Wide' style='width:20%;margin-bottom:10px' id ="transomcustColoWide"/><br>
                    <label for = "custColoHigh" class ='in' style="font-weight:normal;width:80px;">Units High:</label><input type="text" class ="form-control squareCorners height30 in" placeholder ='Units High' style='width:20%' id ="transomcustColoHigh"/>
                 </div>
                 <div style="display:none">
                    Custom Grille:
                    <input type="text" class = "form-control squareCorners" placeholder ="Custom Grille" id ="transomcustGrilleIn"/> 
                 </div>
            </div>
        </div>
        </div>
    </div> 
    </div>    
      <div class="col-lg-5 col-md-4 col-sm-4 stardust" id ="windowCanvas">
       <div id ='abvWindowDims' style='margin-top:15px;'>
       <div id="abvCallout">Callout:&nbsp;&nbsp;</div><div id ="abvRoughOpen">Rough Opening:&nbsp;</div><div id ="abvUnitDim">Unit Dimension:&nbsp;</div>
       </div>
       <!--<img src="windowmk1.png" style="width:213.75px;height:561.875px;margin-left:60px;margin-top: 50px;margin-right:50px; margin-bottom:50px;" id="windowPicture">-->
       <canvas id="myCanvas0" width="111.875" height="160.9375" style="border:3px solid #000000;margin-top: 0px;margin-right:0px; margin-bottom:0px;padding-left:0px;padding-right:0px">
    <script>
    var c = document.getElementById("myCanvas0");
    var ctx = c.getContext("2d");
    ctx.lineWidth=3;
    ctx.moveTo(0,c.height/2);
    ctx.lineTo(c.width,c.height/2);
    ctx.stroke();
    </script>
       </canvas>
    <canvas id = 'widthCanvas' width = '20' height = '166'>
      <script>
       var c0 = document.getElementById('widthCanvas');
       var ctx0 = c0.getContext('2d');
       var str = $('#dimsH option:selected').text().substring(4);
       c0.height = 166; //$('#myCanvas0').attr('height');
       ctx0.font = "16px Helvetica";
       ctx0.lineWidth = 2;
       ctx0.moveTo(c0.width/2,12.5);
       ctx0.lineTo(c0.width/2,c0.height-12.5);
       ctx0.stroke();
       var path0 = new Path2D();
       path0.moveTo(0,12.5);
       path0.lineTo(c0.width/2,0);
       path0.lineTo(c0.width,12.5);      
       ctx0.fill(path0);
       var path01 = new Path2D();
       path01.moveTo(0,c0.height-12.5);
       path01.lineTo(c0.width/2,c0.height);
       path01.lineTo(c0.width,c0.height-12.5);      
       ctx0.fill(path01);
      </script>
    </canvas>
   <canvas id='heightLabel' height = '166' width = '100'>
    <script>
     var can = document.getElementById('heightLabel');
     var con = can.getContext('2d');
     var str = $('#dimsH option:selected').text().substring(4);
     con.font = "16px Helvetica";
     con.rotate(Math.PI/2);
     con.fillText(str,45,0);
    </script>
   </canvas>
   <div>
    <canvas id = 'heightCanvas' width = '117' height = '40' style='padding-left:0px'>
      <script>
       var c1 = document.getElementById('heightCanvas');
       var ctx1 = c1.getContext('2d');
       var str = $('#dimsW option:selected').text().substring(4);
       ctx1.font = "16px Helvetica";
       ctx1.fillText(str,10,30);
       ctx1.lineWidth = 2;
       ctx1.moveTo(12.5,c1.height/4);
       ctx1.lineTo(c1.width-12.5,c1.height/4);
       ctx1.stroke();
       var path1 = new Path2D();
       path1.moveTo(0,c1.height/4);
       path1.lineTo(12.5,0);
       path1.lineTo(12.5,c1.height/2);
       ctx1.fill(path1);
       var path12 = new Path2D();
       path12.moveTo(c1.width,c1.height/4);
       path12.lineTo(c1.width-12.5,0);
       path12.lineTo(c1.width-12.5,c1.height/2);
       ctx1.fill(path12);
      </script>
    </canvas>
   </div>
    <div id= 'multiWindows'></div>
    <div id ="multiWindowDims" style ="display:none;margin-top:10px">
    <p id ='multiWidth'>Width:&nbsp</p>
    <p id ='multiHeight'>Height:&nbsp</p>
    </div>
  </div>
 </div>
</div>
  <div class="modal" id="additionalItemsModal" tabindex="-1" role="dialog" aria-labelledby="Additional Items Modal" aria-hidden="true">
    <div class="modal-dialog" id="additionalItemsModalDialog">
       <div class="modal-content">
          <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title" id="myModalLabel">Additional Items</h3>
          <h5>Note: These items will appear on your order but will not go through the Casco system.</h5>
          </div>
        <div class="modal-body">
        Description:
        <p><input type = "text" class = "form-control height30 squareCorners" id ="addDesc"  placeholder="Description"></input></p>
        Price:
        <p><input type = "text" class = "form-control height30 squareCorners" id ="additionalPrice" placeholder="Price"></input></p>
        <div class="checkbox"  style ="display:inline-block;padding-right: 5px; padding-left: 5px;">
         <label>
          <input type="checkbox"  id ="additionalMultiplier">Apply Multiplier
         </label>
        </div>
        <div class="checkbox"  style ="display:inline-block;padding-right: 5px; padding-left: 5px;">
         <label>
          <input type="checkbox"  id ="additionalMarkup">Apply Markup Percent
         </label>
        </div>
        <div class="checkbox"  style ="display:inline-block;">
         <label>
          <input type="checkbox"  id ="additionalTax">Apply Tax
         </label>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal" id="additionalConfirm" style="width:20%">Add</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" id="additionalCancel">Cancel</button>
        </div>
       </div>
     </div>
  </div>
</div>
  <div class="modal" id="confirmOrderModal" tabindex="-1" role="dialog" aria-labelledby="Color Modal" aria-hidden="true">
    <div class="modal-dialog" id="confirmOrderModalDialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title" id="confirmOrderModalTitle">Confirm Order</h3>
        </div>
        <div class="modal-body">
          <p>
          PO#:
          </p>
          <div><input type = "text" class = "form-control height30 squareCorners" id="orderConfirmPO" maxlength='15' placeholder="(PO must be less than 15 characters)" style="width:50%"></input></div>
          <br>
          <p>
          Email:
          </p>
          <div><input type = "text" class = "form-control height30 squareCorners" id="orderConfirmEmail" placeholder="Email" style="width:50%"></input></div>
          &nbsp;<label style="cursor:pointer;font-weight:normal"><input type="checkbox" id="noEmail" style="cursor:pointer;margin-top:15px"/>&nbsp;Do not attach pdf to email.</label>
          <br>
          <br>
          <b>Ship-Via:</b>
          <label class="radio-inline" style="margin-bottom:5px;">
                    <input type="radio" name = "shipViaOptsE" id="shipViaPickupE" onclick="javascript:showAddressForm('p')" value="option1" checked="true">Pick-up
               </label>
                <label class="radio-inline" style="margin-bottom:5px">
                    <input type="radio" name = "shipViaOptsE" id="shipViaDeliveryCustE" onclick="javascript:showAddressForm('s')" value="option2">Delivery - Shop
                </label> 
                <label class="radio-inline" style="margin-bottom:5px">
                    <input type="radio" name = "shipViaOptsE" id="shipViaDeliveryJobE" onclick="javascript:showAddressForm('j')" value="option3">Delivery - Jobsite
                </label>
            <br>
            <br>
            <div id='jobsiteCharge' style="display: none">**Jobsite Delivery Charges Will Apply**</div>
             <!-- change add these inputs -->
            <div id="displayOrderAddress" style="display: none"></div>
            <div id="placeOrderAddressDiv" style="display: none">    
            <div class= 'form-group'>
              <label class="address1Label" for="address1JobSE">Address 1:&nbsp;</label>
              <textarea rows ='1' id ='address1JobSE' placeholder="Address 1" class="form-control squareCorners"></textarea>
            </div>
            <div class= 'form-group'>
              <label class="address2Label" for="address2JobSE">Address 2:&nbsp;</label>
              <textarea rows ='1' id ='address2JobSE' placeholder="Address 2" class="form-control squareCorners"></textarea>
            </div>
            <div class= 'form-group'>
              <label class="address3Label" for="address3JobSE">Address 3:&nbsp;</label>
              <textarea rows ='1' id ='address3JobSE' placeholder="Address 3" class="form-control squareCorners"></textarea>
            </div>
            <div class= 'form-group' style='float:left'>
            <label for="cityJobSE">City:&nbsp;</label>
              <input type="text" id ='cityJobSE' placeholder="City" class="form-control height30 squareCorners" style='width:95%'></input>
             </div>
           <div class= 'form-group' style='float:left'>
            <label for="stateJobSE">State:&nbsp;</label>
              <input type="text" id='stateJobSE' placeholder="State" class="form-control squareCorners height30" style='width:95%;'></input>
           </div>
           <div class= 'form-group'>
            <label  for="zipCodeJobSE">ZIP Code:&nbsp;</label>
              <input type="text" id='zipCodeJobSE' placeholder="ZIP Code" class="form-control height30 squareCorners" style='width:30%'></input>
           </div>
          
          <div class= 'form-group' style='float:left;'>
            <label for="contactJobSE">Contact:</label>
              <input type="text" id='contactJobSE' placeholder="Contact" class="form-control height30 squareCorners" style='width:95%'></input>
             </div>
          <div class= 'form-group' style='float:left'>
            <label for="phoneNumberJobSE">Phone Number:</label>
              <input type="tel" id ='phoneNumberJobSE' placeholder="Phone Number" class="form-control height30 squareCorners" style='width:95%'></input>
           </div>
           <br>
           <br>
           <br>
           <br>
           <div class= 'form-group'>
              <label class="addressLabel" for="notesJobSE">Notes:&nbsp;</label>
              <textarea rows ='3' id ='notesJobSE' placeholder="Notes" class="form-control squareCorners"></textarea>
           </div> 
           </div>      
        <div class="modal-footer">
          <button type="button" class="btn btn-info" style="margin-right:260px" onclick="createPdf()">View PDF</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" id="glassOrderCancel">Cancel</button>
          <button type="button" class="btn btn-success" data-loading-text="Loading..." id="glassOrderConfirm">Place Order</button>
        </div>
      </div>
    </div>
  </div>
</div><!--end modal-->
<div class="modal" id="testLoadModal" tabindex="-1" role="dialog" aria-labelledby="Test Modal" aria-hidden="true">
    <div class="modal-dialog" id="testLoadModalDialog">
      <div class="modal-content">
        <div class="modal-header">
          <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
          <h3 class="modal-title" id="testLoadModalTitle">Sending Order....</h3>
        </div>
        <div class="modal-body">
         
          <!--<div id="loading">
                <ul class="bokeh">
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>-->
            <div class="progress progress-striped active page-progress-bar">
              <div class="progress-bar" style="width: 100%;background-color: #f16722"></div>
            </div>
            <p>This Process May Take a Few Minutes. Do not exit this window, refresh this page, or use the browser's back button until this dialogue has closed. If the loading bar does not close after a few minutes, please refresh and try again. </p>
            <p>If the problem persists, please contact Casco Technical Support at <a href="mailto:techsupport@cascoonline.com">techsupport@cascoonline.com</a></p>
        <!--<div class="modal-footer">
        footer
        </div>-->
      </div>
    </div>
  </div>
</div><!--end modal-->
<div class="modal" id="confirmPDFModal" tabindex="-1" role="dialog" aria-labelledby="PDF Modal" aria-hidden="true">
    <div class="modal-dialog" id="confirmPDFModalDialog">
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="confirmPDFModalTitle">PDF Options</h3>
          </div>
        <div class="modal-body">
          <p>
            Display Price:
          </p>
          <select class = "form-control squareCorners" id ='selectDisPrice' name = "selectDisPriceName" style = "width:50%;"> 
            <option value="list">List</option>
            <option value="netCost">Cost</option>
            <option value="sell">Sell</option>
            <option value="noPrice">No Price</option>
          </select>
          <p>  
          <div class="in">
            <input type="radio" id ="priceItemized" checked='checked' name="pdfPriceType"/>&nbsp;<label class="notbold" for="priceItemized">Itemized Price</label>
          </div>
          &nbsp;
          <div class="in">
            <input type="radio" id = "priceTotalOnly" name="pdfPriceType"/>&nbsp;<label class="notbold" for="priceTotalOnly">Total Price Only</label>
          </div>
          </p>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" id="glassPdfCancel">Cancel</button>
          <button type="button" class="btn btn-success" onclick="javascript:createPdf()" id="glassPdfConfirm">Download PDF</button>
        </div>
      </div>
    </div>
  </div>
</div><!--end modal-->
</div>
<canvas id ="pdfImgCanvas" style="display:none">
  <script type="text/javascript">
    var c = document.getElementById('pdfImgCanvas');
    c.width = 200;
    c.height = 200;
    var ctx = c.getContext('2d');
    ctx.fillStyle = "#fff";
    ctx.fillRect(0,0,c.width, c.height);
    var img = document.getElementById('shape1');
    //var img2 = document.getElementById('shape2').src;
    ctx.drawImage(img,0,0);
  </script>   
</canvas>
<div class="col-lg-8 col-lg-offset-2 col-sm-12 col-xs-12 stardust reviewPanel" style = "display:none" id = "bottomHalf">
  <h2>Current Items</h2>
  <button type = "button" data-loading-text="Loading..." autocomplete="off" onclick = "this.blur()" class = "btn btn-primary alignRight" data-toggle = "modal" data-target ="#additionalItemsModal" id ="glassadd_line">Add Manual Line Item</button>
  <p></p>
  <!--
  <div class="checkbox"  style ="display:inline-block; border-right: 1px solid black; padding-right: 5px; padding-left: 5px;">
    <label>
      <input type="checkbox"  disabled ="disabled" id ="hideList">Hide List Price 
    </label>
  </div>
  <div class="checkbox"  style ="display:inline-block; border-right: 1px solid black; padding-right: 5px; padding-left: 5px;">
    <label>
      <input type="checkbox" disabled = "disabled" id ="hideNet">Hide Net Price
    </label>
  </div>
  <div class="checkbox"  style ="display:inline-block; border-right: 1px solid black; padding-right: 5px; padding-left: 5px;">
    <label>
      <input type="checkbox"  disabled = "disabled" id ="hideSell" >Hide Dealer Price
    </label>
  </div>
 <div class="checkbox"  style ="display:inline-block;">
    <label>
      <input type="checkbox" disabled="disabled" id ="hideExtended">Hide Extended Price
    </label>
  </div>
  -->
  <?php 
    if($currentUser =='dev' || $currentUser =='kb'){
      echo "Multiplier: <input type = 'text' class = 'form-control in squareCorners' style = 'width: 11%; height: 30px;' placeholder = 'Multiplier' id = 'multiplierIn' value = 1></input> &nbsp;";
    }else{
      echo "<input type = 'hidden' class = 'form-control in squareCorners' disabled='disabled' style = 'width: 11%; height: 30px; display:none' placeholder = 'Multiplier' id = 'multiplierIn' value = 1></input> &nbsp;";
    }
  ?>
  Markup Percent:
  <input type = "text" class = "form-control in squareCorners" style = "width: 11%;height: 30px;" placeholder = "Markup Percent" id ='markupPercIn' value = 0></input>
  &nbsp;
  Tax Percent:
  <input type = "text" class = "form-control in squareCorners" style = "width: 11%;height: 30px;" placeholder = "Tax Percent" id ='taxPercIn'></input>
  &nbsp;
  Display Price:
  <select class = "form-control in squareCorners" id ='selectDisPrice' name="selectDisPriceName" style = "width: 11%;height: 30px;"> 
    <option value="list">List</option>
    <option value="netCost">Cost</option>
    <option value="sell">Sell</option>
    <option value="noPrice">No Price</option>
  </select>
  <br>
  <br>
  <table class="table table-bordered" id="tab_logic" style="border-top: 1px solid #ddd;border-left: 1px solid #ddd;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;">
    <thead>
      <tr>
        <th class="text-center" style="border-bottom: #ffffff;">
          Line
        </th>
        <th class="text-center" style="border-bottom: #ffffff;width:5%;">
          Quantity
        </th>
        <th class="text-center"  style="border-bottom: #ffffff;border-right:1px solid #ddd">
          Details
        </th>
        <th class="text-center" id ="listColumn" style="border-bottom: #ffffff;">
          Price
        <!--</th>
        <th class="text-center" id ="netColumn"  style="border-bottom: #ffffff;">
            Net<br>Price
        </th>
        <th class="text-center" id = "sellColumn"  style="border-bottom: #ffffff;">
            Dealer<br>Price
        </th>
        <th class="text-center" id = "extendedColumn" style="border-bottom: #ffffff;">
            Extended<br>Price
        </th>-->
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td style = 'border-right:#ffffff; text-align:right' id ='priceFooter' colspan = "7"><strong>Total Price: </strong>$0</td>
      </tr> 
    </tfoot>
    <tbody style="font-size:12px;" id ="tabLogicBody">
      <tr id='addr0' data-id="0" class="hidden">
        <td data-name="lineNumber">       
        </td>
        <td data-name="preview">
        </td>
        <td data-name="dims">
        </td>
        <td data-name ="listPriceTd">
        </td>
        <!--<td data-name ="netPriceTd">
        </td>
        <td data-name ="sellPriceTd">
        </td>
        <td data-name ="extendedPriceTd">
        </td>-->
      </tr>
    </tbody>
  </table>
  <button type = "button" data-loading-text="Loading..." autocomplete="off" data-toggle = "modal" data-target ="#confirmOrderModal" class = "btn btn-success alignRight" onclick= "sendOrder()" id ="glasssendOrder">Place Order</button>
  <!--<button type="button" id="deleteFlagButton" style="margin-right:4px;" class="btn btn-warning alignRight" onclick="deleteFlag()">Delete Flag</button>-->
  <div class = "button in padb">
    <!--<button type = "button" class = "btn btn-default" id='viewAddItms'>Show Additional Items</button>&nbsp; 
    <button type = "button" id ="viewBlobButton" class = "btn btn-info" id='makePdf'>View Blob</button>-->
    <button type = "button" class = "btn btn-default genPdf" data-toggle="modal" data-target ="#confirmPDFModal" id='makePdf'>Download PDF</button>
    <button type = "button" class = "btn btn-default" style="display:none;" onclick="javascript:mailQuote();$(this).blur()" id='mailQuote'>Email PDF of Quote</button>&nbsp;
    <button type = "button" class = "btn btn-default" onclick="javascript:editHeader();$(this).blur()" id='editHeader'>Edit Customer Information</button>
  </div>
  <table class="table table-bordered" id="addTable" style="width:50%;display:none;">
    <caption class="text-center"><strong style='font-size:15px;color:#292929;'>Additional Items</strong></caption> 
      <thead>
        <tr>
          <th class="text-center" style="border-bottom:#fff">
            Description
          </th>
          <th class="text-center" style="border-bottom:#fff">
            Price
          </th>
        </tr>
      </thead>    
    <tbody id = 'addBody'>
    </tbody>
  </table>
  </div>
 </div>
 </div>
 </div>
 </div> 
 </div> 
</div>
<div class="footer navbar-fixed-bottom" id="contactFooter" style="margin-bottom: 35px; margin-left:25px;width:50%;display: none"> 
    <a title="email the developer" href = "mailto:alopez@custom-aluminum.com"><button id="contactButton" class = "btn btn-primary">Report Bug or Give Feedback</button></a>
  </div>
<script type="text/javascript" src="/jsPDF-master/jsPDF-master/dist/jspdf.debug.js"></script>
<script type="text/javascript" src="/jsPDF-master/jsPDF-master/plugins/from_html.js"></script>
<script type="text/javascript" src="/jsPDF-master/jsPDF-master/plugins/cell.js"></script>
<!--<script type="text/javascript" src="/jsPDF-master/jsPDF-master/libs/png_support/png.js"></script>-->
<script type="text/javascript">
//variable list
//var doTaxes = 0;
var use12 = true;
var homeId = 0;
var quoteTax = 0;
var savedTax = "7.5%";
var testAmount = 0;
var price = 0;
var checkGrilleColor = 0;
var checkExtColor = 0;
var grillPrice;
var jambPrice;
var extPrice;
var glassPrice;
var tempOldPrice;
var tempNewPrice = 0;
var checkCustom = 0;
var addId = 0;
var extChoiceEl = document.getElementById("extChoice");
var extE = document.getElementById("extColorChoice");
var priceDims;
var quickAdd = 0;
var roughOpenH;
var roughOpenW;
var roughOpenWStr;
var roughOpenHStr;
var jobNumber;
var jobID;
var jobDate;
var jobPrepared;
var jobPoId;
var jobDesc;
var jobClientId;
var jobClientName;
var jobAddress;
var jobCity;
var jobState;
var jobZip;
var jobCountry = "United States";
var jobContact;
var jobPhoneNumber;
var jobEmail;
var sashCheck = 0;
var bothTemp = 0;
var timer;
var mullUnitDimW;
var mullUnitDimH;
var custUnitsWide;
var custUnitsHigh;
var imgData;
var imgData2;
var imgData3;
var shapeData1;
var jobSiteAddress;
var jobSiteCity;
var jobSiteState;
var jobSiteZip;
var jobSiteCountry = "United States";
var jobSiteContact;
var jobSitePhone1;
var jobSitePhone2;
var jobSiteNotes;
var jobFaxNumber;
var shipToAddress;
var shipToCity;
var shipToState;
var shipToZip;
var shipToCountry = "United States";
var shipToContact;
var shipToPhone;
var shipToNotes;
var windowOptions = [];
var savedImgArr = [];
var jsonWindowString;
var quoteTotal = 0;
var newQuote = 0;
var needQuotes = 0;
var needCust = 0;
var testV;
var arr2;
var responseArr;
var deleteQuote = 0;
var useEstate = 0;
var screenHasEstate = 0;
var checkGrilleSash = 0;
var thisId;
var deleteCount = 0;
var additionalArray = [];
var accessArray = [];
var ww ="";
var ww2 = "CDH";
var ww3 = "glass";
var mullNum = 1;
var mullNum2 = 1;
var arrayWinBalances = " ";
var mullPrice;
var screenPrice;
var finishPrice;
var installPrice;
var grilleSashPrice;
var useCustomDims = 0;
var winArrayCustWInch = 0;
var winArrayCustWFt = 0;
var winArrayCustHInch = 0;
var winArrayCustHFt = 0;
var transomPrice = 0; 
var priceTransom = 0;
var parseArray = 0;
var taxFreeAmt = 0;
var taxableAmt = 0;
var tempPriceLevel2 = 0;
var windowPriceOpts = [];
var user = <?php echo "'".$currentUser."'"; ?>;
var savedLineNum = 0;
state_abbr = {
'Alabama':  'AL' ,
'Alaska':  'AK' ,
'America Samoa':  'AS' ,
'Arizona':  'AZ' ,
'Arkansas':  'AR' ,
'California':  'CA' ,
'Colorado':  'CO' ,
'Connecticut':  'CT' ,
'Delaware':  'DE' ,
'District of Columbia':  'DC' ,
'Micronesia':  'FM' ,
'Florida':  'FL' ,
'Georgia':  'GA' ,
'Guam':  'GU' ,
'Hawaii':  'HI' ,
'Idaho':  'ID' ,
'Illinois':  'IL' ,
'Indiana':  'IN' ,
'Iowa':  'IA' ,
'Kansas':  'KS' ,
'Kentucky':  'KY' ,
'Louisiana':  'LA' ,
'Maine':  'ME' ,
'Marshall Islands':  'MH' ,
'Maryland':  'MD' ,
'Massachusetts':  'MA' ,
'Michigan':  'MI' ,
'Minnesota':  'MN' ,
'Mississippi':  'MS' ,
'Missouri':  'MO' ,
'Montana':  'MT' ,
'Nebraska':  'NE' ,
'Nevada':  'NV' ,
'New Hampshire':  'NH' ,
'New Jersey':  'NJ' ,
'New Mexico':  'NM' ,
'New York':  'NY' ,
'North Carolina':  'NC' ,
'North Dakota':  'ND' ,
'Ohio':  'OH' ,
'Oklahoma':  'OK' ,
'Oregon':  'OR' ,
'Palau':  'PW' ,
'Pennsylvania':  'PA' ,
'Puerto Rico':  'PR' ,
'Rhode Island':  'RI' ,
'South Carolina':  'SC' ,
'South Dakota':  'SD' ,
'Tennessee':  'TN' ,
'Texas':  'TX' ,
'Utah':  'UT' ,
'Vermont':  'VT' ,
'Virgin Island':  'VI' ,
'Virginia':  'VA' ,
'Washington':  'WA' ,
'West Virginia':  'WV' ,
'Wisconsin':  'WI' ,
'Wyoming':  'WY' 
}
orderTaxAmt = 0;
custEmail = "";
glassOptions = [];
//savedGPArray = [];
savedGLabelArray = [];
savedGShapeArray = [];
savedGDimsArray = [];
savedGCSArray = [];
savedGTypeArray = [];
savedGQuantArray = [];
savedGStrArray = [];
savedGThckArray = [];
savedGSpcrArray = [];
savedGGrilleArray = [];
savedGGrillePattArray = [];
savedGGrilleIntArray = [];
savedGGrilleSDLArray = [];
savedGPreArray = [];
savedGTintArray = [];
savedGHCoatArray = [];
savedGObscArray = [];
savedGIgArray = [];
savedGSurface5Array = [];
savedGUnits2Array = [];
savedGUnitsArray = [];
savedGBlankArray = [];
savedGAddArray = [];
savedWDimsArray = [];
savedWCSArray = [];
savedWSizeArray = [];
savedWMullArray = [];
savedWBalArray = [];
savedWLabelArray = [];
savedWQuantArray = [];
savedWExtArray = [];
savedWCladColArray = [];
savedWEstateColArray = [];
savedWGTypeArray = [];
savedWGOptArray = [];
savedWTempArray = [];
savedWGrilleArray = [];
savedWGrillePattArray = [];
savedWGrilleColArray = [];
savedWGrilleSashArray = [];
savedWScrReqArray = [];
savedWScreenTypeArray = [];
savedWScreenColArray = [];
savedWHardColArray = [];
savedWJambArray = [];
savedWIntFinArray = [];
savedWAccArray = [];
savedWInstallArray = [];
savedWAddArray = [];
savedWGUnitArray = [];
savedW998Array = [];
savedW999Array = [];
pdfQuantVal = 1;
priceMulti = 1;
addItmsLine = "";
editNum = 0;
saveWin = 0;
editTblRow = 0;
savedGImgPath1 = '';
savedGImgPath2 = '';
savedGImgPath3 = '';
savedGImgPath4 = '';
savedGImgPath5 = '';
blankRow = 0;
disPrice = 1;
pdfPriceType = 0;
as4OrderNum = 0;
seqOffset = 0;
orderedOn = "Not Ordered";
cascoAddress = "540 Division Street, South Elgin Illinois, 60177 (847)741-9595";
var newid = 0;
var price = 0;
var deliveryCheck = 0;
var lineNum = 0;
var qmulti;
var qmarkup;
$(document).on('click', '.panel-heading span.clickable', function(e){
var $this = $(this);
  if(!$this.hasClass('panel-collapsed')){
    $this.closest('.panel').find('.panel-body').slideUp();
    $this.addClass('panel-collapsed');
    $this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
  }else{
    $this.closest('.panel').find('.panel-body').slideDown();
    $this.removeClass('panel-collapsed');
    $this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
  }
})
$(document).ready(function(){
    //disable('#sideBarPrint');
    $('#contactFooter').width($('#contactButton').width());
    homeId = window.location.href.split('?homeId=')[1];
    $.get('/logouri.txt', function(data){
      imgData = data.toString();
    });
    $.get('/logouri2.txt', function(data){
      imgData2 = data.toString();
    });
    $.get('/outlinewidth2.txt',function(data){
      imgData3 = data.toString();
    });
    $.get('/shape1DataJPEG.txt',function(data){
      shapeData1 = data.toString();
    });
    $.get('/pdfHeaderURI.txt',function(data){
      headerImg = data.toString();
    });
    $.get('/rectImgURI.txt',function(data){
      rectImg = data.toString();
    })
    isCasco = <?php echo $isCasco ?>;
    if(isCasco == '0'){
      $('#custSearch').hide();
      $('#custSearchSpan').hide();
      $('#windowLi').hide();
    }else if(isCasco == '1' && $('#custSearch').is(':hidden')){
      $('#custSearch').show();
      $('#custSearchSpan').show();
     
    }
    getRoughOpening();
    $('#abvRoughOpen').html('<strong>Rough Opening: </strong>'+roughOpenWStr+ " X " +roughOpenHStr+"<br>");
    $('#abvCallout').html('<strong>Callout:</strong> '+ww2+ $('#'+ww+'dimsW option:selected').val()+$('#'+ww+'dimsH option:selected').val()+'-' +$('#'+ww+'installMulls1 option:selected').text());
    $('#abvUnitDim').html('<strong>Unit Dimension: </strong>' + $('#'+ww+'dimsW option:selected').text().substring(5,$('#'+ww+'dimsW option:selected').text().length) +" X " + $('#'+ww+'dimsH option:selected').text().substring(5,$('#'+ww+'dimsH option:selected').text().length)+"<br><br>");
    var bldthis = $('#abvUnitDim').text().substring(0,15)
    bldthis.bold();
    $('[name="quickAddName"]').click(function(){
       quickClicked = 1; 
       quickAdd = 1;
           if($('#'+ww+'custDimsInchs').is(':visible')){ 
       if($('#'+ww+'custDimW').val() != "" && $('#'+ww+'custDimH').val() != "" && ($('#'+ww+'custDimH').val() > 36 ||  $('#'+ww+'custDimW').val() > 40) || isNaN($('#'+ww+'custDimW').val()) || isNaN($('#'+ww+'custDimH').val())){
           alert('Please enter valid dimensions.');
           quickAdd = 0;
           $(this).blur();
           return;      
        }else{
           var newW = sizeUpW($('#'+ww+'custDimW').val(),'dimsW');
           var newH = sizeUpH($('#'+ww+'custDimH').val(),'dimsH');
           priceDims = newW+newH;
        }
      }else if($('#'+ww+'ftInCustDims').is(':visible')){ 
          var custFtH = +(+$('#'+ww+'custDimHFt').val() * 12) + +$('#'+ww+'custDimHInch').val()
          var custFtW = +(+$('#'+ww+'custDimWFt').val() * 12) + +$('#'+ww+'custDimWInch').val()
      if(custFtH != "" && custFtW != "" && (custFtH > 36 ||  custFtW > 40 ) || isNaN(custFtW) || isNaN(custFtH)){
        alert('Please enter valid dimensions.');
        $(this).blur();
        return;
      }else{
        useCustomDims = 1;
        winArrayCustWInch = $('#'+ww+'custDimWInch').val();
        winArrayCustWFt = $('#'+ww+'custDimWFt').val();
        winArrayCustHInch = $('#'+ww+'custDimHInch').val();
        winArrayCustHFt = $('#'+ww+'custDimHFt').val();
        var newW = sizeUpW(parseInt(custFtW),'dimsW');
        var newH = sizeUpH(parseInt(custFtH),'dimsH');
        priceDims = newW+newH;
        }      
      }else{
        priceDims = $('#'+ww+'dimsW option:selected').val()+$('#'+ww+'dimsH option:selected').val();
      }    
      $('#'+ww+'add_row').click();
      $(this).blur();
    });
  //#MakeCascoGreatAgain  
  $('[name="addToOrderName"]').on("click", function(){//window add_row function
    if($('#bottomHalf').is(':hidden')){
      $('#bottomHalf').toggle();
    }
    if(quickAdd == 1){
      var $btn = $('[name="quickAddName"]').button('loading');
    }else{
      var $btn = $(this).button('loading');
    }
    if($('#'+ww+'transomPanel').is(':visible')){
      $('#'+ww+'transomPanel').toggle();
    }
    setTimeout(function(){
      if(ww == "cc"){
        priceDims +="-"+$('#'+ww+'installMulls1 option:selected').text();
        getMullPrice(ww2,$('#'+ww+'installMulls1 option:selected').text(),priceDims);
      }
      else if(ww=="ca"){
        priceDims = $('#'+ww+'installMulls1 option:selected').text() + $('#'+ww+'installMulls2 option:selected').text() + "-" + priceDims;
        getMullPrice(ww2,$('#'+ww+'installMulls1 option:selected').text()+$('#'+ww+'installMulls2 option:selected').text(),priceDims);
      }
      if(ww=="cdhpw"){
         priceDims = $('#'+ww+'dimsW option:selected').val() + 'X' +$('#'+ww+'dimsH option:selected').val();}
      if(ww=="cdhpw" || ww=="cs"){
        getPwExtPrice(ww2,'Clad',priceDims);
      }else{
        getExtPrice('Clad',ww2,priceDims);
      }
      getJambPrice($("#"+ww+"jambSize option:selected").text().replace('"',''),priceDims,ww2);
      if(ww == "cs" || ww == "" || ww=="cdhpw"){
        if($('#screens_required').is(':checked')){
            
        }else{
          getScreenPrice(ww2,'Yes','',priceDims);
        } 
      }else{
        if($('#screens_required').is(':checked')){
            
        }else{
          getScreenPrice(ww2,'Screens',ww2,priceDims);
        }
      }
      //getGlassPrice(document.getElementById(ww+"glass1").options[document.getElementById(ww+'glass1').selectedIndex].text,ww2,priceDims);
      getFinishPrice(ww2,$('#'+ww+'intPrime option:selected').text(),priceDims);
      //getGrillePrice(ww2,priceDims,($('#'+ww+'grilleType option:selected').val()),($("#"+ww+"grillePattern option:selected").text()),($('#'+ww+'grilleSash option:selected').text()));
      getGrilleSashPrice(ww2,$('#'+ww+'grilleSash option:selected').text(),"");
      getConfigPrice($('#'+ww+'installBalances option:selected').text(),ww2,priceDims);
      //getAccessoriesPrice(ww2,$('#'+ww+'install1 option:selected').val(),priceDims);
      //getInstallPrice(ww2,$('#'+ww+'nailFinSelect option:selected').val(),priceDims);
      if(priceTransom == 1){
        getTransomPrice(ww2+"TR",$('#transomDimsH option:selected').val(),$('#transomUnitsWide option:selected').val(),$('#transomgrilleType option:selected').val(),$('#transomgrillePattern option:selected').val());
      }
      if(quickAdd == 0){
        $("#"+ww+"panel9").find('.panel-body').slideUp();
        $("#"+ww+"panel9").find("#"+ww+"span9").addClass('panel-collapsed');
        $("#"+ww+"panel9").find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
      }
      $(this).blur();
      tempOldPrice = $('#priceFooter').html().replace(/^\D+/g, "");
      deliveryCharge = 0; 
      if(ww ==""){
        tempNewPrice *= $('#'+ww+'installMulls1 option:selected').text(); 
      }
      tempNewPrice += 6*($('#'+ww+'installMulls1 option:selected').text()-1);
      if(checkCustom == 1){
        tempNewPrice *= 1.5;
      }
      otherWindowOpts = [];
      //get list of options that use square foot based price
        $('.searchDesc > option:selected').each(function(){
          if($(this).attr('data-desc')){
            windowPriceOpts.push($(this).attr('data-desc'));
          }else{
            console.log($(this).closest('select').attr('name') + ": not square feet: " + $(this).attr('value'));
          }
        });
        windowPriceOptsJson = JSON.stringify(windowPriceOpts);
        //get price of selected options * square feet of window
        $.ajax({
          url:"getNewPrice.php",
          type: "POST",
          data:{d: windowPriceOpts},
          async:false,
          success:function(data){
            console.log(parseFloat(data * (($('#dimsW option:selected').attr('value') * $('#dimsH option:selected').attr('value'))/144)).toFixed(2));
            tempNewPrice += +parseFloat(data * (($('#dimsW option:selected').attr('value') * $('#dimsH option:selected').attr('value'))/144)).toFixed(2);
          }    
        });
        $('#priceFooter').html("<strong>Total Price: </strong>$"+(+tempNewPrice + +tempOldPrice + +deliveryCharge));
        $.each($("#tab_logic tr"), function(){
          if(parseInt($(this).data("id")) > newid){
            newid = parseInt($(this).data("id"));
          }
        });
        newid++;
        lineNum++;
        var lineNumDiv = "<div id = line" + newid+ " name='lineNumDivName'>"+lineNum+"</div>";
        var tr = $("<tr></tr>", {
            id: "addr"+newid,
            "data-id": (newid)
        });
        // loop through each td and create new elements with name of newid
        $.each($("#tab_logic tbody tr:nth(0) td"), function(){
          var cur_td = $(this);
          var children = cur_td.children();
          // add new td and element if it has a name
          if($(this).data("name") != undefined){
            var td = $("<td></td>", {
                "data-name": $(cur_td).data("name")
            });
            var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
            c.attr("name", $(cur_td).data("name") + newid);
            var name10 = c.attr("name");
            c.attr("id",c.attr("name"));
            c.val(c.attr('placeholder'));
            var v = "window";
            c.appendTo($(td));
            td.appendTo($(tr));              
          }else{
            var td = $("<td></td>", {
              'text': $('#tab_logic tr').length
            }).appendTo($(tr));
          }
        });
        // add the new row
        $(tr).appendTo($('#tab_logic'));
        /*
        enable('hideList'); 
        enable('hideSell');
        enable('hideNet');
        enable('hideExtended');
        */
        var numUnitsInput = $("#"+ww+"numUnits").val();
        var mullUnits = $("#"+ww+"installMulls1 option:selected").text();
        var dims = $("#"+ww+"dimsW option:selected").val()+$("#"+ww+"dimsH option:selected").val();
        if(checkCustom == 1){
          dims = $('#'+ww+'custDimW').val() + $('#'+ww+'custDimH').val();
        }
        /*
        0|CDH|CDH[WH]|
        1|Custom Size|[NO\YES]|000     000     000     000     000     000     000     
        2|Size|WH|000     000     000     000     000     000     000     
        3|Mulled Units|[SINGLE\TWIN\TRIPLE\QUAD]|000     000     000     000     000     000     000     
        4|Balances|[Tilt\Comp]|000     000     000     000     000     000     000     
       {5|}
        6|Quantity|000000N|000     000     000     000     000     000     000     
       {7|Vertical Mulls|-------------------------------------}
       {8|Horizontal Mulls|-----------------------------------}
        9|Exterior|[Color]|000     000     000     000     000     000     000     
       10|Clad Color|[Color]
      {11|}
       12|Glass Type|[Clear\Lo-e Type]|000     000     000     000     000     000     000     
       13|Glass Option|[Obscure\Clear\etc]|000     000     000     000     000     000     000     
       14|Tempered|[No\Yes]|000     000     000     000     000     000     000     
       15|Grille|[Opts]|000     000     000     000     000     000     000     
      {16|}
      {17|}
      {18|}
      {19|}
      {20|}
      {21|}
       22|Screens Required|[Yes\No]|000     000     000     000     000     000     000     
       23|Screen Type|[Screen Opts]|000     000     000     000     000     000     000     
       24|Screen Color|[Colors]|000     000     000     000     000     000     000     
      {25|}
       26|Hardware Color|[Colors]|000     000     000     000     000     000     000     
       27|Jamb Size|[size]|000     000     000     000     000     000     000     
       28|Int. Finish|[none\colors]|000     000     000     000     000     000     000     
       29|Accessories|[none\opts]|000     000     000     000     000     000     000     
       30|Installation|[opts.]|000     000     000     000     000     000     000     
       31|Additional Units|[yes\no]|000     000     000     000     000     000     000     
      997|Glass Units|[quant]|
      998|W-w X H-h|
      999|W X H|
        */
        var extColor;
        if(checkExtColor == 0){
          if($("#"+ww+"extColorChoice option:selected").val() == "Estate Colors"){
            extColor =$("#"+ww+"extColorChoiceEstate option:selected").text();
          }else{
            extColor = $("#"+ww+"extColorChoice option:selected").text();
          }
        }
        var grilleTypeChoice = $("#"+ww+"grilleType option:selected").val();
        var grilleTypeChoiceText = $("#"+ww+"grilleType option:selected").text();
        var grillePatternChoice = $("#"+ww+"grillePattern option:selected").val();
        var grillePatternChoiceText = $('#'+ww+'grillePattern option:selected').text();
        if(checkGrilleColor == 1){
          var grilleColorChoice = $("#"+ww+"grilleColor option:selected").val();
          var grilleColorChoiceText = $("#"+ww+"grilleColor option:selected").text();
        }else{
          var grilleColorChoice = "";
          var grilleColorChoiceText = "";
        }
        if(checkGrilleSash == 1){
          var grilleSashChoice = $("#"+ww+"grilleSash option:selected").val();
        }else{
          var grilleSashChoice = "";
        }
        if($('#screens_required').is(':checked')){
          var screenColorChoice = "";
          var screenColorChoiceText = "";
          var screenPatternChoice ="";
        }else{
          if(screenHasEstate==1){
            var screenColorChoice = $('#'+ww+'screenColorChoiceEstate option:selected').val();
            var screenColorChoiceText = $('#'+ww+'screenColorChoiceEstate option:selected').text();
          }else{
            var screenColorChoice = $("#"+ww+"screenColor option:selected").val();
            var screenColorChoiceText = $('#'+ww+'screenColor option:selected').text();
          }
            var screenPatternChoice = $("#"+ww+"screenPattern option:selected").val();
        }
        var hardwareColorChoice = $("#"+ww+"hardColorStand option:selected").text();
        var interiorFinish = "\n<strong>Finish:</strong> " + $("#"+ww+"intPrime option:selected").text(); 
        var otherInstall = $("#"+ww+"install1 option:selected").text();
        var masonStrap = $("#"+ww+"nailFinSelect option:selected").text();  
        var balanceChoice = "";
        if(ww==""){
          balanceChoice = $("#"+ww+"installBalances option:selected").text();
        }else if(ww=="cc"){
          for(m=1;m<=mullNum;m++){
            if(m==mullNum){
              balanceChoice += $('#ccunit'+m+'Handing option:selected').text();
            }else{
              balanceChoice += $('#ccunit'+m+'Handing option:selected').text()+", ";
            }
          }
        }
        if(ww==""){
          var transomHeight = $('#'+ww+'transomDimsH option:selected').val();
          var transomNum = $('#'+ww+'transomUnitsWide option:selected').val();
          var transomPattern = $('#'+ww+'transomgrillePattern option:selected').val();
          var transomgrilleType = $('#'+ww+'grilleType option:selected').val();
          var transomgrilleTypeText = $('#'+ww+'grilleType option:selected').text();
        }    
        var finalString ="";
        var dimsH;
        var dimsW;
        var newDims;  
        var grille = "\n<strong>Grille:</strong> " + grilleTypeChoiceText +", ";
        grille += grillePatternChoiceText +', ';
        if(grilleColorChoice !=""){
          grille += grilleColorChoiceText + ', ';
        }
        grille += grilleSashChoice;
        mullUnitDimW = $('#'+ww+'dimsW option:selected').text().substring(5,$('#'+ww+'dimsW option:selected').text().length);
        mullUnitDimH = $('#'+ww+'dimsH option:selected').text().substring(5,$('#'+ww+'dimsH option:selected').text().length);   
        getRoughOpening();
        if(ww==""){
          var balanceTitle = "Balances: ";
        }else if(ww=='cc'){
          var balanceTitle = "Handing: ";
        }
        var dimsString = "<strong>Callout:</strong> "+ww2+ priceDims+'-'+mullUnits+", <strong>Unit Dimension: </strong>" + mullUnitDimW + " X " + mullUnitDimH +", <strong>Rough Opening: </strong>"+roughOpenWStr+ " X " +roughOpenHStr+"&nbsp;";
        var glass = "\n<strong>Glass:</strong> " + $("#"+ww+"glass1 option:selected").text() + ", "  + $("#"+ww+"glass2 option:selected").text();
        if($("#"+ww+"glass_i89").is(':checked')){
          glass += ", i89 Upgrade";
        }
        if($("#"+ww+"glassTemp").is(':checked') && $('#'+ww+'bothSashTemp').is(':checked')){
          glass += ", <em><mark id = 'tempBothText' style='background-color:yellow; color:black;'>Tempered-Both</mark></em>";
        }
        else if($("#"+ww+"glassTemp").is(':checked') && $('#'+ww+'topSashTemp').is(':checked')){
          glass += ", <em><mark id = 'tempTopText' style='background-color:yellow; color:black;'>Tempered-Top</mark></em>";
        }
        else if($("#"+ww+"glassTemp").is(':checked') && $('#'+ww+'botSashTemp').is(':checked')){
          glass += ", <em><mark id = 'tempBotText' style='background-color:yellow; color:black;'>Tempered-Bottom</mark></em>";
        }
   
        var installStuff = "\n<strong>Installation:</strong> " + otherInstall +", "+ masonStrap;
        var jambChoice = "\n<strong>Jamb:</strong> " + $("#"+ww+"jambSize option:selected").text();
        if($('#'+ww+'screens_required').is(':checked')){
        var screens = "";
        }else{
        var screens = "\n<strong>Screens:</strong> " + screenColorChoiceText + ", " + screenPatternChoice;
        }
        //var winGlassLabel = "<input type='text' class = 'squareCorners in' onkeyup='updateLabel(this)' name ='lineLabels' value='"+hGlassLabel+"' id ='"+lineLabelId+"'/>&nbsp;&nbsp;<span name = 'labelCheckName' class='glyphicon glyphicon-ok hidden' title='Label Saved' style='font-size:1.25em;color:green'></span>";
        var winLabel2 = '<strong>Label:</strong><input type="text" name ="winLabelBottom" onkeyup = "updateLabel(this)" value ="'+$('#windowLabel').val()+'" style = "width:40%; height:30px;" class ="form-control squareCorners" placeholder = "Enter Label Here..."></button><br>';
        var hardwareString = "\n<strong>Hardware:</strong> " + hardwareColorChoice;
        var extString = "\n<strong>Exterior:</strong> " + extColor; 
        var oldPrice = $("#tab_logic").find('tr#addr'+(newid-1)).find('td:eq(11)').text().replace(/^\D+/g, "");
        price = $('#priceFooter').html().replace(/^\D+/g, "");
        finalString =  "\n <p></p><strong>Configuration:</strong> " + balanceTitle + balanceChoice + ", Units wide: " + mullUnits+ extString + " " + glass + " " + grille + " " + jambChoice + " " + screens + " " + hardwareString + " " + interiorFinish + " " + installStuff;
        var quantId = "quantity" + newid;
        var listId = "listString" + newid;
        var netId = "netString" + newid;
        var sellId = "sellString" + newid;
        var extendedId = "extendedString" + newid;
        var hiddenId = "hiddenInput" + newid;
        var hiddenIdTwo = "hiddenInputTwo" + newid;
        var quantTextId = "quantText" + newid;
        var chunkButId = "showChunk" + newid;
        $('body').popover({
           selector: '[data-toggle="popover"]',
        });
        var tblInputString = '<strong>Quantity:</strong><input type="text" name = "quantityText" onkeyup="updateQuant(this)" class="form-control squareCorners" style ="height:30px;" placeholder="QTY." value = "1" id ='+ quantTextId+' style="width:100%">';
        if(priceTransom == 1){
          var transomString = "<strong>Transom: </strong>" + ww2 +"TR" + transomHeight + $('#'+ww+'dimsW option:selected').val() + ", " + transomNum + ", " + transomPattern + ", " + transomgrilleTypeText;
        }else{
          var transomString = "";
        }
        var tblDelButtons = '<button name="del0" id="deleteRow" onclick="deleteRow(this)" class="btn btn-danger row-remove in" style="margin-top:8px;width:100%;"><span class="glyphicon glyphicon-remove"></span></button>';
        var listString = "<div id ="+listId+" name ='listString'></div>";
        var netString ="<div id ="+netId+" name = 'netString'></div>";
        var sellString = "<div id ="+sellId+" name = 'sellString'></div>";
        var extendedString = "<div id ="+extendedId+" name = 'extendedString'></div>";
        var hiddenPriceIn = "<input type ='hidden' id ="+hiddenId+" name ='hiddenInput' style='width:0%'></input>";
        var hiddenPriceIn2 = "<input type ='hidden' id ="+hiddenIdTwo+" name ='hiddenInput2' style='width:0%'></input>";
        var hiddenWinLabel = "<input type ='hidden' name ='hiddenWinLabel' value ='"+escapeHtml($('#'+ww+'windowLabel').val())+"' style='width:0%'></input>";
        var multiplierAmt = document.getElementById('multiplierIn').value;
        var markupPerc = 1 + +document.getElementById('markupPercIn').value/100;
        var netPrice =  Math.round((tempNewPrice * multiplierAmt + 0.00001) * 100) / 100;
        var sellPrice = Math.round((tempNewPrice * markupPerc + 0.00001) * 100) / 100;
        var quantChunk = '<div id ="quantChunk" name ="quantChunk">' + tblInputString + tblDelButtons +'</div>';
        var newMenu ="<button class='popover-dismiss btn btn-danger' tabindex='0' data-toggle='popover' data-animation='false' data-placement='auto' style ='margin-left:7px' data-trigger='click' data-original-title='Options' data-html='true' data-content ='"+quantChunk+"'><span id= 'tblSpan' class ='glyphicon glyphicon-chevron-up tblSpan'></span></button>";
        $("#tab_logic").find('tr#addr'+newid).find('td:eq(1)').html(tblInputString + tblDelButtons + hiddenPriceIn + hiddenPriceIn2 + hiddenWinLabel);
        $("#tab_logic").find('tr#addr'+newid).find('td:eq(0)').html(lineNumDiv);
        $('#tab_logic').find('tr#addr'+newid).find('td:eq(3)').html(listString);
        //$('#tab_logic').find('tr#addr'+newid).find('td:eq(4)').html(netString);
        //$('#tab_logic').find('tr#addr'+newid).find('td:eq(5)').html(sellString);
        //$('#tab_logic').find('tr#addr'+newid).find('td:eq(6)').html(extendedString);
        $("#tab_logic").find('tr#addr'+newid).find('#quantText' + newid).attr('value',$('#hiddenWinQuant').val());
        var extendedPrice = 1 * sellPrice;
        $("#tab_logic").find('tr#addr'+newid).find('td:eq(2)').html(winLabel2 + dimsString + "<br>" + transomString + "<br>"+ finalString );
        $("#tab_logic").find('tr#addr'+newid).find('#listString' + newid).html("$" + tempNewPrice);
        //$("#tab_logic").find('tr#addr'+newid).find('#netString' + newid).html("$" + netPrice);
        //$("#tab_logic").find('tr#addr'+newid).find('#sellString' + newid).html("$" + sellPrice);
        $("#tab_logic").find('tr#addr'+newid).find('#hiddenInput' + newid).attr('value',tempNewPrice);
        $("#tab_logic").find('tr#addr'+newid).find('[name = "hiddenInput2"]').val($("#tab_logic").find('tr#addr'+newid).find('[name = "hiddenInput"]').val());
        //$("#tab_logic").find('tr#addr'+newid).find('#extendedString' + newid).html("$" + extendedPrice);
        var winArrayListPrice = tempNewPrice;
        var winArrayNetPrice = netPrice;
        var winArraySellPrice = sellPrice;
        var winArrayExtendedPrice = extendedPrice;
        quoteTotal = +quoteTotal + +tempNewPrice;
        //#makeWindowOrdersGreatAgain 
        
        salesOrderNum = jobNumber.trim();
        savedWDimsArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "0",
          newLine: "0",
          option: ww2,
          optionVal:ww2+$('#dimsW option:selected').attr('value') + $('#dimsH option:selected').attr('value')+$('#installMulls1 option:selected').attr('value').toUpperCase(),
          custEntries: '',
          function: "",
          prcPg: tempNewPrice.toString().replace(".",""),
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "1"
        });
        
        if(checkCustom == 1){
          wcsVal = 'Yes';
          wcsFunc = 'C';
          wcsCustVals ='';
        }else{
          wcsVal = 'No';
          wcsCustVals = '';
          wcsFunc = 'S';
        }
      
        savedWCSArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "1",
          newLine: "0",
          option: 'Custom Size',
          optionVal:wcsVal,
          custEntries: wcsCustVals,
          function: wcsFunc,
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "1"
        });
        savedWSizeArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "2",
          newLine: "0",
          option: 'Size', 
          optionVal:$('#dimsW option:selected').attr('value')+$('#dimsH option:selected').attr('value'),
          custEntries: wcsCustVals,
          function: "S",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        wMullArrFunc = "R";
        checkMulls = $('#installMulls1 option:selected').text();
        if(checkMulls == '1'){
          wMullArrFunc = "R";
        }else if(checkMulls == '2'){
          wMullArrFunc = "V";
        }else if(checkMulls == '3'){
          wMullArrFunc = "X";
        }else if(checkMulls == '4'){
          wMullArrFunc = "Y"; 
        }else if(checkMulls == '5'){
          wMullArrFunc = "F";
        }
        
        savedWMullArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "3",
          newLine: "0",
          option: 'Mulled Units',
          optionVal:$('#installMulls1 option:selected').attr('value'),
          custEntries: '',
          function: wMullArrFunc,
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        wBalPg = '14000000';
        wBalSlt = '14000000';
        if($('#installBalances option:selected').text() == 'Compression Balance'){
          wBalPg = '0';
          wBalSlt = '0';
        }
        savedWBalArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "4",
          newLine: "0",
          option: 'Balances',
          optionVal:$('#installBalances option:selected').text(),
          custEntries: '',
          function: "",
          prcPg: wBalPg,
          prcSlt: wBalSlt,
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWLabelArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "5",
          newLine: "0",
          option: 'Label (location)',
          optionVal:$('#windowLabel').val(),
          custEntries: '',
          function: "",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWQuantArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "6",
          newLine: "0",
          option: 'Quantity',
          optionVal: '0000001',
          custEntries: '',
          function: "Q",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWExtArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "7",
          newLine: "0",
          option: 'Exterior',
          optionVal:'Clad',
          custEntries: '',
          function: "",
          prcPg: "2000000",
          prcSlt: "1000000",
          prcBases: "100",
          dsLiteNo: "",
          man: "0"
        });
        if($('#extColorChoice option:selected').attr('value') == 'Other'){
          wExtColPg = '12000000';
          wExtColSlt = '13000000';
          wExtColFunc = 'M';
        }else if($('#extColorChoice option:selected').attr('value') == 'Estate Colors'){
          wExtColPg = '12000000';
          wExtColSlt = '15000000';
          wExtColFunc = '';
        }else{
          wExtColPg = '12000000';
          wExtColSlt = '13000000';
          wExtColFunc = '';
        }
        savedWCladColArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "8",
          newLine: "0",
          option: 'Clad Color',
          optionVal: $('#extColorChoiceEstate option:selected').attr('value'),
          custEntries: '',
          function: "",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        if($('#extColorChoice').attr('value') == 'Estate Values'){
          savedWEstateColArray.push({
            salesOrd: salesOrderNum,
            line: lineNum,
            seq: "11",
            newLine: "0",
            option: 'Estate Colors',
            optionVal: $('#extColorChoice option:selected').attr('value'),
            custEntries: '',
            function: wExtColFunc,
            prcPg: wExtColPg,
            prcSlt: wExtColSlt,
            prcBases: "",
            dsLiteNo: "",
            man: "0"
          });
        }else{
          savedWEstateColArray = [];
        }
        savedWGTypeArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "12",
          newLine: "0",
          option: 'Glass Type',
          optionVal:$('#glass1 option:selected').attr('value'),
          custEntries: '',
          function: "9",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWGOptArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "13",
          newLine: "0",
          option: 'Glass Option',
          optionVal:$('#glass2 option selected').text(),
          custEntries: '',
          function: "9",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        if($('#glassTemp').is(':checked')){
            wTempVal = 'Yes';
        }else{
            wTempVal = 'No';
        }
        savedWTempArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "14",
          newLine: "0",
          option: 'Tempered',
          optionVal: wTempVal,
          custEntries: '',
          function: "",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWGrilleArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "15",
          newLine: "0",
          option: 'Grille',
          optionVal:$('#grilleType option:selected').attr('value'),
          custEntries: '',
          function: "9",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        if($('#grillePattern option:selected').text() == 'Custom'){
          wGPattFunc = '9';
        }else{
          wGPattFunc = '9';
        }
        savedWGrillePattArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "16",
          newLine: "0",
          option: 'Grille Style',
          optionVal:$('#grillePattern option:selected').attr('value'),
          custEntries: '',
          function: wGPattFunc,
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWGrilleColArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "17",
          newLine: "0",
          option: 'Inter. Grille Color',
          optionVal:$('#grilleColor option:selected').attr('value'),
          custEntries: '',
          function: "9",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        wGrilleSashPg = '0';
        wGrilleSashFunc ='';
        wGrilleSashSlt = 0;
        if($('#grilleSash option:selected').attr('value') == 'Top Sash Only'){
          wGrilleSashPg = '900000000';
          wGrilleSashFunc = '9';
          wGrilleSashSlt = '1000000';
        }
        savedWGrilleSashArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "17",
          newLine: "0",
          option: 'Grill Sash Option',
          optionVal:$('#grilleSash option:selected').attr('value'),
          custEntries: '',
          function: wGrilleSashFunc,
          prcPg: wGrilleSashPg,
          prcSlt: wGrilleSashSlt,
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        wScrReq = 'Yes';
        wScrReqPg = '7000000';
        if($('#screens_required').is(':checked')){
          wScrReq = 'No';
          wScrReqPg = '0';
        }
        
        savedWScrReqArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "22",
          newLine: "0",
          option: 'Screens Required',
          optionVal: wScrReq,
          custEntries: '',
          function: "",
          prcPg: "7000000",
          prcSlt: "0",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWScreenTypeArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "23",
          newLine: "0",
          option: 'Screen Type',
          optionVal:$('#screenPattern option:selected').attr('value'),
          custEntries: '',
          function: "",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWScreenColArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "24",
          newLine: "0",
          option: 'Screen Color',
          optionVal:$('#screenColor option:selected').attr('value'),
          custEntries: '',
          function: "",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWHardColArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "26",
          newLine: "0",
          option: 'Hardware Color',
          optionVal:$('#hardColorStand option:selected').attr('value'),
          custEntries: '',
          function: "",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWJambArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "27",
          newLine: "0",
          option: 'Jamb Size',
          optionVal:$('#jambSize option:selected').attr('value'),
          custEntries: '',
          function: "J",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWIntFinArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "28",
          newLine: "0",
          option: 'Interior Finish',
          optionVal:$('#intPrime option:selected').attr('value'),
          custEntries: '',
          function: "B",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWAccArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "29",
          newLine: "0",
          option: 'Accessories',
          optionVal:$('#install1 option:selected').attr('value'),
          custEntries: '',
          function: "",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWInstallArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "30",
          newLine: "0",
          option: 'Installation',
          optionVal:$('#nailFinSelect option:selected').attr('value'),
          custEntries: '',
          function: "",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWAddArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "31",
          newLine: "0",
          option: 'Additional Items',
          optionVal:'Yes',
          custEntries: '',
          function: "A",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedWGUnitArray.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "997",
          newLine: "0",
          option: 'Glass Units',
          optionVal:'',
          custEntries: '',
          function: "G",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedW998Array.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "998",
          newLine: "0",
          option: '',
          optionVal:'',
          custEntries: '',
          function: "G",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        savedW999Array.push({
          salesOrd: salesOrderNum,
          line: lineNum,
          seq: "999",
          newLine: "0",
          option: '',
          optionVal:'',
          custEntries: '',
          function: "G",
          prcPg: "",
          prcSlt: "",
          prcBases: "",
          dsLiteNo: "",
          man: "0"
        });
        
        tempNewPrice = 0;
        $(tr).find("td button.popover-dismiss").on("click", function(){
          if($(this).find("span.tblSpan").hasClass('glyphicon glyphicon-chevron-up')){
            $(this).find("span.tblSpan").removeClass('glyphicon glyphicon-chevron-up');
            $(this).find("span.tblSpan").addClass('glyphicon glyphicon-chevron-down');
          }else if($(this).find("span.tblSpan").hasClass('glyphicon glyphicon-chevron-down')){
            $(this).find("span.tblSpan").removeClass('glyphicon glyphicon-chevron-down');
            $(this).find("span.tblSpan").addClass('glyphicon glyphicon-chevron-up');
          }
       });  
       /*if($('#hideList').is(':checked')){
         $('#listString'+newid).closest('[data-name = "listPriceTd"]').toggle();
       }
       if($('#hideNet').is(':checked')){
          $('#netString'+newid).closest('[data-name="netPriceTd"]').toggle();
       }
       if($('#hideSell').is(':checked')){
          $('#sellString'+newid).closest('[data-name="sellPriceTd"]').toggle();
       }
       if($('#hideExtended').is(':checked')){
          $('#extendedString'+newid).closest('[data-name="extendedPriceTd"]').toggle();
       }
        */
    if($('#'+ww+'panel9').find('#'+ww+'span9').hasClass('panel-collapsed') && quickAdd == 0){
      $('#'+ww+'click1').show();
      $('#'+ww+'panel1').find('.panel-body').slideDown();
      $("#"+ww+"panel1").find("#"+ww+"span1").removeClass('panel-collapsed');
      $("#"+ww+"panel1").find('i').addClass('glyphicon-chevron-up').removeClass('glyphicon-chevron-down');
      $('#'+ww+'click2').show();
      $('#'+ww+'panel2').toggle();
      $('#'+ww+'panel2').find('.panel-body').slideDown();
      $("#"+ww+"panel2").find("#"+ww+"span2").removeClass('panel-collapsed');
      $("#"+ww+"panel2").find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
      $('#'+ww+'click3').show();
      $('#'+ww+'panel3').toggle();
      $('#'+ww+'panel3').find('.panel-body').slideDown();
      $("#"+ww+"panel3").find("#"+ww+"span3").removeClass('panel-collapsed');
      $("#"+ww+"panel3").find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
      $('#'+ww+'click4').show();
      $('#'+ww+'panel4').toggle();
      $('#'+ww+'panel4').find('.panel-body').slideDown();
      $("#"+ww+"panel4").find("#"+ww+"span4").removeClass('panel-collapsed');
      $("#"+ww+"panel4").find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
      $('#'+ww+'click5').show();
      $('#'+ww+'panel5').toggle();
      $('#'+ww+'panel5').find('.panel-body').slideDown();
      $("#"+ww+"panel5").find("#"+ww+"span5").removeClass('panel-collapsed');
      $("#"+ww+"panel5").find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
      if($('#'+ww+'panel6').is(':visible')){
      $('#'+ww+'click6').show();
      $('#'+ww+'panel6').toggle();
      $('#'+ww+'panel6').find('.panel-body').slideDown();
      $("#"+ww+"panel6").find("#s"+ww+"pan6").removeClass('panel-collapsed');
      $("#"+ww+"panel6").find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
      }
      $('#'+ww+'click7').show();
      $('#'+ww+'panel7').toggle();
      $('#'+ww+'panel7').find('.panel-body').slideDown();
      $("#"+ww+"panel7").find("#"+ww+"span7").removeClass('panel-collapsed');
      $("#"+ww+"panel7").find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
      $('#'+ww+'click8').show();
      $('#'+ww+'panel8').toggle();
      $('#'+ww+'panel8').find('.panel-body').slideDown();
      $("#"+ww+"panel8").find("#"+ww+"span8").removeClass('panel-collapsed');
      $("#"+ww+"panel8").find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
      $('#'+ww+'click9').show();
      $('#'+ww+'panel9').toggle();
      $('#'+ww+'panel9').find('.panel-body').slideDown();
      $("#"+ww+"panel9").find("#"+ww+"span9").removeClass('panel-collapsed');
      $("#"+ww+"panel9").find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
      $('#'+ww+'windowLabel').val('');
      $('#'+ww+'numUnits').val('');
    }   
      $btn.button('reset');
      quickAdd = 0;
      
      var arrayWinLabel = escapeHtml($('#'+ww+'windowLabel').val());
      var arrayWinWidth = escapeHtml($('#'+ww+'dimsW option:selected').val());
      var arrayWinHeight = escapeHtml($('#'+ww+'dimsH option:selected').val());
      var arrayWinUnitsWide = escapeHtml($('#'+ww+'installMulls1 option:selected').val());
      if(ww==""){
        var arrayWinBalances = escapeHtml($('#'+ww+'installBalances option:selected').val());
      }else if(ww=="cc"){
        var arrayWinBalances ="";
        for(m=1;m<=mullNum;m++){
          if(m<mullNum){
            arrayWinBalances += $('#ccunit'+m+'Handing option:selected').text()+"~";
          }else{
            arrayWinBalances += $('#ccunit'+m+'Handing option:selected').text();
          }
        }
      }
      
      if(useEstate == 1){
        var arrayWinExtColor = escapeHtml($('#'+ww+'extColorChoiceEstate option:selected').val());
        var hasEstate = true;
      }else if(useEstate == 0){
        var arrayWinExtColor = escapeHtml($('#'+ww+'extColorChoice option:selected').val());
        var hasEstate = false;
      }
      var arrayWinGlassType = escapeHtml($('#'+ww+'glass1 option:selected').val());
      var arrayWinGlassObscured = escapeHtml($('#'+ww+'glass2 option:selected').val());
      if($('#'+ww+'glass_i89').is(':checked')){
        var arrayWinI89 = true;
      }else{
        var arrayWinI89 = false;
      }
      if($('#'+ww+'glassTemp').is(':checked')){
        var arrayWinTempered = true;
        if($('#'+ww+'bothSashTemp').is(':checked')){
          var arrayWinTempLoc = 1;
        }else if($('#'+ww+'topSashTemp').is(':checked')){
          var arrayWinTempLoc = 2;
        }else if ($('#'+ww+'botSashTemp')){
          var arrayWinTempLoc = 3;
        }
      }else{
        var arrayWinTempered = false;
        var arrayWinTempLoc = 0;
      }
      var arrayWinGrillePattern = escapeHtml($('#'+ww+'grillePattern option:selected').val());
      if($('[name="spcrOptsRdo"]').is(':visible')){
        if($('#'+ww+'withSpacer').is(':checked')){
            var arrayWinSpacer = true;
        }else if($('#'+ww+'withoutSpacer').is(':checked')){
            var arrayWinSpacer = false;
        }
      }
     /* if($('#grilleColor').is(':visible')){
        var arrayWinGrilleColor = escapeHtml($('#grilleColor option:selected').val());
      }else{
        var arrayWinGrilleColor ="";
      }*/
        
      if(grilleColorChoice.length > 0){
        var arrayWinGrilleColor = escapeHtml(grilleColorChoice);
      }else{
        var arrayWinGrilleColor = "";
      }
      var arrayWinGrilleType = escapeHtml(grilleTypeChoice);
      if(grilleSashChoice == ""){
        var arrayWinGrilleSash = "";
      }else{
        var arrayWinGrilleSash = escapeHtml(grilleSashChoice);
      }
      var arrayWinGrilleCustom;
      var arrayWinJamb = escapeHtml($('#'+ww+'jambSize option:selected').val());
      var arrayWinJambCustom;
      if(screenHasEstate == 0){
        var arrayWinScreenColor = escapeHtml($('#'+ww+'screenColor option:selected').val()); 
        var screenEstate = false;
      }else if(screenHasEstate == 1){
        var arrayWinScreenColor = escapeHtml($('#'+ww+'screenColorChoiceEstate option:selected').val());
        var screenEstate = true;
      } 
      var arrayWinScreenType = escapeHtml($('#'+ww+'screenPattern option:selected').val());
      if($('#'+ww+'shipHardware').is(':checked')){
        var arrayWinScreenShip = true;
      }else if($('#'+ww+'holdRelease').is(':checked')){
        var arrayWinScreenShip = false;
      }
      if($('#'+ww+'screens_required').is(':checked')){
        var arrayWinScreensReq = false;
      }else{
        var arrayWinScreensReq = true;
      }
      var arrayWinHardware = escapeHtml($('#'+ww+'hardColorStand option:selected').val());
      var arrayWinInterior = escapeHtml($('#'+ww+'intPrime option:selected').val());
      var arrayWinAccess = escapeHtml($('#'+ww+'install1 option:selected').val());
      var arrayWinStrapFin = escapeHtml($('#'+ww+'nailFinSelect option:selected').val());
      var arrayWinCategory = ww;
        windowOptions.push({
          id: newid,
          cat: arrayWinCategory,
          winLabel: arrayWinLabel,
          custDims: useCustomDims,
          custHFt: winArrayCustHFt,
          custHIn: winArrayCustHInch,
          custWFt: winArrayCustWFt,
          custWIn: winArrayCustWInch,
          width: arrayWinWidth, 
          height: arrayWinHeight,
          unitsWide: arrayWinUnitsWide,
          balances: arrayWinBalances,
          exteriorColor: arrayWinExtColor,
          hasExtEstate: hasEstate,
          glassType: arrayWinGlassType,
          glassObscure: arrayWinGlassObscured,
          glass89: arrayWinI89,
          glassTemper: arrayWinTempered,
          glassTemperLoc: arrayWinTempLoc,
          grillePat: arrayWinGrillePattern,
          grilleType: arrayWinGrilleType,
          grilleColor: arrayWinGrilleColor,
          grilleSash: arrayWinGrilleSash,
          jambSize: arrayWinJamb,
          screenColor: arrayWinScreenColor,
          screenType: arrayWinScreenType,
          screenShip: arrayWinScreenShip,
          screenReq: arrayWinScreensReq,
          screenEstate: screenEstate,
          hardware: arrayWinHardware,
          interiorFin: arrayWinInterior,
          accessories: arrayWinAccess,
          nailStrap: arrayWinStrapFin,
          quantity: '1',
          listPrice: winArrayListPrice,
          netPrice: winArrayNetPrice,
          sellPrice: winArraySellPrice,
          extendedPrice: winArrayExtendedPrice,
          wDimsArr: savedWDimsArray,
          wCSArr: savedWCSArray,
          wSizewArr: savedWSizeArray,
          wMullArr: savedWMullArray,
          wBalArr: savedWBalArray,
          wLabelArr: savedWLabelArray,
          wQuantArr: savedWQuantArray,
          wExtArr: savedWExtArray,
          wCladCArr: savedWCladColArray,
          wEstColArr: savedWEstateColArray,
          wGTypeArr: savedWGTypeArray,
          wGOptArr: savedWGOptArray,
          wTempArr: savedWTempArray,
          wGrilleArr: savedWGrilleArray,
          wGrillePArr: savedWGrillePattArray,
          wGrilleCArr: savedWGrilleColArray,
          wGrilleSArr: savedWGrilleSashArray,
          wScrReqArr: savedWScrReqArray,
          wScrTypeArr: savedWScreenTypeArray,
          wScrColArr: savedWScreenColArray,
          wHardColArr: savedWHardColArray,
          wJambArr: savedWJambArray, 
          wIntFinArr: savedWIntFinArray,
          wAccArr: savedWAccArray,
          wInstallArr: savedWInstallArray,
          wAddArr: savedWAddArray,
          wGUnitArr: savedWGUnitArray,
          w998Arr: savedW998Array,
          w999Arr: savedW999Array,
          wPrice: tempNewPrice
        });
    $('#'+ww+'windowLabel').val("");
    jsonWindowString = JSON.stringify(windowOptions);
    qmulti = escapeHtml($('#multiplierIn').val());
    qmarkup = escapeHtml($('#markupPercIn').val());
    //var quoteNum = "000000";
    var quoteNum = jobNumber;
    newQuote = 1;
    needQuotes = 0;
    
    saveQuote(jobNumber,jobDate,jobClientName,jobPrepared,quoteNum,quoteTotal,jobPoId,jobClientId,jobAddress1,jobAddress2,jobAddress3,jsonWindowString,jobCity,jobState,jobZip,jobContact,jobPhoneNumber,jobFaxNumber,jobEmail,jobSiteAddress1,jobSiteAddress2,jobSiteAddress3,jobSiteCity,jobSiteState,jobSiteZip,jobSiteContact,jobSitePhone1,jobSitePhone2,jobSiteNotes,shipToAddress1,shipToAddress2,shipToAddress3,shipToCity,shipToState,shipToZip,shipToContact,shipToPhone,shipToNotes,pickOrShipArr,jobID,qmarkup,qmulti,newQuote,additionalArray,"configure");
},100); 
      
});
});
$('.dropdown-menu-sidebar a').on('click', function(){    
    $('.dropdown-toggle').html($(this).html() + '<span class="caret"></span>');    
});
function changeImage(e){
    var image = document.getElementById(e);
    image.style.display = (image.style.display == 'none') ? 'block' : 'none';
}
function changeUnits(w,h){
var opts1 = document.getElementById(w).options;
var opts2 = document.getElementById(h).options;
 if($('#'+ww+'custDimsFt').is(':checked')){
  for(x=0;x<opts1.length;x++){
    if(ww==""){
        var tempUDim = (((+opts1[x].value + (47/8)) - (1/2)) * +$('#'+ww+'installMulls1 option:selected').text()) + ((.0625 * (+$('#'+ww+'installMulls1 option:selected').text() - 1))); 
        var newUDim = Math.floor((+tempUDim)/(12)) + "'-" + Math.floor(+tempUDim%12) + ' ' + 8 * ((+tempUDim%12)%1) + '/8"';
        opts1[x].text ="(" + opts1[x].value +") " + newUDim;
    }else if(ww=="cc"){
        var tempUDim = ((+opts1[x].value + 5.0625) * +$('#'+ww+'installMulls1 option:selected').text()) + ((.0625 * (+$('#'+ww+'installMulls1 option:selected').text() - 1))); 
        var newUDim = Math.floor((+tempUDim)/(12)) + "'-" + Math.floor(+tempUDim%12) + ' ' + 16 * ((+tempUDim%12)%1) + '/16"';
        opts1[x].text ="(" + opts1[x].value +") " + newUDim;
    }
  }
 
  for(y=0;y<opts2.length-1;y++){
    if(ww==""){
        var tempUDim = (2* +opts2[y].value  + 9) - (13/16);
        var newUDim = Math.floor((+tempUDim*1)/12) + "'-" + Math.floor(+tempUDim%12) + ' ' + 16 * ((+tempUDim%12)%1) + '/16"';
        opts2[y].text = "(" + opts2[y].value +") " + newUDim;
    }else if(ww=='cc'){
        var tempUDim = ((+opts2[y].value + 5.0625) * +$('#'+ww+'installMulls1 option:selected').text()) + ((.0625 * (+$('#'+ww+'installMulls1 option:selected').text() - 1))); 
        var newUDim = Math.floor((+tempUDim)/(12)) + "'-" + Math.floor(+tempUDim%12) + ' ' + 16 * ((+tempUDim%12)%1) + '/16"';
        opts2[y].text ="(" + opts2[y].value +") " + newUDim;
    }
  }
  var oldTop = opts2[opts2.length-1].value.substring(0,2);
  var oldBot = opts2[opts2.length-1].value.substring(3,5);
  var newTopFeet = Math.floor(+oldTop/12);
  var newBotFeet = Math.floor(+oldBot/12);
  var newTopInch = +oldTop % 12;
  var newBotInch = +oldBot % 12;
  if(ww==""){
    opts2[opts2.length-1].text = "(24/36) 5'-8 3/16"+'"';
  }
 }else if($('#'+ww+'custDimsInch').is(':checked')){
  for(x=0;x<opts1.length;x++){
    var tempUDim = (((+opts1[x].value + (47/8)) - (1/2))* +$('#'+ww+'installMulls1 option:selected').text()) + ((.0625 * (+$('#'+ww+'installMulls1 option:selected').text() - 1)));
    opts1[x].text = "(" + opts1[x].value +") " + Math.floor(tempUDim/1) + ' ' + 8 * ((+tempUDim%12)%1) + '/8"';
  }
  for(y=0;y<opts2.length-1;y++){
    var tempUDim = (2*(+opts2[y].value)  + 9) - (13/16);
    opts2[y].text = "(" + opts2[y].value +") " + Math.floor(tempUDim/1) + ' ' + 16 * ((+tempUDim%12)%1) + '/16"';
  }
  if(ww==""){
   opts2[opts2.length-1].text = "(24/36) 68 3/16"+"'";
  } 
}
}
function getScreenPrice(str,str2,str3,dims){
  $.ajax({
    url:"getScreenPrice.php",
    type: "GET",
    data:{qq:str,
        d:dims,
        q:str2,
        qqq:str3},
    async:false,
    success:function(data){
      tempNewPrice += parseInt(data);
      screenPrice = parseInt(data);
      testAmount += parseFloat(data); 
      console.log(testAmount);
    }    
  })
}
function getFinishPrice(str,str2,dims){
  $.ajax({
    url:"getPrice.php",
    type: "GET",
    data:{qq:str,
      d:dims,
      q:str2,
      },
    async:false,
    success:function(data){
      tempNewPrice += parseInt(data);
      finishPrice = parseInt(data);
      testAmount += parseFloat(data); 
      console.log(testAmount);
    }    
})
}
function getGrilleSashPrice(str,str2,dims){
  $.ajax({
  url:"getPrice.php",
  type: "GET",
  data:{qq:str,
        d:dims,
        q:str2,
        },
  async:false,
  success:function(data){
      tempNewPrice += parseInt(data);
      grilleSashPrice = parseInt(data);
      testAmount += parseFloat(data); 
      console.log(testAmount);
  }    
})
}
function getInstallPrice(str,str2,dims){
  $.ajax({
  url:"getPrice.php",
  type: "GET",
  data:{qq:str,
        d:dims,
        q:str2,
        },
  async:false,
  success:function(data){
      tempNewPrice += parseInt(data);
      installPrice = parseInt(data);
      testAmount += parseFloat(data); 
      console.log(testAmount);
  }    
})
}
function getAccessoriesPrice(str,str2,dims){
  $.ajax({
  url:"getPrice.php",
  type: "GET",
  data:{qq:str,
        d:dims,
        q:str2,
        },
  async:false,
  success:function(data){
      tempNewPrice += parseInt(data);
      screenPrice = parseInt(data);
      testAmount += parseFloat(data); 
      console.log(testAmount);
  }    
})
}
function getPwExtPrice(str,str2,dims){
  $.ajax({
  url:"getPwExtPrice.php",
  type: "GET",
  data:{qq:str,
        d:dims,
        q:str2,
        },
  async:false,
  success:function(data){
    tempNewPrice += parseInt(data);
    extPrice = parseInt(data);
    testAmount += parseFloat(data); 
    console.log(testAmount);
  }    
})
}
function getExtPrice(str,str2,dims){
    if(window.XMLHttpRequest){
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    }else{
      // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
        tempNewPrice += parseInt(xmlhttp.responseText);
        extPrice = parseInt(xmlhttp.responseText);
        testAmount += parseFloat(xmlhttp.responseText); 
        console.log(testAmount);          
      }
    }
    xmlhttp.open("GET","/getPrice.php?q="+str+"&qq="+str2+"&d="+dims,false);
    xmlhttp.send();
        
}
function getConfigPrice(str,str2,dims){
  if(window.XMLHttpRequest){
  // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  }else{
  // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      tempNewPrice += parseInt(xmlhttp.responseText);
      configPrice = parseInt(xmlhttp.responseText);
      testAmount += parseFloat(xmlhttp.responseText); 
      console.log(testAmount);
    }
  }
  xmlhttp.open("GET","/getPrice.php?q="+str+"&qq="+str2+"&d="+dims,false);
  xmlhttp.send();
        
}
 function getGlassPrice(str,str2,dims){
  if(window.XMLHttpRequest){
  // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  }else{
  // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      tempNewPrice += parseInt(xmlhttp.responseText);
      glassPrice = parseInt(xmlhttp.responseText);
      testAmount += parseFloat(xmlhttp.responseText); 
      console.log(testAmount);    
    }
  }
  xmlhttp.open("GET","/getPrice.php?q="+str+"&qq="+str2+"&d="+dims,false);
  xmlhttp.send();  
}
 function getGrillePrice(cat,dims,type,pat,sash){
if(window.XMLHttpRequest){
  // code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp = new XMLHttpRequest();
}else{
// code for IE6, IE5
  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      tempNewPrice += parseInt(xmlhttp.responseText);
      grillePrice = parseInt(xmlhttp.responseText);  
      testAmount += parseFloat(xmlhttp.responseText); 
      console.log(testAmount);
    }
  }
  xmlhttp.open("GET","/getGrillePrice.php?c="+cat+"&d="+dims+"&t="+type+"&p="+pat+"&s="+sash,false);
  xmlhttp.send();
}
function saveQuote(jn,qd,cn,pb,qn,qt,poid,ci,ca,ca2,ca3,wo,cc,cs,cz,cco,cp,cf,ce,ja,ja2,ja3,jc,js,jz,jco,jp1,jp2,jnotes,sa,sa2,sa3,sc,ss,sz,sco,sp,si,sv,ji,qmark,qmulti,nq,aa,prod){
  $.post("saveQuote.php", {
    jn:jn,
    qd:qd,
    cn:cn,
    pb:pb,
    qn:qn,
    qt:qt,
    poid:poid,
    ci:ci,
    ca:ca,
    ca2:ca2,
    ca3:ca3,
    wo:wo,
    cc:cc,
    cs:cs,
    cz:cz,
    cco:cco,
    cp:cp,
    cf:cf,
    ce:ce,
    ja:ja,
    ja2:ja2,
    ja3:ja3,
    jc:jc,
    js:js,
    jz:jz,
    jco:jco,
    jp1:jp1,
    jp2:jp2,
    jnotes:jnotes,
    sa:sa,
    sa2:sa2,
    sa3:sa3,
    sc:sc,
    ss:ss,
    sz:sz,
    sco:sco,
    sp:sp,
    si:si,
    sv:sv,
    ji:ji,
    qmark:qmark,
    qmulti:qmulti,
    nq:nq,
    aa:aa,
    product:prod
  });
}
function getJambPrice(str,dims,str2){
  if (window.XMLHttpRequest){
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else {
  // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function(){
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
      tempNewPrice += parseInt(xmlhttp.responseText);
      jambPrice = parseInt(xmlhttp.responseText);
      testAmount += parseFloat(xmlhttp.responseText); 
      console.log(testAmount);
    }
  }
  xmlhttp.open("GET","/getJambPrice.php?q="+str+"&d="+dims+"&qq="+str2,false);
  xmlhttp.send();      
}
function getMullPrice(str,str2,dims){
    $.ajax({
        url:"getPrice.php",
        type: "GET",
        data:{qq:str,
              d:dims,
              q:str2},
        async:false,
        success:function(data){
            tempNewPrice += parseInt(data);
            mullPrice = parseInt(data);
            testAmount += parseFloat(data);
             console.log(testAmount);
        }    
})
}
function panelMove(num){
    if($('#'+ww+'backClick' + num).is(':visible')){
       changeImage('backClick' + num);
    }
    changeImage(ww+'panel'+(parseInt(num)+1));
    var panel = '#'+ww+'panel'+num;
    changeImage(ww+'collapse'+num);
    $(panel).find("#"+ww+"span"+num).addClass('panel-collapsed');
    $(panel).find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
    changeImage(ww+'click'+num);
    if($('#'+ww+'backClick' +(+num+1)).is(':hidden')){
       changeImage(ww+'backClick' + (+num+1));
    }
    
}
function panelMoveBack(num){
    changeImage(ww+'panel'+num);
    var panel = '#'+ww+'panel'+num;
    var lastPanel ='#'+ww+'panel' + (+num-1);
    changeImage(ww+'collapse'+(+num-1));
    $(lastPanel).find("#"+ww+"span"+(+num-1)).removeClass('panel-collapsed');
    $(lastPanel).find('i').addClass('glyphicon-chevron-up').removeClass('glyphicon-chevron-down');
    $(panel).find("#"+ww+"span"+num).removeClass('panel-collapsed');
    changeImage(ww+'click'+(+num-1));
    changeImage(ww+'backClick' + num);
    if($('#'+ww+'backClick'+(+num-1)).is(':hidden')){
      changeImage(ww+'backClick'+(+num-1));
    } 
}
function sizeUpW(nw,w){
  var widths = document.getElementById(w).options;
  var foundW = false;
  var sizeUpW;
  while(foundW == false){
    for(x=0;x<widths.length;x++){
      if(nw == widths[x].value){
        sizeUpW = widths[x].value;
        foundW = true;
          return sizeUpW;
      }else{
        foundW = false;
      }
  }
   nw++;
  }
}
function sizeUpH(nh,h){
var heights = document.getElementById(h).options;
var foundH = false;
var sizeUpH;
while(foundH == false){
   for(x=0;x<heights.length;x++){
       if(nh == heights[x].value){
          sizeUpH = heights[x].value;
          foundH = true;
          return sizeUpH;
       }else{
          foundH = false;
       }
   }
   nh++;
}
}
$('[name="click1Name"]').click(function(){
   if($('#'+ww+'custDimsInchs').is(':visible')){ 
       if($('#'+ww+'custDimW').val() != "" && $('#'+ww+'custDimH').val() != "" && ($('#'+ww+'custDimH').val() > 36 ||  $('#'+ww+'custDimW').val() > 40) || isNaN($('#'+ww+'custDimW').val()) || isNaN($('#'+ww+'custDimH').val())){
           alert('Please enter valid dimensions.');      
          }else{
           useCustomDims = 1;
           panelMove('1');
           var newW = sizeUpW($('#'+ww+'custDimW').val(),ww+'dimsW');
           var newH = sizeUpH($('#'+ww+'custDimH').val(),ww+'dimsH');
           priceDims = newW+newH;
          }
  }else if($('#'+ww+'ftInCustDims').is(':visible')){ 
          var custFtH = ($('#'+ww+'custDimHFt').val() * 12) + +$('#'+ww+'custDimHInch').val()
          var custFtW = ($('#'+ww+'custDimWFt').val() * 12) + +$('#'+ww+'custDimWInch').val()
       if(custFtH != "" && custFtW != "" && (custFtH > 36 ||  custFtW > 40 ) || isNaN(custFtW) || isNaN(custFtH)){
           alert('Please enter valid dimensions.');      
          }else{
            useCustomDims = 1;
            winArrayCustWInch = $('#'+ww+'custDimWInch').val();
            winArrayCustWFt = $('#'+ww+'custDimWFt').val();
            winArrayCustHInch = $('#'+ww+'custDimHInch').val();
            winArrayCustHFt = $('#'+ww+'custDimHFt').val();
            panelMove('1');
            var newW = sizeUpW(custFtH,ww+'dimsW');
            var newH = sizeUpH(custFtW,ww+'dimsH');
            priceDims = newW+newH;
           }
}else{
  panelMove('1');
  priceDims = $('#'+ww+'dimsW option:selected').val()+$('#'+ww+'dimsH option:selected').val();
}
});
$('[name="click2Name"]').click(function(){
//getExtPrice('Clad','CDH',priceDims);
panelMove('2');
});
$('[name="backClickName2"]').click(function(){
panelMoveBack('2');
});
$('[name="click3Name"]').click(function(){
//getGlassPrice(document.getElementById("glass1").options[document.getElementById('glass1').selectedIndex].text,'CDH',priceDims);
panelMove('3');
});
$('[name="backClickName3"]').click(function(){
//tempNewPrice -= extPrice;
panelMoveBack('3');
});
$('[name="click4Name"]').click(function(){
//getGrillePrice('CDH',priceDims,(document.getElementById("grilleType").options[document.getElementById('grilleType').selectedIndex].text),($("#grillePattern option:selected").text()),
       // (document.getElementById("grilleSash").options[document.getElementById('grilleSash').selectedIndex].text));
panelMove('4');
});
$('[name="backClickName4"]').click(function(){
panelMoveBack('4');
//tempNewPrice -= glassPrice;
});
$('[name="click5Name"]').click(function(){
//getJambPrice($("#jambSize option:selected").text(),priceDims);
panelMove('5');
});
$('[name="backClickName5"]').click(function(){
panelMoveBack('5');
//tempNewPrice -= grillePrice;
});
$('[name="click6Name"]').click(function(){
panelMove('6');
});
$('[name="backClickName6"]').click(function(){
panelMoveBack('6');
//tempNewPrice -= jambPrice;
});
$('[name="click7Name"]').click(function(){
panelMove('7');
});
$('[name="backClickName7"]').click(function(){
panelMoveBack('7');
});
$('[name="click8Name"]').click(function(){
//getConfigPrice($('#installBalances option:selected').text(),'CDH',priceDims);
panelMove('8');
});
$('[name="backClickName8"]').click(function(){
panelMoveBack('8');
});
$('[name="backClickName9"]').click(function(){
//tempNewPrice -= configPrice;
panelMoveBack('9');
});
 $('[name="jambSizeName"]').change(function(){
   if($('#'+ww+'jambSize option:selected').val() == 'Other'){
    $('#'+ww+'customJambDiv').toggle();
    $(this).blur();
    }else if($('#'+ww+'jambSize option:selected').val() != 'Other' && $('#'+ww+'customJambDiv').is(':visible')){
     $('#'+ww+'customJambDiv').toggle();
    }
  });
  $('#'+ww+'customDimsButton').click(function(){
    if($('#'+ww+'customDims').is(':visible')){
     checkCustom = 0;
    }
    else{
    checkCustom = 1;
    }
    $('#'+ww+'customDims').toggle();
    $('#'+ww+'dimsW').toggle();
    $('#'+ww+'dimsH').toggle();
    $('#'+ww+'custDimsTextH').toggle();
    $('#'+ww+'custDimsTextW').toggle();
    $(this).blur();
    if($('#'+ww+'custDimsFt').is(':checked')){
      if($('#'+ww+'custDimsInchs').is(':visible')){ 
          $('#'+ww+'custDimsInchs').toggle();
       }
      if(!$('#'+ww+'ftInCustDims').is(':visible')){
          $('#'+ww+'ftInCustDims').toggle();
       }
     
    }
if($('#'+ww+'custDimsInch').is(':checked')){
  if(!$('#'+ww+'custDimsInchs').is(':visible')){ 
    $('#'+ww+'custDimsInchs').toggle();
  }
  if($('#'+ww+'ftInCustDims').is(':visible')){
    $('#'+ww+'ftInCustDims').toggle();
  }  
}
  });
function estatePicChange(){
  if($('#'+ww+'extColorChoiceEstate').is(':hidden')){
    $('#'+ww+'extColorChoiceEstate').toggle();
    $('#'+ww+'extColorLabelEstate').toggle();
    $('#'+ww+'screenColor').val('Estate');
    $('#'+ww+'screenColor').change();
    var changeScreens = function(){      
      $('#'+ww+'screenColor').val($('#'+ww+'extColorChoiceEstate').val());
    }
    setTimeout(changeScreens,300);
  }
  if($('#'+ww+'custExtColorInput').is(":visible")){
    $('#'+ww+'custExtColorLabel').toggle();
    $('#'+ww+'custExtColorInput').toggle();
  }
};
function standardPicChange(){
  if($('#'+ww+'extColorChoice').is(':hidden')){
    $('#'+ww+'extColorLabelEstate').toggle();
    $('#'+ww+'extColorChoiceEstate').toggle();
  }
  if($('#'+ww+'custExtColorInput').is(":visible")){
    $('#'+ww+'custExtColorLabel').toggle();
    $('#'+ww+'custExtColorInput').toggle();
  }
};
  var extEE = document.getElementById(ww+'extColorChoiceEstate');
  document.getElementById("almond").onclick=function(){
      standardPicChange();
      extE.value ="Almond";
    };
  document.getElementById("beige").onclick=function(){
      standardPicChange();
      extE.value ="Beige";
    };
    document.getElementById("black").onclick=function(){
      standardPicChange();
      extE.value ="Black";
    };
    document.getElementById("brick").onclick=function(){
      standardPicChange();
      extE.value ="Brick";
    };
    document.getElementById("dBronze").onclick=function(){
      standardPicChange();
      extE.value ="Dark";
    };
    document.getElementById("fGreen").onclick=function(){
      standardPicChange();
      extE.value ="Forest";
    };
    document.getElementById("vanilla").onclick=function(){
      standardPicChange();
      extE.value ="Vanilla";
    };
    document.getElementById("white").onclick=function(){
      standardPicChange();
      extE.value ="White";
    };
    document.getElementById("cashmere").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Cashmere";
    };
    document.getElementById("chalk").onclick=function(){
     estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Chalk";
    };
    document.getElementById("fern").onclick=function(){
     estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Fern";
    };
    document.getElementById("glacier").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Glacier";
    };
    document.getElementById("gunmetal").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Gunmetal";
    };
    document.getElementById("harbor").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Harbor";
    };
    document.getElementById("heather").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Heather";
    };
    document.getElementById("iBlue").onclick=function(){
      estatePicChange();  
      extE.value = "Estate Colors";
      extEE.value ="Blue";
    };
    document.getElementById("khaki").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Khaki";
    };
    document.getElementById("mocha").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Mocha";
    };
    document.getElementById("musket").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Musket";
    };
    document.getElementById("olive").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Olive";
    };
    document.getElementById("pebble").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Pebble";
    };
    document.getElementById("platinum").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Platinum";
    };
    document.getElementById("sienna").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Sienna";
    };
    document.getElementById("smoke").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Smoke";
    };
    document.getElementById("sGreen").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Spring";
    };
    document.getElementById("suede").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Suede";
    };
    document.getElementById("teal").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Teal";
    };
    document.getElementById("wicker").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Wicker";
    };
    document.getElementById("bVein").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Copper";
    };
    document.getElementById("sVein").onclick=function(){
      estatePicChange();
      extE.value = "Estate Colors";
      extEE.value ="Silver";
    };
$('[name="extColorChoiceName"]').change(function(){
        useEstate = 0;
        if($("#"+ww+"extColorChoice").val()== "Estate Colors" || $("#"+ww+"extColorChoice option:selected").val() == "Other"){
         /*$("#"+ww+"grilleType option[value='58Flat']").hide();
          $('#'+ww+'grilleType option[value="58FlatTT"]').hide();
          $('#'+ww+'grilleType option[value="1316Flat"]').hide();
          $('#'+ww+'grilleType option[value="1316FlatTT"]').hide();
          $('#'+ww+'grilleType option[value="34Prof"]').hide();
          $('#'+ww+'grilleType option[value="34ProfTT"]').hide();
          $('#'+ww+'grilleType option[value="1Prof"]').hide();
          $('#'+ww+'grilleType option[value="1ProfTT"]').hide();*/
        }else if($("#"+ww+"extColorChoice option:selected").val() !="Estate Colors" && $("#extColorChoice option:selected").val() !="Other"){
          /*$("#"+ww+"grilleType option[value='58Flat']").show();
          $('#'+ww+'grilleType option[value="58FlatTT"]').show();
          $('#'+ww+'grilleType option[value="1316Flat"]').show();
          $('#'+ww+'grilleType option[value="1316FlatTT"]').show();
          $('#'+ww+'grilleType option[value="34Prof"]').show();
          $('#'+ww+'grilleType option[value="34ProfTT"]').show();
          $('#'+ww+'grilleType option[value="1Prof"]').show();
          $('#'+ww+'grilleType option[value="1ProfTT"]').show();  */
        }
        if($("#"+ww+"extColorChoice option:selected").attr('value')=="Estate Colors"){
            $('#'+ww+'extColorChoiceEstate').show();
            $('#'+ww+'extColorLabelEstate').show();
            $('#'+ww+'screenColor').val('Estate Colors');
            $('#'+ww+'screenColor').change();
            useEstate = 1;
            if($('#'+ww+'custExtColorInput').is(":visible")){
                $('#'+ww+'custExtColorLabel').toggle();
                $('#'+ww+'custExtColorInput').toggle();
            }
        }else if($("#"+ww+"extColorChoice option:selected").val() == "Other"){
            $('#'+ww+'custExtColorLabel').toggle();
            $('#'+ww+'custExtColorInput').toggle();
        }else if($("#"+ww+"extColorChoice option:selected").val()=="Standard"){
            if (window.XMLHttpRequest){
                         // code for IE7+, Firefox, Chrome, Opera, Safari
                         xmlhttp = new XMLHttpRequest();
            }else{
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            
               xmlhttp.onreadystatechange = function(){
                   if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                     extE.innerHTML= xmlhttp.responseText;
                   }   
            }        
                   
              xmlhttp.open("GET","/getStndrdExColor.php",true);
              xmlhttp.send();
          
         }
         }else{
         $('#'+ww+'screenColor').val($("#"+ww+"extColorChoice option:selected").val());
         if($('#'+ww+'custExtColorInput').is(":visible")){
            $('#'+ww+'custExtColorLabel').toggle();
            $('#'+ww+'custExtColorInput').toggle();
         }
        }
         if($('#'+ww+'extColorChoice option:selected').val()!= "Estate Colors" && $('#'+ww+'extColorChoiceEstate').is(':visible')){
          $('#'+ww+'extColorChoiceEstate').hide();
          $('#'+ww+'extColorLabelEstate').hide();
          $('#'+ww+'screenColor').val('Standard');
          $('#'+ww+'screenColor').change();
          
         }
});
$('[name="extColorChoiceEstateName"]').change(function(){
    if($("#"+ww+"extColorChoiceEstate").is(':visible')){
         /* $("#"+ww+"grilleType option[value='58Flat']").hide();
          $('#'+ww+'#grilleType option[value="58FlatTT"]').hide();
          $('#'+ww+'#grilleType option[value="1316Flat"]').hide();
          $('#'+ww+'#grilleType option[value="1316FlatTT"]').hide();
          $('#'+ww+'#grilleType option[value="34Prof"]').hide();
          $('#'+ww+'#grilleType option[value="34ProfTT"]').hide();
          $('#'+ww+'#grilleType option[value="1Prof"]').hide();
          $('#'+ww+'#grilleType option[value="1ProfTT"]').hide();*/  
        }
      if($("#"+ww+"extColorChoiceEstate option:selected").val()=="Standard"){
            useEstate = 0;
              $('#'+ww+'screenColor').val('Standard');
              $('#'+ww+'screenColor').change();
              $('#'+ww+'extColorChoiceEstate').toggle();
              $('#'+ww+'extColorLabelEstate').toggle();
              
              if (window.XMLHttpRequest){
                         // code for IE7+, Firefox, Chrome, Opera, Safari
                         xmlhttp = new XMLHttpRequest();
               } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
               }
                        xmlhttp.onreadystatechange = function(){
               if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                     extE.innerHTML= xmlhttp.responseText;
                     $('#'+ww+'screenColor').val($("#"+ww+"extColorChoice option:selected").val());
                  }
                        
                    }
               
       $('#'+ww+'screenColorChoiceEstate').val('Standard');
       $('#'+ww+'screenColorChoiceEstate').change();
       screenHasEstate = 0;
       xmlhttp.open("GET","/getStndrdExColor.php",true);
       xmlhttp.send();
       
        
    }else{
      $('#'+ww+'screenColorChoiceEstate').val($("#extColorChoiceEstate option:selected").val());
      screenHasEstate = 1;
      }
});
$('[name="screenColorName"]').change(function(){
    if($('#'+ww+'screenColor option:selected').val() == "Estate Colors"){
        if($('#'+ww+'screenColorChoiceEstate').is(':hidden')){
            $('#'+ww+'screenColorChoiceEstate').show();
            $('#'+ww+'screenColorLabelEstate').show();
            $('#'+ww+'screenColorChoiceEstate').val($("#"+ww+"extColorChoiceEstate option:selected").val());
            screenHasEstate = 1;
        }
                
    }else if($('#'+ww+'screenColorChoiceEstate option:selected').val() =="Standard"){
        $('#'+ww+'screenColorChoiceEstate').hide();
        $('#'+ww+'screenColorLabelEstate').hide();        
        $('#'+ww+'screenColor').val($("#"+ww+"extColorChoice option:selected").val());      
        screenHasEstate = 0;
    }
});
$('[name="screenColorChoiceEstateName"]').change(function(){
    if($('#'+ww+'screenColorChoiceEstate option:selected').val() =="Standard"){
        $('#'+ww+'screenColorChoiceEstate').hide();
        $('#'+ww+'screenColorLabelEstate').hide();        
        $('#'+ww+'screenColor').val($("#"+ww+"extColorChoice option:selected").val());      
        screenHasEstate = 0;
    }else{
        screenHasEstate = 1;
    }
});
$('[name="grillePatternName"]').change(function(){
   if($('#'+ww+'grillePattern option:selected').text() == 'Custom Colonial'){
     if($('#'+ww+'custGrilleDiv').is(':hidden')){
      $('#'+ww+'custColonialGrilleDiv').toggle();
      $('#'+ww+'custGrilleIn').attr('placeholder', $('#'+ww+'grillePattern option:selected').text());
      $('#'+ww+'custGrilleDiv').toggle();    
     }
  }else{
      if($('#'+ww+'custGrilleDiv').is(':visible')){
        $('#'+ww+'custGrilleDiv').toggle();
      }
  }
  if($('#'+ww+'grillePattern').is(':hidden') && $('#'+ww+'custGrilleDiv').is(':visible')){
     $('#'+ww+'custGrilleDiv').toggle();
   }
});
$('[name="grilleTypeName"]').change(function(){
     if($('#'+ww+'spacerOptsDiv').is(':visible')){
         $('#'+ww+'spacerOptsDiv').toggle();
       }    
     if($('#'+ww+'grilleType option:selected').text().indexOf("2-") > -1){
     
      var sstr = 'Int%20Grl%202-Tone%20Color';
       
     if($('#'+ww+'grilleColor').is(':hidden')){
       $('#'+ww+'grilleColor').toggle(); 
       $('#'+ww+'grilleColorDiv').toggle(); 
       checkGrilleColor = 1;
      }
     if($('#'+ww+'grilleLabelColor').is(':visible')){
           $('#'+ww+'grilleLabelColor').toggle();
                  }
       if($('#'+ww+'grilleLabelColor2').is(':hidden')){
           $('#'+ww+'grilleLabelColor2').toggle();
                  }
      if (window.XMLHttpRequest){
                         // code for IE7+, Firefox, Chrome, Opera, Safari
                         xmlhttp = new XMLHttpRequest();
               } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
               }
                        xmlhttp.onreadystatechange = function(){
               if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                        $("#"+ww+"grilleColor").html(xmlhttp.responseText);
                  }
                        
                   } 
               
  
    xmlhttp.open("GET","/getGrilleColor.php?q="+sstr,false);
    xmlhttp.send();
 
  
    
     }else if($('#'+ww+'grilleType option:selected').text().indexOf("SDL") > -1){
       if($('#'+ww+'extColorChoice option:selected').val() != 'Estate' && $('#'+ww+'extColorChoice option:selected').val() != 'Other' ){
        var sdlColor = $('#extColorChoice').val();
       }
       else if($('#'+ww+'extColorChoice option:selected').val() == 'Estate'){
        var sdlColor = $('#'+ww+'extColorChoiceEstate').val();
        var showEstate = true;
       }
       if($('#'+ww+'spacerOptsDiv').is(':hidden')){
         $('#'+ww+'spacerOptsDiv').toggle();
       }
       var sstr ='Inter.%20Grille%20Color';
       if($('#'+ww+'grilleColor').is(':hidden')){
         $('#'+ww+'grilleColor').toggle();
         $('#'+ww+'grilleColorDiv').toggle(); 
         checkGrilleColor = 1; 
       }
       if($('#'+ww+'grilleLabelColor2').is(':visible')){
           $('#'+ww+'grilleLabelColor2').toggle();
                  }
        if($('#'+ww+'grilleLabelColor').is(':hidden')){
           $('#'+ww+'grilleLabelColor').toggle();
                  }
     if(!showEstate){   
      if (window.XMLHttpRequest){
                  // code for IE7+, Firefox, Chrome, Opera, Safari
                  xmlhttp = new XMLHttpRequest();
        } else {
                 // code for IE6, IE5
                 xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
                 xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                 $("#"+ww+"grilleColor").html(xmlhttp.responseText);
                 $('#'+ww+'grilleColor').val(sdlColor);   
           }
                 
               }
    
    xmlhttp.open("GET","/getGrilleColor.php?q="+sstr,false);
    xmlhttp.send();
    }
     if(showEstate){
           if (window.XMLHttpRequest){
                         // code for IE7+, Firefox, Chrome, Opera, Safari
                         xmlhttp = new XMLHttpRequest();
               } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
               }
                        xmlhttp.onreadystatechange = function(){
               if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                       $('#'+ww+'grilleColor').html($('#grilleColor').html() + xmlhttp.responseText);
                       $('#'+ww+'grilleColor').val(sdlColor);
                  }
                        
                    }
    
    xmlhttp.open("GET","/getExColor.php?q=Estate Colors",false);
    xmlhttp.send();
  }
    
     }else{
      var sstr ='Inter.%20Grille%20Color';
      if($('#'+ww+'grilleColor').is(':hidden')){
       $('#'+ww+'grilleColor').toggle();
       $('#'+ww+'grilleColorDiv').toggle(); 
       checkGrilleColor = 1;              
}
        if($('#'+ww+'grilleLabelColor2').is(':visible')){
           $('#'+ww+'grilleLabelColor2').toggle();
                  }
        if($('#'+ww+'grilleLabelColor').is(':hidden')){
           $('#'+ww+'grilleLabelColor').toggle();
                  }
          if (window.XMLHttpRequest){
                         // code for IE7+, Firefox, Chrome, Opera, Safari
                         xmlhttp = new XMLHttpRequest();
               }else{
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
               }
                        xmlhttp.onreadystatechange = function(){
               if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                        $("#"+ww+"grilleColor").html(xmlhttp.responseText);
                  }
                        
               }
    
    xmlhttp.open("GET","/getGrilleColor.php?q="+sstr,false);
    xmlhttp.send();
     
     }
     
    if($('#'+ww+'grilleType option:selected').text() == 'None' || $('#'+ww+'grilleType option:selected').text() =="No Grills" && $('#'+ww+'grilleLabelSash').is(':visible')){
       $('#'+ww+'grilleLabelSash').toggle();
       $('#'+ww+'grilleSash').toggle();
       checkGrilleSash = 0;
       if($('#'+ww+'grilleColor').is(':visible')){
       $('#'+ww+'grilleColor').toggle();
       $('#'+ww+'grilleColorDiv').toggle(); 
       checkGrilleColor = 0;
       if($('#'+ww+'grilleLabelColor').is(':visible')){
           $('#'+ww+'grilleLabelColor').toggle();
                  }
       if($('#'+ww+'grilleLabelColor2').is(':visible')){
           $('#'+ww+'grilleLabelColor2').toggle();
                  }
        }
    }
    else if($('#'+ww+'grilleType option:selected').text() != 'None' || $('#'+ww+'grilleType option:selected').text() !="No Grills" && $('#'+ww+'grilleLabelSash').is(':hidden')){
       $('#'+ww+'grilleLabelSash').toggle();
       $('#'+ww+'grilleSash').toggle();
       checkGrilleSash = 1;
       
    }
    if($('#'+ww+'grilleType option:selected').text() != 'None' || $('#'+ww+'grilleType option:selected').text() !="No Grills"){
       if($('#'+ww+'grillePatternDiv').is(':hidden')){
        $('#'+ww+'grillePatternDiv').show();
         }
      }else if($('#'+ww+'grilleType option:selected').text() == 'None' || $('#'+ww+'grilleType option:selected').text() =="No Grills" && $('#'+ww+'grillePatternDiv').is(':visible')){
         $('#'+ww+'grillePatternDiv').hide();
       }
});
        
$('[name="screens_required"]').change(function(){
   changeImage(ww+'screenColorLabel');
   changeImage(ww+'screenSelectLabel');
   $('#'+ww+'viewColors2Button').toggle();
   changeImage(ww+'screenPattern');
   changeImage(ww+'screenColor');
   $('#'+ww+'shipRadios').toggle();
});
function enable(e){
    document.getElementById(e).disabled = false;
}
function disable(e){
     $(e).prop('disabled','true');
}
/*document.getElementById('hideList').onchange = function(){
    $('[data-name="listPriceTd"]').toggle();
    $('#listColumn').toggle();       
};
document.getElementById('hideNet').onchange = function(){
    $('[data-name="netPriceTd"]').toggle();
    $('#netColumn').toggle();          
};
document.getElementById('hideSell').onchange = function(){
    $('[data-name="sellPriceTd"]').toggle();
    $('#sellColumn').toggle();          
};
document.getElementById('hideExtended').onchange = function(){
    $('[data-name="extendedPriceTd"]').toggle();
    $('#extendedColumn').toggle();          
};*/
document.getElementById('additionalConfirm').onclick = function(){
    if(newQuote == 0){
      newQuote = 1;
    }
    var tempOld = $('#priceFooter').html().replace(/^\D+/g, "");
    var newTemp = +$('#additionalPrice').val();
    if($('#additionalModifier').is(':checked')){
      newTemp *= +$('#multiplierIn').val();
    }
    if($('#additionalMarkup').is(':checked')){
      newTemp *= (1 + +document.getElementById('markupPercIn').value/100);
    }
    if($('#additionalTax').is(':checked')){
      newTemp *= (1+ +($('#taxPercIn').val().replace('%', "")/100));
    }
    newBot = parseFloat(Math.round((+newTemp + +tempOld)*100)/100).toFixed(2);
    //$('#priceFooter').html("<strong>Total Price: </strong>$"+newBot);
    $('#addBody').html($('#addBody').html()+"<tr name='newDescTr"+addId+"'><td>&nbsp;"+"<button type='button' class='addRemove close' style ='float:left' name='removeAdd' aria-label='Remove Additional Item'><span id='removeAdds'  aria-hidden='true'><font id='removeAdds' color='red'>&times;</font></span></button><div class='in' name='addDescTd'>"+$('#addDesc').val()+"</div></td></tr>");
    var tempName = "newDescTr"+addId;
    $("[name='"+tempName+"']").html($("[name='"+tempName+"']").html()+"<td name='newPriceTr'>&nbsp;$"+newTemp+"</td>");
    if(additionalArray.length > 0){ 
      additionalArray = $.map(JSON.parse(additionalArray), function(xx){
        return xx;
      },JSON); 
    }
    additionalArray.push({
      id: lineNum,
      addDescription: $('#addDesc').val(),
      addPrice: newTemp     
    }); 
    addPrice = newTemp;
    
    if(blankRow == 1){
      addItmsLine = "<p id='addItms"+additionalArray[addId].id+"' style='font-size:1.22em'><b>Additional Item: </b><text id='addPrice"+(additionalArray[addId].id+1)+"' name='addPriceName' value='"+$('#additionalPrice').val()+"'>" + $('#addDesc').val() + ", $" + parseFloat($('#additionalPrice').val()).toFixed(2)+"</text></p>";
    }else{
      addItmsLine = "<p id='addItms"+additionalArray[addId].id+"' style='font-size:1.22em'><b>Additional Items: </b><text id='addPrice"+(additionalArray[addId].id+1)+"' name='addPriceName' value='"+$('#additionalPrice').val()+"'>" + $('#addDesc').val() + ", $" + parseFloat($('#additionalPrice').val()).toFixed(2)+"</text></p>";
    }  
    if($('#additionalTax').prop('checked') == true){
      taxableAmt += newTemp;  
    }else{
      taxFreeAmt += newTemp;
      addItmsLine = "<p id='addItms"+additionalArray[addId].id+"' style='font-size:1.22em'><b>Additional Item: </b><text id='addPrice"+(additionalArray[addId].id+1)+"' name='addPriceName' value='"+$('#additionalPrice').val()+"'>" + $('#addDesc').val() + ", $" + parseFloat($('#additionalPrice').val()).toFixed(2)+", No Tax</text></p>";
    }
    $('#additionalPrice').val("");
    $('#addDesc').val("");
    addId++;
    quoteTotal = $('#priceFooter').html().replace(/^\D+/g,"");
    additionalArray = JSON.stringify(additionalArray);
    
    saveQuote(jobNumber,jobDate,jobClientName,jobPrepared,quoteNum,quoteTotal,jobPoId,jobClientId,jobAddress1,jobAddress2,jobAddress3,jsonWindowString,jobCity,jobState,jobZip,jobContact,jobPhoneNumber,jobFaxNumber,jobEmail,jobSiteAddress1,jobSiteAddress2,jobSiteAddress3,jobSiteCity,jobSiteState,jobSiteZip,jobSiteContact,jobSitePhone1,jobSitePhone2,jobSiteNotes,shipToAddress1,shipToAddress2,shipToAddress3,shipToCity,shipToState,shipToZip,shipToContact,shipToPhone,shipToNotes,pickOrShipArr,jobID,qmarkup,qmulti,newQuote,additionalArray,"configure");
    $("tr").find("td button.addRemove").on("click", function(){
      if(additionalArray.length > 0){ 
      additionalArray = $.map(JSON.parse(additionalArray), function(xx){
              return xx;
      }); 
      }
      var tempCost = $(this).closest('td').next().html().replace(/^\D+/g, "");
      var tempOldCost = $('#priceFooter').html().replace(/^\D+/g, "");
      $('#priceFooter').html("<strong>Total Price: </strong>$" + parseFloat(Math.round((+tempOldCost - +tempCost)*100)/100).toFixed(2));
      quoteTotal = $('#priceFooter').html().replace(/^\D+/g,"");
      additionalArray.splice(findWithAttr(additionalArray,'addDescription',$(this).closest('tr').find('[name="addDescTd"]').val()),1);
      $(this).closest('tr').remove(); 
      additionalArray = JSON.stringify(additionalArray);
      saveQuote(jobNumber,jobDate,jobClientName,jobPrepared,quoteNum,quoteTotal,jobPoId,jobClientId,jobAddress1,jobAddress2,jobAddress3,jsonWindowString,jobCity,jobState,jobZip,jobContact,jobPhoneNumber,jobFaxNumber,jobEmail,jobSiteAddress1,jobSiteAddress2,jobSiteAddress3,jobSiteCity,jobSiteState,jobSiteZip,jobSiteContact,jobSitePhone1,jobSitePhone2,jobSiteNotes,shipToAddress1,shipToAddress2,shipToAddress3,shipToCity,shipToState,shipToZip,shipToContact,shipToPhone,shipToNotes,pickOrShipArr,jobID,qmarkup,qmulti,newQuote,additionalArray,'configure');
      additionalArray = $.map(JSON.parse(additionalArray), function(xx){
            return xx;
        });
    });
    if(blankRow == 1){
      $('#glassadd_row').click();
    }      
};
$('[name="custDimsRadioName"]').change(function(){
  if($('#'+ww+'custDimsFt').is(':checked')){
    if($('#'+ww+'custDimsInchs').is(':visible')){
      $('#'+ww+'custDimsInchs').toggle();
    }
    if(!$('#'+ww+'ftInCustDims').is(':visible')){
      $('#'+ww+'ftInCustDims').toggle();
    } 
  }
  if($('#'+ww+'custDimsInch').is(':checked')){
    if(!$('#'+ww+'custDimsInchs').is(':visible')){ 
      $('#'+ww+'custDimsInchs').toggle();
    }
    if($('#'+ww+'ftInCustDims').is(':visible')){
      $('#'+ww+'ftInCustDims').toggle();
    }  
  }
  changeUnits(ww+'dimsW',ww+'dimsH');
  getRoughOpening();
  $('#abvCallout').html('<strong>Callout:</strong> '+ww2+ $('#'+ww+'dimsW option:selected').val()+$('#'+ww+'dimsH option:selected').val()+'-' +$('#'+ww+'installMulls1 option:selected').text());
  if(ww==""){
    $('#abvRoughOpen').html('<strong>Rough Opening:</strong> '+roughOpenWStr+ " X " +roughOpenHStr+'"');
  }else if(ww=="cc"){
    $('#abvRoughOpen').html('<strong>Rough Opening:</strong> '+roughOpenWStr+ " X " +roughOpenHStr);
  }
  $('#abvUnitDim').html('<strong>Unit Dimension:</strong> ' + $('#'+ww+'dimsW option:selected').text().substring(5,$('#'+ww+'dimsW option:selected').text().length) +" X " + 
  $('#'+ww+'dimsH option:selected').text().substring(5,$('#'+ww+'dimsH option:selected').text().length));
});
$(document).keypress(function(e){
  if(e.which === 13){
    if($('#'+ww+'click1').is(':visible') && $('#additionalConfirm').is(':hidden') && !$('[name="quantityText"]').is(':focus') && !$('[name="winLabelBottom"]').is(':focus')){
      $('#'+ww+'click1')[0].click(); 
    }
    else if ($('#startQuote').is(':visible')){
      $('#startQuote').click();
    }
    else if($('#startQuote0').is(':visible') && $('#startQuote').is(':hidden')){
      $('#startQuote0').click();
    }
    else if($('#startQuote1').is(':visible') && $('#startQuote').is(':hidden') && $('#startQuote0').is(':hidden')){
      $('#startQuote1').click();
    }
    else if($('[name="winLabelBottom"]').is(':focus') && $('#additionalConfirm').is(':hidden') && !$('[name="quantityText"]').is(':focus')){
      $('[name="refreshQuantity"]').click();
    }
    else if($('[name="quantityText"]').is(':focus') && $('#additionalConfirm').is(':hidden')){
      $('[name="refreshQuantity"]').click();
    }
    else if($("#"+ww+"click2").is(':visible') && $('#additionalConfirm').is(':hidden') && !$('[name="quantityText"]').is(':focus')){
      $("#"+ww+"click2")[0].click();
    }
    else if($("#"+ww+"click3").is(':visible') && $('#additionalConfirm').is(':hidden') && !$('[name="quantityText"]').is(':focus')){
      $("#"+ww+"click3")[0].click();
    }
    else if($("#"+ww+"click4").is(':visible') && $('#additionalConfirm').is(':hidden') && !$('[name="quantityText"]').is(':focus')){
      $("#"+ww+"click4")[0].click();
    }
    else if($("#"+ww+"click5").is(':visible') && $('#additionalConfirm').is(':hidden') && !$('[name="quantityText"]').is(':focus')){
      $("#"+ww+"click5")[0].click();
    }
    else if($("#"+ww+"click6").is(':visible') && $('#additionalConfirm').is(':hidden') && !$('[name="quantityText"]').is(':focus')){
      $("#"+ww+"click6")[0].click();
    }
    else if($("#"+ww+"click7").is(':visible') && $('#additionalConfirm').is(':hidden') && !$('[name="quantityText"]').is(':focus')){
      $("#"+ww+"click7")[0].click();
    }
    else if($("#"+ww+"click8").is(':visible') && $('#additionalConfirm').is(':hidden') && !$('[name="quantityText"]').is(':focus')){
      $("#"+ww+"click8")[0].click();
    }
    else if($('[name="addToOrderName"]').is(':visible') && $('#additionalConfirm').is(':hidden') && !$('[name="quantityText"]').is(':focus')){
      $("#"+ww+"add_row")[0].click();
    }
  }
});
/*$('#viewAddItms').click(function(){
   $('#addTable').toggle();
   $(this).blur();
   if($('#addTable').is(':visible')){
     $('#viewAddItms').html('Hide Additional Items');
     $('#viewAddItms').attr('class','btn btn-warning');
     $('html, body').animate({ 
        scrollTop: $(document).height()-$(window).height()}, 
        0, 
        "swing"
     );
   }else if($('#addTable').is(':hidden')){
     $('#viewAddItms').html('Show Additional Items');
     $('#viewAddItms').attr('class','btn btn-default');
     
     }
  });*/
function scrllTop(){
  $('html, body').animate({ 
    scrollTop: $(document).height()-$(window).height()}, 
    100, 
    "swing"
  );
}
/*$('#spanJobSite').click(function(){
 setTimeout(scrllTop,385);
});*/
$('#showColors').click(function(){
  $(this).blur();
});
$('#colorModal').on('shown.bs.modal', function(e){
  $('#showColors').one('focus', function(e){$(this).blur();});
});
$('#additionalItemsModal').on('shown.bs.modal', function(e){
  $('#addAddItems').one('focus', function(e){$(this).blur();});
});
$('#confirmOrderModal').on('shown.bs.modal', function(e){
  $('#glasssendOrder').one('focus', function(e){$(this).blur();});
});
$('#confirmPDFModal').on('shown.bs.modal', function(e){
  $('#makePdf').one('focus', function(e){$(this).blur();});
});
function deleteRow(e){
  deleteCount++;
  $(e).blur();
  var test = $(e).closest('tr').find('[name = "hiddenInput2"]').val(); 
  var totalPrice = $('#priceFooter').text().replace(/^\D+/g, ""); 
  var newPrice = +totalPrice - +test;
  var deleteCostPrice = (Math.round(test * $('#multiplierIn').val()*100)/100).toFixed(2);
  if(disPrice == 2){
    newPrice = +totalPrice - +deleteCostPrice;
  }
  if($(e).closest('tr').find('[name = "addPriceName"]').length > 0){
    addId --;
    //newPrice -= $(e).closest('tr').find('[name = "addPriceName"]').attr('value');
    additionalArray = $.map(JSON.parse(additionalArray), function(xx){
      return xx;
    });
    for(i = 0;i<additionalArray.length;i++){
      if(additionalArray[i].id == (parseInt($(e).closest('tr').find('[name = "addPriceName"]').attr('id').replace(/^\D+/g, ""))-1)){
        additionalArray.splice(i,1);
      }
    }
    additionalArray = JSON.stringify(additionalArray);
    if($(e).closest('tr').find('[name = "addPriceName"]').text().indexOf('No Tax') > -1){
      taxFreeAmt -= $(e).closest('tr').find('[name = "addPriceName"]').attr('value');
    }
  }
  savedLineNum--;
  for(x=1;x<=newid;x++){
    
    if($('#line'+x).html() > parseInt($(e).closest('tr').find('[name = "lineNumDivName"]').html())){
      $('#line'+x).html(+$('#line'+x).html()-1);
      $('#line'+x).closest('tr').attr('data-id',parseInt($('#line'+x).closest('tr').attr('data-id'))-1);
      $('#line'+x).closest('tr').attr('id','addr' + $('#line'+x).closest('tr').attr('data-id'));
      console.log($('#line'+x).closest('tr').find('[name="hiddenInput2"]').attr('id'));
      $('#line'+x).closest('tr').find('[name="hiddenInput2"]').attr('id','hiddenInputTwo'+$('#line'+x).closest('tr').attr('data-id'));
      $('#line'+x).closest('tr').find('[name="hiddenInput"]').attr('id','hiddenInput'+$('#line'+x).closest('tr').attr('data-id'));
      $('#line'+x).closest('tr').find('[name="quantityText"]').attr('id','quantText'+$('#line'+x).closest('tr').attr('data-id'));
      $('#line'+x).closest('tr').find('[name="listString"]').attr('id','listString'+$('#line'+x).closest('tr').attr('data-id'));
      $('#line'+x).closest('tr').find('[id="sellPriceDiv'+x+'"]').attr('id','sellPriceDiv'+$('#line'+x).closest('tr').attr('data-id'));
      $('#line'+x).closest('tr').find('[id="costPriceDiv'+x+'"]').attr('id','costPriceDiv'+$('#line'+x).closest('tr').attr('data-id'));
      $('#line'+x).attr('id',("line"+$('#line'+x).html()));
     //$('#addr'+x).closest('tr').attr('id','addr' + $('#addr'+x).closest('tr').attr('data-id'));
    }
  } 
  /*for(j=0;j<glassOptions.length;j++){
     if(glassOptions[j].id == ($(e).closest('tr').find('[name=lineNumDivName]').closest('div').attr('id').replace(/^\D+/g, ""))){
         glassOptions.splice(j,1);
     }
  }*/
  glassOptions.splice($(e).closest('tr').find('[name = "lineNumDivName"]').html()-1,1);
  newPrice = parseFloat(Math.round(newPrice * 100)/100).toFixed(2);
  for(j=0;j<glassOptions.length;j++){
    glassOptions[j].id = (j+1);
    glassOptions[j].gAddArr[0].line = (j+1);
    glassOptions[j].gBlankArr[0].line = (j+1);
    glassOptions[j].gCSArr[0].line = (j+1);
    glassOptions[j].gDArr[0].line = (j+1);
    glassOptions[j].gGArr[0].line = (j+1);
    glassOptions[j].gGIntArr[0].line = (j+1);
    glassOptions[j].gGPatArr[0].line = (j+1);
    glassOptions[j].gHCArr[0].line = (j+1);
    glassOptions[j].gIgArr[0].line = (j+1);
    glassOptions[j].gLabelArr[0].line = (j+1);
    glassOptions[j].gObscArr[0].line = (j+1);
    glassOptions[j].gPreArr[0].line = (j+1);
    glassOptions[j].gQArr[0].line = (j+1);
    glassOptions[j].gShArr[0].line = (j+1);
    glassOptions[j].gSpArr[0].line = (j+1);
    glassOptions[j].gStrArr[0].line = (j+1);
    glassOptions[j].gSur5Arr[0].line = (j+1);
    glassOptions[j].gTckArr[0].line = (j+1);
    glassOptions[j].gTintArr[0].line = (j+1);
    glassOptions[j].gTypArr[0].line = (j+1);
    glassOptions[j].gUnitArr[0].line = (j+1);
    glassOptions[j].gUnit2Arr[0].line = (j+1);
  }
  
  
  $('#priceFooter').html("<strong>Total Price:</strong> $"+ newPrice);
  $(e).closest('tr').find('[name = "quantityText"]').remove();
  $(e).closest('tr').find('[name = "hiddenInput2"]').remove();
  $(e).closest('tr').find('[data-name = "dims"]').remove();
  quoteTotal = newPrice;
  $(e).closest("tr").remove();
  needQuotes = 0;
  if(deleteQuote == 0){
    jsonWindowString=JSON.stringify(glassOptions);
    jsonGlassString=JSON.stringify(glassOptions);
    saveQuote(jobNumber,jobDate,jobClientName,jobPrepared,quoteNum,quoteTotal,jobPoId,jobClientId,jobAddress1,jobAddress2,jobAddress3,jsonWindowString,jobCity,jobState,jobZip,jobContact,jobPhoneNumber,jobFaxNumber,jobEmail,jobSiteAddress1,jobSiteAddress2,jobSiteAddress3,jobSiteCity,jobSiteState,jobSiteZip,jobSiteContact,jobSitePhone1,jobSitePhone2,jobSiteNotes,shipToAddress1,shipToAddress2,shipToAddress3,shipToCity,shipToState,shipToZip,shipToContact,shipToPhone,shipToNotes,pickOrShipArr,jobID,qmarkup,qmulti,newQuote,additionalArray,'configure');
  }
  newid = newid - 1;
}
function updateQuant(e){
  multiplierAmt = document.getElementById('multiplierIn').value;
  markupPerc = 1+ +document.getElementById('markupPercIn').value/100;
  $(e).closest('tr').find('[name = "hiddenWinLabel"]').val($(e).closest('tr').find('[name = "winLabelBottom"]').val());
  thisId = parseInt($(e).closest('tr').attr('data-id'));
  
  var tempQuantPrice = $(e).closest('tr').find('[name = "quantityText"]').val() * $(e).closest('tr').find('[name = "hiddenInput"]').val();
  var pastQuantPrice = $(e).closest('tr').find('[name = "hiddenInput2"]').val();
  $(e).closest('tr').find('[name = "extendedString"]').html("$" + tempQuantPrice);
  var oldTotalPrice = $('#priceFooter').html().replace(/^\D+/g, "") - (+pastQuantPrice * $('#multiplierIn').val());
  var newTotalPrice = +oldTotalPrice + (+tempQuantPrice * $('#multiplierIn').val());
  if($('#selectDisPrice option:selected').text() =="Cost"){
    //(parseFloat(Math.round((+$('#priceFooter').html().replace(/^\D+/g, "") - (+pastQuantPrice))+ (+tempQuantPrice * $('#multiplierIn').val())*100)/100).toFixed(2)))
    $('#priceFooter').html("<strong>Total Price: </strong>$"+parseFloat(Math.round(newTotalPrice * 100)/100).toFixed(2));
    //tempQuantPrice = parseFloat(Math.round((tempQuantPrice * $('#multiplierIn').val())*100)/100).toFixed(2);
  }else{
    $('#priceFooter').html("<strong>Total Price: </strong>$"+(parseFloat(Math.round(((+$('#priceFooter').html().replace(/^\D+/g, "") - pastQuantPrice)+ +tempQuantPrice)*100)/100).toFixed(2)));
  }
  
  $(e).closest('tr').find('[name = "hiddenInput2"]').val(tempQuantPrice);
  glassOptions[thisId-1].gq = escapeHtml($(e).closest('tr').find('[name = "quantityText"]').val());
  console.log("element: " + $(e).closest('tr').find('[name = "quantityText"]') +' value: '+$(e).closest('tr').find('[name = "quantityText"]').val());
  if($(e).closest('tr').find('td[data-name="dims"]').find('p').text().toLowerCase().indexOf('additional item') == -1){
    sGOrderQuant = escapeHtml($(e).closest('tr').find('[name = "quantityText"]').val());
    if(sGOrderQuant.length == 1){
        sGOrderQuant = "000000" + sGOrderQuant;
      }else if(sGOrderQuant.length == 2){
        sGOrderQuant = "00000" + sGOrderQuant;
      }else if(sGOrderQuant.length == 3){
        sGOrderQuant = "0000" + sGOrderQuant;
      }else if(sGOrderQuant.length == 4){
        sGOrderQuant = "000" + sGOrderQuant;
      }else if(sGOrderQuant.length == 5){
        sGOrderQuant = "00" + sGOrderQuant;
      }else if(sGOrderQuant.length == 6){
        sGOrderQuant = "0" + sGOrderQuant;
      }
    glassOptions[thisId-1].gQArr[0].optionVal = sGOrderQuant;
  }
  pdfQuantVal = escapeHtml($(e).closest('tr').find('[name = "quantityText"]').val());
  glassOptions[thisId-1].extendedPrice = tempQuantPrice;
  jsonWindowString = JSON.stringify(glassOptions);  
  quoteTotal = $('#priceFooter').html().replace(/^\D+/g, "");
  newQuote = 1;
  saveQuote(jobNumber,jobDate,jobClientName,jobPrepared,quoteNum,quoteTotal,jobPoId,jobClientId,jobAddress1,jobAddress2,jobAddress3,jsonWindowString,jobCity,jobState,jobZip,jobContact,jobPhoneNumber,jobFaxNumber,jobEmail,jobSiteAddress1,jobSiteAddress2,jobSiteAddress3,jobSiteCity,jobSiteState,jobSiteZip,jobSiteContact,jobSitePhone1,jobSitePhone2,jobSiteNotes,shipToAddress1,shipToAddress2,shipToAddress3,shipToCity,shipToState,shipToZip,shipToContact,shipToPhone,shipToNotes,pickOrShipArr,jobID,qmarkup,qmulti,newQuote,additionalArray,'configure');
}
$('#markupPercIn').keydown(function(){
  clearTimeout(timer); 
  timer = setTimeout(function(){
    $('#selectDisPrice').change();
    if($('#markupPercIn').val().indexOf('%') == -1 && $('#markupPercIn').val() != ''){
      $('#markupPercIn').val($('#markupPercIn').val() + "%");
    }
  },1000);
});
//dostuff bookmark
function doStuff(){
  mkFootPrice = 0;
  if($('#markupPercIn').val() == ""){
    $('#markupPercIn').val(0);
  } 
  if($('#markupPercIn').val()==0){
    if(newid > lineNum){
      for(i=1;i<=lineNum;i++){
      $('#listString'+i).html("$"+parseFloat($('#hiddenInput'+i).val()).toFixed(2));
      mkFootPrice += +parseFloat($('#listString'+i).html().replace(/^\D+/g, "") * $('#hiddenInput'+i).closest('tr').find('[name="quantityText"]').val()).toFixed(2);
      /*$('#priceFooter').html("Total Price: $"+(+$('#priceFooter').html().replace(/^\D+/g, "") + +$('#hiddenInput'+i).val()));*/
      }
    }else{
      for(i=1;i<=newid;i++){
       $('#listString'+i).html("$"+parseFloat($('#hiddenInput'+i).val()).toFixed(2));
        mkFootPrice += +parseFloat($('#listString'+i).html().replace(/^\D+/g, "") * $('#hiddenInput'+i).closest('tr').find('[name="quantityText"]').val()).toFixed(2);
      /*$('#priceFooter').html("Total Price: $"+(+$('#priceFooter').html().replace(/^\D+/g, "") + +$('#hiddenInput'+i).val()));*/
      }
    }
  }else{
    if(newid>lineNum){
      for(i=1;i<=lineNum;i++){
        $('#listString'+i).html("$"+parseFloat($('#hiddenInput'+i).val() * (1 + +$('#markupPercIn').val().replace('%','')/100)).toFixed(2));
      /*//$('#priceFooter').html("Total Price: $"+parseFloat(+$('#priceFooter').html().replace(/^\D+/g, "") + +parseFloat($('#hiddenInput'+i).val() * (1 + +$('#markupPercIn').val()/100)).toFixed(2)).toFixed(2));*/
        glassOptions[i-1].extendedPrice = $('#hiddenInput'+i).val() * (1 + +$('#markupPercIn').val().replace('%','')/100)* $('#hiddenInput'+i).closest('tr').find('[name="quantityText"]').val();
        mkFootPrice += +parseFloat($('#listString'+i).html().replace(/^\D+/g, "") * $('#hiddenInput'+i).closest('tr').find('[name="quantityText"]').val()).toFixed(2);
      }
    }else{
      for(i=1;i<=newid;i++){
        $('#listString'+i).html("$"+parseFloat($('#hiddenInput'+i).val() * (1 + +$('#markupPercIn').val().replace('%','')/100)).toFixed(2));
      /*//$('#priceFooter').html("Total Price: $"+parseFloat(+$('#priceFooter').html().replace(/^\D+/g, "") + +parseFloat($('#hiddenInput'+i).val() * (1 + +$('#markupPercIn').val()/100)).toFixed(2)).toFixed(2));*/
        glassOptions[i-1].extendedPrice = $('#hiddenInput'+i).val() * (1 + +$('#markupPercIn').val().replace('%','')/100)* $('#hiddenInput'+i).closest('tr').find('[name="quantityText"]').val();
        mkFootPrice += +parseFloat($('#listString'+i).html().replace(/^\D+/g, "") * $('#hiddenInput'+i).closest('tr').find('[name="quantityText"]').val()).toFixed(2);
      }
    }
  }
  $('#priceFooter').html("<strong>Total Price: </strong>$"+(mkFootPrice).toFixed(2));
  /*if(doTaxes == 1){
      combinedTaxAmt = +parseFloat($('#priceFooter').html().replace(/^\D+/g, "")) + +parseFloat((mkFootPrice.toFixed(2) * $('#taxPercIn').val().replace('%',"")/100).toFixed(2));
      $('#priceFooter').html('<strong>Total Price: </strong>$'+ parseFloat(combinedTaxAmt).toFixed(2));
  }*/
  jsonGlassString = JSON.stringify(glassOptions);
  qmarkup = parseFloat($('#markupPercIn').val().replace('%','')/100).toFixed(2);
  saveQuote(jobNumber,jobDate,jobClientName,jobPrepared,quoteNum,mkFootPrice,jobPoId,jobClientId,jobAddress1,jobAddress2,jobAddress3,jsonGlassString,jobCity,jobState,jobZip,jobContact,jobPhoneNumber,jobFaxNumber,jobEmail,jobSiteAddress1,jobSiteAddress2,jobSiteAddress3,jobSiteCity,jobSiteState,jobSiteZip,jobSiteContact,jobSitePhone1,jobSitePhone2,jobSiteNotes,shipToAddress1,shipToAddress2,shipToAddress3,shipToCity,shipToState,shipToZip,shipToContact,shipToPhone,shipToNotes,pickOrShipArr,jobID,qmarkup,qmulti,newQuote,additionalArray,'configure');
}
function doStuff2(){
  multiplierAmt = document.getElementById('multiplierIn').value;
  markupPerc = 1+ +document.getElementById('markupPercIn').value.replace('%','')/100;
  $(this).closest('tr').find('[name = "hiddenWinLabel"]').val($(this).closest('tr').find('[name = "winLabelBottom"]').val());
  var tempQuantPrice = $(this).closest('tr').find('[name = "quantityText"]').val() * $(this).closest('tr').find('[name = "hiddenInput"]').val();
  var pastQuantPrice = $(this).closest('tr').find('[name = "hiddenInput2"]').val();
  var extendedUpdated = Math.round(($(this).closest('tr').find('[name = "extendedString"]').html().replace(/^\D+/g, "") * $(this).closest('tr').find('[name = "quantityText"]').val() + 0.00001) * 100) / 100;
  $(this).closest('tr').find('[name = "extendedString"]').html("$" + tempQuantPrice);
  $('#priceFooter').html("<strong>Total Price: </strong>$"+((+$('#priceFooter').html().replace(/^\D+/g, "") - pastQuantPrice)+ +tempQuantPrice));
  $(this).closest('tr').find('[name = "hiddenInput2"]').val(tempQuantPrice);
}
function createPdf(){
  //change add pdfShapeCount
  console.log($('#addr1').height()/$('#tabLogicBody').height());

  pdfShapeCount = 0;
  pdfGrilleCount = 0;
  totalPage = 1;
  thisPage = 1;            
  var nextPlace = 1;
  var pdf = new jsPDF('p', 'mm', 'letter');
  //Standard letter paper is 215.9 by 279.4 mm
  //var source = $('#addr1');
  //pdf.rect(13,27,115,.5,'F');
  pdf.addImage(headerImg, 'PNG',5,6,110,20);
  pdf.addFont('verdana','verdana','normal');
  pdf.addFont('impact','impact','normal');
  pdf.addFont('impact','impact','italic');
  pdf.addFont('Helvetica','Helvetica','normal');
  //pdf.setFont("verdana");
  pdf.setFont('Arial');
  pdf.setFontSize(14);
  //pdf.text(40,17,'CASCO INDUSTRIES, INC.');
  pdf.setFontSize(9.5);
  pdf.setFontType('italic');
  //pdf.text(40.5,22,'Quality Building Products Since 1960');
  pdf.setFontSize(9);
  pdf.setFontType('normal');
  pdf.rect(5,5,206,30);//top outline box
  pdf.rect(5,38,206,47);//bottom outline box  
  pdf.rect(5,88,206,47);
  pdf.rect(5,138,206,57);
  thirtyOneDaysInMill = 2678000000;
  expireDate2 = new Date(Date.parse(jobDate1) + thirtyOneDaysInMill);
  var d = new Date(expireDate2);
  var mm = d.getMonth()+1;
  var dd = d.getDate();
  if(dd<10){
    dd ='0'+dd;
  }
  if(mm<10){
    mm ='0'+mm;
  }
  createOnDate = new Date(Date.parse(jobDate1));
  cMM = createOnDate.getMonth() + 1;
  cDD = createOnDate.getDate();
  if(cDD < 10){
    cDD = '0'+cDD;
  }
  if(cMM < 10){
    cMM = '0'+cMM;
  }
  pdf.text(12,32,cascoAddress);
  pdf.text(115,16.5,'Created By: ' + jobPrepared);
  pdf.text(115,11.5,'Company: ' + jobClientName);
  pdf.text(162,16.5,'Created On: ' + cMM+'-'+cDD+'-'+createOnDate.getFullYear());
  pdf.text(162,21.5,'Expires On: ' + mm+'-'+dd+'-'+d.getFullYear());
  pdf.text(115,21.5,'Ordered On: '+ orderedOn);
  //change add this if else
  if(jobPoId != ""){
    pdf.text(162,26.5,'PO #: ' + jobPoId);
  }else{
    pdf.text(162,26.5,'PO #: ' + $('#topGlassPOInput').val());
  }
  if(as4OrderNum == 0){
    pdf.text(115,26.5,'Quote #: ' + jobNumber);
  }else{
    pdf.text(115,26.5,'Order #: ' + as4OrderNum);
  }
  //pdf.rect(5,37,205,0.5,'F');
  //pdf.addImage(imgData2, 'JPEG',5,44,205,60);
  /*
  pdf.setFontSize(17);
  pdf.text(5,110,'Casco Industries');
  pdf.rect(63,104,0,8,'F');
  pdf.setFontSize(14);
  pdf.text(68,110,'SUPERIOR CUSTOMER SERVICE WITH COMMITMENT');
  pdf.text(68,110,'Superior customer service with commitment');
  */
  //pdf.rect(5,100.5,205,.5,'F');
  pdf.setFontSize(12);
  pdf.text(11,48,'CUSTOMER');
  pdf.rect(8,51,200,.5,'F');
  pdf.setFontSize(9);
  /*if(jobClientName ==""){
    jobClientName = "Not Given";
  }*/
  pdf.text(10,57, 'Customer Name: ' + jobClientName);
  pdf.text(10,63, 'Customer Address: ');
  /*if(jobAddress1 == "" && jobAddress2 == "" && jobAddress3 == ""){
    jobAddress1 = "Not Given";
  }*/
  pdf.text(10,67,jobAddress1 + " " + jobAddress2 + " " + jobAddress3);
  /*
  if(jobCity == ""){
    jobCity = "City Not Given";
  }
  if(jobState == ""){
    jobState = "State Not Given";
  }
  if(jobZip == ""){
    jobZip = "Zip Code Not Given"
  }
  */
  pdf.text(10,71,jobCity + " " +jobState+", " + jobZip);
  //pdf.rect(95,135,0,20,'F');
  /*if(jobPhoneNumber == ""){
    jobPhoneNumber = " Not Given";
  }
  if(jobPhoneNumber != "" && jobPhoneNumber != " Not Given" && jobPhoneNumber.indexOf('(') == -1){
    jobPhoneNumber = "(" + jobPhoneNumber.substring(0,3)+") " + jobPhoneNumber.substring(3,6) + "-"+jobPhoneNumber.substring(6,10);
  }
  if(jobFaxNumber == ""){
    jobFaxNumber = " Not Given";
  }*/
  pdf.text(103,57, 'Customer Phone:' + jobPhoneNumber);
  pdf.text(103,63, 'Customer Fax:' + jobFaxNumber);
  /*if(jobEmail == ""){
    jobEmail = " Not Given";
  }*/
  pdf.text(103,69, 'Customer Email: ' + jobEmail);
  pdf.setFontSize(12);
  pdf.text(11,95,'JOBSITE');
  pdf.rect(8,98,200,.5,'F');
  pdf.setFontSize(9);
  pdf.text(10,104, 'Jobsite Address: ');
  /*if(jobSiteAddress1 == "" && jobSiteAddress2 == "" && jobSiteAddress3 == ""){
    jobSiteAddress1 = " Not Given";
  }*/
  pdf.text(10,108, jobSiteAddress1 + " " + jobSiteAddress2 + " " + jobSiteAddress3);
  pdf.text(10,113, jobSiteCity + " " + jobSiteState +", " + jobSiteZip);
  //pdf.rect(95,172,0,18,'F');
  /*if(jobSiteContact == ""){
    jobSiteContact = " Not Given";
  }*/
  pdf.text(103,104, 'Jobsite Contact: ' + jobSiteContact);
  /*if(jobSitePhone1 == ""){
    jobSitePhone1 = " Not Given";
  }
  if(jobSitePhone2 == ""){
    jobSitePhone2 = " Not Given";
  }
  if(jobSitePhone1 != "" && jobSitePhone1 != " Not Given" && jobSitePhone1.indexOf('(') == -1){
    jobSitePhone1 = "(" + jobSitePhone1.substring(0,3)+") " + jobSitePhone1.substring(3,6) + "-"+jobSitePhone1.substring(6,10);
  }*/
  pdf.text(103,110, 'Jobsite Phone: ' + jobSitePhone1);
  /*
  if(jobSitePhone2 != "" && jobSitePhone2 != " Not Given" && jobSitePhone2.indexOf('(') == -1){
    jobSitePhone2 = "(" + jobSitePhone2.substring(0,3)+") " + jobSitePhone2.substring(3,6) + "-"+jobSitePhone2.substring(6,10);
  }*/
  pdf.text(103,116, 'Jobsite Alt. Phone: ' + jobSitePhone2);
  pdf.text(10,127,'Jobsite Notes:' + jobSiteNotes);
  
  pdf.setFontSize(12);
  if($('input[name="shipViaOpts"]:checked').val() == "option1"){
    pickOrShip = "Pick Up";
  }else{
    pickOrShip = "Ship To";
  }
  pdf.text(11,148,pickOrShip.toUpperCase());
  pdf.rect(8,151,200,.5,'F');
  pdf.setFontSize(9);
  pdf.text(10,157,pickOrShip + ' Address: ');
  /*if(shipToAddress1 == "" && shipToAddress2 == "" && shipToAddress3 == ""){
    shipToAddress1 = " Not Given";
  }*/
  pdf.text(10,161, shipToAddress1 + " " + shipToAddress2 + " " + shipToAddress3);
  pdf.text(10,166, shipToCity + " " +shipToState +", " +shipToZip);
  /*if(shipToContact == ""){
    shipToContact = " Not Given";
  }*/
  pdf.text(103,157,pickOrShip + ' Contact: ' + shipToContact);
  /*if(shipToPhone == ""){
    shipToPhone = " Not Given";
  }
  if(shipToPhone != "" && shipToPhone != " Not Given" && shipToPhone.indexOf('(') == -1){
    shipToPhone = "(" + shipToPhone.substring(0,3)+") " + shipToPhone.substring(3,6) + "-"+shipToPhone.substring(6,10);
  }*/
  pdf.text(103,163,pickOrShip + ' Phone: ' + shipToPhone);
  pdf.text(10,180,'Special Shipping Instructions: ' + shipToNotes);
  pdf.rect(8,266,198,.5,'F');
  pdf.text(10,272,'www.cascoonline.com');
  pdf.text(66,272,cascoAddress);
  pdf.text(183,272,'PAGE '+thisPage);
  newPageHandF(pdf);
  listPdfXPos = 145.3;//L = 95
  $('input[name="shipViaOpts"]:checked').val();
  var specialElementHandlers = {
    '#bypassme': function(element, renderer){
      return true;
    }
  };  
  tblLength = ($('#tab_logic >tbody >tr').length);
  for(x=1;x<tblLength;x++){ 
    if($('[data-id="'+x+'"]').is(':visible')){
      pdfQuantVal = $('[data-id="'+x+'"]').find($('[data-name="preview"]')).find($('[name="quantityText"]')).val();
      if(disPrice > 0 && pdfPriceType != 1){
        pdfUnitPrice = parseFloat($('[data-id="'+x+'"]').find($('[data-name="listPriceTd"]')).text().replace(/^\D+/g, "")).toFixed(2);
        listPdf = "<font style='font-size:.75em;font-family:Arial,sans-serif'><strong>Unit Price: </strong>$" + parseFloat($('[data-id="'+x+'"]').find($('[data-name="listPriceTd"]')).text().replace(/^\D+/g, "")).toFixed(2) +"</font>";
        pdfExtPrice = parseFloat(pdfUnitPrice * pdfQuantVal).toFixed(2);
        extPdf = "<font style='font-size:.75em;font-family:Arial,sans-serif'><strong>Extended: </strong>$"+pdfExtPrice+"</font>";
        if(listPdf.length > 95){
          listPdfXPos -= (1.7 * (listPdf.length - 95));
        }
      }else{
        listPdf = "";
      }
      dimsString = "<strong>Label: "+$('[data-id="'+x+'"]').find($('[data-name="dims"]')).find($('[name ="lineLabels"]')).val()+"</strong><br>"+$('[data-id="'+x+'"]').find($('[data-name="dims"]')).text().substring(7);
      //change add dimBoxHeight
      dimBoxHeight = $('[data-id="'+x+'"]').find($('[data-name="dims"]')).height();
      console.log("dimBoxHeight: "+dimBoxHeight);
      if($('[data-id="'+x+'"]').find($('[data-name="dims"]')).find($('[name ="lineLabels"]')).val() != ''){
        labelString = "<font style='font-size:.80em;font-family: Arial,sans-serif'><strong>Label: </strong>"+$('[data-id="'+x+'"]').find($('[data-name="dims"]')).find($('[name ="lineLabels"]')).val()+"<font>";
      }else{
        labelString = '';
      }
      lineNumString = "<font style='font-size:.80em;font-family: Arial,sans-serif'><strong>Line: </strong>"+$('[data-id="'+x+'"]').find($('td[data-name="lineNumber"]')).text()+"</font>";
    //pdfQuant = "Quantity: " + $('[data-id="'+x+'"]').find('td[data-name="preview"]').find('[name="quantityText"]').val();
    }
    pdf.setFont('Arial');
    pdf.setFontType('normal');
    //htmlString =  "<div style ='font-size:.65em'>"+ dimsString + "<br>"+ "<p></p>" +  "_______________________________________________________________________________________________________________________________</div>";
    htmlString = "<br><br><font style='font-size:.60em;font-family: Arial,sans-serif'>" + $('[data-id="'+x+'"]').find($('td[data-name="dims"]')).html().replace("Label:","") + "</font>";
    if(htmlString.indexOf('Additional Item:') > -1){
      htmlString = "<br>" + htmlString;
      labelString = '';
    }
    
    var pdfQuantString = htmlString.substring(htmlString.toLowerCase().indexOf('quantity'),htmlString.toLowerCase().indexOf('glass strength'));
    htmlString = htmlString.replace(pdfQuantString,'');
    pdfQuantString = "<font style='font-size:.80em;font-family: Arial,sans-serif'><strong>QTY: </strong>" + pdfQuantVal + "</font>";
    if(((40*nextPlace) + 20) > 225){
      nextPlace = 1;
      newPageHandF(pdf);
    }
    //chage to + 6 (added 7 pixels for shapes)
    if(dimsString.indexOf('Shape')>-1 || pdfShapeCount > 0){
      pdf.fromHTML(htmlString,30,(40*nextPlace)-9.45,{
        'width': 174 , // max width of content on PDF
        'elementHandlers': specialElementHandlers
      });
    }else{
      pdf.fromHTML(htmlString,30,(40*nextPlace)-9.45,{
        'width': 174, // max width of content on PDF
        'elementHandlers': specialElementHandlers
      });
    }
    //line, qty, prices
    //change to + 10 (added 7 pixels for shapes, added 4 pixels for grilles)
    //change add shape check
    if(dimsString.indexOf('Shape') > -1){
      if(dimsString.indexOf('Grille Pattern') > -1 || pdfGrilleCount > 0){
        pdfGrilleCount++
        pdf.fromHTML(listPdf,listPdfXPos,(40*nextPlace));
        pdf.fromHTML(extPdf,175.3,(40*nextPlace));
        pdf.fromHTML(labelString,95,(40*nextPlace));
        pdf.fromHTML(lineNumString,7,(40*nextPlace));
        pdf.fromHTML(pdfQuantString,95,(40*nextPlace));
      }else{
        pdf.fromHTML(listPdf,listPdfXPos,(40*nextPlace));
        pdf.fromHTML(extPdf,175.3,(40*nextPlace));
        pdf.fromHTML(labelString,95,(40*nextPlace));
        pdf.fromHTML(lineNumString,7,(40*nextPlace));
        pdf.fromHTML(pdfQuantString,95,(40*nextPlace));
      }
    }else{
      if(dimsString.indexOf('Grille Pattern') > -1 || pdfGrilleCount > 0){
        pdfGrilleCount++
        if(pdfShapeCount > 0){
          pdf.fromHTML(listPdf,listPdfXPos,(40*nextPlace));
          pdf.fromHTML(extPdf,175.3,(40*nextPlace));
          pdf.fromHTML(labelString,95,(40*nextPlace));
          pdf.fromHTML(lineNumString,7,(40*nextPlace));
          pdf.fromHTML(pdfQuantString,95,(40*nextPlace));
        }else{
          pdf.fromHTML(listPdf,listPdfXPos,(40*nextPlace));
          pdf.fromHTML(extPdf,175.3,(40*nextPlace));
          pdf.fromHTML(labelString,95,(40*nextPlace));
          pdf.fromHTML(lineNumString,7,(40*nextPlace));
          pdf.fromHTML(pdfQuantString,95,(40*nextPlace));
        }
      }else{
        if(pdfShapeCount > 0){
          pdf.fromHTML(listPdf,listPdfXPos,(40*nextPlace));
          pdf.fromHTML(extPdf,175.3,(40*nextPlace));
          pdf.fromHTML(labelString,95,(40*nextPlace));
          pdf.fromHTML(lineNumString,7,(40*nextPlace));
          pdf.fromHTML(pdfQuantString,95,(40*nextPlace));
        }else{
          pdf.fromHTML(listPdf,listPdfXPos,(40*nextPlace));
          pdf.fromHTML(extPdf,175.3,(40*nextPlace));
          pdf.fromHTML(labelString,95,(40*nextPlace));
          pdf.fromHTML(lineNumString,7,(40*nextPlace));
          pdf.fromHTML(pdfQuantString,95,(40*nextPlace));
      }
    }
  }
    //pdf.fromHTML(listPdf,170,(24*(nextPlace+1)));
    nextPlace++;
    if(dimsString.indexOf('Rectangle') > -1){
      //change add 7 pixels, -18 add if else
      if(pdfShapeCount == 0 && pdfGrilleCount == 0){
        pdf.addImage(rectImg,'JPEG',7,(40*nextPlace)-30,11,15);
        console.log("shape check under next place");
      }else if((pdfShapeCount == 0 && pdfGrilleCount !=0) || (pdfShapeCount != 0 && pdfGrilleCount == 0)){
        pdf.addImage(rectImg,'JPEG',7,(40*nextPlace)-30,11,15);
      }else if(pdfShapeCount != 0 && pdfGrilleCount !=0 ){
        pdf.addImage(rectImg,'JPEG',7,(40*nextPlace)-30,11,15);
      }
    }else if(dimsString.indexOf('Shape') > -1){
      //change add ++ statement
      pdfShapeCount++;
      $('#pdfImgCanvas').attr('style',$('#pdfImgCanvas').attr('style')+';height:200px');
      var c = document.getElementById('pdfImgCanvas');
      //change canvas height below
      c.height = 200;
      //c.width = c.width - 10;
      var shapeDrawImg = document.getElementById($('#'+$('[data-id="'+x+'"]').find($('td[data-name="dims"]')).html().substring($('[data-id="'+x+'"]').find($('td[data-name="dims"]')).html().indexOf("#"),$('[data-id="'+x+'"]').find($('td[data-name="dims"]')).html().indexOf("#")+3).replace('#','shape')).attr('id'));
      var ctx = c.getContext('2d');
      //change add temp width/height
      tempPicWidth = document.getElementById($('#'+$('[data-id="'+x+'"]').find($('td[data-name="dims"]')).html().substring($('[data-id="'+x+'"]').find($('td[data-name="dims"]')).html().indexOf("#"),$('[data-id="'+x+'"]').find($('td[data-name="dims"]')).html().indexOf("#")+3).replace('#','shape')).attr('id')).width;
      tempPicHeight = document.getElementById($('#'+$('[data-id="'+x+'"]').find($('td[data-name="dims"]')).html().substring($('[data-id="'+x+'"]').find($('td[data-name="dims"]')).html().indexOf("#"),$('[data-id="'+x+'"]').find($('td[data-name="dims"]')).html().indexOf("#")+3).replace('#','shape')).attr('id')).height;
      console.log("tempheight:" + tempPicHeight);
      console.log("c height:" + c.height);
      ctx.fillStyle = "#FFF";
      ctx.fillRect(0,0,c.width,c.height);
      ctx.drawImage(shapeDrawImg,0,0);
      dataCanvasURLJpeg = c.toDataURL("image/jpeg");
      //change this line below
      pdf.addImage(dataCanvasURLJpeg,'JPEG',6,(40*nextPlace)-30,tempPicWidth/8,tempPicHeight/12);

    }else{
      $('#pdfImgCanvas').html('');
      $('#pdfImgCanvas').append('<div id="pdfImgCanvasDiv"></div');
      $('#pdfImgCanvas').append("<canvas id='pdfImgCanvasDivImg'  style='width:11px;height:15px' alt='window'></canvas>");
      $('#pdfImgCanvas').append('<div id="pdfImgCanvasDiv2"></div>');
      //$('#pdfImgCanvasDivImg').attr('style',"background-image: url(/window_pictures/"+comboWindowList[x-1].url.replace('/','')+".png);background-size: contain;background-repeat: no-repeat;width:11px;height:15px;");
      canvasPDF = document.getElementById('pdfImgCanvasDivImg');
      //change add if else for shape count
      if(dimsString.indexOf('Shape') > -1){
        //-3 OG
        pdf.addImage(canvasPDF.toDataURL("image/jpeg"),'JPEG',7,(40*nextPlace)-8,11,15);
      }else{
        //change add if else statement
        if(pdfShapeCount > 0){
          if(pdfGrilleCount > 0){
            pdf.addImage(canvasPDF.toDataURL("image/jpeg"),'JPEG',7,(40*nextPlace),11,15);
          }else{
            pdf.addImage(canvasPDF.toDataURL("image/jpeg"),'JPEG',7,(40*nextPlace),8,15);
          }
        }else{
          if(pdfGrilleCount > 0){
            pdf.addImage(canvasPDF.toDataURL("image/jpeg"),'JPEG',7,(40*nextPlace),11,15);
          }else{
            pdf.addImage(canvasPDF.toDataURL("image/jpeg"),'JPEG',7,(40*nextPlace),11,15);
          }
        }
      }
      /*html2canvas(document.getElementById('pdfImgCanvasDiv'),{
        onrendered: function(canvas){
          canvas.id = 'pdfComboCanvas';
          $('#pdfImgCanvasDiv2').append(canvas);
          canvasPDF = document.getElementById('pdfComboCanvas');
          pdf.addImage(canvasPDF.toDataURL("image/jpeg"),'JPEG',8,(30*nextPlace)-16,11,15);
    }

    },
    async: false
  }); */
    }
    //add shape check here
    //change add if else 
    //add grille stuff
    //pdf ratio lines
    console.log('lines: ' + $('#addr'+x).height()/$('#tabLogicBody').height() * 220.5);
    console.log('lines2: ' + +(($('#addr'+x).height()/$('#tabLogicBody').height()) * 220.5)+ +(($('#addr'+(x-1)).height()/$('#tabLogicBody').height()) * 220.5));
    //pdf.rect(6,(+($('#addr'+x).height()/$('#tabLogicBody').height()) * 220.5)+(+($('#addr'+(x-1)).height()/$('#tabLogicBody').height()) * 220.5),198,0,'F');
    /*if(dimsString.indexOf('Shape') > -1){
      if(pdfGrilleCount >0){
          pdf.rect(6,(30*(nextPlace-1))+53,198,0,'F');
        }else{
          pdf.rect(6,(30*(nextPlace-1))+45,198,0,'F');
        }
    }else{
      if(pdfShapeCount > 0){
        if(pdfGrilleCount > 0){
          pdf.rect(6,(30*(nextPlace-1))+48,198,0,'F');
        }else{
          pdf.rect(6,(30*(nextPlace-1))+45,198,0,'F');
        }
      }else{
        if(pdfGrilleCount >0){  
          pdf.rect(6,(30*(nextPlace-1))+43,198,0,'F');
        }else{
          pdf.rect(6,(30*(nextPlace-1))+40,198,0,'F');
        }
      }
    }*/
    listPdfXPos = 145.3;
  }//end for-loop
  if((custTaxTerms == 2 && $('#taxPercIn').val() == "") || (custTaxTerms == 2 && $('#taxPercIn').val() == 0) || (custTaxTerms == 2 && $('#taxPercIn').val() == '0%')){
    pdfTax = 0;
  }else{
    pdfTax = parseFloat(Math.round(((($('#priceFooter').html().replace(/^\D+/g, ""))-taxFreeAmt) * ($('#taxPercIn').val().replace('%', "")/100))*100)/100).toFixed(2);
  }
  pdfSubtotal = "$" + (($('#priceFooter').html().replace(/^\D+/g, ""))  - taxFreeAmt).toFixed(2);
  if($('#taxPercIn').val() == 0 || $('#taxPercIn').val() == ""){
    pdfTaxLineLabel = "Tax (N/A):";
  }else{
    pdfTaxLineLabel = "Tax ("+$('#taxPercIn').val()+"):";
  }
  if(pdfTax == 0){
    pdfTax = "0.00";
  }    
  pdfTaxLine = "$" + pdfTax;
  if(taxFreeAmt != 0){
    pdfTaxFreeLineLabel = "Tax Exempt Total:";
    pdfTaxFreeLine =  "$" + taxFreeAmt.toFixed(2);
  }else{
    pdfTaxFreeLineLabel = "";
    pdfTaxFreeLine = "";
  }
  pdfTotalPrice = "$" + parseFloat(Math.round((+$('#priceFooter').html().replace(/^\D+/g, "") + +pdfTax)*100)/100).toFixed(2);
  //.7mm per character
  subtotalLineXPos = 191.3;
  taxLineXPos = 191.3;
  taxFreeLineXPos = 191.3;
  totalLineXPos = 191.3;
  if(pdfSubtotal.length > 5){
    subtotalLineXPos -= (1.7 * (pdfSubtotal.length-5));
  }
  if(pdfTaxLine.length > 5){
    taxLineXPos -= (1.7 * (pdfTaxLine.length-5));
  }
  if(pdfTaxFreeLine.length > 5){
    taxFreeLineXPos -= (1.7 * (pdfTaxFreeLine.length-5));
  }
  if(pdfTotalPrice.length > 5){
    totalLineXPos -= (1.7 * (pdfTotalPrice.length-5));
  }
  //change 5/31 add extra pixels for shapes
  if(disPrice > 0){
    pdf.setFontType('bold');
    pdf.text("Taxable Subtotal:",157.5,(40*nextPlace)+13);
    pdf.setFontType('normal');
    pdf.text(pdfSubtotal,subtotalLineXPos,(40*nextPlace)+13);
    pdf.setFontType('bold');
    pdf.text(pdfTaxLineLabel,165.8,(40*nextPlace)+18);
    pdf.setFontType('normal');
    pdf.text(pdfTaxLine,taxLineXPos,(40*nextPlace)+18);
    pdf.setFontType('bold');
    pdf.text(pdfTaxFreeLineLabel,156.5,(40*nextPlace)+23);
    pdf.setFontType('normal');
    pdf.text(pdfTaxFreeLine,taxFreeLineXPos,(40*nextPlace)+23);
    if(taxFreeAmt > 0){
      pdf.setFontType('bold');
      pdf.text("Total: ",174.5,(40*nextPlace)+28);
      pdf.setFontType('normal');
      pdf.text(pdfTotalPrice,totalLineXPos,(40*nextPlace)+28); 
    }else{
      //change height to 25
      pdf.setFontType('bold');
      pdf.text("Total: ",174.5,(40*nextPlace)+23);
      pdf.setFontType('normal');
      pdf.text(pdfTotalPrice,totalLineXPos,(40*nextPlace)+23);
    }
  }
  pdfSign1 = " All the above unit quantities and accessories have been verified and accepted by the undersigned for purchase from Casco Industries, Inc. \n Casco does not claim responsibility for ensuring final order specifications and correct sizing. Customer must confirm each line item at the time of \n order. Any changes must be made within 24 hours of placing the order. Any changes after the 24 hour time frame are chargeable and may incur \n a 50% restocking fee for parts/pieces canceled or changed. Any delivered orders will incur a delivery fee. All orders have a 2-4 week lead time \n unless otherwise noted. If products are ready prior to this time, Casco will notify the purchaser by phone and arrange for delivery/pick-up. \n By signing below, the purchaser agrees to all terms set forth by Casco Industries, Inc. and approves this order for production on the date below. \n\n Accepted by:___________________________________________________  Date:______________________________________________";
  pdfSign2 = userInfoArr[1] + " " +userInfoArr[2];
  pdfSign3 = $('#dateTopBar').find('strong').html();
  if((34*nextPlace)+45 > 210){
    nextPlace = 0;
    pdfShapeCount = 0;
    pdfGrilleCount = 0;
    newPageHandF(pdf);
  }

  pdf.text(pdfSign1,5,(40*nextPlace)+45);
    pdf.setFontType('bold');
  if(as4OrderNum != 0){  
    pdf.text(pdfSign2,55,(40*nextPlace)+68);
    pdf.text(pdfSign3,158,(40*nextPlace)+68);
  }
  /*comboCount = 0;
  $.each(comboWindowList,function(i){
    if(comboWindowList[i].isCombo == true){
      comboCount++;
    }
  })*/
  
  //canvasPDF = document.getElementById('windowComboCanvas');
  //add canvas pdf bookmark
  //pdf.addImage(canvasPDF.toDataURL("image/jpeg"), 'JPEG',50,50+65,containerWidth*.5,containerHeight*.5);
  /*if(comboCount > 0){
    newComboPage(pdf);
  }*/
  pdf.setFontType('normal');
  fileNum = (((Math.random() * 100)*100)/100).toFixed(2);
  if(as4OrderNum != 0){
    pdf.output('save',as4OrderNum + ".pdf");  
  }else{
    pdf.output('save',jobNumber.trim() + ".pdf");
  } 
  //pdf.output('dataurlnewwindow');
  pdfData = pdf.output();
  pdfDataBlob = pdf.output("blob");
  pdfFileNum = jobNumber.trim();
  var fd2 = new FormData();
  fd2.append('uploadPdf',pdfDataBlob);
  fd2.append('fileNum',pdfFileNum);

  $.ajax({
    url:"uploadPdf.php",
    type: "POST",
    data: fd2,
    async:false,
    processData:false,
    contentType: false,
    success:function(e){
      console.log(e);
    }    
  });
  $('#makePdf').blur();
  $('#glassPdfCancel').click();
}

function newPageHandF(pdf){
  pdf.addPage();
  thisPage++;
  //pdf.rect(13,17,115,.5,'F');
  pdf.rect(5,6,206,23);
  pdf.addImage(headerImg,'PNG',5,7.5,110,20);
  pdf.setFont('Arial');
  pdf.setFontSize(14);
  //pdf.text(40,17,'CASCO INDUSTRIES, INC.');
  pdf.setFontSize(9.5);
  pdf.setFontType('italic');
  //pdf.text(40.5,22,'Quality Building Products Since 1960');
  pdf.setFontSize(9);
  pdf.setFontType('normal');
  //pdf.addFont('verdana','verdana','normal');
  //pdf.setFont("verdana");
  pdf.setFont('Arial');
  pdf.setFontType('normal');
  /*pdf.setFontSize(10);
  pdf.text(34,12,'CASCO');
  pdf.text(34,17,'INDUSTRIES');
  pdf.text(34,22,'INC.')
  pdf.setFontSize(10);*/
  //pdf.text(55,25,'Quality Building Products Since 1960');
  pdf.setFontSize(9);
  /*pdf.text(65,15.5,'Created By: ' + jobPrepared);
  pdf.text(65,19.5,'Company: ');
  pdf.text(108,15.5,'Created On: ' + jobDate);
  pdf.text(108,19.5,'Expires On: ');
  pdf.text(151,15.5,'Ordered On: Not Ordered');
  pdf.text(151,19.5,'PO #: ' + jobPoId);
  */
  expireDate2 = new Date(Date.parse(jobDate1) + thirtyOneDaysInMill);
  var d = new Date(expireDate2);
  var mm = d.getMonth()+1;
  var dd = d.getDate();
  if(dd<10){
    dd='0'+dd;
  } 
  if(mm<10){
    mm='0'+mm;
  }
  pdf.text(115,16.5,'Created By: ' + jobPrepared);
  pdf.text(115,11.5,'Company: ' + jobClientName);
  pdf.text(162,16.5,'Created On: ' + cMM+'-'+cDD+'-'+createOnDate.getFullYear());
  pdf.text(162,21.5,'Expires On: ' + mm+'-'+dd+'-'+d.getFullYear());
  pdf.text(115,21.5,'Ordered On: ' + orderedOn);
  pdf.text(162,26.5,'PO #: ' + jobPoId);
  if(as4OrderNum == 0){
    pdf.text(115,26.5,'Quote #: ' + jobNumber);
  }else{
    pdf.text(115,26.5,'Order #: ' + as4OrderNum);
  }
  pdf.rect(8,266,200,.5,'F');
  pdf.text(10,272,'www.cascoonline.com');
  pdf.text(66,272,cascoAddress);
  pdf.text(183,272,'PAGE '+thisPage);
}//end pdf 
$('[name="intPrimeName"]').change(function(){
  if($('#'+ww+'intPrime option:selected').val() == 'PrimePaint'){
    $('#'+ww+'interiorPaintPrime').toggle();
  }else{
    if($('#'+ww+'interiorPaintPrime').is(':visible')){
      $('#'+ww+'interiorPaintPrime').toggle();
    }
  } 
});
$('[name="intPaintColorName"]').change(function(){
  if($('#'+ww+'intPaintColor option:selected').val() == 'Custom'){
    $('#'+ww+'customIntPaint').toggle();
  }else{
    if($('#'+ww+'customIntPaint').is(':visible')){
      $('#'+ww+'customIntPaint').toggle();
    }
  }
});
$('[name="glassTempName"]').change(function(){
  if($('#'+ww+'temperedSash').is(':hidden')){
    $('#'+ww+'temperedSash').toggle();
    $('[name="tempSashLoc"]').prop('checked',false);
  }else if($('#'+ww+'temperedSash').is(':visible')){
    bothTemp = 0;
    $('#'+ww+'temperedSash').toggle();
    ctx.clearRect(0,c.height/2+2,c.width,c.height/2-2);
    ctx.clearRect(0,0,c.width,c.height/2-2);
    $('#'+ww+'grillePattern').change();
  }
});
$('#startQuote0').click(function(){ 
  var panel = '#bidInfoPanel';
  changeImage('bidInfoCollapse');
  $(panel).find("#spanBidInfo").addClass('panel-collapsed');
  if($(panel).find('i').hasClass('glyphicon-chevron-up')){
    $(panel).find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
  }else if($(panel).find('i').hasClass('glyphicon-chevron-down')){
    $(panel).find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
  }
  if($('#startQuote').is(':hidden')){
    changeImage('jobSiteInfoCollapse');
    $('#jobSiteInfoPanel').find('#spanJobSite').removeClass('panel-collapsed');
  if($('#jobSiteInfoPanel').find('i').hasClass('glyphicon-chevron-up')){
    $('#jobSiteInfoPanel').find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
  }else if($(panel).find('i').hasClass('glyphicon-chevron-down')){
    $('#jobSiteInfoPanel').find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
  }
 }
});
document.getElementById('startQuote1').onclick= function(){
  var panel = '#jobSiteInfoPanel';
  changeImage('jobSiteInfoCollapse');
  $(panel).find("#spanJobSite").addClass('panel-collapsed');
  if($(panel).find('i').hasClass('glyphicon-chevron-up')){
    $(panel).find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
  }else if($(panel).find('i').hasClass('glyphicon-chevron-down')){
    $(panel).find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
  }
  if($('#startQuote').is(':hidden')){
    changeImage('shipToInfoCollapse');
    $('#shipToInfoPanel').find('#spanShipTo').removeClass('panel-collapsed');
  if($('#shipToInfoPanel').find('i').hasClass('glyphicon-chevron-up')){
    $('#shipToInfoPanel').find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
  }else if($(panel).find('i').hasClass('glyphicon-chevron-down')){
    $('#shipToInfoPanel').find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
  }
 }
 if($('#stateJobS').val()!="" && $('#stateJobS').val().length > 2){
    $('#stateJobS').val(state_abbr[$('#stateJobS').val()]);
  }
};
$('#startQuote').click(function(){
  document.getElementById('editHeader').innerHTML='Edit Customer Information';
  $('#stickySidebar').show();
  if($('#stateShipTo').val()!="" && $('#stateShipTo').val().length > 2){
    $('#stateShipTo').val(state_abbr[$('#stateShipTo').val()]);
  }
  if(editNum == 1){
    newQuote = 1;
  }
  checkCustom = 0;
  checkExtColor = 0;
  checkGrilleColor = 0;
  checkGrilleSash = 0;  
  $('#transomPanel').hide();
  $('#doubleHungPanels').hide();
  $('#casementPanels').hide();
  $('#awningPanels').hide();
  $('#sliderPanels').hide();
  $('#doubleHungPicturePanels').hide();
  $('#windowCanvas').hide();
  $('#mainGlassDiv').hide();
  $('#glassButton').click();
  if(editNum == 1){ 
  }else{
    jobNumber = $('#jobNum').html().replace(/^\D+/g, "").trim();
  }
  //jobID = escapeHtml($('#jobIdInput').val());
  jobDate = $('#dateInput').val();
  jobPrepared = $('#preparedInput').val();
  jobPoId = $('#poIdInput').val();
  jobDesc = $('#descInput').val();
  jobClientId = $('#clientInput').val();
  jobClientName = $('#nameInput').val();
  jobAddress1 = $('#address1').val();
  jobAddress2 = $('#address2').val();
  jobAddress3 = $('#address3').val();
  jobCity = $('#city').val();
  jobState = $('#state').val();
  jobZip = $('#zipCode').val();
  jobContact = $('#contact').val();
  jobPhoneNumber = $('#phoneNumber').val();
  jobEmail = $('#eMail').val();
  jobFaxNumber = $('#faxNumber').val();
  jobSiteAddress1 = $('#address1JobS').val();
  jobSiteAddress2 = $('#address2JobS').val();
  jobSiteAddress3 = $('#address3JobS').val();
  jobSiteCity = $('#cityJobS').val();
  jobSiteState = $('#stateJobS').val();
  jobSiteZip = $('#zipCodeJobS').val();
  jobSiteContact = $('#contactJobS').val();
  jobSitePhone1 = $('#phoneNumberJobS').val();
  jobSitePhone2 = $('#altNumberNumber').val();
  jobSiteNotes = $('#notesJobS').val();
  shipToAddress1 = $('#address1ShipTo').val();
  shipToAddress2 = $('#address2ShipTo').val();
  shipToAddress3 = $('#address3ShipTo').val();
  shipToCity = $('#cityShipTo').val();
  shipToState = $('#stateShipTo').val();
  shipToZip = $('#zipCodeShipTo').val();
  shipToContact = $('#contactShipTo').val();
  shipToPhone = $('#phoneNumberShipTo').val();
  shipToNotes = $('#notesShipTo').val();
  if($('input[name="shipViaOpts"]:checked').val() == "option1"){
    pickOrShipArr = "PICK-UP";
  }else{
    pickOrShipArr = "DELIVERY";
  }
  enable('sideBarPrint');
  if($('#topHalf').is(':hidden')){
    $('#topHalf').show(); 
  }
  if($('#custInfoDiv').is(':visible')){
      $('#custInfoDiv').hide();
  }
  quoteNum = '000000';
  if(saveWin == 1){
    saveQuote(jobNumber,jobDate,jobClientName,jobPrepared,quoteNum,quoteTotal,jobPoId,jobClientId,jobAddress1,jobAddress2,jobAddress3,jsonGlassString,jobCity,jobState,jobZip,jobContact,jobPhoneNumber,jobFaxNumber,jobEmail,jobSiteAddress1,jobSiteAddress2,jobSiteAddress3,jobSiteCity,jobSiteState,jobSiteZip,jobSiteContact,jobSitePhone1,jobSitePhone2,jobSiteNotes,shipToAddress1,shipToAddress2,shipToAddress3,shipToCity,shipToState,shipToZip,shipToContact,shipToPhone,shipToNotes,pickOrShipArr,jobID,qmarkup,qmulti,newQuote,additionalArray,'configure');
  }else{
    saveQuote(jobNumber,jobDate,jobClientName,jobPrepared,quoteNum,quoteTotal,jobPoId,jobClientId,jobAddress1,jobAddress2,jobAddress3,'',jobCity,jobState,jobZip,jobContact,jobPhoneNumber,jobFaxNumber,jobEmail,jobSiteAddress1,jobSiteAddress2,jobSiteAddress3,jobSiteCity,jobSiteState,jobSiteZip,jobSiteContact,jobSitePhone1,jobSitePhone2,jobSiteNotes,shipToAddress1,shipToAddress2,shipToAddress3,shipToCity,shipToState,shipToZip,shipToContact,shipToPhone,shipToNotes,pickOrShipArr,jobID,qmarkup,qmulti,newQuote,additionalArray,'configure');
  }
  saveWin = 0;
});
$('#orderConfirmPO').val(jobPoId);
$('#searchCustomers').focus(function(){
   $(this).blur();
});
$('#quotesButton').focus(function(){
   $(this).blur();
});
$(function(){
  $(".dropdown-hover").hover(            
    function(){
      //$('.dropdown-menu', this).stop( true, true ).fadeIn("slow");
      $(this).toggleClass('open');
      $('b', this).toggleClass("caret caret-up");                
    },
    function(){
      //$('.dropdown-menu', this).stop( true, true ).fadeOut("slow");
      $(this).toggleClass('open');
      $('b', this).toggleClass("caret caret-up");                
    });
});
$(document).ready(function(){
    (function($){
    $('#filter').keyup(function(){
      var rex = new RegExp($(this).val(), 'i');
      $('.searchable tr').hide();
      $('.searchable tr').filter(function(){
        return rex.test($(this).text());
      }).show();
    })
  }(jQuery));
    (function($){
    $('#filter2').keyup(function(){
      var rex = new RegExp($(this).val(), 'i');
      $('.searchable tr').hide();
      $('.searchable tr').filter(function(){
        return rex.test($(this).text());
      }).show();
    })
  }(jQuery));
});
function getDate1(){
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0!
  var yyyy = today.getFullYear();
  if(dd<10){
      dd='0'+dd;
  } 
  if(mm<10){
      mm='0'+mm;
  } 
  today = yyyy+"-"+mm+"-"+dd;
  return today;
}
function getDate2(){
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0!
  var yyyy = today.getFullYear();
  if(dd<10){
    d='0'+dd;
  } 
  if(mm<10){
    mm='0'+mm;
  } 
  today = mm+"/"+dd+"/"+yyyy;
  return today;
}
$('#dateInput').val(getDate1());
var jobDate1 = $('#dateInput').val();
$('#dateTopBar').html("<strong>"+getDate2()+"</strong>");
$('[name="dimsWName"]').change(function(){
  getRoughOpening();
  $('#abvCallout').html('<strong>Callout:</strong> '+ww2+ $('#'+ww+'dimsW option:selected').val()+$('#'+ww+'dimsH option:selected').val()+'-' +$('#'+ww+'installMulls1 option:selected').text());
  $('#abvRoughOpen').html('<strong>Rough Opening:</strong> '+roughOpenWStr+ " X " +roughOpenHStr+'"');
  $('#abvUnitDim').html('<strong>Unit Dimension:</strong> ' + $('#'+ww+'dimsW option:selected').text().substring(5,$('#'+ww+'dimsH option:selected').text().length) +" X " + 
  ($('#'+ww+'dimsH option:selected').text().substring(5,$('#'+ww+'dimsH option:selected').text().length)));
  var c = document.getElementById("myCanvas0");
  var ctx = c.getContext("2d");
  if(ww==""){
    var windowWidth = +$('#'+ww+'dimsW option:selected').val() + (47/8) - (1/2);
  }else{
    var windowWidth = +$('#'+ww+'dimsW option:selected').val() + 5.0625;
  }
  windowWidth *= 5;
  $('#myCanvas0').attr('width', windowWidth);
     var c1 = document.getElementById('heightCanvas');
     var ctx1 = c1.getContext('2d'); 
     c1.width = c1.width;
     c1.width = (+$('#myCanvas0').attr('width')+6);
     var str = $('#'+ww+'dimsW option:selected').text().substring(4);
     ctx1.font = "16px Helvetica";
     ctx1.fillText(str,c1.width/4,30);
     ctx1.lineWidth = 2;
     ctx1.moveTo(12.5,c1.height/4);
     ctx1.lineTo(c1.width-12.5,c1.height/4);
     ctx1.stroke();
     var path1 = new Path2D();
     path1.moveTo(0,c1.height/4);
     path1.lineTo(12.5,0);
     path1.lineTo(12.5,c1.height/2);
     ctx1.fill(path1);
     var path12 = new Path2D();
     path12.moveTo(c1.width,c1.height/4);
     path12.lineTo(c1.width-12.5,0);
     path12.lineTo(c1.width-12.5,c1.height/2);
     ctx1.fill(path12);
  ctx.lineWidth=3;
  ctx.moveTo(0,c.height/2);
  ctx.lineTo(c.width,c.height/2);
  ctx.stroke();
  $('#multiWidth').text('Width: ' +$('#'+ww+'dimsW option:selected').text().substring(4));
  $('#'+ww+'installMulls1').change();
});
$('[name="dimsHName"]').change(function(){
  getRoughOpening();
  $('#abvCallout').html('<strong>Callout:</strong> '+ww2+ $('#'+ww+'dimsW option:selected').val()+$('#'+ww+'dimsH option:selected').val()+'-' +$('#'+ww+'installMulls1 option:selected').text());
  $('#abvRoughOpen').html('<strong>Rough Opening:</strong> '+roughOpenWStr+ " X " +roughOpenHStr+'"');
  $('#abvUnitDim').html('<strong>Unit Dimension:</strong> ' + $('#'+ww+'dimsW option:selected').text().substring(5,$('#'+ww+'dimsW option:selected').text().length) +" X " + 
  ($('#'+ww+'dimsH option:selected').text().substring(5,$('#'+ww+'dimsH option:selected').text().length)));
  var c = document.getElementById("myCanvas0");
  var ctx = c.getContext("2d");
  if(ww==""){
      var windowHeight = (2*$('#'+ww+'dimsH option:selected').val() + 9) - (13/16);
  }else{
      var windowHeight = +$('#'+ww+'dimsH option:selected').val() + 5.0625;
  }
  windowHeight *= 5;
  $('#myCanvas0').attr('height', windowHeight);
  var c0 = document.getElementById('widthCanvas');
  var ctx0 = c0.getContext('2d');
     var str = $('#'+ww+'dimsH option:selected').text().substring(4);
     c0.width=c0.width;
     c0.height = (+$('#myCanvas0').attr('height')+6);
     ctx0.font = "16px Helvetica";
     ctx0.lineWidth = 2;
     ctx0.moveTo(c0.width/2,12.5);
     ctx0.lineTo(c0.width/2,c0.height-12.5);
     ctx0.stroke();
     var path0 = new Path2D();
     path0.moveTo(0,12.5);
     path0.lineTo(c0.width/2,0);
     path0.lineTo(c0.width,12.5);      
     ctx0.fill(path0);
     var path01 = new Path2D();
     path01.moveTo(0,c0.height-12.5);
     path01.lineTo(c0.width/2,c0.height);
     path01.lineTo(c0.width,c0.height-12.5);      
     ctx0.fill(path01);
  ctx.lineWidth=3;
  ctx.moveTo(0,c.height/2);
  ctx.lineTo(c.width,c.height/2);
  ctx.stroke();
   var can = document.getElementById('heightLabel');
   var con = can.getContext('2d');
   can.width = can.width;
   can.height = (+$('#myCanvas0').attr('height')+6);
   var str = $('#'+ww+'dimsH option:selected').text().substring(4);
   con.font = "16px Helvetica";
   con.rotate(Math.PI/2);
   con.fillText(str,can.height/3,0);
  $('#multiHeight').text('Height: ' +$('#'+ww+'dimsH option:selected').text().substring(4));
  $('#'+ww+'installMulls1').change();
});
$('[name="grillePatternName"]').change(function(){
  if($('#'+ww+'installMulls1 option:selected').text() == 1){
   c.width=c.width;
   ctx.lineWidth=3;
   ctx.moveTo(0,c.height/2);
   ctx.lineTo(c.width,c.height/2);
   ctx.stroke();
   if(bothTemp == 1){
     ctx.font = "30px Arial";
     ctx.fillText('T', c.width-50, c.height/2 - 30);
     ctx.fillText('T', c.width-50, c.height - 30);
   }
   if(bothTemp == 2){
     ctx.font = "30px Arial";
     ctx.fillText('T', c.width-50, c.height/2-30);
   }
   if(bothTemp == 3){
     ctx.font = "30px Arial";
     ctx.fillText('T',c.width-50,c.height -30);
   }
  if($('#'+ww+'grillePattern option:selected').val() == 'standardColonial'){
     if($('#'+ww+'dimsW option:selected').val() <= 20){
         ctx.lineWidth =1;
         ctx.moveTo(c.width/2,0);
         ctx.lineTo(c.width/2,c.height);
       if($('#'+ww+'dimsH option:selected').val() <=28){
         ctx.moveTo(0,c.height/4);
         ctx.lineTo(c.width,c.height/4);
         ctx.moveTo(0,3*c.height/4);
         ctx.lineTo(c.width,3*c.height/4);
       }else if($('#'+ww+'dimsH option:selected').val() > 28){
         ctx.moveTo(0,c.height/6);
         ctx.lineTo(c.width,c.height/6);
         ctx.moveTo(0,c.height/3);
         ctx.lineTo(c.width,c.height/3);
         ctx.moveTo(0,2*c.height/3);
         ctx.lineTo(c.width,2*c.height/3);
         ctx.moveTo(0,5*c.height/6);
         ctx.lineTo(c.width,5*c.height/6);
       }
         ctx.stroke();
     }else if($('#'+ww+'dimsW option:selected').val() > 20 && $('#'+ww+'dimsW option:selected').val() <= 32){
         ctx.lineWidth =1;
         ctx.moveTo(c.width/3,0);
         ctx.lineTo(c.width/3,c.height);         
         ctx.moveTo(2*c.width/3,0);
         ctx.lineTo(2*c.width/3,c.height);
         
         if($('#'+ww+'dimsH option:selected').val() <=28){
          ctx.moveTo(0,c.height/4);
          ctx.lineTo(c.width,c.height/4);
          ctx.moveTo(0,3*c.height/4);
          ctx.lineTo(c.width,3*c.height/4);
         }else if($('#'+ww+'dimsH option:selected').val() > 28){
          ctx.moveTo(0,c.height/6);
          ctx.lineTo(c.width,c.height/6);
          ctx.moveTo(0,c.height/3);
          ctx.lineTo(c.width,c.height/3);
          ctx.moveTo(0,2*c.height/3);
          ctx.lineTo(c.width,2*c.height/3);
          ctx.moveTo(0,5*c.height/6);
          ctx.lineTo(c.width,5*c.height/6);
         }
         ctx.stroke();
     }else if($('#'+ww+'dimsW option:selected').val() > 32){
         ctx.lineWidth = 1;
         ctx.moveTo(c.width/4,0);
         ctx.lineTo(c.width/4,c.height);
         ctx.moveTo(c.width/2,0);
         ctx.lineTo(c.width/2,c.height);
         ctx.moveTo(3*c.width/4,0);
         ctx.lineTo(3*c.width/4,c.height);
         if($('#'+ww+'dimsH option:selected').val() <=28){
          ctx.moveTo(0,c.height/4);
          ctx.lineTo(c.width,c.height/4);
          ctx.moveTo(0,3*c.height/4);
          ctx.lineTo(c.width,3*c.height/4);
         }else if($('#'+ww+'dimsH option:selected').val() > 28){
          ctx.moveTo(0,c.height/6);
          ctx.lineTo(c.width,c.height/6);
          ctx.moveTo(0,c.height/3);
          ctx.lineTo(c.width,c.height/3);
          ctx.moveTo(0,2*c.height/3);
          ctx.lineTo(c.width,2*c.height/3);
          ctx.moveTo(0,5*c.height/6);
          ctx.lineTo(c.width,5*c.height/6);
         }
         ctx.stroke();
     }     
   }else if($('#'+ww+'grillePattern option:selected').val() == 'standardPrairie6'){
         ctx.lineWidth = 1;
         ctx.moveTo(0,20);
         ctx.lineTo(c.width,20);
         ctx.moveTo(20,0)
         ctx.lineTo(20,c.height);
         ctx.moveTo(c.width-20,0);
         ctx.lineTo(c.width-20,c.height);
         ctx.moveTo(0,c.height-20);
         ctx.lineTo(c.width,c.height-20);
         ctx.stroke();
   }else if($('#'+ww+'grillePattern option:selected').val() == 'standardPrairie9'){
         ctx.lineWidth = 1;
         ctx.moveTo(0,20);
         ctx.lineTo(c.width,20);
         ctx.moveTo(20,0)
         ctx.lineTo(20,c.height);
         ctx.moveTo(c.width-20,0);
         ctx.lineTo(c.width-20,c.height);
         ctx.moveTo(0,c.height/2-20);
         ctx.lineTo(c.width,c.height/2-20);
         ctx.moveTo(0,c.height-20);
         ctx.lineTo(c.width,c.height-20);
         ctx.moveTo(0,c.height/2+20);
         ctx.lineTo(c.width,c.height/2+20);
         ctx.stroke();
         
   }else if($('#'+ww+'grillePattern option:selected').val() == 'artsCraft'){
        ctx.lineWidth = 1;
        if($('#dimsW option:selected').val() <= 20){
         ctx.lineWidth =1;
         ctx.moveTo(c.width/2,0);
         ctx.lineTo(c.width/2,c.height/2);
         ctx.stroke();
        }else if($('#'+ww+'dimsW option:selected').val() > 20 && $('#dimsW option:selected').val() <= 32){
         ctx.lineWidth =1;
         ctx.moveTo(c.width/3,0);
         ctx.lineTo(c.width/3,c.height/2);         
         ctx.moveTo(2*c.width/3,0);
         ctx.lineTo(2*c.width/3,c.height/2);
         ctx.stroke();
        }else if($('#'+ww+'dimsW option:selected').val() > 32){
         ctx.lineWidth = 1;
         ctx.moveTo(c.width/4,0);
         ctx.lineTo(c.width/4,c.height/2);
         ctx.moveTo(c.width/2,0);
         ctx.lineTo(c.width/2,c.height/2);
         ctx.moveTo(3*c.width/4,0);
         ctx.lineTo(3*c.width/4,c.height/2);
         ctx.stroke();
        }
   }
   if($('#'+ww+'grilleSash option:selected').val() == 'Bottom'){
     ctx.clearRect(0,0,c.width,c.height/2-1);
     if(bothTemp == 2){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
     }else if(bothTemp == 1){
        ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
       ctx.fillText('T', c.width-50, c.height - 30);
     }else if(bothTemp == 3){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height - 30);
     }
   }else if($('#'+ww+'grilleSash option:selected').val() == 'Top'){
     ctx.clearRect(0,c.height/2+1,c.width,c.height/2-1);
     if(bothTemp == 2){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
     }else if(bothTemp == 1){
        ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
       ctx.fillText('T', c.width-50, c.height - 30);
     }else if(bothTemp == 3){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height - 30);
     }
   }
 }else{
   $('.newCanvas').each(function(i,obj){
    var c = obj;
    var ctx = c.getContext("2d");
    c.width=c.width;
   ctx.lineWidth=3;
   ctx.moveTo(0,c.height/2);
   ctx.lineTo(c.width,c.height/2);
   ctx.stroke();
   if(bothTemp == 1){
     ctx.font = "30px Arial";
     ctx.fillText('T', c.width-50, c.height/2 - 30);
     ctx.fillText('T', c.width-50, c.height - 30);
   }
   if(bothTemp == 2){
     ctx.font = "30px Arial";
     ctx.fillText('T', c.width-50, c.height/2-30);
   }
   if(bothTemp == 3){
     ctx.font = "30px Arial";
     ctx.fillText('T',c.width-50,c.height -30);
   }
  if($('#'+ww+'grillePattern option:selected').val() == 'standardColonial'){
     if($('#'+ww+'dimsW option:selected').val() <= 20){
         ctx.lineWidth =1;
         ctx.moveTo(c.width/2,0);
         ctx.lineTo(c.width/2,c.height);
       if($('#'+ww+'dimsH option:selected').val() <=28){
         ctx.moveTo(0,c.height/4);
         ctx.lineTo(c.width,c.height/4);
         ctx.moveTo(0,3*c.height/4);
         ctx.lineTo(c.width,3*c.height/4);
       }else if($('#'+ww+'dimsH option:selected').val() > 28){
         ctx.moveTo(0,c.height/6);
         ctx.lineTo(c.width,c.height/6);
         ctx.moveTo(0,c.height/3);
         ctx.lineTo(c.width,c.height/3);
         ctx.moveTo(0,2*c.height/3);
         ctx.lineTo(c.width,2*c.height/3);
         ctx.moveTo(0,5*c.height/6);
         ctx.lineTo(c.width,5*c.height/6);
       }
         ctx.stroke();
     }else if($('#'+ww+'dimsW option:selected').val() > 20 && $('#'+ww+'dimsW option:selected').val() <= 32){
         ctx.lineWidth =1;
         ctx.moveTo(c.width/3,0);
         ctx.lineTo(c.width/3,c.height);         
         ctx.moveTo(2*c.width/3,0);
         ctx.lineTo(2*c.width/3,c.height);
         
         if($('#'+ww+'dimsH option:selected').val() <=28){
          ctx.moveTo(0,c.height/4);
          ctx.lineTo(c.width,c.height/4);
          ctx.moveTo(0,3*c.height/4);
          ctx.lineTo(c.width,3*c.height/4);
         }else if($('#'+ww+'dimsH option:selected').val() > 28){
          ctx.moveTo(0,c.height/6);
          ctx.lineTo(c.width,c.height/6);
          ctx.moveTo(0,c.height/3);
          ctx.lineTo(c.width,c.height/3);
          ctx.moveTo(0,2*c.height/3);
          ctx.lineTo(c.width,2*c.height/3);
          ctx.moveTo(0,5*c.height/6);
          ctx.lineTo(c.width,5*c.height/6);
         }
         ctx.stroke();
     }else if($('#'+ww+'dimsW option:selected').val() > 32){
         ctx.lineWidth = 1;
         ctx.moveTo(c.width/4,0);
         ctx.lineTo(c.width/4,c.height);
         ctx.moveTo(c.width/2,0);
         ctx.lineTo(c.width/2,c.height);
         ctx.moveTo(3*c.width/4,0);
         ctx.lineTo(3*c.width/4,c.height);
         if($('#'+ww+'dimsH option:selected').val() <=28){
          ctx.moveTo(0,c.height/4);
          ctx.lineTo(c.width,c.height/4);
          ctx.moveTo(0,3*c.height/4);
          ctx.lineTo(c.width,3*c.height/4);
         }else if($('#'+ww+'dimsH option:selected').val() > 28){
          ctx.moveTo(0,c.height/6);
          ctx.lineTo(c.width,c.height/6);
          ctx.moveTo(0,c.height/3);
          ctx.lineTo(c.width,c.height/3);
          ctx.moveTo(0,2*c.height/3);
          ctx.lineTo(c.width,2*c.height/3);
          ctx.moveTo(0,5*c.height/6);
          ctx.lineTo(c.width,5*c.height/6);
         }
         ctx.stroke();
     }     
   }else if($('#'+ww+'grillePattern option:selected').val() == 'standardPrairie6'){
         ctx.lineWidth = 1;
         ctx.moveTo(0,20);
         ctx.lineTo(c.width,20);
         ctx.moveTo(20,0)
         ctx.lineTo(20,c.height);
         ctx.moveTo(c.width-20,0);
         ctx.lineTo(c.width-20,c.height);
         ctx.moveTo(0,c.height-20);
         ctx.lineTo(c.width,c.height-20);
         ctx.stroke();
   }else if($('#'+ww+'grillePattern option:selected').val() == 'standardPrairie9'){
         ctx.lineWidth = 1;
         ctx.moveTo(0,20);
         ctx.lineTo(c.width,20);
         ctx.moveTo(20,0)
         ctx.lineTo(20,c.height);
         ctx.moveTo(c.width-20,0);
         ctx.lineTo(c.width-20,c.height);
         ctx.moveTo(0,c.height/2-20);
         ctx.lineTo(c.width,c.height/2-20);
         ctx.moveTo(0,c.height-20);
         ctx.lineTo(c.width,c.height-20);
         ctx.moveTo(0,c.height/2+20);
         ctx.lineTo(c.width,c.height/2+20);
         ctx.stroke();
         
   }else if($('#'+ww+'grillePattern option:selected').val() == 'artsCraft'){
        ctx.lineWidth = 1;
        if($('#'+ww+'dimsW option:selected').val() <= 20){
         ctx.lineWidth =1;
         ctx.moveTo(c.width/2,0);
         ctx.lineTo(c.width/2,c.height);
         ctx.stroke();
        }else if($('#'+ww+'dimsW option:selected').val() > 20 && $('#dimsW option:selected').val() <= 32){
         ctx.lineWidth =1;
         ctx.moveTo(c.width/3,0);
         ctx.lineTo(c.width/3,c.height);         
         ctx.moveTo(2*c.width/3,0);
         ctx.lineTo(2*c.width/3,c.height);
         ctx.stroke();
        }else if($('#'+ww+'dimsW option:selected').val() > 32){
         ctx.lineWidth = 1;
         ctx.moveTo(c.width/4,0);
         ctx.lineTo(c.width/4,c.height);
         ctx.moveTo(c.width/2,0);
         ctx.lineTo(c.width/2,c.height);
         ctx.moveTo(3*c.width/4,0);
         ctx.lineTo(3*c.width/4,c.height);
         ctx.stroke();
        }
   }
   if($('#'+ww+'grilleSash option:selected').val() == 'Bottom'){
     ctx.clearRect(0,0,c.width,c.height/2-1);
     if(bothTemp == 2){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
     }else if(bothTemp == 1){
        ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
       ctx.fillText('T', c.width-50, c.height - 30);
     }else if(bothTemp == 3){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height - 30);
     }
   }else if($('#'+ww+'grilleSash option:selected').val() == 'Top'){
     ctx.clearRect(0,c.height/2+1,c.width,c.height/2-1);
     if(bothTemp == 2){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
     }else if(bothTemp == 1){
        ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
       ctx.fillText('T', c.width-50, c.height - 30);
     }else if(bothTemp == 3){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height - 30);
     }
   }
    });
}
});
$('[name="grilleSashName"]').change(function(){
   if($('#'+ww+'grilleSash option:selected').val() == 'Bottom'){
    if($('#'+ww+'custColonialGrilleDiv').is(':hidden')){
     $('#'+ww+'grillePattern').trigger('change');
    }else{
      $('#'+ww+'custColoWide').keydown();
     }
     ctx.clearRect(0,0,c.width,c.height/2-1);
     if(bothTemp == 3){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height - 30);
     }
     else if(bothTemp == 2){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
       }
     else if(bothTemp == 1){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
       ctx.fillText('T', c.width-50, c.height - 30);
     }
   }else if($('#'+ww+'grilleSash option:selected').val() == 'Top'){
    if($('#'+ww+'custColonialGrilleDiv').is(':hidden')){
     $('#'+ww+'grillePattern').trigger('change');
    }else{
     $('#'+ww+'custColoWide').keydown();
    }
     ctx.clearRect(0,c.height/2+1,c.width,c.height/2-1);
     if(bothTemp == 2){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
       }
     else if(bothTemp == 3){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height - 30);
     }
     else if(bothTemp == 1){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
       ctx.fillText('T', c.width-50, c.height - 30);
     }
   }else{
    if($('#'+ww+'custColonialGrilleDiv').is(':hidden')){
     $('#'+ww+'grillePattern').trigger('change');
    }else{
     $('#'+ww+'custColoWide').keydown();
    }
   }
});
//window.onbeforeunload = function(){ return 'All UNSAVED CHANGES WILL BE LOST.' }
$('[name="dimsWName"]').change(function(){
    if($('#'+ww+'topSashTemp').is(':checked')){
     bothTemp = 2;
    $('#'+ww+'grillePattern').change();
     ctx.font = "30px Arial";
     if(bothTemp == 3){
       ctx.clearRect(0,c.height/2+1,c.width,c.height/2-1);
       ctx.fillText('T', c.width-50, c.height/2 - 30);
     }
     
     
     
    }else if($('#'+ww+'botSashTemp').is(':checked')){
     bothTemp = 3;
    $('#'+ww+'grillePattern').change();
     ctx.font = "30px Arial";
     if(bothTemp == 2){
       ctx.clearRect(0,0,c.width,c.height/2-1);
       ctx.fillText('T', c.width-50, c.height - 30);   
     }
      
    }else if($('#'+ww+'bothSashTemp').is(':checked')){
     bothTemp = 1;
    $('#'+ww+'grillePattern').change();
     ctx.fillText('T', c.width-50, c.height/2 - 30);
     ctx.fillText('T', c.width-50, c.height - 30);
    }
});
function quantKeyDown(e){
   clearTimeout(timer); 
   timer = setTimeout(updateQuant('#quantText'+e),500)
   
}
$('[name="installMulls1Name"]').change(function(){
    if(ww == ""){
        $('#'+ww+'unit1Label').hide();
        $('#'+ww+'unit1Handing').hide();
        $('#'+ww+'unit2Label').hide();
        $('#'+ww+'unit2Handing').hide();
        $('#'+ww+'unit3Label').hide();
        $('#'+ww+'unit3Handing').hide();
        $('#'+ww+'unit4Label').hide();
        $('#'+ww+'unit4Handing').hide();
        $('#'+ww+'unit5Label').hide();
        $('#'+ww+'unit5Handing').hide();   
    }
 mullNum = $('#'+ww+'installMulls1 option:selected').text();
 var winWidth = $('#'+ww+'dimsW option:selected').val();
  if(mullNum == 1){
    $('#'+ww+'unit2Label').hide();
    $('#'+ww+'unit2Handing').hide();
    $('#'+ww+'unit3Label').hide();
    $('#'+ww+'unit3Handing').hide();
    $('#'+ww+'unit4Label').hide();
    $('#'+ww+'unit4Handing').hide();
    $('#'+ww+'unit5Label').hide();
    $('#'+ww+'unit5Handing').hide();
  }else if(mullNum == 2){
    if($('#'+ww+'unit2Label').is(':hidden') && ww == "cc"){
        $('#'+ww+'unit2Handing').val('right');
        $('#'+ww+'unit2Label').show();
        $('#'+ww+'unit2Handing').show();
    }else{
        $('#'+ww+'unit2Label').show();
        $('#'+ww+'unit2Handing').show();
    }
    
    $('#'+ww+'unit3Label').hide();
    $('#'+ww+'unit3Handing').hide();
    $('#'+ww+'unit4Label').hide();
    $('#'+ww+'unit4Handing').hide();
    $('#'+ww+'unit5Label').hide();
    $('#'+ww+'unit5Handing').hide();
  }else if (mullNum == 3){
    if($('#'+ww+'unit2Label').is(':hidden') && ww == "cc"){
        $('#'+ww+'unit2Handing').val('stationary');
        $('#'+ww+'unit2Label').show();
        $('#'+ww+'unit2Handing').show();
    }else{
        $('#'+ww+'unit2Label').show();
        $('#'+ww+'unit2Handing').show();
    }
    if($('#'+ww+'unit3Label').is(':hidden') && ww == "cc"){
        $('#'+ww+'unit3Handing').val('right');
        $('#'+ww+'unit3Label').show();
        $('#'+ww+'unit3Handing').show();
    }else{
        $('#'+ww+'unit3Label').show();
        $('#'+ww+'unit3Handing').show();
    }
    $('#'+ww+'unit4Label').hide();
    $('#'+ww+'unit4Handing').hide();
    $('#'+ww+'unit5Label').hide();
    $('#'+ww+'unit5Handing').hide();
  }else if(mullNum == 4){
    if($('#'+ww+'unit2Label').is(':hidden') && ww == "cc"){
        $('#'+ww+'unit2Handing').val('stationary');
        $('#'+ww+'unit2Label').show();
        $('#'+ww+'unit2Handing').show();
    }else{
        $('#'+ww+'unit2Label').show();
        $('#'+ww+'unit2Handing').show();
    }
    if($('#'+ww+'unit3Label').is(':hidden') && ww == "cc"){
        $('#'+ww+'unit3Handing').val('stationary');
        $('#'+ww+'unit3Label').show();
        $('#'+ww+'unit3Handing').show();
    }else{
        $('#'+ww+'unit3Label').show();
        $('#'+ww+'unit3Handing').show();
    }
    if($('#'+ww+'unit4Label').is(':hidden') && ww == "cc"){
        $('#'+ww+'unit4Handing').val('right');
        $('#'+ww+'unit4Label').show();
        $('#'+ww+'unit4Handing').show();
    }else{
        $('#'+ww+'unit4Label').show();
        $('#'+ww+'unit4Handing').show();
    }
    $('#'+ww+'unit5Label').hide();
    $('#'+ww+'unit5Handing').hide();
  }else if(mullNum ==5){
    if($('#'+ww+'unit2Label').is(':hidden') && ww == "cc"){
        $('#'+ww+'unit2Handing').val('stationary');
        $('#'+ww+'unit2Label').show();
        $('#'+ww+'unit2Handing').show();
    }else{
        $('#'+ww+'unit2Label').show();
        $('#'+ww+'unit2Handing').show();
    }
    if($('#'+ww+'unit3Label').is(':hidden') && ww == "cc"){
        $('#'+ww+'unit3Handing').val('stationary');
        $('#'+ww+'unit3Label').show();
        $('#'+ww+'unit3Handing').show();
    }else{
        $('#'+ww+'unit3Label').show();
        $('#'+ww+'unit3Handing').show();
    }
    if($('#'+ww+'unit4Label').is(':hidden') && ww == "cc"){
        $('#'+ww+'unit4Handing').val('stationary');
        $('#'+ww+'unit4Label').show();
        $('#'+ww+'unit4Handing').show();
    }else{
        $('#'+ww+'unit4Label').show();
        $('#'+ww+'unit4Handing').show();
    }
    if(ww == "cc"){
      $('#'+ww+'unit5Handing').val('right');
    }  
    $('#'+ww+'unit5Label').show();
    $('#'+ww+'unit5Handing').show();
  }
  $('#'+ww+'installMulls2').change();
  if(mullNum > 1){
   $('#heightLabel').hide();
  }else{
   $('#heightLabel').show();
  }
 $('#'+ww+'custDimsRadio').change();
   $('.newCanvas').remove();
  if(mullNum > 1 || mullNum2 >1){
   $('#widthCanvas').hide();
   $('#heightCanvas').hide();
   $('#multiWindowDims').show();
   $('#multiWidth').text('Width: '+$('#'+ww+'dimsW option:selected').text().substring(4));
   $('#multiHeight').text('Height: ' +$('#'+ww+'dimsH option:selected').text().substring(4));
   for(i=1;i<=$('#'+ww+'installMulls1 option:selected').text();i++){
    var oldCanvas = document.getElementById('myCanvas0');
    var newCanvas = document.createElement('canvas');
    var context = newCanvas.getContext('2d');
    newCanvas.id = 'newCanvas'+i;
    if(mullNum < 3){
       if(winWidth > 32){
          newCanvas.width = oldCanvas.width/1.25;
       }else{
          newCanvas.width = oldCanvas.width;
       }
    }else if(mullNum == 3){
       switch (winWidth){
           case '16':
             newCanvas.width = oldCanvas.width;
             break;
           case '20':
             newCanvas.width = oldCanvas.width/1.1;
             break;
           case '24':
             newCanvas.width = oldCanvas.width/1.25;
             break;
           case '28':
             newCanvas.width = oldCanvas.width/1.4;
             break;
           case '32':
             newCanvas.width = oldCanvas.width/1.55;
             break;
           case '36':
             newCanvas.width = oldCanvas.width/1.7;
             break;
           case '40':
             newCanvas.width = oldCanvas.width/1.85;
             break;
       } 
    }else if(mullNum == 4){
       switch (winWidth){
           case '16':
             newCanvas.width = oldCanvas.width/1.1;
             break;
           case '20':
             newCanvas.width = oldCanvas.width/1.25;
             break;
           case '24':
             newCanvas.width = oldCanvas.width/1.4;
             break;
           case '28':
             newCanvas.width = oldCanvas.width/1.55;
             break;
           case '32':
             newCanvas.width = oldCanvas.width/1.7;
             break;
           case '36':
             newCanvas.width = oldCanvas.width/1.85;
             break;
           case '40':
             newCanvas.width = oldCanvas.width/2;
             break;
       } 
    }else if(mullNum == 5){
       switch (winWidth){
           case '16':
             newCanvas.width = oldCanvas.width/1.3;
             break;
           case '20':
             newCanvas.width = oldCanvas.width/1.4;
             break;
           case '24':
             newCanvas.width = oldCanvas.width/1.6;
             break;
           case '28':
             newCanvas.width = oldCanvas.width/1.9;
             break;
           case '32':
             newCanvas.width = oldCanvas.width/2.2;
             break;
           case '36':
             newCanvas.width = oldCanvas.width/2.5;
             break;
           case '40':
             newCanvas.width = oldCanvas.width/2.5;
             break;
       } 
    }
    if(ww=="ca"){
        newCanvas.height = oldCanvas.height * $('#'+ww+'installMulls2 option:selected').text();
    }
    document.getElementById('multiWindows').appendChild(newCanvas);
    $('#newCanvas'+i).attr('style','border:3px solid #000000;margin-right:0px;padding-left:0px;padding-right:0px;margin-left:0px;margin-top:10px;');
    $('#newCanvas'+i).attr('class','newCanvas');
   }
   $('#myCanvas0').hide();
   $('.newCanvas').each(function(i,obj){
    var c = obj;
    var ctx = c.getContext("2d");
    ctx.lineWidth=3;
    ctx.moveTo(0,c.height/2);
    ctx.lineTo(c.width,c.height/2);
    ctx.stroke();
    });
  }else{
    $('#myCanvas0').show();
    $('#widthCanvas').show();
    $('#heightCanvas').show();
    $('#multiWindowDims').hide();
  }
});
$('[name="installMulls2Name"]').change(function(){
    mullNum2 = $('#'+ww+'installMulls2 option:selected').text();
    if(mullNum2 > 1){
        if($('#'+ww+'extraHanding').is(':hidden')){
            $('#'+ww+'extraHanding').show();
        }
    }else{
        $('#'+ww+'extraHanding').hide();
    }    
    if(mullNum2 == 1){
        $('#'+ww+'unit4Label').hide();
        $('#'+ww+'unit4Handing').hide();
        $('#'+ww+'unit5Label').hide();
        $('#'+ww+'unit5Handing').hide();
        $('#'+ww+'unit6Label').hide();
        $('#'+ww+'unit6Handing').hide();
        $('#'+ww+'unit7Label').hide();
        $('#'+ww+'unit7Handing').hide();
        $('#'+ww+'unit8Label').hide();
        $('#'+ww+'unit8Handing').hide();
        $('#'+ww+'unit9Label').hide();
        $('#'+ww+'unit9Handing').hide();
  }else if(mullNum2 == 2){
    if(mullNum >= 1){
        if($('#'+ww+'unit4Label').is(':hidden')){
            
            $('#'+ww+'unit4Label').show();
            $('#'+ww+'unit4Handing').show();
        }
    }else{
            $('#'+ww+'unit4Label').hide();
            $('#'+ww+'unit4Handing').hide();
        }
    if(mullNum > 1){    
        if($('#'+ww+'unit5Label').is(':hidden')){
            
            $('#'+ww+'unit5Label').show();
            $('#'+ww+'unit5Handing').show();
        }
    }else{
            $('#'+ww+'unit5Label').hide();
            $('#'+ww+'unit5Handing').hide();
        }
    if(mullNum > 2){    
        if($('#'+ww+'unit6Label').is(':hidden')){
            
            $('#'+ww+'unit6Label').show();
            $('#'+ww+'unit6Handing').show();
        }
    }else{
            $('#'+ww+'unit6Label').hide();
            $('#'+ww+'unit6Handing').hide();
        }
    
    $('#'+ww+'unit7Label').hide();
    $('#'+ww+'unit7Handing').hide();
    $('#'+ww+'unit8Label').hide();
    $('#'+ww+'unit8Handing').hide();
    $('#'+ww+'unit9Label').hide();
    $('#'+ww+'unit9Handing').hide();
  }else if (mullNum2 == 3){
    if(mullNum >= 1){
        if($('#'+ww+'unit4Label').is(':hidden')){
            
            $('#'+ww+'unit4Label').show();
            $('#'+ww+'unit4Handing').show();
        }
    }else{
            $('#'+ww+'unit4Label').hide();
            $('#'+ww+'unit4Handing').hide();
        }
    if(mullNum > 1){    
        if($('#'+ww+'unit5Label').is(':hidden')){
           
            $('#'+ww+'unit5Label').show();
            $('#'+ww+'unit5Handing').show();
        }
    }else{
            $('#'+ww+'unit5Label').hide();
            $('#'+ww+'unit5Handing').hide();
        }
    if(mullNum > 2){    
        if($('#'+ww+'unit6Label').is(':hidden')){
            
            $('#'+ww+'unit6Label').show();
            $('#'+ww+'unit6Handing').show();
        }
    }else{
            $('#'+ww+'unit6Label').hide();
            $('#'+ww+'unit6Handing').hide();
        }
    if(mullNum >= 1){
        if($('#'+ww+'unit7Label').is(':hidden')){
            
            $('#'+ww+'unit7Label').show();
            $('#'+ww+'unit7Handing').show();
        }
    }else{
            $('#'+ww+'unit7Label').hide();
            $('#'+ww+'unit7Handing').hide();
    }
    if(mullNum > 1){    
        if($('#'+ww+'unit8Label').is(':hidden')){
           
            $('#'+ww+'unit8Label').show();
            $('#'+ww+'unit8Handing').show();
        }
    }else{
            $('#'+ww+'unit8Label').hide();
            $('#'+ww+'unit8Handing').hide();
        }
    if(mullNum > 2){    
        if($('#'+ww+'unit9Label').is(':hidden')){
           
            $('#'+ww+'unit9Label').show();
            $('#'+ww+'unit9Handing').show();
        }
    }else{
            $('#'+ww+'unit9Label').hide();
            $('#'+ww+'unit9Handing').hide();
        }
  }
});
$('#'+ww+'custColoWide').keydown(function(){
       clearTimeout(timer); 
       timer = setTimeout(upColonialWide,500);
});
$('#'+ww+'custColoHigh').keydown(function(){
       clearTimeout(timer);
       timer = setTimeout(upColonialWide,500);
});
function upColonialWide(){
var c;
var ctx;
 $('.newCanvas').each(function(i,obj){
    var c = obj;
    var ctx = c.getContext("2d");
    c.width=c.width;
    ctx.lineWidth= 3;
    ctx.moveTo(0,c.height/2);
    ctx.lineTo(c.width,c.height/2);
    ctx.stroke();
    });
 var mullNum = $('#'+ww+'installMulls1 option:selected').text(); 
 custUnitsWide = $('#'+ww+'custColoWide').val();
 custUnitsHigh = $('#'+ww+'custColoHigh').val();
 if(mullNum > 1){
   $('.newCanvas').each(function(i,obj){
    c = obj;
    ctx = c.getContext("2d");
    var liteWidth = c.width/custUnitsWide;
    ctx.lineWidth = 1;
    for(z=liteWidth;z<=c.width;z+=liteWidth){
     ctx.moveTo(z,0);
     ctx.lineTo(z,c.height);
    }
    var liteHeight = (c.height/2)/custUnitsHigh;
    for(z=liteHeight;z<=c.height;z+=liteHeight){
     ctx.moveTo(0,z);
     ctx.lineTo(c.width,z);
     }
     ctx.stroke();
    });
  }else{
    var c = document.getElementById("myCanvas0");
    var ctx = c.getContext("2d");
    c.width=c.width;
    var liteWidth = c.width/custUnitsWide;
    ctx.lineWidth = 3;
    ctx.moveTo(0,c.height/2);
    ctx.lineTo(c.width,c.height/2);
    ctx.stroke();
    ctx.lineWidth = 1;
    for(z=liteWidth;z<=c.width;z+=liteWidth){
     ctx.moveTo(z,0);
     ctx.lineTo(z,c.height);
    }
    var liteHeight = (c.height/2)/custUnitsHigh;
    for(z=liteHeight;z<=c.height;z+=liteHeight){
     ctx.moveTo(0,z);
     ctx.lineTo(c.width,z);
    }
     ctx.stroke();
  }   
  if(mullNum>1){
    $('.newCanvas').each(function(i,obj){
      var c = obj;
      var ctx = c.getContext("2d");
    if($('#'+ww+'grilleSash option:selected').val() == 'Bottom'){
     ctx.clearRect(0,0,c.width,c.height/2-1);
     /*if(bothTemp == 2){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
     }else if(bothTemp == 1){
        ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
       ctx.fillText('T', c.width-50, c.height - 30);
     }else if(bothTemp == 3){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height - 30);
     }*/
   }else if($('#'+ww+'grilleSash option:selected').val() == 'Top'){
     ctx.clearRect(0,c.height/2+1,c.width,c.height/2-1);
    /* if(bothTemp == 2){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
     }else if(bothTemp == 1){
        ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
       ctx.fillText('T', c.width-50, c.height - 30);
     }else if(bothTemp == 3){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height - 30);
     }*/
   }
  });
  }else{ 
   if($('#'+ww+'grilleSash option:selected').val() == 'Bottom'){
     ctx.clearRect(0,0,c.width,c.height/2-1);
   }else if($('#'+ww+'grilleSash option:selected').val() == 'Top'){
     ctx.clearRect(0,c.height/2+1,c.width,c.height/2-1);
   }
  }
  if(bothTemp == 2){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
  }else if(bothTemp == 1){
        ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height/2 - 30);
       ctx.fillText('T', c.width-50, c.height - 30);
  }else if(bothTemp == 3){
       ctx.font = "30px Arial";
       ctx.fillText('T', c.width-50, c.height - 30);
  }
}
$('[name="shipToRadioOptions"]').click(function(){
  if($('#shipToRadio1').is(':checked')){
       $('#address1ShipTo').val($('#address1').val());
       $('#address2ShipTo').val($('#address2').val());
       $('#address3ShipTo').val($('#address3').val());
       $('#cityShipTo').val($('#city').val());
       $('#stateShipTo').val($('#state').val());
       $('#zipCodeShipTo').val($('#zipCode').val());
       $('#contactShipTo').val($('#contact').val());
       $('#phoneNumberShipTo').val($('#phoneNumber').val());
  }else if($('#shipToRadio2').is(':checked')){
       $('#address1ShipTo').val($('#address1JobS').val());
       $('#address2ShipTo').val($('#address2JobS').val());
       $('#address3ShipTo').val($('#address3JobS').val());
       $('#cityShipTo').val($('#cityJobS').val());
       $('#stateShipTo').val($('#stateJobS').val());
       $('#zipCodeShipTo').val($('#zipCodeJobS').val());
       $('#contactShipTo').val($('#contactJobS').val());
       $('#phoneNumberShipTo').val($('#phoneNumberJobS').val());   
  }
});
function getRoughOpening(){
    if($('#'+ww+'custDimsInch').is(':checked')){
          if($('#'+ww+'custDimsInchs').is(':hidden')){
            if(ww==""){ 
                roughOpenW = ($('#'+ww+'dimsW option:selected').val() + (47/8)) * $('#'+ww+'installMulls1 option:selected').text() + ((.0625 * $('#'+ww+'installMulls1 option:selected').text()) - 1);
                roughOpenH = (2 * $('#'+ww+'dimsH option:selected').val() + 9);
                roughOpenWStr = Math.floor(roughOpenW/1) + ' ' + 8 * ((+roughOpenW%12)%1) + '/8"';
                roughOpenHStr = Math.floor(roughOpenH/1) + ' ' + 8 * ((+roughOpenH%12)%1) + '/8"';
            }else if(ww=="cc"){
                roughOpenW = ($('#'+ww+'dimsW option:selected').val() + (5.0625)) * $('#'+ww+'installMulls1 option:selected').text() + ((.0625 * $('#'+ww+'installMulls1 option:selected').text()) - 1);
                roughOpenH = ($('#'+ww+'dimsH option:selected').val() + 5.0625);
                roughOpenWStr = Math.floor(roughOpenW/1) + ' ' + 16 * ((+roughOpenW%12)%1) + '/16"';
                roughOpenHStr = Math.floor(roughOpenH/1) + ' ' + 16 * ((+roughOpenH%12)%1) + '/16"';
            }
        }
    }else if($('#'+ww+'custDimsFt').is(':checked')){
          if($('#'+ww+'ftInCustDims').is(':hidden')){
            if(ww==""){
                roughOpenWStr = Math.floor((((+$('#'+ww+'dimsW option:selected').val() + (47/8))*$('#'+ww+'installMulls1 option:selected').text() + ((.0625 * $('#'+ww+'installMulls1 option:selected').text()) - 1))*1)/(12)) + "'-" + Math.floor(+($('#'+ww+'dimsW option:selected').val() + (47/8))%12) + ' ' + 8 * ((+($('#'+ww+'dimsW option:selected').val() + (47/8))%12)%1) + '/8"';
                roughOpenHStr = Math.floor((2 * $('#'+ww+'dimsH option:selected').val() + 9)*1/12) + "'-" + Math.floor(+(2 * $('#'+ww+'dimsH option:selected').val() + 9)%12);
            }else if(ww=='cc'){
                roughOpenWStr = Math.floor((((+$('#'+ww+'dimsW option:selected').val() + (5.5625))*$('#'+ww+'installMulls1 option:selected').text() + ((.0625 * $('#'+ww+'installMulls1 option:selected').text()) - 1))*1)/(12)) + "'-" + Math.floor(+($('#'+ww+'dimsW option:selected').val() + (5.5625))%12) + ' ' + 16 * ((+($('#'+ww+'dimsW option:selected').val() + (5.5625))%12)%1) + '/16"';
                roughOpenHStr = Math.floor((((+$('#'+ww+'dimsH option:selected').val() + (5.5625))*$('#'+ww+'installMulls1 option:selected').text() + ((.0625 * $('#'+ww+'installMulls1 option:selected').text()) - 1))*1)/(12)) + "'-" + Math.floor(+($('#'+ww+'dimsH option:selected').val() + (5.5625))%12) + ' ' + 16 * ((+($('#'+ww+'dimsH option:selected').val() + (5.5625))%12)%1) + '/16"';
            }
          }else{
           roughOpenWStr = "ft w.i.p.";
           roughOpenHStr = "ft w.i.p.";
          }
        }
}
function escapeHtml(text){
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m){ return map[m]; });
}
$('#viewBlobButton').click(function(){
    $.post("getBlob.php",{jn: jobNumber},function(data){
        var arr = $.map(JSON.parse(data), function(vv){
            return vv;
        }); 
    for (var i = 0; i < arr.length; i++){
            alert(arr[i].id+" "+arr[i].width + " " + arr[i].height);
        };    
   });
});
function editQuoteRow(e){
if(newid > 0){
    deleteQuote = 0;
    for(var a=1;a<=newid;a++){
        $('#addr'+a).find('[name="del0"]').click();
    }
    newid = 0;
 }
 deleteQuote = 0;
 var jn = $(e).closest('tr').find('[name="job_number"]').text();
 jobNumber = jn;
 $.ajax({
    url:"editQuote.php",
    type: "POST",
    data:{jn: jn},
    async:false,
    success:function(data){
        quoteNum = data;
    }    
})
 
 $.ajax({
    url:"getBlob.php",
    type: "POST",
    data: {jn: jn},
    async: false,
    success: function(data){
        arr2 = $.map(JSON.parse(data), function(vvv){
            return vvv;
        });
    }
 })  
    $('#custInfoDiv').hide();
    $('#topHalf').show();
    var nextWindow = 0;
    $('#testLoadModal').modal({backdrop: 'static', keyboard: false});
        //waitingDialog.show("Loading...");
        var interval = setInterval(function(){
            if(nextWindow < arr2.length){
                    ww = arr2[nextWindow].cat;
                    if(ww==""){
                        $('#cdh').click();
                    }else if(ww=="cc"){
                        $('#casement').click();
                    }else if(ww=="ca"){
                        $('#awning').click();
                    }else if(ww=="cs"){
                        $('#slider').click();
                    }
                    $('#'+ww+'windowLabel').val(arr2[nextWindow].winLabel);
                    $('#'+ww+'hiddenWinQuant').val(arr2[nextWindow].quantity);
                    if(arr2[nextWindow].custDims == 1){
                        $('#'+ww+'customDimsButton').click();
                        $('#'+ww+'custDimWFt').val(arr2[nextWindow].custWFt);
                        $('#'+ww+'custDimWInch').val(arr2[nextWindow].custWIn);
                        $('#'+ww+'custDimHFt').val(arr2[nextWindow].custHFt);
                        $('#'+ww+'custDimHInch').val(arr2[nextWindow].custHIn);
                    }else{                    
                        $('#'+ww+'dimsW').val(arr2[nextWindow].width);
                        $('#'+ww+'dimsH').val(arr2[nextWindow].height);
                    }
                    $('#'+ww+'installMulls1').val(arr2[nextWindow].unitsWide);
                    $('#'+ww+'installBalances').val(arr2[nextWindow].balances);
                    if(arr2[nextWindow].hasExtEstate==true){
                        $('#'+ww+'extColorChoice').val('Estate');
                        $('#'+ww+'extColorChoice').change();
                        $('#'+ww+'extColorChoiceEstate').show();
                        $('#'+ww+'extColorChoiceEstate').val(arr2[nextWindow].exteriorColor);
                    }else{    
                        $('#'+ww+'extColorChoice').val(arr2[nextWindow].exteriorColor);
                    }
                    $('#'+ww+'glass1').val(arr2[nextWindow].glassType);
                    $('#'+ww+'glass2').val(arr2[nextWindow].glassObscure);
                    if(arr2[nextWindow].glass89 == 1){
                        $('#'+ww+'glass_i89').click();
                    }else{
                        $('#'+ww+'glass_i89').prop('checked',false);
                    }
                    if(arr2[nextWindow].glassTemper == true){
                    $('#'+ww+'glassTemp').prop('checked',true);
                        if(arr2[nextWindow].glassTemperLoc == 1){
                            $('#'+ww+'bothSashTemp').prop('checked',true);
                            $('#'+ww+'topSashTemp').prop('checked',false);
                            $('#'+ww+'botSashTemp').prop('checked',false);
                        }else if(arr2[nextWindow].glassTemperLoc == 2){
                            $('#'+ww+'topSashTemp').prop('checked',true);
                            $('#'+ww+'botSashTemp').prop('checked',false);
                            $('#'+ww+'bothSashTemp').prop('checked',false);
                        }else if(arr2[nextWindow].glassTemperLoc == 3){
                            $('#'+ww+'botSashTemp').prop('checked',true);
                            $('#'+ww+'bothSashTemp').prop('checked',false);
                            $('#'+ww+'topSashTemp').prop('checked',false);
                        }
                    }else{
                        $('#'+ww+'glassTemp').prop('checked',false);
                    }
                    $('#'+ww+'grillePattern').val(arr2[nextWindow].grillePat);
                    $('#'+ww+'grilleType').val(arr2[nextWindow].grilleType.replace("&quot;",'"'));
                    $('#'+ww+'grilleType').change();
                    if(arr2[nextWindow].grilleColor == ""){
                        $('#'+ww+'grilleColorDiv').toggle();
                        checkGrilleColor = 0;
                    }
                    if(arr2[nextWindow].grillePat == 'None'){
                        $('#'+ww+'grilleSash').hide();
                        $('#'+ww+"grilleSashLabel").hide();
                        checkGrilleSash = 0;
                        
                    }
                    $('#'+ww+'grilleSash').val(arr2[nextWindow].grilleSash);
                    $('#'+ww+'jambSize').val(arr2[nextWindow].jambSize);
                    if(arr2[nextWindow].screenEstate == true){
                        $('#'+ww+'screenColor').val('Estate');
                        $('#'+ww+'screenColor').change();
                        $('#'+ww+'screenColorChoiceEstate').val(arr2[nextWindow].screenColor);
                    }else if(arr2[nextWindow].screenEstate == false){
                        $('#'+ww+'screenColor').val(arr2[nextWindow].screenColor);
                    }
                    $('#'+ww+'screenPattern').val(arr2[nextWindow].screenType);
                    if(arr2[nextWindow].screenShip == true){
                        $('#'+ww+'shipHardware').prop('checked',true);
                    }else{
                        $('#'+ww+'shipHardware').prop('checked',false);
                    }
                    if(arr2[nextWindow].screenReq == false){
                        $('#'+ww+'screens_required').prop('checked',true);
                    }else{
                        $('#'+ww+'screens_required').prop('checked',false);
                    }
                    $('#'+ww+'hardColorStand').val(arr2[nextWindow].hardware);
                    $('#'+ww+'intPrime').val(arr2[nextWindow].interiorFin);
                    $('#'+ww+'install1').val(arr2[nextWindow].accessories.replace("&quot;",'"'));
                    $('#'+ww+'nailFinSelect').val(arr2[nextWindow].nailStrap.replace("&quot;",'"'));
                    $('#'+ww+'quickAdd').click();
                    //$('#extColorChoiceEstate').hide();
                    nextWindow++;
            }else{
                clearInterval(interval);
                //waitingDialog.hide();
                for(l=1;l<=newid;l++){
                    updateQuant($("#tab_logic").find('tr#addr'+l).find('#quantText' + l));
                }
                return;
            }
        },1000);
    
}
$('#quotesButton').on('click',function(){
  /*if(needQuotes == 0){ 
    $.post("getQuotes.php",function(data){$('#quoteTBody').html(data);});
    needQuotes = 1;
  }*/
  $.post("getQuotes.php",function(data){$('#quoteTBody').html(data);});
});
$('#custSearch').on('click',function(){
  if(needCust == 0 && isCasco == '1'){
    $.post("getCustTbl.php",function(data){$('#custTBody').html(data);});
    needCust = 1;
  }
  $('#custSearch').blur();
  if($('#custModal').is('visible')){
    $('#closeCustModal').click();
  }
});
$('#custSearchSpan').click(function(){
  $('#custSearch').click();
  $('#custSearchSpan').blur();
});
function removeQuoteRow(e){
    if(!$('#stopWarning').is(':checked')){
        var result = confirm("Are you sure you want to delete this quote?");
        if(result){
            var deleteId = $(e).closest('tr').find('[name="job_number"]').text();
            $.ajax({
                url:"deleteQuote.php",
                type: "POST",
                data: {id: deleteId},
                async: false,
                success: function(data){
                    
                }
            }) 
            $(e).closest('tr').remove();
        }else{
            return;
        }
    }else{
        var deleteId = $(e).closest('tr').find('[name="job_number"]').text();
        $.ajax({
                url:"deleteQuote.php",
                type: "POST",
                data: {id: deleteId},
                async: false,
                success: function(data){
                    
                }
        })
        $(e).closest('tr').remove();
    }
}
$('.img-with-text').click(function(){
    $(this).closest('.modal').modal('toggle');
});
function findWithAttr(array, attr, value) {
    for(var i = 0; i < array.length; i += 1) {
        if(array[i][attr] === value) {
            return i;
        }
    }
}
function changeWindow(e){
    priceTransom = 0;
    ww='glassButton';
    ww = $(e).attr('id');
    if(ww == "cdh"){
        ww2 = 'CDH';
        ww ="";
        ww3 = 'CDH';
        checkCustom = 0;
        checkExtColor = 0;
        checkGrilleColor = 0;
        checkGrilleSash = 0;
        $('#transomPanel').hide();
        $('#doubleHungPicturePanels').hide();
        $('#casementPanels').hide();
        $('#awningPanels').hide();
        $('#sliderPanels').hide();
        $('#mainAccessoriesDiv').hide();
        $('#mainGlassDiv').hide();
        $('#windowCanvas').show();
        $('#doubleHungPanels').show();
    }else if(ww=="casement"){
        ww2='CC';
        ww="cc";
        checkCustom = 0;
        checkExtColor = 0;
        checkGrilleColor = 0;
        checkGrilleSash = 0;
        $('#transomPanel').hide();
        $('#doubleHungPicturePanels').hide();
        $('#doubleHungPanels').hide();
        $('#awningPanels').hide();
        $('#sliderPanels').hide();
        $('#mainAccessoriesDiv').hide();
        $('#mainGlassDiv').hide();
        $('#windowCanvas').show();
        $('#casementPanels').show();
    }else if(ww=="awning"){
        ww2='CA';
        ww='ca';
        checkCustom = 0;
        checkExtColor = 0;
        checkGrilleColor = 0;
        checkGrilleSash = 0;
        $('#transomPanel').hide();
        $('#doubleHungPicturePanels').hide();
        $('#doubleHungPanels').hide();
        $('#casementPanels').hide();
        $('#sliderPanels').hide();
        $('#mainGlassDiv').hide();
        $('#mainAccessoriesDiv').hide();
        $('#windowCanvas').show();
        $('#awningPanels').show();
    }else if(ww=="slider"){
        ww2='CS';
        ww='cs';
        checkCustom = 0;
        checkExtColor = 0;
        checkGrilleColor = 0;
        checkGrilleSash = 0;
        $('#transomPanel').hide();
        $('#doubleHungPicturePanels').hide();
        $('#doubleHungPanels').hide();
        $('#casementPanels').hide();
        $('#awningPanels').hide();
        $('#mainGlassDiv').hide();
        $('#mainAccessoriesDiv').hide();
        $('#windowCanvas').show();
        $('#sliderPanels').show();
    }else if(ww=="cdhpicture"){
        ww2='CDHPW';
        ww='cdhpw';
        checkCustom = 0;
        checkExtColor = 0;
        checkGrilleColor = 0;
        checkGrilleSash = 0;
        $('#transomPanel').hide();
        $('#doubleHungPanels').hide();
        $('#casementPanels').hide();
        $('#awningPanels').hide();
        $('#sliderPanels').hide();
        $('#windowCanvas').show();
        $('#mainGlassDiv').hide();
        $('#mainAccessoriesDiv').hide();
        $('#doubleHungPicturePanels').show();
    }
    else if(ww=="glassButton"){
        checkCustom = 0;
        checkExtColor = 0;
        checkGrilleColor = 0;
        checkGrilleSash = 0;
        $('#transomPanel').hide();
        $('#doubleHungPanels').hide();
        $('#casementPanels').hide();
        $('#awningPanels').hide();
        $('#sliderPanels').hide();
        $('#doubleHungPicturePanels').hide();
        $('#windowCanvas').hide();
        $('#mainAccessoriesDiv').hide();
        $('#mainGlassDiv').show();
      }else if(ww="glazeAcc"){
        checkCustom = 0;
        checkExtColor = 0;
        checkGrilleColor = 0;
        checkGrilleSash = 0;
        $('#transomPanel').hide();
        $('#doubleHungPanels').hide();
        $('#casementPanels').hide();
        $('#awningPanels').hide();
        $('#sliderPanels').hide();
        $('#doubleHungPicturePanels').hide();
        $('#windowCanvas').hide();
        $('#mainGlassDiv').hide();
        $('#mainAccessoriesDiv').show();
        $('#osiSealantSelectId').hide();
        $('#foamSelectId').hide();
        $('#glazingSelectId').hide();
        $('#accessoriesCatSelect').show();
      }
    
    $('#abvCallout').html('<strong>Callout:</strong> '+ww2+ $('#'+ww+'dimsW option:selected').val()+$('#'+ww+'dimsH option:selected').val()+'-' +$('#'+ww+'installMulls1 option:selected').text());
    
    $('#'+ww+'dimsH').change();
    $('#'+ww+'dimsW').change();
}
$('[name="addTransomName"]').click(function(){
    $(this).blur();
    if($('#transomPanel').is(':hidden')){
        priceTransom = 1;
    }else{
        priceTransom = 0;
    }
    $('#transomPanel').toggle();
    if($('#bottomHalf').is(':hidden')){
    $('html, body').animate({ 
        scrollTop: $(document).height()-$(window).height()}, 
        50, 
        "swing"
     );
    }/*else{
        $('html, body').animate({ 
        scrollTop: $(document).height()-($(window).height()+$('#'+ww+'bottomHalf').height())}, 
        50, 
        "swing"
     );
    }*/
    $('#transomDimsW').val($('#'+ww+'dimsW option:selected').val());
    $('#transomUnitsWide option').each(function(i){
        if($(this).text() > $('#'+ww+'installMulls1 option:selected').text()){
            $(this).hide();
        }else{
            $(this).show();
        }
    });
});
function getTransomPrice(cat,height,num,grilleT,grilleP){
    var transDims = $('#'+ww+'dimsW option:selected').val() + height + "-" + num.substring(0,1);
    $.ajax({
        url:"getPrice.php",
        type: "GET",
        data:{qq:cat,
              d:transDims,
              q:num},
        async:false,
        success:function(data){
            tempNewPrice += parseInt(data);
            transomPrice += parseInt(data);
        }   
    });
    $.ajax({
        url:"getPrice.php",
        type: "GET",
        data:{qq:cat,
              d:transDims,
              q:grilleT},
        async:false,
        success:function(data){
            tempNewPrice += parseInt(data);
            transomPrice += parseInt(data);
        }   
    });
    $.ajax({
        url:"getPrice.php",
        type: "GET",
        data:{qq:cat,
              d:transDims,
              q:grilleP},
        async:false,
        success:function(data){
            tempNewPrice += parseInt(data);
            transomPrice += parseInt(data);
        }   
    });
}
$('#glassButton').click(function(){
  $('#glassButton').blur();
});
 $('#glassOrderShape').change(function(){
  $('#shapeDimBase').val('');
  $('#shapeDimLeft').val('');
  $('#shapeDimRight').val('');
  $('#shapeDimTop').val('');
  $('#shapeDimS1').val('');
  $('#shapeDimS2').val('');
  $('#shapeDimRadius').val('');
  var shapeNum = $('#glassOrderShape option:selected').attr('id');
  if($('#shapeDimInputs').is(':hidden')){
    $('#shapeDimInputs').show();
  }
  $('.shapeDimsPic').each(function(){
    $(this).hide();
  });
  $.ajax({
    url:"getShapeFields.php",
    type: "GET",
    data:{
    n:shapeNum
    },
    async:true,
    success:function(data){
      splitData = data.split(' ');
      if(splitData[0] == 1){
        $('#shapeDimBase').show();
        $('#baseLabel').show();
      }else{
        $('#shapeDimBase').hide();
        $('#baseLabel').hide();
      }
      if(splitData[1] == 1){
        $('#shapeDimLeft').show();
        $('#leftLabel').show();
      }else{
        $('#shapeDimLeft').hide();
        $('#leftLabel').hide();
      }if(splitData[2] == 1){
        $('#shapeDimRight').show();
        $('#rightLabel').show();
      }else{
        $('#shapeDimRight').hide();
        $('#rightLabel').hide();
      }if(splitData[3] == 1){
        $('#shapeDimTop').show();
        $('#topLabel').show();
      }else{
        $('#shapeDimTop').hide();
        $('#topLabel').hide();
      }if(splitData[4] == 1){
        $('#shapeDimS1').show();
        $('#s1Label').show();
      }else{
        $('#shapeDimS1').hide();
        $('#s1Label').hide();
      }if(splitData[5] == 1){
        $('#shapeDimS2').show();
        $('#s2Label').show();
      }else{
        $('#shapeDimS2').hide();
        $('#s2Label').hide();
      }if(splitData[6] == 1){
        $('#shapeDimRadius').show();
        $('#radiusLabel').show();
      }else{
        $('#radiusLabel').hide();
        $('#shapeDimRadius').hide();
      }
    }
  }); 
  $('#shape'+shapeNum+'Dims').show();        
});
$('#glassOrderProduct').change(function(){
  $('.shapeDimsPic').each(function(){
      $(this).hide();
  });
  var e = '#glassOrderProduct';
  $('select').each(function(){
    if($(this).attr('id') != 'selectDisPrice'){
      $(this).hide();
    }
  });
  hideGrillePrompts();
  lookVal = "";
  if($('#glassOverallLabel').is(':hidden') || $('#glassOverallLabel').is(':hidden')){
    $('#glassOverallLabel').show();
    $('#glassThickness1').show();
    $('#glassThickness2').show();
  }
  $('#glassGrilleInputGroup').hide();
  $('#glassObscureInputGroup').hide();
  $('#imageHere').html('');
  $('#shapeDimInputs').hide();
  $('[name=glassOrderGrilleName]').val('');
  $("#glassOrder2Tone").val('glass');
  $('#glassOrderProduct').show();
  $('#glassOrderQuant').hide();
  $('#glassShapeLabel').hide();
  $('#viewsFromTheSix').hide();
  $('#glassOrderQuant').val("1");
  $('#glassTemperLabel').hide();
  $('#glassSurface5Label').hide();
  $('#glassPatternLabel').hide();
  $('#glassGrilleColorLabel').hide();
  $('#glass2ToneLabel').hide();
  $('#glassSDLLabel').hide();
  $('#glassOrderColonialWide').hide();
  $('#glassOrderColonialHigh').hide();
  $('#glassOrderColonialCust').hide();
  $('#glassColonialWide').hide();
  $('#glassColonialHigh').hide();
  $('#glassShapeInputGroup').hide();
  $('#showGrilleShapes').hide();
  $('#glassCustColonialNum').hide();
  if($(e +' option:selected').val() == 'RECT IG'){
    hideGrillePrompts();
    lookVal = 'RIG'; 
    $('#glassGrilleInputGroup').show();
    $('#showGrilleShapes').show();
    $('#glassTypeLabel').show();
    $('#glassOrderTypeRIG').show();
    $('#glassQuantLabel').show();
    $('#glassOrderQuant').show();
    $('#glassStrengthLabel').show();
    $('#glassOrderStrengthRIG').show();
    $('#glassThicknessLabel').show();
    $('#glassOrderThicknessRIG').show();
    $('#glassOrderStrengthRIG').change(function(){
      if($('#glassOrderStrengthRIG option:selected').val() == "#TEMP" || $('#glassOrderStrengthRIG option:selected').val() == '#TLAMI'){
        $('#glassTemperLabel').show();
        $('#glassOrderTemper').show();
        $('#glassThicknessLabel').hide();
        $('#glassOrderThicknessRIG').hide();
      }else{
        $('#glassThicknessLabel').show();
        $('#glassOrderThicknessRIG').show();
        $('#glassTemperLabel').hide();
        $('#glassOrderTemper').hide();
      }  
    });
    $('#glassSpacerLabel').show();
    $('#glassOrderSpacer').show();
    $('#glassGrilleLabel').show();
    $('#glassOrderGrilleRIG').show();     
    $('#glassPreserveLabel').show();
    $('#glassOrderPreserveRIG').show();
    $('#glassTintLabel').show();
    $('#glassOrderTintRIG').show();
    $('#glassOrderTintRIG').change(function(){
      if($('#glassOrderTintRIG option:selected').val() != 'no'){
        $('#glassObscureInputGroup').hide();
        $('#glassObscureLabel').hide();
        $('#glassOrderObscureRIG').hide();
      }else{
        $('#glassObscureInputGroup').show();
        $('#glassObscureLabel').show();
        $('#glassOrderObscureRIG').show();
      }
    });
    $('#glassObscureLabel').show();
    $('#glassOrderObscureRIG').show();
    $('#glassObscureInputGroup').show();
    $('#glassHardLabel').show();
    $('#glassOrderHardRIG').show();
    $('#glassLogoLabel').show();
    $('#glassOrderLogo').show();
    $('#glassOrderGrilleRIG').change(function(){
      if($('#glassOrderGrilleRIG option:selected').val() != ""){
        $('#glassPatternLabel').show();
        $('#glassOrderGrillePattRIG').show();
        $('#glassGrilleColorLabel').show();
        $('#glassOrderIntGrilleRIG').show();
        glassGrillePattChange('RIG');
        $('#glassOrderGrillePattRIG').change(function(){
          glassGrillePattChange(lookVal);
        });
        
        if($('#glassOrderGrilleRIG option:selected').text().indexOf('SDL') > -1){
          $('#glassSDLLabel').show();
          $('#glassOrderSDLRIG').show();
          $('#glass2ToneLabel').hide();
          $('#glassOrder2Tone').hide();
          $('#glassGrilleColorLabel').hide();
          $('#glassOrderIntGrilleRIG').hide();
        }else if($('#glassOrderGrilleRIG option:selected').text().indexOf('2-tone') > -1){
          $('#glass2ToneLabel').show();
          $('#glassOrder2Tone').show();
          $('#glassGrilleColorLabel').hide();
          $('#glassOrderIntGrilleRIG').hide();
        }else{
          $('#glassSDLLabel').hide();
          $('#glassOrderSDLRIG').hide();
          $('#glass2ToneLabel').hide();
          $('#glassOrder2Tone').hide();
        }
      }else{
        $('#glassPatternLabel').hide();
        $('#glassOrderGrillePattRIG').hide();
        $('#glassGrilleColorLabel').hide();
        $('#glassOrderIntGrilleRIG').hide();
        $('#glass2ToneLabel').hide();
        $('#glassOrder2Tone').hide();
        hideGrillePrompts();
      }
    }); 
    }else if($(e +' option:selected').val() == 'SHAPE IG'){
      hideGrillePrompts();
      lookVal = 'SIG';
      $('#glassGrilleInputGroup').show();
      $('#showGrilleShapes').show();
      $('#viewsFromTheSix').show();
      $('#shape1Dims').show();
      $('#showGlassShapes').show();
      $('#glassShapeLabel').show();
      $('#glassShapeInputGroup').show();
      $('#glassOrderShape').show();
      $('#shapeDimInputs').show();
      $('#glassTypeLabel').show();
      $('#glassOrderTypeRIG').hide();
        $('#glassOrderTypeSIG').show();
        $('#glassQuantLabel').show();
        $('#glassOrderQuant').show();
        $('#glassStrengthLabel').show();
        $('#glassOrderStrengthSIG').show();
        $('#glassOrderStrengthRIG').hide();
        $('#glassThicknessLabel').show();
        $('#glassOrderThicknessSIG').show();
        $('#glassOrderStrengthSIG').change(function(){
          if($('#glassOrderStrengthSIG option:selected').val() == "#TEMP" || $('#glassOrderStrengthSIG option:selected').val() == '#TLAMI'){
            $('#glassTemperLabel').show();
            $('#glassOrderTemper').show();
            $('#glassThicknessLabel').hide();
            $('#glassOrderThicknessSIG').hide();
          }else{
            $('#glassThicknessLabel').show();
            $('#glassOrderThicknessSIG').show();
            $('#glassTemperLabel').hide();
            $('#glassOrderTemper').hide();
          }  
        });
        $('#glassSpacerLabel').show();
        $('#glassOrderSpacer').show();
        $('#glassGrilleLabel').show();
        $('#glassOrderGrilleSIG').show(); 
        $('#glassOrderGrilleRIG').hide();       
        $('#glassPreserveLabel').show();
        $('#glassOrderPreserveRIG').hide();
        $('#glassOrderPreserveSIG').show();
        $('#glassTintLabel').show();
        $('#glassOrderTintSIG').show();
        $('#glassOrderTintSIG').change(function(){
          if($('#glassOrderTintSIG option:selected').val() != 'no'){
            $('#glassObscureLabel').hide();
            $('#glassOrderObscureSIG').hide();
            $('#glassObscureInputGroup').hide();
          }else{
            $('#glassObscureLabel').show();
            $('#glassOrderObscureSIG').show();
            $('#glassObscureInputGroup').show();
        }
        });
        $('#glassObscureLabel').show();
        $('#glassOrderObscureSIG').show();
        $('#glassObscureInputGroup').show();
        $('#glassHardLabel').show();
        $('#glassOrderHardSIG').show();
        $('#glassOrderHardRIG').hide();
        $('#glassLogoLabel').show();
        $('#glassOrderLogo').show();
        $('#glassOrderGrilleSIG').change(function(){
          if($('#glassOrderGrilleSIG option:selected').val() != ""){
            $('#glassPatternLabel').show();
            $('#glassOrderGrillePattSIG').show();
            $('#glassGrilleColorLabel').show();
            $('#glassOrderIntGrilleSIG').show();
            glassGrillePattChange('SIG');
            $('#glassOrderGrillePattSIG').change(function(){
                glassGrillePattChange(lookVal);
            });
            if($('#glassOrderGrilleSIG option:selected').text().indexOf('SDL') > -1){
              $('#glassSDLLabel').show();
              $('#glassOrderSDLSIG').show();
              $('#glass2ToneLabel').hide();
              $('#glassOrder2Tone').hide();
              $('#glassGrilleColorLabel').hide();
              $('#glassOrderIntGrilleSIG').hide();
            }else if($('#glassOrderGrilleSIG option:selected').text().indexOf('2-tone') > -1){
              $('#glass2ToneLabel').show();
              $('#glassOrder2Tone').show();
              $('#glassGrilleColorLabel').hide();
              $('#glassOrderIntGrilleSIG').hide();
            }else{
              $('#glassSDLLabel').hide();
              $('#glassOrderSDLSIG').hide();
              $('#glass2ToneLabel').hide();
              $('#glassOrder2Tone').hide();
            }
          }else{
            $('#glassPatternLabel').hide();
            $('#glassOrderGrillePattSIG').hide();
            $('#glassGrilleColorLabel').hide();
            $('#glassOrderIntGrilleSIG').hide();
            $('#glass2ToneLabel').hide();
            $('#glassOrder2Tone').hide();
            hideGrillePrompts();
            }
        });
    }else if($(e +' option:selected').val() == 'TRIPLE RECT'){
      hideGrillePrompts();
      lookVal = 'TR';
      $('#glassGrilleInputGroup').show();
      $('#showGrilleShapes').show();
      $('#glassOrderTypeSurface').show();
      $('#glassSurface5Label').show();
      $('#glassTypeLabel').show();
      $('#glassOrderTypeTR').show();
      $('#glassQuantLabel').show();
      $('#glassOrderQuant').show();
      $('#glassStrengthLabel').show();
      $('#glassOrderStrengthTR').show();
      $('#glassOrderStrengthTR').change(function(){
        if($('#glassOrderStrengthTR option:selected').val() == "#TEMP" || $('#glassOrderStrengthTR option:selected').val() == '#TLAMI'){
          $('#glassTemperLabel').show();
          $('#glassOrderTemper').show();
          $('#glassThicknessLabel').hide();
          $('#glassOrderThicknessTR').hide();
        }else{
          $('#glassThicknessLabel').show();
          $('#glassOrderThicknessTR').show();
          $('#glassTemperLabel').hide();
          $('#glassOrderTemper').hide();
        }  
      });
      $('#glassSpacerLabel').show();
      $('#glassOrderSpacer').show();
      $('#glassGrilleLabel').show();
      $('#glassOrderGrilleTR').show();    
      $('#glassPreserveLabel').show();
      $('#glassOrderPreserveTR').hide();
      $('#glassOrderPreserveTR').show();
      $('#glassTintLabel').show();
      $('#glassOrderTintTR').show();
      $('#glassOrderTintTR').change(function(){
        if($('#glassOrderTintTR option:selected').val() != 'no'){
          $('#glassObscureLabel').hide();
          $('#glassOrderObscureTR').hide();
          $('#glassObscureInputGroup').hide();
        }else{
          $('#glassObscureLabel').show();
          $('#glassOrderObscureTR').show();
          $('#glassObscureInputGroup').show();
        }
      }); 
      $('#glassObscureLabel').show();
      $('#glassOrderObscureTR').show();
      $('#glassObscureInputGroup').show();
      $('#glassHardLabel').show();
      $('#glassOrderHardTR').show();
      $('#glassLogoLabel').show();
      $('#glassOrderLogo').show();
      $('#glassThicknessLabel').show();
      $('#glassOrderThicknessTR').show();
      $('#glassOrderGrilleTR').change(function(){
          if($('#glassOrderGrilleTR option:selected').val() != ""){
            $('#glassPatternLabel').show();
            $('#glassOrderGrillePattTR').show();
            $('#glassGrilleColorLabel').show();
            $('#glassOrderIntGrilleTR').show();
            glassGrillePattChange('TR');
            $('#glassOrderGrillePattTR').change(function(){
                glassGrillePattChange(lookVal);
            });
            if($('#glassOrderGrilleTR option:selected').text().indexOf('SDL') > -1){
              $('#glassSDLLabel').show();
              $('#glassOrderSDLTR').show();
              $('#glass2ToneLabel').hide();
              $('#glassOrder2Tone').hide();
              $('#glassGrilleColorLabel').hide();
              $('#glassOrderIntGrilleTR').hide();
            }else if($('#glassOrderGrilleTR option:selected').text().indexOf('2-tone') > -1){
              $('#glass2ToneLabel').show();
              $('#glassOrder2Tone').show();
              $('#glassGrilleColorLabel').hide();
              $('#glassOrderIntGrilleTR').hide();
            }else{
              $('#glassSDLLabel').hide();
              $('#glassOrderSDLTR').hide();
              $('#glass2ToneLabel').hide();
              $('#glassOrder2Tone').hide();
            }
          }else{
            $('#glassPatternLabel').hide();
            $('#glassOrderGrillePattTR').hide();
            $('#glassGrilleColorLabel').hide();
            $('#glassOrderIntGrilleTR').hide();
            $('#glass2ToneLabel').hide();
            $('#glassOrder2Tone').hide();
            hideGrillePrompts();
          }
          });
    }else if($(e +' option:selected').val() == 'TRIPLE SHAPE'){
      hideGrillePrompts();
      lookVal = 'TS';  
      $('#glassGrilleInputGroup').show();
      $('#showGrilleShapes').show();
      $('#shape1Dims').show();
      $('#viewsFromTheSix').show();
      $('#showGlassShapes').show();
      $('#glassOrderTypeSurface').show();
      $('#glassSurface5Label').show();
      $('#glassShapeLabel').show();
      $('#glassShapeInputGroup').show();
      $('#glassOrderShape').show();
      $('#shapeDimInputs').show();
      $('#glassTypeLabel').show();
      $('#glassOrderTypeTS').show();
      $('#glassQuantLabel').show();
      $('#glassOrderQuant').show();
      $('#glassStrengthLabel').show();
      $('#glassOrderStrengthTS').show();
      $('#glassThicknessLabel').show();
      $('#glassOrderThicknessTS').show();
      $('#glassOrderStrengthTS').change(function(){
        if($('#glassOrderStrengthTS option:selected').val() == "#TEMP" || $('#glassOrderStrengthTS option:selected').val() == '#TLAMI'){
          $('#glassTemperLabel').show();
          $('#glassOrderTemper').show();
          $('#glassThicknessLabel').hide();
          $('#glassOrderThicknessTS').hide();
        }else{
          $('#glassThicknessLabel').show();
          $('#glassOrderThicknessTS').show();
          $('#glassTemperLabel').hide();
          $('#glassOrderTemper').hide();
        }   
      });
      $('#glassSpacerLabel').show();
      $('#glassOrderSpacer').show();
      $('#glassGrilleLabel').show();
      $('#glassOrderGrilleTS').show();      
      $('#glassPreserveLabel').show();
      $('#glassOrderPreserveTS').show();
      $('#glassTintLabel').show();
      $('#glassOrderTintTS').show();
      $('#glassOrderTintTS').change(function(){
        if($('#glassOrderTintTS option:selected').val() != 'no'){
          $('#glassObscureLabel').hide();
          $('#glassOrderObscureTS').hide();
          $('#glassObscureInputGroup').hide();
        }else{
          $('#glassObscureLabel').show();
          $('#glassOrderObscureTS').show();
          $('#glassObscureInputGroup').show();
        }
      });  
      $('#glassObscureLabel').show();
      $('#glassObscureInputGroup').show();
      $('#glassOrderObscureTS').show();
      $('#glassHardLabel').show();
      $('#glassOrderHardTS').show();
      $('#glassLogoLabel').show();
      $('#glassOrderLogo').show();
      $('#glassOrderGrilleTS').change(function(){
        if($('#glassOrderGrilleTS option:selected').val() != ""){
          $('#glassPatternLabel').show();
          $('#glassOrderGrillePattTS').show();
          $('#glassGrilleColorLabel').show();
          $('#glassOrderIntGrilleTS').show();
          glassGrillePattChange('TS');
          $('#glassOrderGrillePattTS').change(function(){
            glassGrillePattChange(lookVal);
          }); 
        if($('#glassOrderGrilleTS option:selected').text().indexOf('SDL') > -1){
            $('#glassSDLLabel').show();
            $('#glassOrderSDLTS').show();
            $('#glass2ToneLabel').hide();
            $('#glassOrder2Tone').hide();
            $('#glassGrilleColorLabel').hide();
            $('#glassOrderIntGrilleTS').hide();
        }else if($('#glassOrderGrilleTS option:selected').text().indexOf('2-tone') > -1){
            $('#glass2ToneLabel').show();
            $('#glassOrder2Tone').show();
            $('#glassGrilleColorLabel').hide();
            $('#glassOrderIntGrilleTS').hide();
        }else{
            $('#glassSDLLabel').hide();
            $('#glassOrderSDLTS').hide();
            $('#glass2ToneLabel').hide();
            $('#glassOrder2Tone').hide();
        }
          }else{
            $('#glassPatternLabel').hide();
            $('#glassOrderGrillePattTS').hide();
            $('#glassGrilleColorLabel').hide();
            $('#glassOrderIntGrilleTS').hide();
            $('#glass2ToneLabel').hide();
            $('#glassOrder2Tone').hide();
            hideGrillePrompts();
          }
      
      });
    }else if($(e +' option:selected').val() == 'MONO RECT'){
          hideGrillePrompts();
          lookVal = 'MR';
          $('#glassGrilleInputGroup').hide();
          $('#glassOverallLabel').hide();
          $('#glassThickness1').hide();
          $('#glassThickness2').hide();
          //$('#glassTypeLabel').show();
          //$('#glassOrderTypeMR').show();
          $('#glassTypeLabel').hide();
          $('#glassSpacerLabel').hide();
          $('#glassGrilleLabel').hide();
          $('#glassPatternLabel').hide();
          $('#glassShapeLabel').hide();
          $('#glassGrilleColorLabel').hide();
          $('#glassPreserveLabel').hide();
          $('#glassLogoLabel').hide();
          $('#glassSDLLabel').hide();
          $('#glass2ToneLabel').hide();
          $('#glassQuantLabel').show();
          $('#glassOrderQuant').show();
          $('#glassStrengthLabel').show();
          $('#glassOrderStrengthMR').show();
          $('#glassThicknessLabel').show();
          $('#glassOrderThicknessMR').show();
          $('#glassOrderStrengthMR').change(function(){
            if($('#glassOrderStrengthMR option:selected').val() == "#TEMP" || $('#glassOrderStrengthMR option:selected').val() == '#TLAMI'){
                  $('#glassTemperLabel').show();
                  $('#glassOrderTemper').show();
                  $('#glassThicknessLabel').hide();
                  $('#glassOrderThicknessMR').hide();
            }else{
                  $('#glassThicknessLabel').show();
                  $('#glassOrderThicknessMR').show();
                  $('#glassTemperLabel').hide();
                  $('#glassOrderTemper').hide();
            }
          });
          $('#glassTintLabel').show();
          $('#glassOrderTintMR').show();
          $('#glassOrderTintMR').change(function(){
            if($('#glassOrderTintMR option:selected').val() != 'no'){
                $('#glassObscureLabel').hide();
                $('#glassOrderObscureMR').hide();
                $('#glassObscureInputGroup').hide();
            }else{
                $('#glassObscureLabel').show();
                $('#glassOrderObscureMR').show();
                $('#glassObscureInputGroup').show();
            }
          });  
          $('#glassObscureLabel').show();
              $('#glassOrderObscureMR').show();
              $('#glassObscureInputGroup').show();
          $('#glassHardLabel').show();
          $('#glassOrderHardMR').show();
          /*$('#glassLogoLabel').show();
          $('#glassOrderLogo').show();
          $('#glassOrderGrilleTS').change(function(){
              if($('#glassOrderGrilleTS option:selected').val() != ""){
                $('#glassPatternLabel').show();
                $('#glassOrderGrillePattTS').show();
                $('#glassGrilleColorLabel').show();
                $('#glassOrderIntGrilleTS').show();
                if($('#glassOrderGrilleTS option:selected').text().indexOf('SDL') > -1){
                    $('#glassSDLLabel').show();
                    $('#glassOrderSDLTS').show();
                    $('#glass2ToneLabel').hide();
                    $('#glassOrder2Tone').hide();
                    $('#glassGrilleColorLabel').hide();
                    $('#glassOrderIntGrilleTS').hide();
                }else if($('#glassOrderGrilleTS option:selected').text().indexOf('2-tone') > -1){
                    $('#glass2ToneLabel').show();
                    $('#glassOrder2Tone').show();
                    $('#glassGrilleColorLabel').hide();
                    $('#glassOrderIntGrilleTS').hide();
                }else{
                    $('#glassSDLLabel').hide();
                    $('#glassOrderSDLTS').hide();
                    $('#glass2ToneLabel').hide();
                    $('#glassOrder2Tone').hide();
                }
              }else{
                $('#glassPatternLabel').hide();
                $('#glassOrderGrillePattTS').hide();
                $('#glassGrilleColorLabel').hide();
                $('#glassOrderIntGrilleTS').hide();
                $('#glass2ToneLabel').hide();
                $('#glassOrder2Tone').hide();
              }
          
          });*/
    }else if($(e +' option:selected').val() == 'MONO SHAPE'){
          hideGrillePrompts();
          lookVal = 'MS';
          $('#glassGrilleInputGroup').hide();
          $('#shape1Dims').show();
          $('#viewsFromTheSix').hide();
          $('#glassOverallLabel').hide();
          $('#glassThickness1').hide();
          $('#glassThickness2').hide();
          $('#showGlassShapes').show();
          $('#shapeDimInputs').show();
          //$('#glassTypeLabel').show();
          //$('#glassOrderTypeMS').show();
          $('#glassTypeLabel').hide();
          $('#glassSpacerLabel').hide();
          $('#glassGrilleLabel').hide();
          $('#glassPatternLabel').hide();
          $('#glassGrilleColorLabel').hide();
          $('#glassPreserveLabel').hide();
          $('#glassLogoLabel').hide();
          $('#glassSDLLabel').hide();
          $('#glass2ToneLabel').hide();
          $('#glassQuantLabel').show();
          $('#glassOrderQuant').show();
          $('#glassStrengthLabel').show();
          $('#glassOrderStrengthMS').show();
          $('#glassThicknessLabel').show();
          $('#glassOrderThicknessMS').show();
          $('#glassOrderStrengthMS').change(function(){
            if($('#glassOrderStrengthMS option:selected').val() == "#TEMP" || $('#glassOrderStrengthMS option:selected').val() == '#TLAMI'){
                  $('#glassTemperLabel').show();
                  $('#glassOrderTemper').show();
                  $('#glassThicknessLabel').hide();
                  $('#glassOrderThicknessMS').hide();
            }else{
                  $('#glassThicknessLabel').show();
                  $('#glassOrderThicknessMS').show();
                  $('#glassTemperLabel').hide();
                  $('#glassOrderTemper').hide();
            }   
          });
          $('#glassTintLabel').show();
          $('#glassOrderTintMS').show();
          $('#glassOrderTintMS').change(function(){
            if($('#glassOrderTintMS option:selected').val() != 'no'){
                $('#glassObscureLabel').hide();
                $('#glassOrderObscureMS').hide();
                $('#glassObscureInputGroup').hide();
            }else{
                $('#glassObscureLabel').show();
                $('#glassOrderObscureMS').show();
                $('#glassObscureInputGroup').show();
            }
          });
          $('#glassObscureLabel').show();
          $('#glassOrderObscureMS').show();
          $('#glassObscureInputGroup').show();
          $('#glassHardLabel').show();
          $('#glassOrderHardMS').show();
          $('#glassShapeLabel').show();
          $('#glassOrderShape').show();
          $('#glassShapeInputGroup').show();
          /*$('#glassLogoLabel').show();
          $('#glassOrderLogo').show();
          $('#glassOrderGrilleTS').change(function(){
              if($('#glassOrderGrilleTS option:selected').val() != ""){
                $('#glassPatternLabel').show();
                $('#glassOrderGrillePattTS').show();
                $('#glassGrilleColorLabel').show();
                $('#glassOrderIntGrilleTS').show();
                if($('#glassOrderGrilleTS option:selected').text().indexOf('SDL') > -1){
                    $('#glassSDLLabel').show();
                    $('#glassOrderSDLTS').show();
                    $('#glass2ToneLabel').hide();
                    $('#glassOrder2Tone').hide();
                    $('#glassGrilleColorLabel').hide();
                    $('#glassOrderIntGrilleTS').hide();
                }else if($('#glassOrderGrilleTS option:selected').text().indexOf('2-tone') > -1){
                    $('#glass2ToneLabel').show();
                    $('#glassOrder2Tone').show();
                    $('#glassGrilleColorLabel').hide();
                    $('#glassOrderIntGrilleTS').hide();
                }else{
                    $('#glassSDLLabel').hide();
                    $('#glassOrderSDLTS').hide();
                    $('#glass2ToneLabel').hide();
                    $('#glassOrder2Tone').hide();
                }
              }else{
                $('#glassPatternLabel').hide();
                $('#glassOrderGrillePattTS').hide();
                $('#glassGrilleColorLabel').hide();
                $('#glassOrderIntGrilleTS').hide();
                $('#glass2ToneLabel').hide();
                $('#glassOrder2Tone').hide();
              }
          
          });*/
    }else if($(e +' option:selected').val() == 'Default'){
          lookVal = '';
          //$('#glassTypeLabel').show();
          //$('#glassOrderTypeMS').show();
          hideGrillePrompts();
          $('#glassTypeLabel').hide();
          $('#glassSpacerLabel').hide();
          $('#glassGrilleLabel').hide();
          $('#glassPatternLabel').hide();
          $('#glassGrilleColorLabel').hide();
          $('#glassPreserveLabel').hide();
          $('#glassLogoLabel').hide();
          $('#glassSDLLabel').hide();
          $('#glass2ToneLabel').hide();
          $('#glassTypeLabel').hide();
          $('#glassQuantLabel').hide();
          $('#glassStrengthLabel').hide();
          $('#glassThicknessLabel').hide();
          $('#glassTemperLabel').hide();
          $('#glassSpacerLabel').hide();
          $('#glassGrilleLabel').hide();
          $('#glassPreserveLabel').hide();
          $('#glassTintLabel').hide();
          $('#glassHardLabel').hide();
          $('#glassObscureLabel').hide();
          $('#glassLogoLabel').hide();
          
    }
});
$('[name=glassOrderStrengthName]').change(function(){
  if($('#'+$(this).attr('id')+' option:selected').text().indexOf('Lami') > -1){
    $('#glassOrderObscure'+lookVal).hide();
    $('#glassObscureLabel').hide();
    $('#showObscureImgs').hide();
  }else if($('#'+$(this).attr('id')+' option:selected').text().indexOf('Lami') == -1 && $('#glassOrderTint'+lookVal+' option:selected').val() == 'no'){
    $('#glassOrderObscure'+lookVal).show();
    $('#glassObscureLabel').show();
    $('#showObscureImgs').show();
  }
})
function glassGrillePattChange(e){
  hideGrillePrompts();
  if($('#glassOrderGrillePatt'+e+' option:selected').text() == "Colonial Custom"){
    $('#glassColonialWide').hide();
    $('#glassColonialHigh').hide();
    $('#glassOrderColonialWide').hide();
    $('#glassOrderColonialHigh').hide();
    $('#glassCustColonialNum').show();
    $('#glassOrderColonialCust').show();
    $('#glassOrderCustAngLites').hide();
    $('#glassOrderCustCurvLites').hide();
    $('#glassOrderCustRectLites').hide();
    $('#glassCustAngLites').hide();
    $('#glassCustRectLites').hide();
    $('#glassCustCurveLites').hide();
  }else if($('#glassOrderGrillePatt'+e+' option:selected').text() == "Prairie"){
    $('#glassColonialWide').hide();
    $('#glassColonialHigh').hide();
    $('#glassOrderColonialWide').hide();
    $('#glassOrderColonialHigh').hide();
    $('#glassCustColonialNum').hide();
    $('#glassOrderColonialCust').hide();
    $('#glassOrderPrairieOff').show();
    $('#glassOrderPrairieHigh').show();
    $('#glassOrderPrairieWide').show();
    $('#glassPrairieHigh').show();
    $('#glassPrairieOff').show();
    $('#glassPrairieWide').show();
    $('#glassCustPrairieHigh').hide();
    $('#glassCustPrairieWide').hide();
    $('#glassCustPrairieVeriOff').hide();
    $('#glassCustPrairieHoriOff').hide();
    $('#glassOrderCustPrairieHigh').hide();
    $('#glassOrderCustPrairieWide').hide();
    $('#glassOrderCustPrairieVertOff').hide();
    $('#glassOrderCustPrairieHoriOff').hide();
    $('#glassOrderCustAngLites').hide();
    $('#glassOrderCustCurvLites').hide();
    $('#glassOrderCustRectLites').hide();
    $('#glassCustAngLites').hide();
    $('#glassCustRectLites').hide();
    $('#glassCustCurveLites').hide();
  }else if($('#glassOrderGrillePatt'+e+' option:selected').text() == "Prairie Custom"){
    $('#glassColonialWide').hide();
    $('#glassColonialHigh').hide();
    $('#glassOrderColonialWide').hide();
    $('#glassOrderColonialHigh').hide();
    $('#glassCustColonialNum').hide();
    $('#glassOrderColonialCust').hide();
    $('#glassOrderPrairieOff').hide();
    $('#glassOrderPrairieHigh').hide();
    $('#glassOrderPrairieWide').hide();
    $('#glassPrairieHigh').hide();
    $('#glassPrairieOff').hide();
    $('#glassPrairieWide').hide();
    $('#glassOrderCustAngLites').hide();
    $('#glassOrderCustCurvLites').hide();
    $('#glassOrderCustRectLites').hide();
    $('#glassCustAngLites').hide();
    $('#glassCustRectLites').hide();
    $('#glassCustCurveLites').hide();
    $('#glassCustPrairieHigh').show();
    $('#glassCustPrairieWide').show();
    $('#glassCustPrairieVeriOff').show();
    $('#glassCustPrairieHoriOff').show();
    $('#glassOrderCustPrairieHigh').show();
    $('#glassOrderCustPrairieWide').show();
    $('#glassOrderCustPrairieVertOff').show();
    $('#glassOrderCustPrairieHoriOff').show();
  }else if($('#glassOrderGrillePatt'+e+' option:selected').text() == "Custom"){
    $('#glassColonialWide').hide();
    $('#glassColonialHigh').hide();
    $('#glassOrderColonialWide').hide();
    $('#glassOrderColonialHigh').hide();
    $('#glassCustColonialNum').hide();
    $('#glassOrderColonialCust').hide();
    $('#glassOrderPrairieOff').hide();
    $('#glassOrderPrairieHigh').hide();
    $('#glassOrderPrairieWide').hide();
    $('#glassPrairieHigh').hide();
    $('#glassPrairieOff').hide();
    $('#glassPrairieWide').hide();
    $('#glassCustPrairieHigh').hide();
    $('#glassCustPrairieWide').hide();
    $('#glassCustPrairieVeriOff').hide();
    $('#glassCustPrairieHoriOff').hide();
    $('#glassOrderCustPrairieHigh').hide();
    $('#glassOrderCustPrairieWide').hide();
    $('#glassOrderCustPrairieVertOff').hide();
    $('#glassOrderCustPrairieHoriOff').hide();
    $('#glassOrderCustAngLites').show();
    $('#glassOrderCustCurvLites').show();
    $('#glassOrderCustRectLites').show();
    $('#glassCustAngLites').show();
    $('#glassCustRectLites').show();
    $('#glassCustCurveLites').show();
  }else{
    $('#glassColonialWide').show();
    $('#glassColonialHigh').show();
    $('#glassOrderColonialWide').show();
    $('#glassOrderColonialHigh').show();
    $('#glassCustColonialNum').hide();
    $('#glassOrderColonialCust').hide();
    $('#glassOrderPrairieOff').hide();
    $('#glassOrderPrairieHigh').hide();
    $('#glassOrderPrairieWide').hide();
    $('#glassPrairieHigh').hide();
    $('#glassPrairieOff').hide();
    $('#glassPrairieWide').hide();
    $('#glassCustPrairieHigh').hide();
    $('#glassCustPrairieWide').hide();
    $('#glassCustPrairieVeriOff').hide();
    $('#glassCustPrairieHoriOff').hide();
    $('#glassOrderCustPrairieHigh').hide();
    $('#glassOrderCustPrairieWide').hide();
    $('#glassOrderCustPrairieVertOff').hide();
    $('#glassOrderCustPrairieHoriOff').hide();
    $('#glassOrderCustAngLites').hide();
    $('#glassOrderCustCurvLites').hide();
    $('#glassOrderCustRectLites').hide();
    $('#glassCustAngLites').hide();
    $('#glassCustRectLites').hide();
    $('#glassCustCurveLites').hide();
  }
            
}
function hideGrillePrompts(){
  $('#glassColonialWide').hide();
  $('#glassColonialHigh').hide();
  $('#glassOrderColonialWide').hide();
  $('#glassOrderColonialHigh').hide();
  $('#glassCustColonialNum').hide();
  $('#glassOrderColonialCust').hide();
  $('#glassOrderPrairieOff').hide();
  $('#glassOrderPrairieHigh').hide();
  $('#glassOrderPrairieWide').hide();
  $('#glassPrairieHigh').hide();
  $('#glassPrairieOff').hide();
  $('#glassPrairieWide').hide();
  $('#glassCustPrairieHigh').hide();
  $('#glassCustPrairieWide').hide();
  $('#glassCustPrairieVeriOff').hide();
  $('#glassCustPrairieHoriOff').hide();
  $('#glassOrderCustPrairieHigh').hide();
  $('#glassOrderCustPrairieWide').hide();
  $('#glassOrderCustPrairieVertOff').hide();
  $('#glassOrderCustPrairieHoriOff').hide();
  $('#glassOrderCustAngLites').hide();
  $('#glassOrderCustCurvLites').hide();
  $('#glassOrderCustRectLites').hide();
  $('#glassCustAngLites').hide();
  $('#glassCustRectLites').hide();
  $('#glassCustCurveLites').hide();
  $('#glassCustGrilleColor').hide();
  $('#glassOrderCustGColor').hide();
  $('#glassCust2ToneExt').hide();
  $('#glassCust2ToneIn').hide();
  $('#glassOrderCust2ToneExt').hide();
  $('#glassOrderCust2ToneIn').hide();
  $('#glassShapeModal').hide();
  $('#glassOrderColonialWide').val('');
  $('#glassOrderColonialHigh').val('');
  $('#glassOrderColonialCust').val('');
  $('#glassOrderPrairieWide').val('');
  $('#glassOrderPrairieHigh').val('');
  $('#glassOrderPrairieOff').val('');
  $('#glassOrderCustPrairieWide').val('');
  $('#glassOrderCustPrairieHigh').val('');
  $('#glassOrderCustPrairieHoriOff').val('');
  $('#glassOrderCustPrairieVertOff').val('');
  $('#glassOrderCustRectLites').val('');
  $('#glassOrderCustCurvLites').val('');
  $('#glassOrderCustAngLites').val('');
}
   $('[name = "glassOrderIntGrilleName"]').change(function(){
      if($('#'+$(this).attr('id')+ " option:selected").val()=="*manual"){
          $('#glassCustGrilleColor').show();
          $('#glassOrderCustGColor').show();
      }else{
          $('#glassCustGrilleColor').hide();
          $('#glassOrderCustGColor').hide();
      }
   }); 
 $('#glassOrder2Tone').change(function(){
      if($('#glassOrder2Tone option:selected').text() == "Custom Color"){
        $('#glassCust2ToneExt').show();
        $('#glassCust2ToneIn').show();
        $('#glassOrderCust2ToneExt').show();
        $('#glassOrderCust2ToneIn').show();
      }else{
        $('#glassCust2ToneExt').hide();
        $('#glassCust2ToneIn').hide();
        $('#glassOrderCust2ToneExt').hide();
        $('#glassOrderCust2ToneIn').hide();
      }
    });
 $('#showGlassShapes').click(function(){
    $(this).blur();
 });
 $('.shapePic').click(function(){
  shapeClickedId = $(this).attr('id').match(/(\d+)/)[0];
  $('#glassOrderShape option').filter(function(){
  return $.trim($(this).attr('id')) ==  shapeClickedId
}).prop('selected', true);
  /**$('#glassOrderShape > option').each(function(){
      $(this).attr('selected',null);
      if($(this).attr('id') == shapeClickedId){
          $(this).attr('selected','true');
      }
    });*/
  $('#glassOrderShape').change();
 });
function clearGOrders(){
  gOrderTint = '';
  gOrderOBSC = '';
  gOrderTemper = '';
  gOrderHard = '';
  gOrderProduct = '';
  gOrderGrille = '';
  gOrderType = '';
  gOrderSpacer ='';
  gOrderPreserve = '';
  gOrderTriple = '';
  gOrderGrillePatt = '';
}
function addZeros(e){
  if(e.length == 1){
    e = "00" + e;
  }else if(e.length == 2){
    e = "0" + e;
  }else if(e.length == 0){
    e = "000";
  }
  return e;
}
$('#glassadd_row').click(function(){
  //$('#glasssendOrder').prop('disabled',false);
  jobPoId = $('#topGlassPOInput').val();
  if(checkDims() == 1){
    return;
  }
  //$('#glasssendOrder').prop('disabled',false);
  parseArray = 1;
  var priceLevel = 0;
  if(lookVal!="MR"){
    if($('#glassThickness1').is(':visible') && $('#glassThickness1').val() == ""){
      alert('Please enter an overall glass thickness.');
      return;
    //change add these else if statements   
    }else if($('#glassOrderThickness'+lookVal+' option:selected').val() == '#T1' && $('#glassThickness1').val() < .375){
      alert('Overall glass thickness must be greater than .375 (3/8") for SS Glass');
      return;
    }else if($('#glassOrderThickness'+lookVal+' option:selected').val() == '#T2' && $('#glassThickness1').val() < .4375){
      alert('Overall Glass Thickness must be greater than .4375 (7/16") for DS Glass');
      return;
    }
  }
  parseArray = 1;
  var priceLevel = 0;
  if($('#glassThickness1').is(':visible') && $('#glassThickness1').val() == ""){
    alert('Please enter an overall glass thickness.');
    return;
  }
  if(blankRow == 0){
    var glassPriceHeight = $('#glassHeight1').val(); 
    var glassPriceWidth = $('#glassWidth1').val();
  }else{
    var glassPriceHeight = "";
    var glassPriceWidth = "";
  }
  if(blankRow == 1){
    lookVal = "";
    clearGOrders();
    tempNewPrice = 0;
    priceSquareFeet = 0;
  } 
  if(glassPriceHeight.indexOf('-')>-1){
    splitGHeight = glassPriceHeight.split('-');
    splitGHeightFraction = splitGHeight[1].split('/');
    glassPriceHeight = +(+splitGHeightFraction[0]/+splitGHeightFraction[1]) + +splitGHeight[0];
  }else if(glassPriceHeight.indexOf('/')>-1 && glassPriceHeight.indexOf('-')==-1){
    glassPriceHeightWhole = glassPriceHeight.split(' ')[0].trim();
    glassPriceHeightFrac = glassPriceHeight.split(' ')[1].trim().split('/');
    glassPriceHeight = parseFloat(+glassPriceHeightWhole + +(glassPriceHeightFrac[0]/glassPriceHeightFrac[1])).toFixed(2);
  }
  if(glassPriceWidth.indexOf('-')>-1){
    splitGWidth = glassPriceWidth.split('-');
    splitGWidthFraction = splitGWidth[1].split('/');
    glassPriceWidth = +(+splitGWidthFraction[0]/+splitGWidthFraction[1]) + +splitGWidth[0];
  }else if(glassPriceWidth.indexOf('/')>-1 && glassPriceWidth.indexOf('-')==-1){
    glassPriceWidthWhole = glassPriceWidth.split(' ')[0].trim();
    glassPriceWidthFrac = glassPriceWidth.split(' ')[1].trim().split('/');
    glassPriceWidth = parseFloat(+glassPriceWidthWhole + +(glassPriceWidthFrac[0]/glassPriceWidthFrac[1])).toFixed(2);
  }
  var glassPriceThickness = $('#glassThickness1').val();
  if(glassPriceThickness.indexOf('-')>-1){
    splitGThick = glassPriceThickness.split('-');
    splitGThickFrac = splitGThick[1].split('/');
    glassPriceThickness = splitGThickFrac[0]/splitGThickFrac[1] + +splitGThick[0];
  }else if(glassPriceThickness.indexOf('/')>-1 && glassPriceThickness.indexOf('-')==-1){
    glassPriceThicknessFrac = glassPriceThickness.split('/');
    glassPriceThickness = parseFloat(glassPriceThicknessFrac[0]/glassPriceThicknessFrac[1]).toFixed(2);
  }
  if($('#glassOrderGrillePatt'+lookVal+' option:selected').text()=="Colonial"){
    numLites = $('#glassOrderColonialWide').val() * $('#glassOrderColonialHigh').val();
  }else if($('#glassOrderGrillePatt'+lookVal+' option:selected').text()=='Colonial Custom'){
    numLites = $('#glassOrderColonialCust').val();
  }else if($('#glassOrderGrillePatt'+lookVal+' option:selected').text()=='Prairie'){
    numLites = $('#glassOrderPrairieHigh').val() * $('#glassOrderPrairieWide').val();
  }else if($('#glassOrderGrillePatt' +lookVal+' option:selected').text()=='Prairie Custom'){
    numLites = $('#glassOrderCustPrairieWide').val() * $('#glassOrderCustPrairieHigh').val();
  }else if($('#glassOrderGrillePatt'+lookVal+' option:selected').text()=='Custom'){
    numLites = +$('#glassOrderCustRectLites').val() + +$('#glassOrderCustAngLites').val() + +$('#glassOrderCustCurvLites').val();
  }
  displayHeight = glassPriceHeight;
  displayWidth = glassPriceWidth;
  displaySquareFeet = parseFloat(Math.round(((+displayWidth*+displayHeight)/144)*100)/100).toFixed(2);
  if(glassPriceHeight%2 !=0){
    glassPriceHeight = Math.ceil(glassPriceHeight);
  }
  if(glassPriceWidth%2 !=0){
    glassPriceWidth = Math.ceil(glassPriceWidth);
  }
  glassPriceWidth = parseFloat(Math.round(+glassPriceWidth * 100)/100).toFixed(2);
  glassPriceHeight = parseFloat(Math.round(+glassPriceHeight * 100)/100).toFixed(2);
  if(glassPriceWidth%2 != 0){
     glassPriceWidth = parseFloat(+glassPriceWidth + 1).toFixed(0);
  }
  if(glassPriceHeight%2 != 0){
    glassPriceHeight = parseFloat(+glassPriceHeight + 1).toFixed(0);
  }
  priceSquareFeet = parseFloat(Math.round(((+glassPriceWidth * +glassPriceHeight)/144)*100)/100).toFixed(2);
  var priceShape;
  if($('#glassOrderShape').is(':visible')){
    if($('#glassOrderShape option:selected').val() == '1'){
      priceShape = "PATTERN";
    }else if($('#glassOrderShape option:selected').val() == '2'){
      priceShape = "CURVE";
    }
  }
  squareFeet = displaySquareFeet
  if(squareFeet < 3){
    squareFeet = 3;
  }
  if(squareFeet <= 10 && squareFeet >=3 ){
    priceLevel = 1;
  }else if(squareFeet > 10 && squareFeet <= 15){
    priceLevel = 2;
  }else if(squareFeet > 15 && squareFeet <= 20){
    priceLevel = 3;
  }else if(squareFeet > 20 && squareFeet <= 25){
    priceLevel = 4;
  }else if(squareFeet > 25){
    priceLevel = 5;
  }
  
  if(lookVal == "RIG"){
    clearGOrders();
    gOrderProduct = "RECTANGLE";
    gOrderType = $('#glassOrderTypeRIG option:selected').val();
    gOrderTypeTxt = $('#glassOrderTypeRIG option:selected').text();
    gOrderGrille = $('#glassOrderGrilleRIG option:selected').val();
    if($('#glassOrderThicknessRIG').is(':visible')){
      if($('#glassOrderThicknessRIG option:selected').val().match(/(\d+)/)[0] > priceLevel){
        priceLevel = $('#glassOrderThicknessRIG option:selected').val().match(/(\d+)/)[0];
      }
    }
    tempPriceLevel = 0;
    if($('#glassOrderTemper').is(':visible')){
      if($('#glassOrderTemper option:selected').val() == '3.1 mm'){
        tempPriceLevel = 2;
      }else if($('#glassOrderTemper option:selected').val() == '3.9 mm'){
        tempPriceLevel = 3;
      }else if($('#glassOrderTemper option:selected').val() == '4.7 mm'){
        tempPriceLevel = 4;
      }else if($('#glassOrderTemper option:selected').val() == '5.7 mm'){
        tempPriceLevel = 5;
      }
    }
    if($('#glassOrderObscureRIG option:selected').val() == "#REED" || $('#glassOrderObscureRIG option:selected').val() == "#REEMY"){
      tempPriceLevel2 = 3;
    }else if($('#glassOrderObscureRIG option:selected').val() == "#FROS" || $('#glassOrderObscureRIG option:selected').val() == "#GLUE"){
      tempPriceLevel2 = 2;
    }
    if(tempPriceLevel2 > tempPriceLevel){
      tempPriceLevel = tempPriceLevel2;
    }
    if(tempPriceLevel > priceLevel){
      priceLevel = tempPriceLevel;
    }
    
    gOrderTemper = $('#glassOrderStrengthRIG option:selected').val();
    gOrderTint = $('#glassOrderTintRIG option:selected').val();
    if(gOrderTint == "no"){
      gOrderTint = "";
    }
    gOrderOBSC = $('#glassOrderObscureRIG option:selected').val();
    if(gOrderOBSC == "no"){
      gOrderOBSC = "";
    }
    if(gOrderTemper == '#'){
      gOrderTemper = "";
    }
    gOrderGrillePatt = $('#glassOrderGrillePattRIG option:selected').val();
    gOrderSpacer = $('#glassOrderSpacer option:selected').val();
    gOrderHard = $('#glassOrderHardRIG option:selected').val();
    gOrderPreserve = $('#glassOrderPreserveRIG option:selected').val();
    $.ajax({
      url:"glassPricing.php",
      type: "GET",
      data:{
        p:gOrderProduct,
        ty:gOrderType, 
        tm:gOrderTemper,
        ti:gOrderTint,
        ob:gOrderOBSC,
        sp:gOrderSpacer,
        h:gOrderHard,
        pl:priceLevel,
        pr:gOrderPreserve
      },
      async:false,
      success:function(data){
        tempNewPrice = data;
        //tempNewPrice = +priceSquareFeet * +tempNewPrice;
        if((glassPriceWidth * glassPriceHeight)/144 < 3){
            tempNewPrice = parseFloat(tempNewPrice * 3).toFixed(2);  
        }else{
          tempNewPrice = parseFloat(tempNewPrice *((glassPriceWidth * glassPriceHeight)/144)).toFixed(2);
        }
      }
    });
    $.ajax({
      url:"glassGrillePrice.php",
      type: "GET",
      data:{
        p:gOrderProduct,
        gt:gOrderGrille,
        gp:gOrderGrillePatt,
        ln:numLites
      },
      async:false,
      success:function(data){
        tempNewPrice = +data + +tempNewPrice;
        //tempNewPrice = parseFloat(Math.round((tempNewPrice*100)/100)).toFixed(2);
        //tempNewPrice = Math.floor(tempNewPrice*100)/100;
      }
    });
   }else if(lookVal == "SIG"){
    clearGOrders();
    gOrderProduct = priceShape;
    gOrderType = $('#glassOrderTypeSIG option:selected').val();
    gOrderTypeTxt = $('#glassOrderTypeSIG option:selected').text();
    if(gOrderType == "#340"){
      priceLevel = 0;
    }
    gOrderGrille = $('#glassOrderGrilleSIG option:selected').val();
    gOrderTemper = $('#glassOrderStrengthSIG option:selected').val();
    if($('#glassOrderThicknessSIG').is(':visible')){
      if($('#glassOrderThicknessSIG option:selected').val().match(/(\d+)/)[0] > priceLevel){
        priceLevel = $('#glassOrderThicknessSIG option:selected').val().match(/(\d+)/)[0];
      }
    }    
    tempPriceLevel = 0;
    if($('#glassOrderTemper').is(':visible')){
      if($('#glassOrderTemper option:selected').val() == '3.1 mm'){
        tempPriceLevel = 2;
      }else if($('#glassOrderTemper option:selected').val() == '3.9 mm'){
        tempPriceLevel = 3;
      }else if($('#glassOrderTemper option:selected').val() == '4.7 mm'){
        tempPriceLevel = 4;
      }else if($('#glassOrderTemper option:selected').val() == '5.7 mm'){
        tempPriceLevel = 5;
      }
    }
    if($('#glassOrderObscureSIG option:selected').val() == "#REED" || $('#glassOrderObscureSIG option:selected').val() == "#REEMY"){
      tempPriceLevel2 = 3;
    }else if($('#glassOrderObscureSIG option:selected').val() == "#FROS" || $('#glassOrderObscureSIG option:selected').val() == "#GLUE"){
      tempPriceLevel2 = 2;
    }
    if(tempPriceLevel2 > tempPriceLevel){
      tempPriceLevel = tempPriceLevel2;
    }
    if(tempPriceLevel > priceLevel){
      priceLevel = tempPriceLevel;
    }   
    gOrderTint = $('#glassOrderTintSIG option:selected').val();
    if(gOrderTint == "no"){
      gOrderTint = "";
    }
    gOrderOBSC = $('#glassOrderObscureSIG option:selected').val();
    if(gOrderOBSC == "no"){
      gOrderOBSC = "";
    }
    if(gOrderTemper == '#'){
      gOrderTemper = "";      
    }
    gOrderGrillePatt = '#GPATT';
    gOrderSpacer =$('#glassOrderSpacer option:selected').val();
    gOrderHard = $('#glassOrderHardSIG option:selected').val();
    gOrderPreserve = $('#glassOrderPreserveSIG option:selected').val();
    $.ajax({
      url:"glassPricing.php",
      type: "GET",
      data:{
        p:gOrderProduct,
        ty:gOrderType,
        tm:gOrderTemper,
        ti:gOrderTint,
        ob:gOrderOBSC,
        sp:gOrderSpacer,
        h:gOrderHard,
        pl:priceLevel,
        pr:gOrderPreserve
      },
      async:false,
      success:function(data){
        tempNewPrice = data;
        //tempNewPrice = Math.ceil(tempNewPrice*100)/100;
        //tempNewPrice = parseFloat(tempNewPrice *((glassPriceWidth * glassPriceHeight)/144)).toFixed(2);
        if((glassPriceWidth * glassPriceHeight)/144 < 3){
            tempNewPrice = parseFloat(tempNewPrice * 3).toFixed(2);  
        }else{
          tempNewPrice = parseFloat(tempNewPrice *((glassPriceWidth * glassPriceHeight)/144)).toFixed(2);
        }
        //tempNewPrice *= +priceSquareFeet;
        //tempNewPrice = parseFloat(Math.round((tempNewPrice*1000)/1000)).toFixed(2);
      }
    });
    $.ajax({
      url:"glassGrillePrice.php",
      type: "GET",
      data:{
        p:gOrderProduct,
        gt:gOrderGrille,
        gp:gOrderGrillePatt,
        ln:numLites
      },
      async:false,
      success:function(data){
        tempNewPrice = +data + +tempNewPrice;
        //tempNewPrice = parseFloat(Math.round((tempNewPrice*1000)/1000)).toFixed(2);
        //tempNewPrice = Math.ceil(tempNewPrice*100)/100;
      }
    });
   }else if(lookVal == "TR"){
    clearGOrders();
    gOrderProduct = "TRIPLE";
    gOrderType = $('#glassOrderTypeTR option:selected').val();
    gOrderTypeTxt = $('#glassOrderTypeTR option:selected').text();
    gOrderGrille = $('#glassOrderGrilleTR option:selected').val();
    gOrderTemper = $('#glassOrderStrengthTR option:selected').val();
   if($('#glassOrderThicknessTR').is(':visible')){
      if($('#glassOrderThicknessTR option:selected').val().match(/(\d+)/)[0] > priceLevel){
        priceLevel = $('#glassOrderThicknessTR option:selected').val().match(/(\d+)/)[0];
      }
    }    
    tempPriceLevel = 0;
    if($('#glassOrderTemper').is(':visible')){
      if($('#glassOrderTemper option:selected').val() == '3.1 mm'){
        tempPriceLevel = 2;
      }else if($('#glassOrderTemper option:selected').val() == '3.9 mm'){
        tempPriceLevel = 3;
      }else if($('#glassOrderTemper option:selected').val() == '4.7 mm'){
        tempPriceLevel = 4;
      }else if($('#glassOrderTemper option:selected').val() == '5.7 mm'){
        tempPriceLevel = 5;
      }
    }
    if($('#glassOrderObscureTR option:selected').val() == "#REED" || $('#glassOrderObscureTR option:selected').val() == "#REEMY"){
      tempPriceLevel2 = 3;
    }else if($('#glassOrderObscureTR option:selected').val() == "#FROS" || $('#glassOrderObscureTR option:selected').val() == "#GLUE"){
      tempPriceLevel2 = 2;
    }
    if(tempPriceLevel2 > tempPriceLevel){
      tempPriceLevel = tempPriceLevel2;
    }
    if(tempPriceLevel > priceLevel){
      priceLevel = tempPriceLevel;
    }   
    gOrderTint = $('#glassOrderTintTR option:selected').val();
    gOrderTriple = $('#glassOrderTypeSurface option:selected').val();
    if(gOrderTint == "no"){
      gOrderTint = "";
    }
    gOrderOBSC = $('#glassOrderObscureTR option:selected').val();
    if(gOrderOBSC == "no"){
      gOrderOBSC = "";
    }
    if(gOrderTemper == '#'){
      gOrderTemper = "";      
    }
    gOrderGrillePatt = $('#glassOrderGrillePattTR option:selected').val();
    gOrderSpacer =$('#glassOrderSpacer option:selected').val(); 
    gOrderHard = $('#glassOrderHardTR option:selected').val();
    gOrderPreserve = $('#glassOrderPreserveTR option:selected').val();
    $.ajax({
      url:"glassPricing.php",
      type: "GET",
      data:{
        p:gOrderProduct,
        ty:gOrderTriple,
        tm:gOrderTemper,
        ti:gOrderTint,
        ob:gOrderOBSC,
        sp:gOrderSpacer,
        h:gOrderHard,
        pl:priceLevel,
        pr:gOrderPreserve,
        tr:gOrderTriple
      },
      async:false,
      success:function(data){
        tempNewPrice = +data;
        //tempNewPrice = parseFloat(Math.round((tempNewPrice*1000)/1000)).toFixed(2);
        //tempNewPrice = Math.ceil(tempNewPrice*100)/100;
      }
    });
    priceAdjust = 0;
    if(gOrderType == "#340"){
      priceAdjust = 3.4;
    }else if(gOrderType != "#340" && gOrderType != "#CLR" && gOrderType != "#272"){
      priceAdjust = .85;
    }
    /*$.ajax({
      url:"glassPricing.php",
      type: "GET",
      data:{
        p:"RECTANGLE",
        ty:gOrderType,
        tm:gOrderTemper,
        ti:gOrderTint,
        ob:gOrderOBSC,
        sp:gOrderSpacer,
        h:gOrderHard,
        pl:priceLevel,
        pr:gOrderPreserve,
      },
      async:false,
      success:function(data){
        tempNewPrice = +tempNewPrice + (+data - priceAdjust);
        //tempNewPrice = Math.ceil(tempNewPrice*100)/100;
        //tempNewPrice *= +priceSquareFeet;
        //tempNewPrice = parseFloat(tempNewPrice *((glassPriceWidth * glassPriceHeight)/144)).toFixed(2);
        if((glassPriceWidth * glassPriceHeight)/144 < 3){
            tempNewPrice = parseFloat(tempNewPrice * 3).toFixed(2);  
        }else{
          tempNewPrice = parseFloat(tempNewPrice *((glassPriceWidth * glassPriceHeight)/144)).toFixed(2);
        }
        //tempNewPrice = parseFloat(Math.round((tempNewPrice*1000)/1000)).toFixed(2);
      }
    });*/
    if((glassPriceWidth * glassPriceHeight)/144 < 3){
            tempNewPrice = parseFloat(tempNewPrice * 3).toFixed(2);  
        }else{
          tempNewPrice = parseFloat(tempNewPrice *((glassPriceWidth * glassPriceHeight)/144));
        }
    $.ajax({
      url:"glassGrillePrice.php",
      type: "GET",
      data:{
        p:gOrderProduct,
        gt:gOrderGrille,
        gp:gOrderGrillePatt,
        ln:numLites
      },
      async:false,
      success:function(data){
        tempNewPrice += +data;
        //tempNewPrice = parseFloat(Math.round((tempNewPrice*1000)/1000)).toFixed(2);
        //tempNewPrice = Math.ceil(tempNewPrice*100)/100;
      }
    });
   }else if(lookVal == "TS"){
    clearGOrders();
    gOrderProduct = "TRIPLE";
    gOrderType = $('#glassOrderTypeTS option:selected').val();
    gOrderTypeTxt = $('#glassOrderTypeTS option:selected').text();
    gOrderGrille = $('#glassOrderGrilleTS option:selected').val();
    gOrderTemper = $('#glassOrderStrengthTS option:selected').val();
    gOrderTint = $('#glassOrderTintTS option:selected').val();
    if($('#glassOrderThicknessTS').is(':visible')){
      if($('#glassOrderThicknessTS option:selected').val().match(/(\d+)/)[0] > priceLevel){
        priceLevel = $('#glassOrderThicknessTS option:selected').val().match(/(\d+)/)[0];
      }
    }    
    tempPriceLevel = 0;
    if($('#glassOrderTemper').is(':visible')){
      if($('#glassOrderTemper option:selected').val() == '3.1 mm'){
          tempPriceLevel = 2;
      }else if($('#glassOrderTemper option:selected').val() == '3.9 mm'){
          tempPriceLevel = 3;
      }else if($('#glassOrderTemper option:selected').val() == '4.7 mm'){
          tempPriceLevel = 4;
      }else if($('#glassOrderTemper option:selected').val() == '5.7 mm'){
          tempPriceLevel = 5;
      }
    }
    if($('#glassOrderObscureTS option:selected').val() == "#REED" || $('#glassOrderObscureTS option:selected').val() == "#REEMY"){
      tempPriceLevel2 = 3;
    }else if($('#glassOrderObscureTS option:selected').val() == "#FROS" || $('#glassOrderObscureTS option:selected').val() == "#GLUE"){
      tempPriceLevel2 = 2;
    }
    if(tempPriceLevel2 > tempPriceLevel){
      tempPriceLevel = tempPriceLevel2;
    }
    if(tempPriceLevel > priceLevel){
      priceLevel = tempPriceLevel;
    }   
    gOrderTriple = $('#glassOrderTypeSurface option:selected').val();
    if(gOrderTint == "no"){
        gOrderTint = "";
    }
    gOrderOBSC = $('#glassOrderObscureTS option:selected').val();
    if(gOrderOBSC == "no"){
        gOrderOBSC = "";
    }
    if(gOrderTemper == '#'){
      gOrderTemper = "";      
    }
    gOrderGrillePatt = '#GPATT';
    gOrderSpacer =$('#glassOrderSpacer option:selected').val();
    gOrderHard = $('#glassOrderHardTS option:selected').val();
    gOrderPreserve = $('#glassOrderPreserveTS option:selected').val();
    $.ajax({
      url:"glassPricing.php",
      type: "GET",
      data:{
        p:gOrderProduct,
        ty:gOrderTriple,
        tm:gOrderTemper,
        ti:gOrderTint,
        ob:gOrderOBSC,
        sp:gOrderSpacer,
        h:gOrderHard,
        pl:priceLevel,
        pr:gOrderPreserve,
        tr:gOrderTriple
      },
      async:false,
      success:function(data){
        tempNewPrice = +data;
        //tempNewPrice = parseFloat(Math.round((tempNewPrice*1000)/1000)).toFixed(2);
        //tempNewPrice = Math.ceil(tempNewPrice*100)/100; 
      }
    });
    $.ajax({
      url:"glassPricing.php",
      type: "GET",
      data:{
        p:priceShape,
        ty:gOrderType,
        tm:gOrderTemper,
        ti:gOrderTint,
        ob:gOrderOBSC,
        sp:gOrderSpacer,
        h:gOrderHard,
        pl:priceLevel,
        pr:gOrderPreserve,
        tr:gOrderTriple
      },
      async:false,
      success:function(data){
        tempNewPrice = +tempNewPrice + +data;
        //tempNewPrice = Math.ceil(tempNewPrice*100)/100;
        //tempNewPrice = parseFloat(tempNewPrice *((glassPriceWidth * glassPriceHeight)/144)).toFixed(2);
        if((glassPriceWidth * glassPriceHeight)/144 < 3){
            tempNewPrice = parseFloat(tempNewPrice * 3).toFixed(2);  
        }else{
          tempNewPrice = parseFloat(tempNewPrice *((glassPriceWidth * glassPriceHeight)/144)).toFixed(2);
        }
        //tempNewPrice *= +priceSquareFeet;
        //tempNewPrice = parseFloat(Math.round((tempNewPrice*1000)/1000)).toFixed(2);
      }
    });
    $.ajax({
      url:"glassGrillePrice.php",
      type: "GET",
      data:{
        p:gOrderProduct,
        gt:gOrderGrille,
        gp:gOrderGrillePatt,
        ln:numLites
      },
      async:false,
      success:function(data){
        tempNewPrice = +data + +tempNewPrice;
        //tempNewPrice = Math.ceil(tempNewPrice*100)/100;
        //tempNewPrice = parseFloat(Math.round((tempNewPrice*1000)/1000)).toFixed(2);
      }
    });
   }else if(lookVal == "MR"){
    clearGOrders();
    gOrderProduct = "MONO";
    gOrderType = "";
    gOrderTypeTxt = "";
    if($('#glassOrderThicknessMR').is(':visible')){
        if($('#glassOrderThicknessMR option:selected').val().match(/(\d+)/)[0] > priceLevel){
            priceLevel = $('#glassOrderThicknessMR option:selected').val().match(/(\d+)/)[0];
        }
    }    
    tempPriceLevel = 0;
    if($('#glassOrderTemper').is(':visible')){
      if($('#glassOrderTemper option:selected').val() == '3.1 mm'){
          tempPriceLevel = 2;
      }else if($('#glassOrderTemper option:selected').val() == '3.9 mm'){
          tempPriceLevel = 3;
      }else if($('#glassOrderTemper option:selected').val() == '4.7 mm'){
          tempPriceLevel = 4;
      }else if($('#glassOrderTemper option:selected').val() == '5.7 mm'){
          tempPriceLevel = 5;
      }
    }
    if($('#glassOrderObscureMR option:selected').val() == "#REED" || $('#glassOrderObscureMR option:selected').val() == "#REEMY"){
      tempPriceLevel2 = 3;
    }else if($('#glassOrderObscureMR option:selected').val() == "#FROS" || $('#glassOrderObscureMR option:selected').val() == "#GLUE"){
      tempPriceLevel2 = 2;
    }
    if(tempPriceLevel2 > tempPriceLevel){
      tempPriceLevel = tempPriceLevel2;
    }
    if(tempPriceLevel > priceLevel){
      priceLevel = tempPriceLevel;
    }   
    gOrderTemper = $('#glassOrderStrengthMR option:selected').val();
    gOrderTint = $('#glassOrderTintMR option:selected').val();
    if(gOrderTint == "no"){
        gOrderTint = "";
    }
    gOrderOBSC = $('#glassOrderObscureMR option:selected').val();
    if(gOrderOBSC == "no"){
        gOrderOBSC = "";
    }
    if(gOrderTemper == '#'){
      gOrderTemper = "";      
    }
    gOrderHard = $('#glassOrderHardMR option:selected').val();
    $.ajax({
      url:"glassPricing.php",
      type: "GET",
      data:{
        p:gOrderProduct,
        ty:'#CLR',
        tm:gOrderTemper,
        ti:gOrderTint,
        ob:gOrderOBSC,
        h:gOrderHard,
        pl:priceLevel
      },
      async:false,
      success:function(data){
        tempNewPrice = data;
        //tempNewPrice = parseFloat(Math.round((tempNewPrice*1000)/1000)).toFixed(2);
        /*
        if(priceLevel == '2'){
          tempNewPrice *= 2;
        }else if(priceLevel == '1'){
          tempNewPrice *= 1.5;
        }*/
      }
    });
    $.ajax({
      url:"glassPricing.php",
      type: "GET",
      data:{
        p:'RECTANGLE',
        ty:'',
        g:'',
        tm:'',
        ti:'',
        ob:gOrderOBSC,
        gp:'',
        sp:'',
        h:gOrderHard,
        pl:'0',
        pr:'',
        tr:''
      },
      async:false,
      success:function(data){
        tempNewPrice = +tempNewPrice + +data;
        //tempNewPrice = Math.ceil(tempNewPrice*100)/100;
        //tempNewPrice = parseFloat(tempNewPrice *((glassPriceWidth * glassPriceHeight)/144)).toFixed(2);
        if((glassPriceWidth * glassPriceHeight)/144 < 3){
            tempNewPrice = parseFloat(tempNewPrice * 3).toFixed(2);  
        }else{
          tempNewPrice = parseFloat(tempNewPrice *((glassPriceWidth * glassPriceHeight)/144)).toFixed(2);
        }
        //tempNewPrice *= +priceSquareFeet;
        //tempNewPrice = parseFloat(Math.round((tempNewPrice*1000)/1000)).toFixed(2);
        /*
        if(priceLevel == '2'){
          tempNewPrice *= 2;
        }else if(priceLevel == '1'){
          tempNewPrice *= 1.5;
        }*/
      }
    });
   }else if(lookVal == "MS"){
    clearGOrders();
    $('#glassOverallLabel').hide();
    gOrderProduct = "MONO";
    gOrderType = $('#glassOrderTypeMS option:selected').val();
    gOrderTypeTxt = $('#glassOrderTypeMS option:selected').text();
    if($('#glassOrderThicknessMS').is(':visible')){
        if($('#glassOrderThicknessMS option:selected').val().match(/(\d+)/)[0] > priceLevel){
            priceLevel = $('#glassOrderThicknessMS option:selected').val().match(/(\d+)/)[0];
        }
    }    
    tempPriceLevel = 0;
    if($('#glassOrderTemper').is(':visible')){
      if($('#glassOrderTemper option:selected').val() == '3.1 mm'){
          tempPriceLevel = 2;
      }else if($('#glassOrderTemper option:selected').val() == '3.9 mm'){
          tempPriceLevel = 3;
      }else if($('#glassOrderTemper option:selected').val() == '4.7 mm'){
          tempPriceLevel = 4;
      }else if($('#glassOrderTemper option:selected').val() == '5.7 mm'){
          tempPriceLevel = 5;
      }
    }
    if($('#glassOrderObscureMS option:selected').val() == "#REED" || $('#glassOrderObscureMS option:selected').val() == "#REEMY"){
      tempPriceLevel2 = 3;
    }else if($('#glassOrderObscureMS option:selected').val() == "#FROS" || $('#glassOrderObscureMS option:selected').val() == "#GLUE"){
      tempPriceLevel2 = 2;
    }
    if(tempPriceLevel2 > tempPriceLevel){
      tempPriceLevel = tempPriceLevel2;
    }
    if(tempPriceLevel > priceLevel){
      priceLevel = tempPriceLevel;
    }   
    gOrderTemper = $('#glassOrderStrengthMS option:selected').val();
    gOrderTint = $('#glassOrderTintMS option:selected').val();
    if(gOrderTint == "no"){
        gOrderTint = "";
    }
    gOrderOBSC = $('#glassOrderObscureMS option:selected').val();
    if(gOrderOBSC == "no"){
        gOrderOBSC = "";
    }
    if(gOrderTemper == '#'){
      gOrderTemper = "";      
    }
    gOrderHard = $('#glassOrderHardMS option:selected').val();
    $.ajax({
      url:"glassPricing.php",
      type: "GET",
      data:{
        p:gOrderProduct,
        ty:'#CLR',
        tm:gOrderTemper,
        ti:gOrderTint,
        ob:gOrderOBSC,
        h:gOrderHard,
        pl:priceLevel
      },
      async:false,
      success:function(data){
        tempNewPrice = data;
        if(priceShape == '2'){
          tempNewPrice *= 2;
        }else if(priceShape == '1'){
          tempNewPrice *= 1.5;
        }
        //tempNewPrice = parseFloat(Math.round((tempNewPrice*1000)/1000)).toFixed(2);
      }
    });
    $.ajax({
      url:"glassPricing.php",
      type: "GET",
      data:{
        p:priceShape,
        ty:'#CLR',
        ob:gOrderOBSC,
        h:gOrderHard,
        pl:priceLevel
      },
      async:false,
      success:function(data){
        tempNewPrice = +tempNewPrice + +data;
        //tempNewPrice = Math.ceil(tempNewPrice*100)/100;
        //tempNewPrice = parseFloat(tempNewPrice *((glassPriceWidth * glassPriceHeight)/144)).toFixed(2);
        if((glassPriceWidth * glassPriceHeight)/144 < 3){
            tempNewPrice = parseFloat(tempNewPrice * 3).toFixed(2);  
        }else{
          tempNewPrice = parseFloat(tempNewPrice *((glassPriceWidth * glassPriceHeight)/144)).toFixed(2);
        }
        //tempNewPrice *= +priceSquareFeet;
        if(priceShape == '2'){
          tempNewPrice *= 2;
        }else if(priceShape == '1'){
          tempNewPrice *= 1.5;
        }
        //tempNewPrice = parseFloat(Math.round((tempNewPrice*1000)/1000)).toFixed(2);
      }
    });
   }   
  /*
    p = product
    ty = type
    g = grille
    tm = temper
    ti = tint
    ob = obsc
    gp = grille pattern
    sp = spacer
    h = hard
    pl = price level
  */
    
    //tempNewPrice *= $('#glassOrderQuant').val();
    //tempNewPrice = Math.ceil(tempNewPrice * 1000)/1000;
    $('#bottomHalf').show();
    if(editTblRow == 0){
      newid++;
      lineNum = savedLineNum;
      lineNum++;
      /*if(deleteCount > 0){
        newid = newid - deleteCount;
      }*/
    var lineNumDiv = "<div id = line" + newid+ " name='lineNumDivName'>"+lineNum+"</div>";
    var tr = $("<tr></tr>", {
        id: "addr"+newid,
        "data-id": (newid)
     });
     
     // loop through each td and create new elements with name of newid
     $.each($("#tab_logic tbody tr:nth(0) td"), function(){
        var cur_td = $(this);
        var children = cur_td.children();
        // add new td and element if it has a name
        if($(this).data("name") != undefined){
          var td = $("<td></td>", {
            "data-name": $(cur_td).data("name")
          });
          var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
          c.attr("name", $(cur_td).data("name") + newid);
          var name10 = c.attr("name");
          c.attr("id",c.attr("name"));
          c.val(c.attr('placeholder'));
          var v = "window";
          c.appendTo($(td));
          td.appendTo($(tr));  
        }else{
          var td = $("<td></td>", {
            'text': $('#tab_logic tr').length
          }).appendTo($(tr));
       
        }
    });
    }
    
     // add the new row
     $(tr).appendTo($('#tab_logic'));
     var quantTextId = "quantText" + newid;
     var tblDelButtons = '<button name="del0" title="Delete Line" id="deleteRow" onclick="deleteRow(this)" class="btn btn-danger row-remove in" style="margin-top:8px;width:100%;"><span class="glyphicon glyphicon-remove"></span></button>';
     var editButtons = '<button name="edit0" title="Edit Line" id="editBotRow" onclick="editTbl(this)"class="btn btn-primary row-remove in" style="margin-top:8px;width:100%"><span class="glyphicon glyphicon-pencil"></span></button>'
     var glassQuantity = $('#glassOrderQuant').val();
     var gOrderSum = "<div style=font-size:1.1em>";
     var count = 0;
     if($('#otherGlassOptions2').is(':hidden')){
        $('#showOtherOptions').click();
     }
     $('.glassInput:visible').each(function(){
        if($(this).is('select')){
          gOrderSum += " " + $('#'+$(this).attr('id')+' option:selected').text().split(' - ')[0];
        }else if($(this).is('input')){
          //console.log($("label[for='"+$(this).attr('id')+'"]'));
          if(count < 3){
            gOrderSum +=" " + $('#'+$(this).attr('id')).val() + '" ';
            count++;
          }else{
            gOrderSum += $('#'+$(this).attr('id')).val();
            count++;
          }
        }else{
          gOrderSum += "<b> " + $(this).html()+" </b>";
        }
      });
      gOrderSum +="</div>";
      if($('#otherGlassOptions2').is(':visible')){
        $('#showOtherOptions').click();
      }
      if(((glassPriceWidth * glassPriceHeight)/144).toFixed(2) > 30){
        tempNewPrice = tempNewPrice * 1;
      }
      var hiddenId = "hiddenInput" + newid;
      var hiddenIdTwo = "hiddenInputTwo" + newid;
      var hiddenPriceIn = "<input type ='hidden' id ="+hiddenId+" name ='hiddenInput' style='width:0%'></input>";
      var hiddenPriceIn2 = "<input type ='hidden' id ="+hiddenIdTwo+" name ='hiddenInput2' style='width:0%'></input>";
      var multiplierAmt = document.getElementById('multiplierIn').value;
      var markupPerc = 1 + (+document.getElementById('markupPercIn').value.replace('%','')/100);
      storeHeight = $('#glassHeight1').val();
      storeWidth = $('#glassWidth1').val();
      var oldPrice = $("#tab_logic").find('tr#addr'+(newid-1)).find('td:eq(11)').text().replace(/^\D+/g, "");
      var tempOldPrice = $('#priceFooter').html().replace(/^\D+/g, "");
      var price = $('#priceFooter').html().replace(/^\D+/g, "");
      var listId = "listString" + newid;
      var listString = "<div id ="+listId+" name ='listString'></div>";
      sellPrice = (tempNewPrice * markupPerc * multiplierAmt).toFixed(2);
      netPrice =  (tempNewPrice * multiplierAmt).toFixed(2);
      var deliveryCharge = 0;
      hGlassLabel = $('#hiddenGlassLabel').val();
      if(editTblRow == 0){
        lineLabelId = 'lineLabel'+newid;
      }
      glassQuantBot = $('#glassOrderQuant').val();
      var glassLineLabel = "<input type='text' class = 'squareCorners in' onkeyup='updateLabel(this)' name ='lineLabels' value='"+hGlassLabel+"' id ='"+lineLabelId+"'/>&nbsp;&nbsp;<span name = 'labelCheckName' class='glyphicon glyphicon-ok hidden' title='Label Saved' style='font-size:1.25em;color:green'></span>";
      var tblInputString = '<strong>Quantity:</strong><input type="text" name = "quantityText" onkeyup="updateQuant(this)" class="form-control squareCorners" style ="height:30px;" placeholder="QTY." value = "'+glassQuantBot+'" id ='+ quantTextId+' style="width:100%">';
      var priceLevel = 0;
      //tempNewPrice *= priceMulti;
      
      tempNewPrice = parseFloat(Math.round(+tempNewPrice * 100) / 100).toFixed(2);
      drawingReq = "";
      if($('#glassOrderGrillePatt'+lookVal+' option:selected').text().toLowerCase().indexOf('custom') > -1 && $('#glassOrderGrillePatt'+lookVal).is(':visible')){
        drawingReq = "<b style='color:red;font-size:1.25em;'>&nbsp;&nbsp;&nbsp;***Grille Drawing Required***</b>";
      }else{
        drawingReq = "";
      }
      var glassWarranty = "";
      if($('#glassOrderLogo option:selected').text() == "No"){
        glassWarranty = "<b style='font-size:1.25em;'>***Warranty Void Without IG Logo***</b>";
      }else{
        glassWarranty = "";
      }
      if(blankRow == 1){
        listString = "<div id ="+listId+" name ='listString'>$"+addPrice.toFixed(2)+"</div>";
        glassLineLabel = "&nbsp;";
        tempNewPrice = addPrice;
      }
      //tempNewPrice = Math.round((+tempNewPrice + .00001) * 1000)/1000;
      $("#tab_logic").find('tr#addr'+newid).find('td:eq(1)').html(tblInputString + editButtons + tblDelButtons + hiddenPriceIn + hiddenPriceIn2);
      $("#tab_logic").find('tr#addr'+newid).find('td:eq(0)').html(lineNumDiv);
      //displayWidth = Math.floor(displayWidth/12) +"' "+parseFloat(displayWidth%12).toFixed(2)+'"';
      //displayHeight = Math.floor(displayHeight/12) +"' "+parseFloat(displayHeight%12).toFixed(2)+'"';
      displayWidth = new Fraction(parseFloat(displayWidth).toFixed(2)).toString();
      displayHeight = new Fraction(parseFloat(displayHeight).toFixed(2)).toString();
      if($('#glassWidth1').val().indexOf('/') > -1){
        botWidth = $('#glassWidth1').val() + '"';
      }else{
        botWidth = $('#glassWidth1').val();
      }
      if($('#glassHeight1').val().indexOf('/') > -1){
        botHeight = $('#glassHeight1').val() + '"';
      }else{
        botHeight = $('#glassHeight1').val();
      }
      $('#tab_logic').find('tr#addr'+newid).find('td:eq(2)').html("<b class='in'>Label:&nbsp;</b>"+glassLineLabel +"<br><br><p><b style='font-size:1.33em'>Dimensions: "+botWidth+" X "+botHeight+"</b><p></p>\n" + gOrderSum+"<p></p>"+ addItmsLine + "<p></p>" + glassWarranty + " " + drawingReq);
      if(blankRow == 1){
        $('#tab_logic').find('tr#addr'+newid).find('td:eq(2)').html(addItmsLine);
      }
      $('#tab_logic').find('tr#addr'+newid).find('td:eq(3)').html(listString);
      if(disPrice == 0){
        $('#tab_logic').find('tr#addr'+newid).find('td:eq(3)').html('');
      } 
      $("#tab_logic").find('tr#addr'+newid).find('#hiddenInput' + newid).attr('value',tempNewPrice);
      $("#tab_logic").find('tr#addr'+newid).find('[name = "hiddenInput2"]').val($("#tab_logic").find('tr#addr'+newid).find('[name = "hiddenInput"]').val());
      if(blankRow == 0){
        $("#tab_logic").find('tr#addr'+newid).find('#listString' + newid).html("$" + tempNewPrice);
      }
      $('#priceFooter').html("<strong>Total Price: </strong>$"+parseFloat(Math.round((+tempNewPrice + +tempOldPrice + +deliveryCharge)*100)/100).toFixed(2));
      if(disPrice == 0){
        $('#priceFooter').html("<strong>Total Price: </strong>");
      }else if(disPrice == 2){
        tempCostPrice = parseFloat(Math.round((+tempNewPrice  * $('#multiplierIn').val())*100)/100).toFixed(2);
        $('#priceFooter').html("<strong>Total Price: </strong>$"+parseFloat(Math.round((+tempCostPrice + +tempOldPrice + +deliveryCharge)*100)/100).toFixed(2));
      }else{
        $('#priceFooter').html("<strong>Total Price: </strong>$"+parseFloat(Math.round((+tempNewPrice + +tempOldPrice + +deliveryCharge)*100)/100).toFixed(2));
      }
      $(tr).find("td button.popover-dismiss").on("click", function(){
        if($(this).find("span.tblSpan").hasClass('glyphicon glyphicon-chevron-up')){
          $(this).find("span.tblSpan").removeClass('glyphicon glyphicon-chevron-up');
          $(this).find("span.tblSpan").addClass('glyphicon glyphicon-chevron-down');
        }else if($(this).find("span.tblSpan").hasClass('glyphicon glyphicon-chevron-down')){
          $(this).find("span.tblSpan").removeClass('glyphicon glyphicon-chevron-down');
          $(this).find("span.tblSpan").addClass('glyphicon glyphicon-chevron-up');
        }
      });
    if(blankRow == 0){
      savedGQuant = escapeHtml($('#glassOrderQuant').val());
    }else{
      savedGQuant = "";
    }
    addItmsLine = "";
    $('#glassWidth1').val('');
    $('#glassHeight1').val('');
    $('#glassOrderQuant').val('1');
    $(this).blur();
    $('html, body').animate(
      { 
      scrollTop: $(document).height()-$(window).height()
      }, 
      100, 
      "swing"
    );
    salesOrderNum = jobNumber.trim();
    savedGPrice = 0;
    if(blankRow == 0){
      if($('#glassOrderProduct option:selected').text().indexOf('Shape') > -1){
        productFunction  = "+";
      }else{
        productFunction = "";
      }
      /*savedGPArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: "0",
        newLine: "0",
        option: escapeHtml($('#glassProductLabel').html().replace(':','')),
        optionVal: escapeHtml($('#glassOrderProduct option:selected').val()),
        custEntries: "",
        function: productFunction,
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: ""
      });*/
      if($('#glassOrderProduct option:selected').val().toLowerCase().indexOf('shape') > -1){
        if($('#glassOrderShape option:selected').attr('id').length == 1){
          arrShape = "0" + escapeHtml($('#glassOrderShape option:selected').text().replace('#',"").toUpperCase());
        }else{
          arrShape = escapeHtml($('#glassOrderShape option:selected').text().replace('#',"").toUpperCase());
        }  
      }else{
        arrShape = "";
      }
      arrShpBase = parseFloat($('#shapeDimBase').val());
      arrShpLeft = parseFloat($('#shapeDimLeft').val());
      arrShpRight = parseFloat($('#shapeDimRight').val());
      arrShpTop = parseFloat($('#shapeDimTop').val());
      arrShpS1 = parseFloat($('#shapeDimS1').val());
      arrShpS2 = parseFloat($('#shapeDimS1').val());
      arrShpRad = parseFloat($('#shapeDimRadius').val());
      if(!isNaN(arrShpBase)){
        if(arrShpBase.toString().indexOf('/')>-1){
          arrShpBaseWhole = arrShpBase.toString().split('-')[0];
          arrShpBaseFraction = arrShpBase.toString().split('-')[1];
          if(arrShpBaseWhole.length == 1){
            arrShpBaseWhole = "00"+arrShpBaseWhole;
          }else if(arrShpBaseWhole.length == 2){
            arrShpBaseWhole = "0"+arrShpBaseWhole;
          }
          if(arrShpBaseFraction.length == 3){
            arrShpBaseFraction = "  " + arrShpBaseFraction;
          }else if(arrShpBaseFraction.length == 4){
            arrShpBaseFraction = " " + arrShpBaseFraction;
          }//BOOKMARK HERE 
        }else if(arrShpBase.toString().indexOf('.')>-1){
          arrShpBase = new Fraction(arrShpBase).toString();
          arrShpBaseFraction = addZeros(arrShpBase.split(' ')[1]);
          if(arrShpBaseFraction.length == 3){
            arrShpBaseFraction = "  " + arrShpBaseFraction;
          }else if(arrShpBaseFraction.length == 4){
            arrShpBaseFraction = " " + arrShpBaseFraction;
          }
          arrShpBaseWhole = addZeros(arrShpBase.split(' ')[0]);
        }else{
          if(arrShpBase != ''){
            arrShpBaseFraction = "     ";
          }else{
            arrShpBaseFraction = '';
          }  
          if(arrShpBase.toString().length == 1){
            arrShpBaseWhole= "00"+ arrShpBase.toString();
          }else if(arrShpBase.toString().length == 2){
            arrShpBaseWhole = "0"+ arrShpBase.toString();
          }else{
            arrShpBaseWhole = arrShpBase.toString();
          }
        }
    }else{
      arrShpBase = "000";
      arrShpBaseWhole = "000";
      arrShpBaseFraction = "     ";
    }
    if(!isNaN(arrShpLeft)){
      if(arrShpLeft.toString().indexOf('/')>-1){
        arrShpLeftWhole = arrShpLeft.toString().split('-')[0];
        arrShpLeftFraction = arrShpLeft.toString().split('-')[1];
        if(arrShpLeftWhole.length == 1){
          arrShpLeftWhole = "00"+arrShpLeftWhole;
        }else if(arrShpLeftWhole.length == 2){
          arrShpLeftWhole = "0"+arrShpLeftWhole;
        }
        if(arrShpLeftFraction.length == 3){
          arrShpLeftFraction = "  " + arrShpLeftFraction;
        }else if(arrShpLeftFraction.length == 4){
          arrShpLeftFraction = " " + arrShpLeftFraction;
        }
        }else if(arrShpLeft.toString().indexOf('.')>-1){
          arrShpLeft = new Fraction(arrShpLeft).toString();
          arrShpLeftFraction = addZeros(arrShpLeft.split(' ')[1]);
          if(arrShpLeftFraction.length == 3){
            arrShpLeftFraction = "  " + arrShpLeftFraction;
          }else if(arrShpLeftFraction.length == 4){
            arrShpLeftFraction = " " + arrShpLeftFraction;
          }
          arrShpLeftWhole = addZeros(arrShpLeft.split(' ')[0]);
        }else{
        if(arrShpLeft != ''){
          arrShpLeftFraction = "     ";
        }else{
          arrShpLeftFraction = '';
        }
        if(arrShpLeft.toString().length == 1){
          arrShpLeftWhole= "00"+ arrShpLeft.toString();
        }else if(arrShpLeft.toString().length == 2){
          arrShpLeftWhole = "0"+ arrShpLeft.toString();
        }else{
          arrShpLeftWhole = arrShpLeft.toString();
        }
      }
    }else{
      arrShpLeft = "000";
      arrShpLeftWhole = "000";
      arrShpLeftFraction = "     ";
    }
    if(!isNaN(arrShpRight)){  
      if(arrShpRight.toString().indexOf('/')>-1){
        arrShpRightWhole = arrShpRight.toString().split('-')[0];
        arrShpRightFraction = arrShpRight.toString().split('-')[1];
        if(arrShpRightWhole.length == 1){
          arrShpRightWhole = "00"+arrShpRightWhole;
        }else if(arrShpRightWhole.length == 2){
          arrShpRightWhole = "0"+arrShpRightWhole;
        }
        if(arrShpRightFraction.length == 3){
          arrShpRightFraction = "  " + arrShpRightFraction;
        }else if(arrShpRightFraction.length == 4){
          arrShpRightFraction = " " + arrShpRightFraction;
        }
      }else if(arrShpRight.toString().indexOf('.')>-1){
          arrShpRight = new Fraction(arrShpRight).toString();
          arrShpRightFraction = addZeros(arrShpRight.split(' ')[1]);
          if(arrShpRightFraction.length == 3){
            arrShpRightFraction = "  " + arrShpRightFraction;
          }else if(arrShpRightFraction.length == 4){
            arrShpRightFraction = " " + arrShpRightFraction;
          }
          arrShpRightWhole = addZeros(arrShpRight.split(' ')[0]);
        
      }else{
        if(arrShpRight != ''){
          arrShpRightFraction = "     ";
        }else{
          arrShpRightFraction = '';
        }
        if(arrShpRight.toString().length == 1){
          arrShpRightWhole= "00"+ arrShpRight.toString();
        }else if(arrShpRight.toString().length == 2){
          arrShpRightWhole = "0"+ arrShpRight.toString();
        }else{
          arrShpRightWhole = arrShpRight.toString();
        }
      }
    }else{
      arrShpRight = "000";
      arrShpRightWhole = "000";
      arrShpRightFraction = "     ";
    }
    if(!isNaN(arrShpTop)){     
      if(arrShpTop.toString().indexOf('/')>-1){
        arrShpTopWhole = arrShpTop.toString().split('-')[0];
        arrShpTopFraction = arrShpTop.toString().split('-')[1];
        if(arrShpTopWhole.length == 1){
          arrShpTopWhole = "00"+arrShpTopWhole;
        }else if(arrShpTopWhole.length == 2){
          arrShpTopWhole = "0"+arrShpTopWhole;
        }
        if(arrShpTopFraction.length == 3){
          arrShpTopFraction = "  " + arrShpTopFraction;
        }else if(arrShpTopFraction.length == 4){
          arrShpTopFraction = " " + arrShpTopFraction;
        }
      }else if(arrShpTop.toString().indexOf('.')>-1){
          arrShpTop = new Fraction(arrShpTop).toString();
          arrShpTopFraction = addZeros(arrShpTop.split(' ')[1]);
          if(arrShpTopFraction.length == 3){
            arrShpTopFraction = "  " + arrShpTopFraction;
          }else if(arrShpTopFraction.length == 4){
            arrShpTopFraction = " " + arrShpTopFraction;
          }
          arrShpTopWhole = addZeros(arrShpTop.split(' ')[0]);
        
      }else{
        if(arrShpTop != ''){
          arrShpTopFraction = "     ";
        }else{
          arrShpTopFraction = '';
        }
        if(arrShpTop.toString().length == 1){
          arrShpTopWhole= "00"+ arrShpTop.toString();
        }else if(arrShpTop.toString().length == 2){
          arrShpTopWhole = "0"+ arrShpTop.toString();
        }else{
          arrShpTopWhole = arrShpTop.toString();
        }
      }
    }else{
      arrShpTop = "000";
      arrShpTopWhole = "000";
      arrShpTopFraction = "     ";
    } 
    if(!isNaN(arrShpS1)){  
      if(arrShpS1.toString().indexOf('/')>-1){
        arrShpS1Whole = arrShpS1.toString().split('-')[0];
        arrShpS1Fraction = arrShpS1.toString().split('-')[1];
        if(arrShpS1Whole.length == 1){
          arrShpS1Whole = "00"+arrShpS1Whole;
        }else if(arrShpS1Whole.length == 2){
          arrShpS1Whole = "0"+arrShpS1Whole;
        }
        if(arrShpS1Fraction.length == 3){
          arrShpS1Fraction = "  " + arrShpS1Fraction;
        }else if(arrShpS1Fraction.length == 4){
          arrShpS1Fraction = " " + arrShpS1Fraction;
        }
      }else if(arrShpS1.toString().indexOf('.')>-1){
          arrShpS1 = new Fraction(arrShpS1).toString();
          arrShpS1Fraction = addZeros(arrShpS1.split(' ')[1]);
          if(arrShpS1Fraction.length == 3){
            arrShpS1Fraction = "  " + arrShpS1Fraction;
          }else if(arrShpS1Fraction.length == 4){
            arrShpS1Fraction = " " + arrShpS1Fraction;
          }
          arrShpS1Whole = addZeros(arrShpS1.split(' ')[0]);
        
      }else{
        if(arrShpS1 != ''){
          arrShpS1Fraction = "     ";
        }else{
          arrShpS1Fraction = '';
        }
        
        if(arrShpS1.toString().length == 1){
          arrShpS1Whole= "00"+ arrShpS1.toString();
        }else if(arrShpS1.toString().length == 2){
          arrShpS1Whole = "0"+ arrShpS1.toString();
        }else{
          arrShpS1Whole = arrShpS1.toString();
        }
      }
    }else{
      arrShpS1 = "000";
      arrShpS1Whole = "000";
      arrShpS1Fraction = "     ";
    }
    if(!isNaN(arrShpS2)){   
      if(arrShpS2.toString().indexOf('/')>-1){
        arrShpS2Whole = arrShpS2Mixed.toString().split('-')[0];
        arrShpS2Fraction = arrShpS2Mixed.toString().split('-')[1];
        if(arrShpS2Whole.length == 1){
          arrShpS2Whole = "00"+arrShpS2Whole;
        }else if(arrShpS2Whole.length == 2){
          arrShpS2Whole = "0"+arrShpS2Whole;
        }
        if(arrShpS2Fraction.length == 3){
          arrShpS2Fraction = "  " + arrShpS2Fraction;
        }else if(arrShpS2Fraction.length == 4){
          arrShpS2Fraction = " " + arrShpS2Fraction;
        }
      }else if(arrShpS2.toString().indexOf('.')>-1){
          arrShpS2 = new Fraction(arrShpS2).toString();
          arrShpS2Fraction = addZeros(arrShpS2.split(' ')[1]);
          if(arrShpS2Fraction.length == 3){
            arrShpS2Fraction = "  " + arrShpS2Fraction;
          }else if(arrShpS2Fraction.length == 4){
            arrShpS2Fraction = " " + arrShpS2Fraction;
          }
          arrShpS2Whole = addZeros(arrShpS2.split(' ')[0]);
        
      }else{
        if(arrShpS2 != ''){
          arrShpS2Fraction = "     ";
        }else{
          arrShpS2Fraction = '';
        }
        if(arrShpS2.toString().length == 1){
          arrShpS2Whole= "00"+ arrShpS2.toString();
        }else if(arrShpS2.toString().length == 2){
          arrShpS2Whole = "0"+ arrShpS2.toString();
        }else{
          arrShpS2Whole = arrShpS2.toString();
        }
      }
    }else{
      arrShpS2 = "000";
      arrShpS2Whole = "000";
      arrShpS2Fraction = "     ";
    } 
    if(!isNaN(arrShpRad)){  
      if(arrShpRad.toString().indexOf('/')>-1){
        arrShpRadWhole = arrShpRadMixed.toString().split('-')[0];
        arrShpRadFraction = arrShpRadMixed.toString().split('-')[1];
        if(arrShpRadWhole.length == 1){
          arrShpRadWhole = "00"+arrShpRadWhole;
        }else if(arrShpRadWhole.length == 2){
          arrShpRadWhole = "0"+arrShpRadWhole;
        }
        if(arrShpRadFraction.length == 3){
          arrShpRadFraction = "  " + arrShpRadFraction;
        }else if(arrShpRadFraction.length == 4){
          arrShpRadFraction = " " + arrShpRadFraction;
        }
      }else if(arrShpRad.toString().indexOf('.')>-1){
          arrShpRad = new Fraction(arrShpRad).toString();
          arrShpRadFraction = addZeros(arrShpRad.split(' ')[1]);
          if(arrShpRadFraction.length == 3){
            arrShpRadFraction = "  " + arrShpRadFraction;
          }else if(arrShpRadFraction.length == 4){
            arrShpRadFraction = " " + arrShpRadFraction;
          }
          arrShpRadWhole = addZeros(arrShpRad.split(' ')[0]);
        
      }else{
        if(arrShpRad != ''){
          arrShpRadFraction = "     ";
        }else{
          arrShpRadFraction = '';
        }
        if(arrShpRad.toString().length == 1){
          arrShpRadWhole= "00"+ arrShpRad.toString();
        }else if(arrShpRad.toString().length == 2){
          arrShpRadWhole = "0"+ arrShpRad.toString();
        }else{
          arrShpRadWhole = arrShpRad.toString();
        }
      }
    }else{
      arrShpRad = "000";
      arrShpRadWhole = "000";
      arrShpRadFraction = "     ";
    } 
      //#makeshapesgreatagain
      arrShapeCust = arrShpBaseWhole + arrShpBaseFraction + arrShpLeftWhole + arrShpLeftFraction +arrShpRightWhole + arrShpRightFraction +arrShpTopWhole + arrShpTopFraction +arrShpS1Whole + arrShpS1Fraction +arrShpS2Whole + arrShpS2Fraction +arrShpRadWhole + arrShpRadFraction;
      //arrShapeCust = widthWhole+widthFraction+heightWhole+heightFraction + thicknessWhole + "000     000     000     000";
      if(arrShpBase == "" && arrShpLeft == "" && arrShpRight == "" && arrShpTop == "" && arrShpS1 == "" && arrShpS2 == "" && arrShpRad == ""){
        arrShapeCust = "000     000     000     000     000     000     000     ";
      }
      //#makesurface5greatagain
      arrSurface5Label = escapeHtml($('#glassSurface5Label').html().replace(':',''));
      arrSurface5Label = arrSurface5Label.replace(' - ','-');
      
      if($('#glassOrderProduct option:selected').val().toLowerCase().indexOf('triple') > -1){
        arrSurface5 = escapeHtml($('#glassOrderTypeSurface option:selected').text());
        seqOffset = 1;
      }else{
        arrSurface5 = '';
      }
      if($('#glassThickness1').val().indexOf('/') > -1){
        dimArrayStringThick = $('#glassThickness1').val();
      }else{
        dimArrayStringThick = new Fraction($('#glassThickness1').val()).toString();
        if(dimArrayStringThick.length > 4){
          dimArrayStringThick = new Fraction(parseFloat($('#glassThickness1').val()).toFixed(1)).toString();
        }
      }
      dimArr1 = "";
      dimArr2 = "";
      if(storeWidth.toString().indexOf('.') > -1){
        dimArr1 = (new Fraction(storeWidth).toString().replace(" ","-"));
      }else{
        dimArr1 = storeWidth.toString().replace(" ","-");
      }       
      if(storeHeight.toString().indexOf('.') > -1){
        dimArr2 = (new Fraction(storeHeight).toString().replace(" ","-"));
      }else{
        dimArr2 = storeHeight.toString().replace(" ","-");
      }
      dimArrayString =  dimArr1+"X"+dimArr2+"X"+dimArrayStringThick;
      dim998String = dimArr1 + " X " + dimArr2 + " X " + dimArrayStringThick;
      storeWidth = storeWidth.replace("-"," ");
      storeHeight = storeHeight.replace("-"," ");
      widthMixed = new Fraction(storeWidth);
      heightMixed = new Fraction(storeHeight);
      if(widthMixed.toString().indexOf('/')>-1){
        widthWhole = widthMixed.toString().split(' ')[0];
        widthFraction = widthMixed.toString().split(' ')[1];
        if(widthWhole.length == 1){
          widthWhole = "00"+widthWhole;
        }else if(widthWhole.length == 2){
          widthWhole = "0"+widthWhole;
        }
        if(widthFraction.length == 3){
          widthFraction = "  " + widthFraction;
        }else if(widthFraction.length == 4){
          widthFraction = " " + widthFraction;
        }
      }else{
        widthFraction = "     ";
        if(widthMixed.toString().length == 1){
          widthWhole = "00"+widthMixed.toString();
        }else if(widthMixed.toString().length == 2){
          widthWhole = "0"+widthMixed.toString();
        }else{
          widthWhole = widthMixed.toString();
        }
      }
      if(heightMixed.toString().indexOf('/')>-1){
        heightWhole = heightMixed.toString().split(' ')[0];
        heightFraction = heightMixed.toString().split(' ')[1];
        if(heightWhole.length == 1){
          heightWhole = "00"+heightWhole;
        }else if(heightWhole.length == 2){
          heightWhole = "0"+heightWhole;
        }
        if(heightFraction.length == 3){
          heightFraction = "  " + heightFraction;
        }else if(heightFraction.length == 4){
          heightFraction = " " + heightFraction;
        }
      }else{
        heightFraction = "     ";
        if(heightMixed.toString().length == 1){
          heightWhole= "00"+heightMixed.toString();
        }else if(heightMixed.toString().length == 2){
          heightWhole = "0"+heightMixed.toString();
        }else{
          heightWhole = heightMixed.toString();
        }
      }
      $('#glassThickness1').val($('#glassThickness1').val().replace('"',''));                                                   
      thicknessMixed = new Fraction(glassPriceThickness); 
      if(thicknessMixed.toString().length == 3){
        thicknessWhole = "000  " + thicknessMixed.toString();
      }else if(thicknessMixed.toString().length == 4){
        thicknessWhole = "000 " + thicknessMixed.toString();
      }else{
        tempThick = new Fraction(parseFloat(glassPriceThickness).toFixed(1)).toString();
        if(tempThick.length == 3){
          thicknessWhole = "000  " + tempThick;
        }else if(tempThick.length == 4){
          thicknessWhole = "000 " + tempThick;
        }else{
          thicknessWhole = "000"+ tempThick;
        } 
      }
      if($('#glassThickness1').val().indexOf('/') > -1){
        if($('#glassThickness1').val().length == 3){
          thicknessWhole = "000  " + $('#glassThickness1').val();
        }else if($('#glassThickness1').val().length == 4){
          thicknessWhole = "000 " + $('#glassThickness1').val();
        }else if($('#glassThickness1').val().length == 5){
          thicknessWhole = "000" + $('#glassThickness1').val();
        }else{
          tempThick = new Fraction(parseFloat($('#glassThickness1').val()).toFixed(1)).toString();
          if(tempThick.length == 3){
            thicknessWhole = "000  " + tempThick;
          }else if(tempThick.length == 4){
            thicknessWhole = "000 " + tempThick;
          }else{
            thicknessWhole = "000"+ tempThick;
          }
        }
      }
      if($('#glassThickness1').val() == '1'){
        thicknessWhole = "00" + tempThick+"     ";
      }
      custSizeString = widthWhole+widthFraction+heightWhole+heightFraction + thicknessWhole + "000     000     000     000";
      savedGCSArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: "1",
        newLine: "0",
        option: "Custom Size",
        optionVal:"Yes",
        custEntries: custSizeString,
        function: "C",
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      });
      savedGShapeArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: "2",
        newLine: "0",
        option: "Shape",
        optionVal: arrShape,
        custEntries: arrShapeCust,
        function: "+",
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: ""
      });
      savedGDimsArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: "0",
        newLine: "0",
        option: escapeHtml($('#glassOrderProduct option:selected').val()),
        optionVal: dimArrayString,
        custEntries: "",
        function: "",
        prcPg: tempNewPrice.replace(".",""),
        prcSlt: escapeHtml($('#glassOrderQuant').val()),
        prcBases: "",
        dsLiteNo: "",
        man: "1"
      });
      /*if($('#glassOrderType'+lookVal+' option:selected').text().toLowerCase().indexOf('lo-e') > -1){
        gTypeSlot = "2";
      }else if($('#glassOrderType'+lookVal+' option:selected').text() == "Clear"){
        gTypeSlot = "1";
      }else{
        gTypeSlot = "0";
      }*/
      savedGTypeArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 3,
        newLine: "0",
        option: "Glass Type",
        optionVal: escapeHtml($('#glassOrderType'+lookVal+' option:selected').text()),
        custEntries: "",
        function: "G",
        prcPg: "",
        prcSlt: '1',
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      });
      savedGSurface5Array.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 3+seqOffset,
        newLine: "0",
        option: arrSurface5Label,
        optionVal: arrSurface5,
        custEntries: "",
        function: "G",
        prcPg: "",
        prcSlt: "5",
        prcBases: "",
        dsLiteNo: "",
        man: ""
      });
      sGOrderQuant = escapeHtml($('#glassOrderQuant').val());
      if(sGOrderQuant.length == 1){
        sGOrderQuant = "000000" + sGOrderQuant;
      }else if(sGOrderQuant.length == 2){
        sGOrderQuant = "00000" + sGOrderQuant;
      }else if(sGOrderQuant.length == 3){
        sGOrderQuant = "0000" + sGOrderQuant;
      }else if(sGOrderQuant.length == 4){
        sGOrderQuant = "000" + sGOrderQuant;
      }else if(sGOrderQuant.length == 5){
        sGOrderQuant = "00" + sGOrderQuant;
      }else if(sGOrderQuant.length == 6){
        sGOrderQuant = "0" + sGOrderQuant;
      }
      savedGQuantArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 4+seqOffset,
        newLine: "0",
        option: "Quantity",
        optionVal: sGOrderQuant,
        custEntries: "",
        function: "Q",
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      });
      gStrOptionVal = "";
      gStrPrcSlt = "";
      gStrFunction ="";
      //tempered = 2
      if($('#glassOrderStrength'+lookVal+' option:selected').text().indexOf('Lami') > -1){
        gStrPrcSlt = "4";
        gStrFunction = "G";
      }else if($('#glassOrderStrength'+lookVal+' option:selected').text() == 'Tempered'){
        gStrPrcSlt = "2";
        gStrFunction = "G";
      }else{
        gStrPrcSlt = "";
        gStrFunction = "";
      }
      savedGStrArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 5+seqOffset,
        newLine: "0",
        option: "Glass Strength",
        optionVal: escapeHtml($('#glassOrderStrength'+lookVal+' option:selected').text()),
        custEntries: "",
        function: gStrFunction,
        prcPg: "",
        prcSlt: gStrPrcSlt,
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      });
      if($('#glassThicknessLabel').is(':visible')){
        temperLabel = "Glass Thickness";
        temperVal = escapeHtml($('#glassOrderThickness'+lookVal+' option:selected').text().split(" (")[0].trim());
      }else{
        temperLabel = "Glass Thick - Temper";
        temperVal = escapeHtml($('#glassOrderTemper option:selected').text().split(" (")[0].trim());
      }
      savedGThckArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 6+seqOffset,
        newLine: "0",
        option: temperLabel,
        optionVal: temperVal,
        custEntries: "",
        function: "",
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      });
      spacerOptVal = "";
      if($('#glassOrderSpacer option:selected').text() == "Standard (XL Edge)"){
        spacerOptVal = "None";
      }else{
        spacerOptVal = escapeHtml($('#glassOrderSpacer option:selected').text());
      }
      savedGSpcrArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 7+seqOffset,
        newLine: "0",
        option: "Spacer Option",
        optionVal: spacerOptVal,
        custEntries: "",
        function: "",
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      });
      if($('#glassOrderGrille'+lookVal+' option:selected').val() == "#CONT2"){
        gGrilleSlot = "6";
      }else if($('#glassOrderGrille'+lookVal+' option:selected').val() == "#FLAT2" || $('#glassOrderGrille'+lookVal+' option:selected').val() == "#CONT"){
        gGrilleSlot = "5";
      }else if($('#glassOrderGrille'+lookVal+' option:selected').text().indexOf("Flat") > -1){
        gGrilleSlot = "4";
      }else{
        gGrilleSlot = "";
      }
      savedGGrilleArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 8+seqOffset,
        newLine: "0",
        option: "Grille",
        optionVal: escapeHtml($('#glassOrderGrille'+lookVal+' option:selected').text()).replace('&quot;','"'),
        custEntries: "",
        function: "",
        prcPg: "",
        prcSlt: gGrilleSlot,
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      });
      if($('#glassOrderGrille' + lookVal + ' option:selected').text().toLowerCase() != 'none'){
        arrGrillePatt = escapeHtml($('#glassOrderGrillePatt' + lookVal +' option:selected').text());
        arrGrilleFunc = "L";
      }else{
        arrGrillePatt = "";
        arrGrilleFunc = "";
      }
      arrColWide = addZeros($('#glassOrderColonialWide').val());
      arrColHigh = addZeros($('#glassOrderColonialHigh').val());
      arrColCust = addZeros($('#glassOrderColonialCust').val());
      arrPrWide = addZeros($('#glassOrderPrairieWide').val());
      arrPrHigh = addZeros($('#glassOrderPrairieHigh').val());
      arrPrOff = addZeros($('#glassOrderPrairieOff').val());
      arrPrCustWide = addZeros($('#glassOrderCustPrairieWide').val());
      arrPrCustHigh = addZeros($('#glassOrderCustPrairieHigh').val());
      arrPrCustHOff = addZeros($('#glassOrderCustPrairieHoriOff').val());
      arrPrCustVOff = addZeros($('#glassOrderCustPrairieVertOff').val());
      arrCustRectLi = addZeros($('#glassOrderCustRectLites').val());
      arrCustCurvLi = addZeros($('#glassOrderCustCurvLites').val());
      arrCustAngLi = addZeros($('#glassOrderCustAngLites').val());
      gPattCnt = 0
      arrGPattString = "";
      if(arrColWide != "" && arrColWide != "000"){
        arrGPattString = arrGPattString + arrColWide + "     ";
        gPattCnt++;
      }
      if(arrColHigh != "" && arrColHigh != "000" ){
        arrGPattString = arrGPattString + arrColHigh + "     ";
        gPattCnt++;
      }
      if(arrColCust != "" && arrColCust != "000" ){
        arrGPattString = arrGPattString + arrColCust + "     ";
        gPattCnt++;
      }
      if(arrPrWide != "" && arrPrWide != "000" ){
        arrGPattString = arrGPattString + arrPrWide + "     ";
        gPattCnt++;
      }
      if(arrPrHigh != "" && arrPrHigh != "000" ){
        arrGPattString = arrGPattString + arrPrHigh + "     ";
        gPattCnt++;
      }
      if(arrPrOff != "" && arrPrOff != "000" ){
        arrGPattString = arrGPattString + arrPrOff + "     ";
        gPattCnt++;
      }
      if(arrPrCustWide != "" && arrPrCustWide != "000" ){
        arrGPattString = arrGPattString + arrPrCustWide + "     ";
        gPattCnt++;
      }
      if(arrPrCustHigh != "" && arrPrCustHigh != "000" ){
        arrGPattString = arrGPattString + arrPrCustHigh + "     ";
        gPattCnt++;
      }
      if(arrPrCustHOff != "" && arrPrCustHOff != "000" ){
        arrGPattString = arrGPattString + arrPrCustHOff + "     ";
        gPattCnt++;
      }
      if(arrPrCustVOff != "" && arrPrCustVOff != "000" ){
        arrGPattString = arrGPattString + arrPrCustVOff + "     ";
        gPattCnt++;
      }
      if(arrCustRectLi != "" && arrCustRectLi != "000" ){
        arrGPattString = arrGPattString + arrCustRectLi + "     ";
        gPattCnt++;
      }
      if(arrCustCurvLi != "" && arrCustCurvLi != "000" ){
        arrGPattString = arrGPattString + arrCustCurvLi + "     ";
        gPattCnt++;
      }
      if(arrCustAngLi != "" && arrCustAngLi != "000" ){
        arrGPattString = arrGPattString + arrCustAngLi + "     ";
        gPattCnt++;
      }
      for(j=gPattCnt;j<7;j++){
        arrGPattString = arrGPattString + "000     "
      }
      savedGGrillePattArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 9+seqOffset,
        newLine: "0",
        option: "Grille Pattern",
        optionVal: arrGrillePatt,
        custEntries: arrGPattString,
        function: arrGrilleFunc,
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      });
      gPattCnt = 0;
      
      if($('#glassOrder2Tone').is(':visible')){
        intGrilleColor = escapeHtml($('#glassOrder2Tone option:selected').text());
        intGrilleColorLabel = "Int Grl 2-Tone Color";        
        intGrilleColorFunc = "9";
        intGrilleColorCust = "";
        if(intGrilleColor == 'Custom'){ 
          intGrilleColorCust = escapeHtml($('#glassOrderCust2ToneIn').val()) + "/" + escapeHtml($('#glassOrderCust2ToneExt').val());
          intGrilleColorFunc = "M"; 
        }
      }else if($('#glassOrderIntGrille'+lookVal).is(':visible')){
        intGrilleColor = escapeHtml($('#glassOrderIntGrille'+lookVal+' option:selected').text());
        intGrilleColorLabel = "Inter. Grille Color";
        intGrilleColorFunc = "";
        intGrilleColorCust = "";
        if(intGrilleColor == 'Custom'){ 
          intGrilleColorCust = escapeHtml($('#glassOrderCustGColor').val()); 
          intGrilleColorFunc = "M"; 
        }
      }else{
        intGrilleColor = "";
        intGrilleColorCust = "";
        intGrilleColorFunc = "";
        intGrilleColorLabel = "Inter. Grille Color";
      }
if($('#glassOrderSDL' + lookVal).is(':hidden')){
      savedGGrilleIntArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 10+seqOffset,
        newLine: "0",
        option: intGrilleColorLabel,
        optionVal: intGrilleColor,
        custEntries: "000     000     000     000     000     000     000     " + intGrilleColorCust,
        function: intGrilleColorFunc,
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      });
    
    }else if($('#glassOrderSDL' + lookVal).is(':visible')){
      sdlColorOpt = $('#glassOrderSDL'+lookVal+ ' option:selected').text();
      //addSDLArrayHere
      savedGGrilleSDLArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 10+seqOffset,
        newLine: "0",
        option: "SDL Color",
        optionVal: sdlColorOpt,
        custEntries: "000     000     000     000     000     000     000     ",
        function: "9",
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      });
    }
    
      savedGPreArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 11+seqOffset,
        newLine: "0",
        option: "Preserve",
        optionVal: escapeHtml($('#glassOrderPreserve'+lookVal+ ' option:selected').text()),
        custEntries: "",
        function: "",
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: ""
      });
      if($('#glassOrderTint'+lookVal+' option:selected').val() == "#SOLARB"){
        gTintPg = "4";
      }else if($('#glassOrderTint'+lookVal+' option:selected').val() == "#SOLARG"){
        gTintPg = "5";
      }else{
        gTintPg = "";
      }
      savedGTintArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 12+seqOffset,
        newLine: "0",
        option: "Tint",
        optionVal: $('#glassOrderTint'+lookVal+' option:selected').text(),
        custEntries: "",
        function: "",
        prcPg: gTintPg,
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      });
      savedGHCoatArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 13+seqOffset,
        newLine: "0",
        option: "Hard Coat",
        optionVal: escapeHtml($('#glassOrderHard' + lookVal + ' option:selected').text()),
        custEntries: "",
        function: "",
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      });
      if($('#glassOrderObscure' + lookVal + ' option:selected').text() == "Rain" || $('#glassOrderObscure' + lookVal + ' option:selected').text() == "Seedy Reemy" || $('#glassOrderObscure' + lookVal + ' option:selected').text() == "Reeded"){
        gObscPg = "3";
      }else if($('#glassOrderObscure' + lookVal + ' option:selected').text() == "Frosted/Acid Etched" || $('#glassOrderObscure' + lookVal + ' option:selected').text() == "Single Glue Chip"){
        gObscPg = "2";
      }else{
        gObscPg = "";
      }
      savedGObscArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 14+seqOffset,
        newLine: "0",
        option: "Obscure",
        optionVal: escapeHtml($('#glassOrderObscure' + lookVal + ' option:selected').text()),
        custEntries: "",
        function: "",
        prcPg: gObscPg,
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      });
      savedGIgArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 15+seqOffset,
        newLine: "0",
        option: "IG Logo Required",
        optionVal: escapeHtml($('#glassOrderLogo option:selected').text()),
        custEntries: "",
        function: "",
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      });
      savedGLabelArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: '19',
        newLine: "0",
        option: "Label (location)",
        optionVal: "",
        custEntries: "000     000     000     000     000     000     000                              ",
        function: "",
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      })
      savedGUnitsArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: "997",
        newLine: "0",
        option: "Glass Units",
        optionVal: escapeHtml($('#glassOrderQuant').val()),
        custEntries: "",
        function: "G",
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      })
      savedGUnits2Array.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: "998",
        newLine: "0",
        option: dim998String,
        optionVal: " ",
        custEntries: "",
        function: "G",
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      })
      savedGBlankArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: "999",
        newLine: "0",
        option: "",
        optionVal:"",
        custEntries: "",
        function: "G",
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      })
      if(additionalArray.length > 0){
        addArrayVal = "Yes";
        addArrayFunc = "A";
      }else{
        addArrayVal = "No";
        addArrayFunc = "D";
      }
      savedGAddArray.push({
        salesOrd: salesOrderNum,
        line: lineNum,
        seq: 16+seqOffset,
        newLine: "0",
        option: "Additional Items",
        optionVal:addArrayVal,
        custEntries: "",
        function: addArrayFunc,
        prcPg: "",
        prcSlt: "",
        prcBases: "",
        dsLiteNo: "",
        man: "0"
      })
      savedImgArr.push({
        img1: savedGImgPath1,
        img2: savedGImgPath2,
        img3: savedGImgPath3,
        img4: savedGImgPath4,
        img5: savedGImgPath5
      })
      jsonImgArr = JSON.stringify(savedImgArr);
      arrGPattString = "";
      savedGProduct = escapeHtml($('#glassOrderProduct option:selected').val());
      savedGShape = escapeHtml($('#glassOrderShape option:selected').attr('id'));
      savedGShapeTxt = escapeHtml($('#glassOrderShape option:selected').text());
      savedGShapeBase = escapeHtml($('#shapeDimBase').val());
      savedGShapeTop = escapeHtml($('#shapeDimTop').val());
      savedGShapeRight = escapeHtml($('#shapeDimRight').val());
      savedGShapeLeft = escapeHtml($('#shapeDimLeft').val());
      savedGShapeS1 = escapeHtml($('#shapeDimS1').val());
      savedGShapeS2 = escapeHtml($('#shapeDimS2').val());
      savedGShapeRadius = escapeHtml($('#shapeDimRadius').val());
      savedGSurface5 = escapeHtml($('#glassOrderTypeSurface option:selected').val());
      savedGSurface5Txt = escapeHtml($('#glassOrderTypeSurface option:selected').text());
      savedGThickness = escapeHtml($('#glassOrderThickness'+lookVal+' option:selected').val());
      savedGCPattW = escapeHtml($('#glassOrderColonialWide').val());
      savedGCPattH = escapeHtml($('#glassOrderColonialHigh').val());
      savedGCNum = escapeHtml($('#glassOrderColonialCust').val());
      savedGPPattW = escapeHtml($("#glassOrderPrairieWide").val());
      savedGPPattH = escapeHtml($('#glassOrderPrairieHigh').val());
      savedGPPattO = escapeHtml($('#glassOrderPrairieOff').val());
      savedGPPattHorO = escapeHtml($('#glassOrderCustPrairieHoriOff').val());
      savedGPPattVertO = escapeHtml($('#glassOrderCustPrairieVertOff').val());
      savedGPPattCustW = escapeHtml($('#glassOrderCustPrairieWide').val());
      savedGPPattCustH = escapeHtml($('#glassOrderCustPrairieHigh').val());
      savedGPCRect = escapeHtml($('#glassOrderCustRectLites').val());
      savedGPCCurv = escapeHtml($('#glassOrderCustCurvLites').val());
      savedGPCAng = escapeHtml($('#glassOrderCustAngLites').val());
      if(lookVal != 'MR' && lookVal != 'MS'){
        savedGIntGrill = escapeHtml($('#glassOrderIntGrille'+lookVal+' option:selected').val());
        savedGIntGrillTxt = escapeHtml($('#glassOrderIntGrille'+lookVal+' option:selected').text());
        savedGInt2Grill = escapeHtml($('#glassOrder2Tone option:selected').val());
        savedGInt2GrillTxt = escapeHtml($('#glassOrder2Tone option:selected').text());
        savedGPreserve = escapeHtml($('#glassOrderPreserve' + lookVal + ' option:selected').val());
        savedGPreserveTxt = escapeHtml($('#glassOrderPreserve' + lookVal + ' option:selected').text());
        savedGIGLogo = escapeHtml($('#glassOrderLogo option:selected').val());
        savedGIGLogoTxt = escapeHtml($('#glassOrderLogo option:selected').text());
      }else{
        savedGIntGrill='';
        savedGIntGrillTxt='';
        savedGInt2Grill='';
        savedGInt2GrillTxt='';
        savedGPreserve='';
        savedGPreserveTxt='';
        savedGIGLogo='';
        savedGIGLogoTxt='';
      }
      savedGTint = escapeHtml($('#glassOrderTint' + lookVal + ' option:selected').val());
      savedGTintTxt = escapeHtml($('#glassOrderTint' + lookVal + ' option:selected').text());
      savedGHCoat = escapeHtml($('#glassOrderHard' + lookVal + ' option:selected').val());
      savedGHCoatTxt = escapeHtml($('#glassOrderHard' + lookVal + ' option:selected').text());
      savedGObsc = escapeHtml($('#glassOrderObscure'+lookVal+' option:selected').val());
      savedGObscTxt = escapeHtml($('#glassOrderObscure'+lookVal+' option:selected').text());
      savedGStrengthTxt = escapeHtml($('#glassOrderStrength'+lookVal+' option:selected').text());
      savedGSpaceTxt = escapeHtml($('#glassOrderSpacer option:selected').text());
      savedGGrilleTxt = escapeHtml($('#glassOrderGrille'+lookVal+' option:selected').text());
      savedGGrillePattTxt = escapeHtml($('#glassOrderGrillePatt'+lookVal+' option:selected').text());
      savedGTemperTxt = escapeHtml($('#glassOrderTemper option:selected').text().split("-")[0].trim());
      savedGTemper = escapeHtml($('#glassOrderTemper option:selected').val());
      savedGLabel = escapeHtml($('#hiddenGlassLabel').val());
    }else{
      savedGProduct = "";
      savedGShape = "";
      savedGShapeTxt = "";
      savedGShapeBase = "";
      savedGShapeTop = "";
      savedGShapeRight = "";
      savedGShapeLeft = "";
      savedGShapeS1 = "";
      savedGShapeS2 = "";
      savedGShapeRadius = ""; 
      savedGSurface5 = "";
      savedGSurface5Txt = "";
      savedGThickness = "";
      savedGCPattW = "";
      savedGCPattH = "";
      savedGCNum = "";
      savedGPPattW = "";
      savedGPPattH = "";
      savedGPPattO = "";
      savedGPPattHorO = "";
      savedGPPattVertO = "";
      savedGPPattCustW = "";
      savedGPPattCustH = "";
      savedGPCRect = "";
      savedGPCCurv = "";
      savedGPCAng = "";
      if(lookVal != 'MR' && lookVal != 'MS'){
        savedGIntGrill = "";
        savedGIntGrillTxt = "";
        savedGInt2Grill = "";
        savedGInt2GrillTxt = "";
        savedGPreserve = "";
        savedGPreserveTxt = "";
        savedGIGLogo = "";
        savedGIGLogoTxt = "";
      }else{
        savedGIntGrill = '';
        savedGIntGrillTxt = '';
        savedGInt2Grill = '';
        savedGInt2GrillTxt = '';
        savedGPreserve = '';
        savedGPreserveTxt = '';
        savedGIGLogo = '';
        savedGIGLogoTxt = '';
      }
      savedGTint = "";
      savedGTintTxt = "";
      savedGHCoat = "";
      savedGHCoatTxt = ""; 
      savedGObsc = "";
      savedGObscTxt = "";
      savedGStrengthTxt = "";
      savedGSpaceTxt = "";
      savedGGrilleTxt = "";
      savedGGrillePattTxt = "";
      savedGTemperTxt = "";
      savedGTemper = "";
      savedGLabel = "";
      gOrderTypeTxt = "";
    }
    quoteTotal = +quoteTotal + +tempNewPrice;
if(editTblRow == 1){
      glassOptions.splice(newid-1, 0, {id: newid,
      pr:savedGProduct,
      gthick:glassPriceThickness,
      gq:savedGQuant,
      gsh:savedGShape,
      gshT:savedGShapeTxt,
      sb:savedGShapeBase,
      st:savedGShapeTop,
      sl:savedGShapeLeft,
      sr:savedGShapeRight,
      s1:savedGShapeS1,
      s2:savedGShapeS2,
      sa:savedGShapeRadius,
      s5:savedGSurface5,
      s5T:savedGSurface5Txt,
      ck:savedGThickness,
      cpw:savedGCPattW,
      cph:savedGCPattH,
      cpn:savedGCNum,
      ppw:savedGPPattW,
      pph:savedGPPattH,
      ppo:savedGPPattO,
      pho:savedGPPattHorO,
      pwo:savedGPPattVertO,
      pcw:savedGPPattCustW,
      pch:savedGPPattCustH,
      pcr:savedGPCRect,
      pcc:savedGPCCurv,
      pca:savedGPCAng,
      gig:savedGIntGrill,
      gigT:savedGIntGrillTxt,
      g2g:savedGInt2Grill,
      g2gT:savedGInt2GrillTxt,
      gpr:savedGPreserve,
      gprT:savedGPreserveTxt,
      gti:savedGTint,
      gtiT:savedGTintTxt,
      ghc:savedGHCoat,
      ghcT:savedGHCoatTxt,
      obs:savedGObsc,
      obsT:savedGObscTxt,
      ig:savedGIGLogo,
      igT:savedGIGLogoTxt,
      img1:savedGImgPath1,
      img2:savedGImgPath2,
      img3:savedGImgPath3,
      img4:savedGImgPath4,
      img5:savedGImgPath5,
      w:storeWidth,
      h:storeHeight,
      gt:gOrderType,
      gtt:gOrderTypeTxt,
      gs:gOrderTemper,
      gtemT:savedGTemperTxt,
      gtem:savedGTemper,
      gsT:savedGStrengthTxt,
      t2:savedGThickness,
      sp:gOrderSpacer,
      spT:savedGSpaceTxt,
      gr:gOrderGrille,
      grT:savedGGrilleTxt,
      gp:gOrderGrillePatt,
      gpT:savedGGrillePattTxt,
      gLabel:savedGLabel,
      //gPArr:savedGPArray,
      gDArr:savedGDimsArray,
      gShArr:savedGShapeArray,
      gCSArr:savedGCSArray,
      gTypArr:savedGTypeArray,
      gQArr:savedGQuantArray,
      gStrArr:savedGStrArray,
      gTckArr:savedGThckArray,
      gSpArr:savedGSpcrArray,
      gGArr:savedGGrilleArray,
      gGPatArr:savedGGrillePattArray,
      gGIntArr:savedGGrilleIntArray,
      gSDLArr: savedGGrilleSDLArray,
      gPreArr:savedGPreArray,
      gTintArr:savedGTintArray,
      gHCArr:savedGHCoatArray,
      gObscArr:savedGObscArray,
      gIgArr:savedGIgArray,
      gAddArr:savedGAddArray,
      gSur5Arr:savedGSurface5Array,
      gLabelArr: savedGLabelArray,
      gUnitArr:savedGUnitsArray,
      gUnit2Arr:savedGUnits2Array,
      gBlankArr:savedGBlankArray,
      gPrice:tempNewPrice
    })
    }else{
    glassOptions.push({
      id: newid,
      pr:savedGProduct,
      gthick:glassPriceThickness,
      gq:savedGQuant,
      gsh:savedGShape,
      gshT:savedGShapeTxt,
      sb:savedGShapeBase,
      st:savedGShapeTop,
      sl:savedGShapeLeft,
      sr:savedGShapeRight,
      s1:savedGShapeS1,
      s2:savedGShapeS2,
      sa:savedGShapeRadius,
      s5:savedGSurface5,
      s5T:savedGSurface5Txt,
      ck:savedGThickness,
      cpw:savedGCPattW,
      cph:savedGCPattH,
      cpn:savedGCNum,
      ppw:savedGPPattW,
      pph:savedGPPattH,
      ppo:savedGPPattO,
      pho:savedGPPattHorO,
      pwo:savedGPPattVertO,
      pcw:savedGPPattCustW,
      pch:savedGPPattCustH,
      pcr:savedGPCRect,
      pcc:savedGPCCurv,
      pca:savedGPCAng,
      gig:savedGIntGrill,
      gigT:savedGIntGrillTxt,
      g2g:savedGInt2Grill,
      g2gT:savedGInt2GrillTxt,
      gpr:savedGPreserve,
      gprT:savedGPreserveTxt,
      gti:savedGTint,
      gtiT:savedGTintTxt,
      ghc:savedGHCoat,
      ghcT:savedGHCoatTxt,
      obs:savedGObsc,
      obsT:savedGObscTxt,
      ig:savedGIGLogo,
      igT:savedGIGLogoTxt,
      img1:savedGImgPath1,
      img2:savedGImgPath2,
      img3:savedGImgPath3,
      img4:savedGImgPath4,
      img5:savedGImgPath5,
      w:storeWidth,
      h:storeHeight,
      gt:gOrderType,
      gtt:gOrderTypeTxt,
      gs:gOrderTemper,
      gtemT:savedGTemperTxt,
      gtem:savedGTemper,
      gsT:savedGStrengthTxt,
      t2:savedGThickness,
      sp:gOrderSpacer,
      spT:savedGSpaceTxt,
      gr:gOrderGrille,
      grT:savedGGrilleTxt,
      gp:gOrderGrillePatt,
      gpT:savedGGrillePattTxt,
      gLabel:savedGLabel,
      //gPArr:savedGPArray,
      gDArr:savedGDimsArray,
      gShArr:savedGShapeArray,
      gCSArr:savedGCSArray,
      gTypArr:savedGTypeArray,
      gQArr:savedGQuantArray,
      gStrArr:savedGStrArray,
      gTckArr:savedGThckArray,
      gSpArr:savedGSpcrArray,
      gGArr:savedGGrilleArray,
      gGPatArr:savedGGrillePattArray,
      gGIntArr:savedGGrilleIntArray,
      gSDLArr: savedGGrilleSDLArray,
      gPreArr:savedGPreArray,
      gTintArr:savedGTintArray,
      gHCArr:savedGHCoatArray,
      gObscArr:savedGObscArray,
      gIgArr:savedGIgArray,
      gAddArr:savedGAddArray,
      gSur5Arr:savedGSurface5Array,
      gLabelArr: savedGLabelArray,
      gUnitArr:savedGUnitsArray,
      gUnit2Arr:savedGUnits2Array,
      gBlankArr:savedGBlankArray,
      gPrice:tempNewPrice
    });
  }
    for(i = 2;i<6;i++){
      $('#filechooser'+i).val('');
      $('#filechooser'+i).hide();
      $('#addFileBtn'+i).hide();
      $('#deleteFileBtn'+i).hide();
      $('#imageHere'+i).html('');
    }
    $('#filechooser1').val('');
    $('#imageHere1').html('');
    jsonGlassString = JSON.stringify(glassOptions);
    //additionalArray = JSON.stringify(additionalArray);
    newQuote = 1;
    needQuotes = 0;
    saveQuote(jobNumber,jobDate,jobClientName,jobPrepared,quoteNum,quoteTotal,jobPoId,jobClientId,jobAddress1,jobAddress2,jobAddress3,jsonGlassString,jobCity,jobState,jobZip,jobContact,jobPhoneNumber,jobFaxNumber,jobEmail,jobSiteAddress1,jobSiteAddress2,jobSiteAddress3,jobSiteCity,jobSiteState,jobSiteZip,jobSiteContact,jobSitePhone1,jobSitePhone2,jobSiteNotes,shipToAddress1,shipToAddress2,shipToAddress3,shipToCity,shipToState,shipToZip,shipToContact,shipToPhone,shipToNotes,pickOrShipArr,jobID,qmarkup,qmulti,newQuote,additionalArray,'configure');
    priceLevel = 0;
    tempPriceLevel2 = 0;
    //$('#glassadd_row').prop('disabled',true);
    $('#'+quantTextId).keyup();
    drawingReq = "";
    hideGrillePrompts();
    if(editTblRow == 0){
      savedLineNum = lineNum;
    }
    $('#hiddenGlassLabel').val('');
    blankRow = 0;
    $('#glassOrderProduct').change();
    savedGProduct="";
    glassPriceThickness="";
    savedGQuant="";
    savedGShape="";
    savedGShapeTxt="";
    savedGShapeBase="";
    savedGShapeTop="";
    savedGShapeLeft="";
    savedGShapeRight="";
    savedGShapeS1="";
    savedGShapeS2="";
    savedGShapeRadius="";
    savedGSurface5="";
    savedGSurface5Txt="";
    savedGThickness="";
    savedGCPattW="";
    savedGCPattH="";
    savedGCNum="";
    savedGPPattW="";
    savedGPPattH="";
    savedGPPattO="";
    savedGPPattHorO="";
    savedGPPattVertO="";
    savedGPPattCustW="";
    savedGPPattCustH="";
    savedGPCRect="";
    savedGPCCurv="";
    savedGPCAng="";
    savedGIntGrill="";
    savedGIntGrillTxt="";
    savedGInt2Grill="";
    savedGInt2GrillTxt="";
    savedGPreserve="";
    savedGPreserveTxt="";
    savedGTint="";
    savedGTintTxt="";
    savedGHCoat="";
    savedGHCoatTxt="";
    savedGObsc="";
    savedGObscTxt="";
    savedGIGLogo="";
    savedGIGLogoTxt="";
    savedGImgPath1="";
    savedGImgPath2="";
    savedGImgPath3="";
    savedGImgPath4="";
    savedGImgPath5="";
    storeWidth="";
    storeHeight="";
    gOrderType="";
    gOrderTypeTxt="";
    gOrderTemper="";
    savedGTemperTxt="";
    savedGTemper="";
    savedGStrengthTxt="";
    savedGThickness="";
    gOrderSpacer="";
    savedGSpaceTxt="";
    gOrderGrille="";
    savedGGrilleTxt="";
    gOrderGrillePatt="";
    savedGGrillePattTxt="";
    //savedGPArray = [];
    savedGDimsArray = [];
    savedGLabelArray = [];
    savedGShapeArray = [];
    savedGCSArray = [];
    savedGTypeArray = [];
    savedGQuantArray = [];
    savedGStrArray = [];
    savedGThckArray = [];
    savedGSpcrArray = [];
    savedGGrilleArray = [];
    savedGGrillePattArray = [];
    savedGGrilleIntArray = [];
    savedGGrilleSDLArray = [];
    savedGPreArray = [];
    savedGTintArray  = [];
    savedGHCoatArray  = [];
    savedGObscArray  = [];
    savedGIgArray = [];
    savedGSurface5Array = [];
    savedGUnits2Array = [];
    savedGUnitsArray = [];
    savedGBlankArray = [];
    savedGAddArray = [];
    savedWDimsArray = [];
    savedWCSArray = [];
    savedWSizeArray = [];
    
    savedWMullArray = [];
    savedWBalArray = [];
    savedWLabelArray = [];
    savedWQuantArray = [];
    savedWExtArray = [];
    savedWCladColArray = [];
    savedWEstateColArray = [];
    savedWGTypeArray = [];
    savedWGOptArray = [];
    savedWTempArray = [];
    savedWGrilleArray = [];
    savedWGrillePattArray = [];
    savedWGrilleColArray = [];
    savedWGrilleSashArray = [];
    savedWScrReqArray = [];
    savedWScreenTypeArray = [];
    savedWScreenColArray = [];
    savedWHardColArray = [];
    savedWJambArray = [];
    savedWIntFinArray = [];
    savedWAccArray = [];
    savedWInstallArray = [];
    savedWAddArray = [];
    savedWGUnitArray = [];
    savedW998Array = [];
    savedW999Array = [];
    //savedGLabel = "";
    });//end glass_addrow click function
function sendOrder(){
  $('#glasssendOrder').blur();
  //$('#orderConfirmPO').val(jobPoId);
}
$('[name=addFileBtn]').click(function(){
  chooseId=$(this).attr('id').match(/(\d+)/)[0];
  if($('#filechooser').val()!=''){
    uploadFile(chooseId);
    $('#filechooser').val('');
  }
  if($('#filechooser').val()!=''){
    savedGUpdImg = uploadImgSrc;
  }else{
    savedGUpdImg = '';
  }
  if($('#imageHere'+chooseId).html().indexOf("not")>-1){
  }else{
    $('#filechooser'+(+chooseId+1)).attr('style','display:inline');
    $('#addFileBtn'+(+chooseId+1)).attr('style','display:inline');
    $('#deleteFileBtn'+(+chooseId+1)).attr('style','display:inline');
  }
  $(this).blur();
});
$('[name=deleteFileBtn]').click(function(){
  deleteId=$(this).attr('id').match(/(\d+)/)[0];
  if($('#filechooser'+deleteId).val() != ''){
    deleteImage($('#uploadedPic'+deleteId).attr('src'));
    $('#filechooser'+(+deleteId+1)).hide();
    $('#addFileBtn'+(+deleteId+1)).hide();
    $('#deleteFileBtn'+(+deleteId+1)).hide();
  }
  $(this).blur();
});
function uploadFile(n){
  blobFile = $('#filechooser'+n)[0].files[0];
  var fd = new FormData();
  fd.append("fileToUpload", blobFile);
  $.ajax({
    url: "uploadFile.php",
    type: "POST",
    data: fd,
    processData: false,
    contentType: false,
    async:false,
    success: function(response){
      $('#imageHere'+n).html(response);
      if($('#chooserDiv').is(':hidden')){
        $('#chooseId').show();
      }
      $('#imageHere'+n).show();
      uploadImgSrc = $('#uploadedPic').attr('src'); 
    }
  });
  $('#uploadedPic').attr('id',$('#uploadedPic').attr('id')+n);
  if($('#imageHere'+n).html().indexOf('not') == -1){
    checkImgNum = $('#uploadedPic'+n).attr('id').match(/(\d+)/)[0];
    if(checkImgNum == '1'){
        savedGImgPath1 = $('#uploadedPic'+n).attr('src');
    }else if(checkImgNum == '2'){
        savedGImgPath2 = $('#uploadedPic'+n).attr('src');
    }else if(checkImgNum == '3'){
        savedGImgPath3 = $('#uploadedPic'+n).attr('src');
    }else if(checkImgNum == '4'){
        savedGImgPath4 = $('#uploadedPic'+n).attr('src');
    }else if(checkImgNum == '5'){
        savedGImgPath5 = $('#uploadedPic'+n).attr('src');
    }
  }
}
function deleteImage(e){
  $.ajax({
    url: "deleteImage.php",
    type: "GET",
    data:{
      e:e,
      },
    async: false,
    success: function(response){
      $('#imageHere'+deleteId).html('');
       $('#filechooser'+deleteId).val('');
    }
  });
}
$('#showGlassShapes').click(function(){
  $(this).blur();
});
$('#glassWidth1').keydown(function(){
  clearTimeout(timer); 
  timer = setTimeout(function(){
    //checkDims();
    var glassPriceHeight = $('#glassHeight1').val();
    var glassPriceWidth = $('#glassWidth1').val();
    if(glassPriceHeight.indexOf('-')>-1){
    splitGHeight = glassPriceHeight.split('-');
    splitGHeightFraction = splitGHeight[1].split('/');
    glassPriceHeight = +(+splitGHeightFraction[0]/+splitGHeightFraction[1]) + +splitGHeight[0];
  }else if(glassPriceHeight.indexOf('/')>-1 && glassPriceHeight.indexOf('-')==-1){
    glassPriceHeightWhole = glassPriceHeight.split(' ')[0].trim();
    glassPriceHeightFrac = glassPriceHeight.split(' ')[1].trim().split('/');
    glassPriceHeight = parseFloat(+glassPriceHeightWhole + +(glassPriceHeightFrac[0]/glassPriceHeightFrac[1])).toFixed(2);
  }
  if(glassPriceWidth.indexOf('-')>-1){
    splitGWidth = glassPriceWidth.split('-');
    splitGWidthFraction = splitGWidth[1].split('/');
    glassPriceWidth = +(+splitGWidthFraction[0]/+splitGWidthFraction[1]) + +splitGWidth[0];
  }else if(glassPriceWidth.indexOf('/')>-1 && glassPriceWidth.indexOf('-')==-1){
    glassPriceWidthWhole = glassPriceWidth.split(' ')[0].trim();
    glassPriceWidthFrac = glassPriceWidth.split(' ')[1].trim().split('/');
    glassPriceWidth = parseFloat(+glassPriceWidthWhole + +(glassPriceWidthFrac[0]/glassPriceWidthFrac[1])).toFixed(2);
  }
    $('#squareFeetDisplayDiv').html("Square Feet: " + parseFloat(Math.round(((glassPriceWidth * glassPriceHeight)/144) * 100)/100).toFixed(2));
  },10);
});
/*function checkWidth(){
  if(($('#glassWidth1').val() > 82 || $('#glassWidth1').val() <= 0) && $('#glassWidth1').val() != ''){
    $('#glassWidth1').attr('style',$('#glassWidth1').attr('style')+";background-color:#D9534F;");
    $('.glassInput').each(function(){
        $(this).prop('disabled',true);
    });
    $('#glassWidth1').prop('disabled',false);
    alert('Width must be greater than 0 and less than 82');
  }else{
    $('#glassWidth1').attr('style',$('#glassWidth1').attr('style')+";background-color:white;");
    $('.glassInput').each(function(){
        $(this).prop('disabled',false);
    });
  }*/
$('#glassHeight1').keydown(function(){
  clearTimeout(timer); 
  timer = setTimeout(function(){
    //checkDims();
   var glassPriceHeight = $('#glassHeight1').val();
    var glassPriceWidth = $('#glassWidth1').val();
    if(glassPriceHeight.indexOf('-')>-1){
    splitGHeight = glassPriceHeight.split('-');
    splitGHeightFraction = splitGHeight[1].split('/');
    glassPriceHeight = +(+splitGHeightFraction[0]/+splitGHeightFraction[1]) + +splitGHeight[0];
  }else if(glassPriceHeight.indexOf('/')>-1 && glassPriceHeight.indexOf('-')==-1){
    glassPriceHeightWhole = glassPriceHeight.split(' ')[0].trim();
    glassPriceHeightFrac = glassPriceHeight.split(' ')[1].trim().split('/');
    glassPriceHeight = parseFloat(+glassPriceHeightWhole + +(glassPriceHeightFrac[0]/glassPriceHeightFrac[1])).toFixed(2);
  }
  if(glassPriceWidth.indexOf('-')>-1){
    splitGWidth = glassPriceWidth.split('-');
    splitGWidthFraction = splitGWidth[1].split('/');
    glassPriceWidth = +(+splitGWidthFraction[0]/+splitGWidthFraction[1]) + +splitGWidth[0];
  }else if(glassPriceWidth.indexOf('/')>-1 && glassPriceWidth.indexOf('-')==-1){
    glassPriceWidthWhole = glassPriceWidth.split(' ')[0].trim();
    glassPriceWidthFrac = glassPriceWidth.split(' ')[1].trim().split('/');
    glassPriceWidth = parseFloat(+glassPriceWidthWhole + +(glassPriceWidthFrac[0]/glassPriceWidthFrac[1])).toFixed(2);
  }
    $('#squareFeetDisplayDiv').html("Square Feet: " + parseFloat(Math.round(((glassPriceWidth * glassPriceHeight)/144) * 100)/100).toFixed(2));
  },10);
});
function checkDims(){
 //change add retunr 1 on false return 0 on true for all
  if($('#glassWidth1').val() > 120 || $('#glassHeight1').val() > 120){
    alert('Height or width cannot be greater than 120.');
    //$('#glassadd_row').prop('disabled',true);
    //change remove this stuff

    /*$('.glassInput').each(function(){
      $(this).prop('disabled',true);
    });*/
    $('#glassHeight1').prop('disabled',false);
    $('#glassWidth1').prop('disabled',false);
    return 1;
  }else if(($('#glassWidth1').val() <= 120 && $('#glassWidth1').val()>70) && $('#glassHeight1').val() > 70){
    alert('Height cannot be greater than 120 if width is greater than 70.');
    //$('#glassadd_row').prop('disabled',true);
    /*$('.glassInput').each(function(){
      $(this).prop('disabled',true);
    });*/
    $('#glassHeight1').prop('disabled',false);
    $('#glassWidth1').prop('disabled',false);
    return 1;
  }else if(($('#glassHeight1').val() <= 120 && $('#glassHeight1').val()>82) && $('#glassWidth1').val() > 70){
    //$('#glassadd_row').prop('disabled',true);
    alert('Width cannot be greater than 120 if height is greater than 70.');
    /*$('.glassInput').each(function(){
      $(this).prop('disabled',true);
    });*/
    $('#glassHeight1').prop('disabled',false);
    $('#glassWidth1').prop('disabled',false);
    return 1;
  }/*else if(($('#glassHeight1').val() <= 0 || $('#glassWidth1').val() <= 0) || ($('#glassHeight1').val() <= 0 && $('#glassWidth1').val() <= 0)){
      $('#glassadd_row').prop('disabled',true);
      alert('Height and width must be greater than 0.');
      $('.glassInput').each(function(){
          $(this).prop('disabled',true);
      });
      $('#glassHeight1').prop('disabled',false);
      $('#glassWidth1').prop('disabled',false);}*/
  //change add this else if 
  else if($('#glassHeight1').val() <=0 || $('#glassWidth1').val() <=0){
    alert('Please enter dimensions.')
    return 1;
  }
  else{
      /*$('.glassInput').each(function(){
          $(this).prop('disabled',false);
      });*/
      $('#glassadd_row').prop('disabled',false);
      return 0;
  }     
  /*if(($('#glassHeight1').val() > 142 || $('#glassHeight1').val() <= 0) && $('#glassHeight1').val() != ''){
    $('#glassHeight1').attr('style',$('#glassHeight1').attr('style')+";background-color:#D9534F;");
    $('.glassInput').each(function(){
        $(this).prop('disabled',true);
    });
    $('#glassHeight1').prop('disabled',false);
    alert('Height must be greater than 0 and less than 142');
  }else{
    $('#glassHeight1').attr('style',$('#glassHeight1').attr('style')+";background-color:white;");
    $('.glassInput').each(function(){
        $(this).prop('disabled',false);
    });
  }*/
}
$('#glassThickness1').keydown(function(){
    clearTimeout(timer); 
    timer = setTimeout(checkThickness,1500);
});
function checkThickness(){
  if($('#glassOrderProduct option:selected').val().indexOf('IG') > -1){
      lowThick = .375;
      highThick = 1;
  }
  else if($('#glassOrderProduct option:selected').val().indexOf('TRIPLE') > -1){
      lowThick = .75;
      highThick = 1.625;
  }else if($('#glassThickness1').val() == ""){
    alert("Please enter an overall glass thickness");
  }
  if(($('#glassThickness1').val() > highThick || $('#glassThickness1').val() <= lowThick) && $('#glassThickness1').val() != ''){
    $('#glassThickness1').attr('style',$('#glassThickness1').attr('style')+";background-color:#FF4B4B;"); 
    /*$('.glassInput').each(function(){
        $(this).prop('disabled',true);
    });*/
    $('#glassThickness1').prop('disabled',false);
    alert('Thickness must be greater than or equal to ' + lowThick + ' and less than ' + highThick);
  }else{
    $('#glassThickness1').attr('style',$('#glassThickness1').attr('style')+";background-color:white;");
    $('.glassInput').each(function(){
        $(this).prop('disabled',false);
    });
  }
}
$('#showOtherGOpts').click(function(){
  $('#otherGlassOptions').toggle();
  $(this).blur();
});
$('document').ready(function(){
  customerNum = $('#getUser').html();
  if(customerNum != "0"){
    $.ajax({
    url:"getCustInfo.php",
    type: "GET",
    data:{
        ci:customerNum,
        },
    async:false,
    success:function(data){
      testCustInfo = JSON.parse(data);
        custInfoArr = $.map(JSON.parse(data), function(vv){
            return vv;
          /*
            0 CUS_CUSTNO
            1 CUS_LSTDTE
            2 CUS_SLSMAN
            3 CUS_ALPHA
            4 CUS_ATTN
            5 CUS_NAME
            6 CUS_ADDR
            7 CUS_ADDR2
            8 CUS_ADDR3
            9 CUS_CITY
            10 CUS_STATE
            11 CUS_ZIP
            12 CUS_CASTYP
            13 CUS_CUSTYP
            14 CUS_PRCMLT
            15 CUS_CLASS
            16 CUS_TAXABL
            17 CUS_TAX
            18 CUS_EXPNO
            19 CUS_PHONE
            20 CUS_CONTCT
            21 CUS_FAXNO
            22 CUS_FAXNO2
            23 CUS_SLSFAX
            24 CUS_TERMS
          */
        });
      }
  });
  $.ajax({
    url:"getEmail.php",
    type: "GET",
    data:{
        ci:customerNum,
        },
    async:false,
    success:function(data){
      custEmail = data;
    }
  }); 
  $.ajax({
    url:"getMulti.php",
    type: "GET",
    data:{
        ci:customerNum,
        },
    async:false,
    success:function(data){
      custMult = data;
    }
  });
    if(custInfoArr[0]=="9999999"){
      $('#preparedInput').val(testCustInfo['CUS_SLSMAN']);
      $('#preparedInput').prop('disabled','true');
      $('#nameInput').val(testCustInfo['CUS_NAME']);
      $('#nameInput').prop('disabled','true');
      $('#clientInput').val(testCustInfo['CUS_CUSTNO']);
      $('#clientInput').prop('disabled','true');
      $('#address1').val(testCustInfo['CUS_ADDR']);
      $('#address2').val('');
      $('#address3').val('');
      $('#address1').prop('disabled','true'); 
      $('#address2').prop('disabled','true');
      $('#address3').prop('disabled','true');
      $('#city').val(testCustInfo['CUS_CITY']);
      $('#city').prop('disabled','true');
      $('#state').val(testCustInfo['CUS_STATE']);
      $('#state').prop('disabled','true');
      $('#zipCode').val(testCustInfo['CUS_ZIP']);
      $('#zipCode').prop('disabled','true');
      $('#contact').val(testCustInfo['CUS_NAME']);
      $('#contact').prop('disabled','true');
      $('#phoneNumber').val(custInfoArr[13]);
      $('#phoneNumber').prop('disabled','true');
      $('#faxNumber').val(testCustInfo['CUS_FAXNO']);
      $('#faxNumber').prop('disabled','true');
      $('#shipToRadio1').click();
      priceMulti = testCustInfo['CUS_PRCMLT'];
      $('#multiplierIn').val(custMult);
      $('#eMail').val(custEmail);
      orderTerms = testCustInfo['CUS_TERMS'];
      if(typeof orderTerms === 'undefined'){
        orderTerms = 1;
      }
      orderAlpha = testCustInfo['CUS_ALPHA'];
      custTaxTerms = testCustInfo['CUS_TAX'];
    }else{
      $('#preparedInput').val(testCustInfo['CUS_SLSMAN']);
      $('#preparedInput').prop('disabled','true');
      $('#nameInput').val(testCustInfo['CUS_NAME']);
      $('#nameInput').prop('disabled','true');
      $('#clientInput').val(testCustInfo['CUS_CUSTNO']);
      $('#clientInput').prop('disabled','true');
      $('#address1').val(testCustInfo['CUS_ADDR']);
      $('#address2').val(testCustInfo['CUS_ADDR2']);
      $('#address3').val(testCustInfo['CUS_ADDR3']);
      $('#address1').prop('disabled','true'); 
      $('#address2').prop('disabled','true');
      $('#address3').prop('disabled','true');
      $('#city').val(testCustInfo['CUS_CITY']);
      $('#city').prop('disabled','true');
      $('#state').val(testCustInfo['CUS_STATE']);
      $('#state').prop('disabled','true');
      $('#zipCode').val(testCustInfo['CUS_ZIP']);
      $('#zipCode').prop('disabled','true');
      $('#contact').val(testCustInfo['CUS_CONTCT']);
      $('#contact').prop('disabled','true');
      $('#phoneNumber').val(testCustInfo['CUS_PHONE']);
      $('#phoneNumber').prop('disabled','true');
      $('#faxNumber').val(testCustInfo['CUS_FAXNO']);
      $('#faxNumber').prop('disabled','true');
      $('#eMail').val(custEmail);
      
      $('#shipToRadio1').click();
      priceMulti = custMult;
      $('#multiplierIn').val(priceMulti);
      orderTerms = testCustInfo['CUS_TERMS'];
      if(typeof orderTerms === 'undefined'){
        orderTerms = 1;
      }
      orderAlpha = testCustInfo['CUS_ALPHA'];
      custTaxTerms = testCustInfo['CUS_TAX'];
    }  
  if(custTaxTerms == '1' || custTaxTerms == '3' || custTaxTerms == '4'){
    $('#taxPercIn').attr('disabled',true);
    if(custTaxTerms == '1'){
      $('#taxPercIn').val('7.5%');
      savedTax = "7.5%";
    }else if(custTaxTerms == '3'){
      $('#taxPercIn').val('5.5%');
      savedTax = "5.5%";
    }else if(custTaxTerms == '4'){
      $('#taxPercIn').val('6.25%');
      savedTax = "6.25%";
    }
  }
  if(custTaxTerms == '2'){
    $('#taxPercIn').val('');
    $('#taxPercIn').attr('disabled','false');
    savedTax = '0%';
  }
}else{ 
  custTaxTerms = 1;
  $('#taxPercIn').val('7.5%');
  savedTax = "7.5%";
}
$.ajax({
  url:"getUserInfo.php",
  type: "GET",
  data:
  {
    u: user,
  },
  async:false,
  success:function(data){
      userInfoArr = $.map(JSON.parse(data), function(vvvv){
        return vvvv;
      });
    }
  })
  userEmail = userInfoArr[0];
  userFirstName = userInfoArr[1];
  userLastName = userInfoArr[2];
  $('#preparedInput').val(userFirstName + " " + userLastName);
  $('#pageLoadText').hide();
  if(homeId > 0){
    newQuote = 1;
    //$('#startQuote').click();
   editGlassQuote(homeId);
  }else{
    $('#startQuote').click();
  }
});
function editGlassQuote(e){
  editNum = 1;
  if($('#bottomHalf').is(':visible')){
    deleteQuote = 1;
    tblLength = $('#tab_logic >tbody >tr').length;
    for(i=tblLength;i>0;i--){ 
      $('#addr'+i).find('td[data-name="preview"]').find('[name="del0"]').click();    
    }
    $('#bottomHalf').hide();
    $('#priceFooter').html(''); 
    /*for(var i = 0; i<arr2.length;i++){
      arr2.splice(i,1);
    }*/
    newid = 0;
    deleteCount = 0;
  }
  if(newid > 0){
    deleteQuote = 0;
    for(var a=1;a<=newid;a++){
      $('#addr'+a).find('[name="del0"]').click();
    }
    newid = 0;
  }
  deleteQuote = 0;
  var jn = e;
  jobNumber = jn;
  $.ajax({
    url:"editQuote.php",
    type: "POST",
    data:{
      jn: jn
    },
    async:false,
    success:function(data){
        quoteNum = data;
    }    
 })
 $.ajax({
    url:"getBlob.php",
    type: "POST",
    data:{
      jn: jn,
    },
    async: false,
    success: function(data){
      arr2 = $.map(JSON.parse(data), function(vvv){
          return vvv;
      });
    }
  })
  $.ajax({
    url:"getHeaderInfo.php",
    type: "POST",
    data:{
      jn: jn,
    },
    async: false,
    success: function(data){
      arr3 = $.map(JSON.parse(data), function(vvv){
          return vvv;
      });
    }
  })
  /*
  0 = cust name 
  1 = prepared by 
  2 = poid 
  3 = client id 
  4 = cust add1
  5 = cust add2
  6 = cust add3
  7 = cust cit
  8 = cust state
  9 = cust zip
  10 = cust cont
  11 = cust phone
  12 = cust fax
  13 = cust ema
  14 = job add1
  15 = job add2
  16 = job add3
  17 = job city 
  18 = job state
  19 = job zip 
  20 = job cont 
  21 = job phone 1
  22 = job phone 2
  23 = job notes
  24 = ship add1
  25 = ship add2
  26 = ship add3
  27 = ship city
  28 = ship state
  29 = ship zip 
  30 = ship cont
  31 = ship phone
  32 = shinp instruc 
  33 = jobid 
  */
  $('#topGlassPOInput').val(arr3[2])
  $('#preparedInput').val(arr3[1]);
  $('#clientInput').val(arr3[3]);
  $('#nameInput').val(arr3[0]);
  $('#address1').val(arr3[4]);
  $('#address2').val(arr3[5]);
  $('#address3').val(arr3[6]);
  $('#city').val(arr3[7]);
  $('#state').val(arr3[8]);
  $('#zipCode').val(arr3[9]);
  $('#contact').val(arr3[10]);
  $('#phoneNumber').val(arr3[11]);
  $('#faxNumber').val(arr3[12]);
  $('#eMail').val(arr3[13]);
  $('#poIdInput').val(arr3[2]);
  $('#address1JobS').val(arr3[14]);
  $('#address2JobS').val(arr3[15]);
  $('#address3JobS').val(arr3[16]);
  $('#cityJobS').val(arr3[17]);
  $('#stateJobS').val(arr3[18]);
  $('#zipCodeJobS').val(arr3[19]);
  $('#contactJobS').val(arr3[20]);
  $('#phoneNumberJobS').val(arr3[21]);
  $('#altNumberNumber').val(arr3[22]);
  $('#notesJobS').val(arr3[23]);
  $('#address1ShipTo').val(arr3[24]);
  $('#address2ShipTo').val(arr3[25]);
  $('#address3ShipTo').val(arr3[26]);
  $('#cityShipTo').val(arr3[27]);
  $('#stateShipTo').val(arr3[28]);
  $('#zipCodeShipTo').val(arr3[29]);
  $('#contactShipTo').val(arr3[30]);
  $('#phoneNumberShipTo').val(arr3[11]);
  $('#notesShipTo').val(arr3[32]);
  
  $.ajax({
    url:"getAddBlob.php",
    type: "POST",
    data:{
      jn: jn,
    },
    async: false,
    success: function(data){
      arrAdd = $.map(JSON.parse(data), function(a){
          return a;
      });
    }
  })
  $('#startQuote').click(); 
  $.ajax({
    url:"getQuoteDate.php",
    type: "POST",
    data:{jn: jn},
    async:false,
    success:function(data){
      jobDate1 = data;
      jobDate = data;
    }    
  })
  if($('#topHalf').is(':hidden')){
    $('#topHalf').show();
  }
  $('#glassButton').click();
    sortOptionArray(arr2);
    var nextWindow = 0;
    waitingDialog.show("Loading...");
    var interval = setInterval(function(){
    if(nextWindow < arr2.length){
      savedGImgPath1 = arr2[nextWindow].img1;
      savedGImgPath2 = arr2[nextWindow].img2;
      savedGImgPath3 = arr2[nextWindow].img3;
      savedGImgPath4 = arr2[nextWindow].img4;
      savedGImgPath5 = arr2[nextWindow].img5;
      if(arr2[nextWindow].pr == 'RECT IG'){
        editSuffix = 'RIG';
      }else if(arr2[nextWindow].pr == 'SHAPE IG'){
        editSuffix = 'SIG';
      }else if(arr2[nextWindow].pr == 'TRIPLE RECT'){
        editSuffix = 'TR';
      }else if(arr2[nextWindow].pr == 'TRIPLE SHAPE'){
        editSuffix = 'TS';
      }else if(arr2[nextWindow].pr == 'MONO RECT'){
        editSuffix = 'MR';
      }else if(arr2[nextWindow].pr == 'MONO SHAPE'){
        editSuffix = 'MS';
      }else if(arr2[nextWindow].pr ==""){
        editSuffix = "";
      } 
      if(editSuffix != ""){
        $('#glassOrderProduct').val(arr2[nextWindow].pr);
        $('#glassOrderProduct').change();
        $('#glassWidth1').val(arr2[nextWindow].w);
        $('#glassHeight1').val(arr2[nextWindow].h);
        $('#glassThickness1').val(arr2[nextWindow].gthick);
        
        $('#hiddenGlassLabel').val(arr2[nextWindow].gLabel);
        $('#glassWidth1').keydown();
        $('#glassOrderType'+editSuffix + ' option').filter(function(){
            return $.trim($(this).text()) ==  arr2[nextWindow].gtt.replace(/&quot;/g, '\"')
        }).prop('selected', true);
        if(arr2[nextWindow].gs == ''){
          $('#glassOrderStrength'+editSuffix).val('#');
        }else{
          $('#glassOrderStrength'+editSuffix + ' option').filter(function(){
            return $.trim($(this).text()) ==  arr2[nextWindow].gsT.replace(/&quot;/g, '\"')
          }).prop('selected', true);
        }
        if(arr2[nextWindow].pr.toLowerCase().indexOf("shape") > -1){
          $('#glassOrderShape option').filter(function(){
            return $.trim($(this).attr('id')) ==  arr2[nextWindow].gsh
          }).prop('selected', true);
          $('#glassOrderShape').change();
          $('#shapeDimBase').val(arr2[nextWindow].sb);
          $('#shapeDimTop').val(arr2[nextWindow].st);
          $('#shapeDimLeft').val(arr2[nextWindow].sl);
          $('#shapeDimRight').val(arr2[nextWindow].sr);
          $('#shapeDimS1').val(arr2[nextWindow].s1);
          $('#shapeDimS2').val(arr2[nextWindow].s2);
          $('#shapeDimRadius').val(arr2[nextWindow].sa); 
        }
        $('#glassOrderStrength'+editSuffix).change();
        $('#glassOrderQuant').val(arr2[nextWindow].gq);
        $('#glassOrderThickness'+editSuffix).val(arr2[nextWindow].ck);
        $('#glassOrderThickness').val(arr2[nextWindow].sp);
        //$('#glassOrderGrille'+editSuffix).val(arr2[nextWindow].gr);
        $('#glassOrderGrille'+editSuffix + ' option').filter(function(){
          return $.trim($(this).text()) ==  arr2[nextWindow].grT.replace(/&quot;/g, '\"')
        }).prop('selected', true);
        $('#glassOrderGrille'+editSuffix).change();
        //$('#glassOrderGrillePatt'+editSuffix).val(arr2[nextWindow].gp);
        $('#glassOrderGrillePatt'+editSuffix + ' option').filter(function(){
          return $.trim($(this).text()) ==  arr2[nextWindow].gpT.replace(/&quot;/g, '\"')
        }).prop('selected', true);
        if(arr2[nextWindow].gpT != "None"){ 
          $('#glassOrderGrillePatt'+editSuffix).change();
          $('#glassOrderColonialWide').val(arr2[nextWindow].cpw);
          $('#glassOrderColonialHigh').val(arr2[nextWindow].cph);
          $('#glassOrderColonialCust').val(arr2[nextWindow].cpn);
          $('#glassOrderPrairieHigh').val(arr2[nextWindow].pph);
          $('#glassOrderPrairieWide').val(arr2[nextWindow].ppw);
          $('#glassOrderPrairieOff').val(arr2[nextWindow].ppo);
          $('#glassOrderCustPrairieHigh').val(arr2[nextWindow].pch);
          $('#glassOrderCustPrairieWide').val(arr2[nextWindow].pcw);
          $('#glassOrderCustPrairieVertOff').val(arr2[nextWindow].pwo);
          $('#glassOrderCustPrairieHoriOff').val(arr2[nextWindow].pho);
          $('#glassOrderCustRectLites').val(arr2[nextWindow].pcr);
          $('#glassOrderCustCurvLites').val(arr2[nextWindow].pcc);
          $('#glassOrderCustAngLites').val(arr2[nextWindow].pca);
        }else{
          $('#glassOrderColonialWide').val('');
          $('#glassOrderColonialHigh').val('');
          $('#glassOrderColonialCust').val('');
          $('#glassOrderPrairieHigh').val('');
          $('#glassOrderPrairieWide').val('');
          $('#glassOrderPrairieOff').val('');
          $('#glassOrderCustPrairieHigh').val('');
          $('#glassOrderCustPrairieWide').val('');
          $('#glassOrderCustPrairieVertOff').val('');
          $('#glassOrderCustPrairieHoriOff').val('');
          $('#glassOrderCustRectLites').val('');
          $('#glassOrderCustCurvLites').val('');
          $('#glassOrderCustAngLites').val('');
        }  
        $('#glassOrderIntGrille'+editSuffix + ' option').filter(function(){
          return $.trim($(this).text()) ==  arr2[nextWindow].gigT.replace(/&quot;/g, '\"')
        }).prop('selected', true);
        //$('#glassOrderIntGrille'+editSuffix).val(arr2[nextWindow].gig);
        //$('#glassOrder2Tone').val(arr2[nextWindow].g2g);
        $('#glassOrderGrillePatt'+editSuffix + ' option').filter(function(){
          return $.trim($(this).text()) ==  arr2[nextWindow].g2gT.replace(/&quot;/g, '\"')
        }).prop('selected', true);
        if($('#otherGlassOptions2').is(':hidden')){
          $('#showOtherOptions').click();
        }
        $('#glassOrderSpacer option').filter(function(){
          return $.trim($(this).text()) ==  arr2[nextWindow].spT.replace(/&quot;/g, '\"')
        }).prop('selected', true);
        //$('#glassOrderPreserve'+editSuffix).val(arr2[nextWindow].gpr);
        //$('#glassOrderTint'+editSuffix).val(arr2[nextWindow].gti);
        //$('#glassOrderHard'+editSuffix).val(arr2[nextWindow].ghc);
        $('#glassOrderPreserve'+editSuffix + ' option').filter(function(){
          return $.trim($(this).text()) ==  arr2[nextWindow].gprT.replace(/&quot;/g, '\"')
        }).prop('selected', true);
        
        $('#glassOrderTint'+editSuffix + ' option').filter(function(){
          return $.trim($(this).text()) ==  arr2[nextWindow].gtiT.replace(/&quot;/g, '\"')
        }).prop('selected', true);
        $('#glassOrderTint'+editSuffix).change();
        $('#glassOrderHard'+editSuffix + ' option').filter(function(){
          return $.trim($(this).text()) ==  arr2[nextWindow].ghcT.replace(/&quot;/g, '\"')
        }).prop('selected', true);
        
        if(arr2[nextWindow].gtiT.replace(/&quot;/g, '\"') == "No"){
          $('#glassOrderObscure'+editSuffix + ' option').filter(function(){
            return $.trim($(this).text()) ==  arr2[nextWindow].obsT.replace(/&quot;/g, '\"')
          }).prop('selected', true);
        }
        
        $('#glassOrderTemper option').filter(function(){
          return $.trim($(this).text().split("-")[0].trim()) ==  arr2[nextWindow].gtemT.replace(/&quot;/g, '\"')
        }).prop('selected', true);
        
        $('#glassOrderTypeSurface option').filter(function(){
          return $.trim($(this).text()) ==  arr2[nextWindow].s5T.replace(/&quot;/g, '\"')
        }).prop('selected', true);
      }
    if(editSuffix == ""){
      blankRow = 1;
    }else{
      blankRow = 0;
    }
    if(arrAdd.length > 0){
      for(i = 0; i<arrAdd.length;i++){
        if(arrAdd[i].id == newid){
          $('#addAddItems').click();
          $('#addDesc').val(arrAdd[i].addDescription);
          $('#additionalPrice').val(arrAdd[i].addPrice);
          $('#additionalConfirm').click();
        }
        //addItmsLine = "<p id='addItms"+arrAdd[nextWindow].id+"'><b>Additional Items: </b>" + arrAdd[nextWindow].addDescription + ", $" + arrAdd[nextWindow].addPrice+"</p>";
      }  
    }
    //$('#glassOrderObscure'+editSuffix).val(arr2[nextWindow].obs);
    if(editSuffix !=""){
      if(arr2[nextWindow].igT != null){
        $('#glassOrderLogo option').filter(function(){
          return $.trim($(this).text()) ==  arr2[nextWindow].igT.replace(/&quot;/g, '\"')
        }).prop('selected', true);
      }else{
        $('#glassOrderLogo').val(arr2[nextWindow].ig);
      }
      $('#glassadd_row').click();
    }else{
      blankRow = 0;
    }  
    //editedLabel = arr2[nextWindow].gLabel.replace(/&quot;/g, '\"');
    //$('#lineLabel'+(nextWindow+1)).val(editedLabel);
      thisId = parseInt($('#lineLabel'+(nextWindow+1)).closest('tr').attr('data-id'));
      if(editSuffix != ""){
        glassOptions[thisId-1].gLabel = escapeHtml($('#lineLabel'+(nextWindow+1)).closest('tr').find('[name = "lineLabels"]').val());
        if(glassOptions[thisId-1].gLabel != ""){
          jsonWindowString = JSON.stringify(glassOptions);  
          newQuote = 1;
          saveQuote(jobNumber,jobDate,jobClientName,jobPrepared,quoteNum,quoteTotal,jobPoId,jobClientId,jobAddress1,jobAddress2,jobAddress3,jsonWindowString,jobCity,jobState,jobZip,jobContact,jobPhoneNumber,      jobFaxNumber,jobEmail,jobSiteAddress1,jobSiteAddress2,jobSiteAddress3,jobSiteCity,jobSiteState,jobSiteZip,jobSiteContact,jobSitePhone1,jobSitePhone2,jobSiteNotes,shipToAddress1,shipToAddress2,shipToAddress3,shipToCity,shipToState,shipToZip,shipToContact,shipToPhone,shipToNotes,pickOrShipArr,jobID,qmarkup,qmulti,newQuote,additionalArray,'configure');
          //$('#lineLabel'+(nextWindow+1)).closest('tr').find('[name = "lineLabels"]').attr('style','background-color:#a6ffa6');
          $('#lineLabel'+(nextWindow+1)).closest('tr').find('[name = "labelCheckName"]').removeClass('hidden');
        }
      }
      nextWindow++;
    }else{
      clearInterval(interval);
      waitingDialog.hide();
      for(l=1;l<=newid;l++){
        updateQuant($("#tab_logic").find('tr#addr'+l).find('#quantText' + l));
      }
      $('#closeQuotes').click();
      editNum = 0;
      return;
    }
  },1000);  
}
$('#showOtherOptions').click(function(){
  $('#otherGlassOptions2').toggle();
  $(this).blur();
  /**$('html, body').animate({ 
        scrollTop: $(document).height()-$(window).height()}, 
        0, 
        "swing"
     );**/
});
function editTbl(e){
  edButtonPressed = e;
  $(e).blur();
  $("[name ='del0']").hide();
  hideGrillePrompts();
  editTblRow = 1;
  if($('#glassedit_row').is(':hidden')){
    $('#glassadd_row').hide();
    $('#glasssendOrder').hide();
    $('#glassedit_row').show();
    $('#exitGlassEdit').show();
    $('#glassPanelHeading').addClass('panel-warning');
    $('#glassPanelHeading').attr('style',$('#glassPanelHeading').attr('style')+";background-color:#FFFF33");
    $('#glassPanelPrimary').removeClass('panel-primary');
    $('#glassPanelPrimary').addClass('panel-warning');
    //$('#glassPanelHeading').attr('style','background-color:#FFB36B')
    $('#glassPanelPrimary').attr('style',$('#glassPanelPrimary').attr('style')+";background-color:#FFFF33");
    $('#glassPanelPrimary').attr('style','border-style:dashed;border-width:2px;border-color:#FFFF33 #FFFF33 #FFFF33 #FFFF33');
  }
  if($('#glassEditLabel').length){
    $('#glassEditLabel').remove();
  }
  $('#glassPanelHeading').html($('#glassPanelHeading').html()+'<div id="glassEditLabel"><br><b style="font-size:2em;color:#000000">Editing line number '+$(e).closest('tr').find('[name="lineNumDivName"]').html());
  $('html, body').animate({ 
    scrollTop: $(window).height()-$(document).height()}, 
    300, 
    "swing"
  );
   
  jn = jobNumber;
  $.ajax({
    url:"getBlob.php",
    type: "POST",
    data: {jn: jn},
    async: false,
    success: function(data){
      arr2 = $.map(JSON.parse(data), function(vvv){
        return vvv;
      });
    }
  })
  savedNewId = newid;
  editId = parseInt($(e).closest('tr').attr('data-id')) - 1;
  newid = parseInt($(e).closest('tr').attr('data-id'));
  sortOptionArray(arr2);
  savedLineNum = lineNum;
  lineNum = arr2[editId].gDArr[0].line;
  $(e).closest('tr').find('[name = "lineLabels"]').prop('disabled',true);
  lineLabelId = $(e).closest('tr').find('[name = "lineLabels"]').attr('id');
  if(arr2[editId].pr == 'RECT IG'){
    editSuffix = 'RIG';
  }else if(arr2[editId].pr == 'SHAPE IG'){
    editSuffix = 'SIG';
  }else if(arr2[editId].pr == 'TRIPLE RECT'){
    editSuffix = 'TR';
  }else if(arr2[editId].pr == 'TRIPLE SHAPE'){
    editSuffix = 'TS';
  }else if(arr2[editId].pr == 'MONO RECT'){
    editSuffix = 'MR';
  }else if(arr2[editId].pr == 'MONO SHAPE'){
    editSuffix = 'MS';
  }
  $('#hiddenGlassLabel').val(arr2[editId].gLabel);
  $('#glassOrderProduct').val(arr2[editId].pr);
  $('#glassOrderProduct').change();
  $('#glassWidth1').val(arr2[editId].w);
  $('#glassHeight1').val(arr2[editId].h);
  $('#glassThickness1').val(arr2[editId].gthick);
  $('#glassWidth1').keydown();
  $('#glassOrderType'+editSuffix + ' option').filter(function(){
    return $.trim($(this).text()) ==  arr2[editId].gtt.replace(/&quot;/g, '\"')
  }).prop('selected', true);
  if(arr2[editId].gs == ''){
    $('#glassOrderStrength'+editSuffix).val('#');
  }else{
    $('#glassOrderStrength'+editSuffix + ' option').filter(function(){
      return $.trim($(this).text()) ==  arr2[editId].gsT.replace(/&quot;/g, '\"')
    }).prop('selected', true);
  }
  if(arr2[editId].pr.toLowerCase().indexOf("shape") > -1){
    $('#glassOrderShape option').filter(function(){
      return $.trim($(this).attr('id')) ==  arr2[editId].gsh
    }).prop('selected', true);
    $('#glassOrderShape').change();
    $('#shapeDimBase').val(arr2[editId].sb);
    $('#shapeDimTop').val(arr2[editId].st);
    $('#shapeDimLeft').val(arr2[editId].sl);
    $('#shapeDimRight').val(arr2[editId].sr);
    $('#shapeDimS1').val(arr2[editId].s1);
    $('#shapeDimS2').val(arr2[editId].s2);
    $('#shapeDimRadius').val(arr2[editId].sa);
  }
  $('#glassOrderStrength'+editSuffix).change();
  $('#glassOrderQuant').val(arr2[editId].gq);
  $('#glassOrderThickness'+editSuffix).val(arr2[editId].ck);
  $('#glassOrderThickness').val(arr2[editId].sp);
  //$('#glassOrderGrille'+editSuffix).val(arr2[editId].gr);
  $('#glassOrderGrille'+editSuffix + ' option').filter(function(){
    return $.trim($(this).text()) ==  arr2[editId].grT.replace(/&quot;/g, '\"')
  }).prop('selected', true);
  
  $('#glassOrderGrille'+editSuffix).change();
  //$('#glassOrderGrillePatt'+editSuffix).val(arr2[editId].gp);
  $('#glassOrderGrillePatt'+editSuffix + ' option').filter(function(){
    return $.trim($(this).text()) ==  arr2[editId].gpT.replace(/&quot;/g, '\"')
  }).prop('selected', true);
  
  if($('#glassOrderGrille'+editSuffix+' option:selected').val() != ""){
    $('#glassOrderGrillePatt'+editSuffix).change();
    $('#glassOrderColonialWide').val(arr2[editId].cpw);
    $('#glassOrderColonialHigh').val(arr2[editId].cph);
    $('#glassOrderColonialCust').val(arr2[editId].cpn);
    $('#glassOrderPrairieHigh').val(arr2[editId].ppw);
    $('#glassOrderPrairieWide').val(arr2[editId].phh);
    $('#glassOrderPrairieOff').val(arr2[editId].ppo);
    $('#glassOrderCustPrairieHigh').val(arr2[editId].pch);
    $('#glassOrderCustPrairieWide').val(arr2[editId].pcw);
    $('#glassOrderCustPrairieVertOff').val(arr2[editId].pwo);
    $('#glassOrderCustPrairieHoriOff').val(arr2[editId].pho);
    $('#glassCustRectLites').val(arr2[editId].pcr);
    $('#glassCustCurveLites').val(arr2[editId].pcc);
    $('#glassCustAngLites').val(arr2[editId].pca);
  }else{
    $('#glassOrderColonialWide').val('');
    $('#glassOrderColonialHigh').val('');
    $('#glassOrderColonialCust').val('');
    $('#glassOrderPrairieHigh').val('');
    $('#glassOrderPrairieWide').val('');
    $('#glassOrderPrairieOff').val('');
    $('#glassOrderCustPrairieHigh').val('');
    $('#glassOrderCustPrairieWide').val('');
    $('#glassOrderCustPrairieVertOff').val('');
    $('#glassOrderCustPrairieHoriOff').val('');
    $('#glassCustRectLites').val('');
    $('#glassCustCurveLites').val('');
    $('#glassCustAngLites').val('');
  }
 
  $('#glassOrderIntGrille'+editSuffix + ' option').filter(function(){
    return $.trim($(this).text()) ==  arr2[editId].gigT.replace(/&quot;/g, '\"')
  }).prop('selected', true);
  //$('#glassOrderIntGrille'+editSuffix).val(arr2[editId].gig);
  //$('#glassOrder2Tone').val(arr2[editId].g2g);
  $('#glassOrder2Tone option').filter(function(){
    return $.trim($(this).text()) ==  arr2[editId].g2gT.replace(/&quot;/g, '\"')
  }).prop('selected', true);
  if($('#otherGlassOptions2').is(':hidden')){
    $('#showOtherOptions').click();
  }
  $('#glassOrderSpacer option').filter(function(){
    return $.trim($(this).text()) ==  arr2[editId].spT.replace(/&quot;/g, '\"')
  }).prop('selected', true);
  //$('#glassOrderPreserve'+editSuffix).val(arr2[editId].gpr);
  //$('#glassOrderTint'+editSuffix).val(arr2[editId].gti);
  //$('#glassOrderHard'+editSuffix).val(arr2[editId].ghc);
  //$('#glassOrderObscure'+editSuffix).val(arr2[editId].obs);
  $('#glassOrderPreserve'+editSuffix + ' option').filter(function(){
    return $.trim($(this).text()) ==  arr2[editId].gprT.replace(/&quot;/g, '\"')
  }).prop('selected', true);
   
  $('#glassOrderTint'+editSuffix + ' option').filter(function(){
    return $.trim($(this).text()) ==  arr2[editId].gtiT.replace(/&quot;/g, '\"')
  }).prop('selected', true);
  $('#glassOrderTint'+editSuffix).change();
  $('#glassOrderHard'+editSuffix + ' option').filter(function(){
    return $.trim($(this).text()) ==  arr2[editId].ghcT.replace(/&quot;/g, '\"')
  }).prop('selected', true);
  
  if(arr2[editId].gtiT.replace(/&quot;/g, '\"') == "No"){
    $('#glassOrderObscure'+editSuffix + ' option').filter(function(){
      return $.trim($(this).text()) ==  arr2[editId].obsT.replace(/&quot;/g, '\"')
    }).prop('selected', true);
  }
  
  $('#glassOrderTemper option').filter(function(){
    return $.trim($(this).text().split("-")[0].trim()) ==  arr2[editId].gtemT.replace(/&quot;/g, '\"')
  }).prop('selected', true);
  
  $('#glassOrderTypeSurface option').filter(function(){
    return $.trim($(this).text()) ==  arr2[editId].s5T.replace(/&quot;/g, '\"')
  }).prop('selected', true);
  $('#glassOrderLogo'+editSuffix).val(arr2[editId].ig);        
}
$('#glassedit_row').click(function(){
  upAddArr = 0;
  var test = $(edButtonPressed).closest('tr').find('[name = "hiddenInput2"]').val();  
  var totalPrice = $('#priceFooter').text().replace(/^\D+/g, ""); 
  var newPrice = +totalPrice - +test;
  if($(edButtonPressed).closest('tr').find('[name = "addPriceName"]').length > 0){
    upAddArr = 1;
    newPrice -= $(edButtonPressed).closest('tr').find('[name = "addPriceName"]').attr('value');
    additionalArray = $.map(JSON.parse(additionalArray), function(xx){
      return xx;
    });
    for(i = 0;i<additionalArray.length;i++){
      if(additionalArray[i].id == (parseInt($(edButtonPressed).closest('tr').find('[name = "addPriceName"]').attr('id').replace(/^\D+/g, ""))-1)){
        additionalArray.splice(i,1);
      }
    }
  }
  glassOptions.splice($(edButtonPressed).closest('tr').find('[name = "lineNumDivName"]').html()-1,1);
  newPrice = parseFloat(Math.round(newPrice * 100)/100).toFixed(2);
  $('#priceFooter').html("<strong>Total Price:</strong> $"+ newPrice);
  $(edButtonPressed).closest('tr').find('[name = "quantityText"]').remove();
  $(edButtonPressed).closest('tr').find('[name = "hiddenInput2"]').remove();
  $(edButtonPressed).closest('tr').find('[data-name = "dims"]').html('');
  $(edButtonPressed).closest('tr').find('[data-name = "listPriceTd"]').html('');
  $(edButtonPressed).closest('tr').attr('id',"addr"+$(edButtonPressed).closest('tr').attr('data-id'));
  console.log($(edButtonPressed).closest('tr').attr('data-id'));
  quoteTotal = newPrice;
  needQuotes = 0;
  jsonWindowString=JSON.stringify(glassOptions);
  if(upAddArr == 1){
    additionalArray = JSON.stringify(additionalArray);
  }
  saveQuote(jobNumber,jobDate,jobClientName,jobPrepared,quoteNum,quoteTotal,jobPoId,jobClientId,jobAddress1,jobAddress2,jobAddress3,jsonWindowString,jobCity,jobState,jobZip,jobContact,jobPhoneNumber,jobFaxNumber,jobEmail,jobSiteAddress1,jobSiteAddress2,jobSiteAddress3,jobSiteCity,jobSiteState,jobSiteZip,jobSiteContact,jobSitePhone1,jobSitePhone2,jobSiteNotes,shipToAddress1,shipToAddress2,shipToAddress3,shipToCity,shipToState,shipToZip,shipToContact,shipToPhone,shipToNotes,pickOrShipArr,jobID,qmarkup,qmulti,newQuote,additionalArray,'configure');
  $('#glassadd_row').click();
  lineId = $('#addr'+newid).find('td[data-name = "lineNumber"]').find("[name='lineNumDivName']").attr('id').replace(/^\D+/g, "");
  if($('#lineLabel'+lineId).val() != ''){
    updateLabel($('#lineLabel'+lineId)[0]);
  }
  $("[name ='del0']").show();
  $('#exitGlassEdit').click(); 
  editTblRow = 0;
})
$('#exitGlassEdit').click(function(){
 $('#glassEditLabel').remove();
  if($('#glassedit_row').is(':visible')){
    $('#glasssendOrder').show();
    $('#glassadd_row').show();
    $('#glassedit_row').hide();
    $('#exitGlassEdit').hide();
    $('#glassPanelHeading').removeClass('panel-warning');
    $('#glassPanelHeading').attr('style','');
    $('#glassPanelPrimary').removeClass('panel-warning');
    $('#glassPanelPrimary').addClass('panel-primary');
    $('#glassPanelPrimary').attr('style','');
    sortedGlass = $.map(JSON.parse(jsonWindowString), function(gg){
      return gg;
    });
    sortOptionArray(sortedGlass);
    sortedGlass = JSON.stringify(sortedGlass);
    saveQuote(jobNumber,jobDate,jobClientName,jobPrepared,quoteNum,quoteTotal,jobPoId,jobClientId,jobAddress1,jobAddress2,jobAddress3,sortedGlass,jobCity,jobState,jobZip,jobContact,jobPhoneNumber,jobFaxNumber,jobEmail,jobSiteAddress1,jobSiteAddress2,jobSiteAddress3,jobSiteCity,jobSiteState,jobSiteZip,jobSiteContact,jobSitePhone1,jobSitePhone2,jobSiteNotes,shipToAddress1,shipToAddress2,shipToAddress3,shipToCity,shipToState,shipToZip,shipToContact,shipToPhone,shipToNotes,pickOrShipArr,jobID,qmarkup,qmulti,newQuote,additionalArray,'configure');
  }
  $('#lineLabel'+newid).prop('disabled',false);
  newid = savedNewId;
  //$("[name ='del0']").show();
});
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();
function addPercentSign(e){
  setTimeout(function(){
    if($(e).val().indexOf('%') == -1 && $(e).val() != ''){
      $(e).val($(e).val() + "%");
    }
  },2000);
}
$('#taxPercIn').keyup(function(){
  addPercentSign($(this));
  savedTax = $('#taxPercIn').val();
});
function updateLabel(e){
  $(e).closest('tr').find('[name = "labelCheckName"]').addClass('hidden');
  delay(function(){
    sortOptionArray(glassOptions);
    thisId = parseInt($(e).closest('tr').attr('data-id'));
    glassOptions[(thisId-1)].gLabel = escapeHtml($(e).closest('tr').find('[name = "lineLabels"]').val());
    glassOptions[(thisId-1)].gLabelArr[0]['optionVal'] = $(e).closest('tr').find('[name="lineLabels"]').val();
    jsonWindowString = JSON.stringify(glassOptions); 
    jsonGlassString = JSON.stringify(glassOptions);
    newQuote = 1;
    saveQuote(jobNumber,jobDate,jobClientName,jobPrepared,quoteNum,quoteTotal,jobPoId,jobClientId,jobAddress1,jobAddress2,jobAddress3,jsonWindowString,jobCity,jobState,jobZip,jobContact,jobPhoneNumber,   jobFaxNumber,jobEmail,jobSiteAddress1,jobSiteAddress2,jobSiteAddress3,jobSiteCity,jobSiteState,jobSiteZip,jobSiteContact,jobSitePhone1,jobSitePhone2,jobSiteNotes,shipToAddress1,shipToAddress2,  shipToAddress3,shipToCity,shipToState,shipToZip,shipToContact,shipToPhone,shipToNotes,pickOrShipArr,jobID,qmarkup,qmulti,newQuote,additionalArray,'configure');
    //$(e).closest('tr').find('[name = "lineLabels"]').attr('style','background-color:#a6ffa6;');
    $(e).closest('tr').find('[name = "labelCheckName"]').removeClass('hidden');
  },750);
}
$('#shipViaPickup').click(function(){
  $('#address1ShipTo').val('540 Division Street');
  $('#address2ShipTo').val('');
  $('#address3ShipTo').val('');
  $('#cityShipTo').val('South Elgin');
  $('#stateShipTo').val('Illinois');
  $('#zipCodeShipTo').val('60177');
  $('#phoneNumberShipTo').val('(847) 741-9595');
});
$('#shipViaDelivery').click(function(){
  $('#address1ShipTo').val($('#address1').val());
  $('#address2ShipTo').val($('#address2').val());
  $('#address3ShipTo').val($('#address3').val());
  $('#cityShipTo').val($('#city').val());
  $('#stateShipTo').val($('#state').val());
  $('#zipCodeShipTo').val($('#zipCode').val());
  $('#phoneNumberShipTo').val($('#phoneNumer').val());
});
function sortOptionArray(e){
  e.sort(function(a,b){
    var valA, valB;
    valA = a.id;
    valB = b.id;
    if(valA < valB){
      return -1;
    }else if(valA > valB){
      return 1;
    }
    return 0;
  });    
}
function mailQuote(){
  /*$.ajax({
    url:"mailQuote.php",
    type: "post",
    data:{
      jn:jobNumber,
      e: $('#orderConfirmEmail').val(),
      fn: userInfoArr[1],
      ln:userInfoArr[2]
    },
    async:true,
    success:function(data){
        alert(data);
    }    
  })*/
  
  //alert("Message Sent.");
  var dataCanvas  = document.getElementById('pdfImgCanvas');
  var dataCanvasURL = dataCanvas.toDataURL();
  dataCanvasURLJpeg = dataCanvas.toDataURL("image/jpeg");
  this.blur();
}
$('#glassadd_line').click(function(){
  blankRow = 1;
})
function equals0(e){
  if(e === ""){
    return '';
  }else{
    return e;
  }
}
function addDays(date,days){
  var result = new Date(date);
  result.setDate(result.getDate() + days);
  return result;
}
$('#glassOrderConfirm').click(function(){
  $(this).blur();
  $('#testLoadModal').modal({backdrop: 'static', keyboard: false});  
  //waitingDialog.show("Sending Order...");
  var tempDate = new Date(Date.parse($('#dateTopBar').find('strong').html()));
  orderedOn = tempDate;
  var dd3 = tempDate.getDate();
  var mm3 = tempDate.getMonth() +1;
  if(dd3 < 10){
    dd3 = "0"+dd3;
  }
  if(mm3 < 10){
    mm3 = "0"+mm3;
  }
  orderedOn = mm3 + "-" + dd3 + '-' + tempDate.getFullYear();
  if(additionalArray.length>0){
    addArrayJson = JSON.parse(additionalArray);
  }else{
    addArrayJson = additionalArray;
  }
  if($('#orderConfirmPO').val()==""){
    alert('Please enter a PO number.');
    $('#testLoadModal').modal('hide');
    return false;
  }else{
    jobPoId = escapeHtml($('#orderConfirmPO').val());
    orderAlpha = "0";
    jobClientName = equals0(jobClientName);
    shipToAddress1 = equals0(shipToAddress1);
    shipToAddress2 = equals0(shipToAddress2);
    shipToAddress3 = equals0(shipToAddress3);
    shipToCity = equals0(shipToCity);
    shipToState = equals0(shipToState);
    shipToZip = equals0(shipToZip);
    orderAlpha = equals0(orderAlpha);
    shipToContact = equals0(shipToContact);
    jobDate = equals0(jobDate);
    jobClientId = equals0(jobClientId);
    jobPoId = equals0(jobPoId);
    jobNumber = equals0(jobNumber);
    jobSiteNotes = equals0(jobSiteNotes);
    jobContact = equals0(jobContact);
    jobEmail = equals0(jobEmail);
    jobPhoneNumber = equals0(jobPhoneNumber);
    priceMulti = equals0(priceMulti);
    jobClientName = equals0(jobClientName);
    user = escapeHtml(user);
    orderToday = new Date();
    orderDay = orderToday.getDate();
    orderMonth = orderToday.getMonth()+1;
    orderYear = orderToday.getFullYear();
    if(orderDay < 10){
      orderDay = '0'+ orderDay;
    }
    if(orderMonth < 10){
      orderMonth = '0'+ orderMonth;
    }
    if(orderToday.getDay() > 2 || (orderToday.getDay() == 2 && orderToday.getHours() >= 12)){
      var daysTillFriday = (5 - orderToday.getDay()) + 7;
      gDueDate = addDays(orderToday,daysTillFriday);
    }else{
      var daysTillFriday = 5 - orderToday.getDay();
      gDueDate = addDays(orderToday,daysTillFriday);
    }
    dueDateDay = gDueDate.getDate();
    dueDateMonth = gDueDate.getMonth()+1;
    dueDateYear = gDueDate.getFullYear();
    if(dueDateDay < 10){
      dueDateDay = '0'+ dueDateDay;
    }
    if(dueDateMonth < 10){
      dueDateMonth = '0'+ dueDateMonth;
    }
    orderDateString = orderYear.toString().replace('20','')+orderMonth+orderDay;
    dueDateString = dueDateYear.toString().replace('20','')+dueDateMonth+dueDateDay;
    slsTax = parseFloat((+quoteTotal- +taxFreeAmt) * ($('#taxPercIn').val().replace('%', "")/100)).toFixed(2);
    if(ww3 == 'CDH'){
      jsonWindowString = JSON.stringify(windowOptions);
      sendOrderJson = JSON.parse(jsonWindowString);
    }else{
      sendOrderJson = JSON.parse(jsonGlassString);
    }
    if(user == 'kb' && jobClientId == '1000'){
      priceMulti = $('#multiplierIn').val();
    }
    if($('#shipViaDeliveryJobE').is(':checked')){
       shipToAddress1 = $('#address1JobSE').val();
       shipToAddress2 = $('#address2JobSE').val();
       shipToAddress3 = $('#address3JobSE').val();
       shipToCity = $('#cityJobSE').val();
       shipToState = $('#stateJobSE').val();
       shipToZip = $('#zipCodeJobSE').val();
       jobClientName = $('#contactJobSE').val();
       jobPhoneNumber = $('#phoneNumberJobSE').val();
    }
    if($('#shipViaPickupE').is(':checked')){
      console.log('pickup!');
      pickOrShipArr = "PICK-UP";
      shipToAddress1 = '540 Division St'
      shipToCity = 'South Elgin'
      shipToState = 'IL'
      shipToZip = '60177'
    }else{
      pickOrShipArr ='DELIVERY';
    }
    var jsonOrderHeader = {
      orderSoldTo:jobClientName,
      orderShipToAdd1: shipToAddress1,
      orderShipToAdd2: shipToAddress2,
      orderShipToAdd3: shipToAddress3,
      orderShipToCity: shipToCity,
      orderShipToState: shipToState,
      orderShipToZip: shipToZip,
      orderCusAlpha: orderAlpha,
      orderShipCon: jobClientName,
      ordershipNotes: shipToNotes,
      orderDate: orderDateString,
      orderDueDate:dueDateString,
      orderAccount: jobClientId,
      customerPO: jobPoId,
      terms: orderTerms,
      orderNum: jobNumber.trim(),
      orderSalesman:usrToSls(user),
      orderGlass: sendOrderJson,
      orderAccessories: accessArray,
      orderAmount: quoteTotal,
      orderTax: quoteTax,
      orderTotal: +quoteTotal + +quoteTax,
      orderComments: jobSiteNotes,
      orderContact:jobContact,
      orderEmail:jobEmail,
      orderFax: jobFaxNumber,
      orderPhone:jobPhoneNumber,
      orderPrcMulti: priceMulti,
      orderAttn: jobClientName,
      orderShipVia: pickOrShipArr,
      orderAddItms: addArrayJson,
      orderUser: user,
      orderTaxCode:custTaxTerms,
      orderSlsAmt:quoteTotal,
      orderTxblAmt: +quoteTotal- +taxFreeAmt,
      orderSlsTax: slsTax
    }
    console.log("Submitting Order");
    $.ajax({
      url: "http://customer.custom-aluminum.com/cascoQuote.php",
      type: "POST",
      data: {header:jsonOrderHeader},
      crossDomain: true,
      dataType: "json",
      async:false,
      success:function(data){
        console.log(jsonOrderHeader);
        responseArr=data;        
        /*responseArr = $.map(JSON.parse(data), function(vv){
            return vv;
        });      */
        console.log(responseArr);
        if(responseArr['bool']!=1){
            alert(responseArr['msg']);                        
            return false;                  
        }
        else{
          attachPdf = 1; //1 = yes, 0 = no
          as4OrderNum = responseArr['nextOrdNum'];
          createPdf();
          if($('#noEmail').is(':checked')){
            attachPdf = 0;
          }
          console.log("Mailing Order");
          $.ajax({
            url:"mailQuote.php",
            type: "POST",            
            data:{
              jn:jobNumber,
              e: $('#orderConfirmEmail').val(),
              n: as4OrderNum,
              n2: salesOrderNum,
              po: jobPoId,
              fn: userInfoArr[1],
              ln: userInfoArr[2],
              at: attachPdf,
              imgs: savedImgArr
            },
            async:false,
            success:function(data){                      
              $('#testLoadModal').modal('hide')
              alert(data);                    
              window.location.replace('http://quotes.cascoonline.com/');
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert("Unable to send Email");
              console.debug("Unable to send Email");
              $('#testLoadModal').modal('hide')
              appendToLog(jqXHR.responseText +", " + textStatus +", " + errorThrown);  
              
            }    
          });     
        }
      },
      error: function(){
        console.log('cascoquote.php ajax error');
        alert("Error processing request");
        $('#testLoadModal').modal('hide');
      }
    });
  $('#glassOrderCancel').click();
  }
})//glassOrderConfirm function end
function editHeader(){
  if($('#topHalf').is(':visible')){
    $('#topHalf').hide();
    $('#custInfoDiv').show();
    document.getElementById('editHeader').innerHTML = 'Edit Glass Quote';
    editNum = 1;
    saveWin = 1;
    $('#startQuote').attr('value','Update Header Information');
    $('#startQuote').html('Update Header Information');
  }else{
    $('#custInfoDiv').hide();
    $('#topHalf').show();
    document.getElementById('editHeader').innerHTML='Edit Customer Information';
    $('#startQuote').attr('value','Next');
    $('#startQuote').html('Next');
    editNum = 0;
  }
  $(this).blur(); 
  //$('#startQuote').hide();
}/*
$('[name="selectDisPriceName"]').change(function(){
  var choice = $(this).val();
  $.each($('td[data-name="listPriceTd"]'),function(){
    $(this).show();
  });
  $('#listColumn').show();
  if($(this).val() == 'sell'){
    savedTaxRate = $('#taxPercIn').val();
    $('#taxPercIn').removeAttr('disabled');
    $('#taxPercIn').val(savedSellTaxRate+'%');
    priceMulti = $('#multiplierIn').val();
    var temp = $('#markupPercIn').val().replace('%','');
    costPriceMulti = ((priceMulti*(1+(temp/100))) * 100) - 100;
    $('#markupPercIn').val(costPriceMulti);
    doTaxes = 1;
    doStuff();
    for(i=1;i<=newid;i++){
      $('#sellPriceDiv'+i).html('$'+ (+$('#listString'+i).html().replace(/^\D+/g, "") + +($('#listString'+i).html().replace(/^\D+/g, "")* ($('#taxPercIn').val().replace('%','')/100))).toFixed(2));
      //console.log('== sell for loop ' + i);
    }
    $('#markupPercIn').val(temp);
    disPrice = 3;
  }else if($(this).val() == 'netCost'){
    $('#taxPercIn').val(savedTaxRate);
    $('#taxPercIn').attr('disabled','disabled');
    priceMulti = $('#multiplierIn').val();
    var temp = $('#markupPercIn').val().replace('%','');
    costPriceMulti = (priceMulti * 100) - 100;
    $('#markupPercIn').val(costPriceMulti);
    doStuff();
    $('#markupPercIn').val(temp);
    disPrice = 2;
  }else if($(this).val() == 'list'){
    $('#taxPercIn').val(savedTaxRate);
    $('#taxPercIn').attr('disabled','disabled');
    var temp = $('#markupPercIn').val().replace('%','');
    $('#markupPercIn').val('');
    doStuff();
    $('#markupPercIn').val(temp);
    disPrice = 1;
  }else if($(this).val() == 'noPrice'){
    $('#taxPercIn').val(savedTaxRate);
    $('#taxPercIn').attr('disabled','disabled');
    disPrice = 0;
    $.each($('td[data-name="listPriceTd"]'),function(){
      $(this).hide();
    });
    $('#listColumn').hide();
  } 
  if(disPrice == 1){
    for(i=1;i<=newid;i++){
      $('#costPriceDiv'+i).hide();
      $('#sellPriceDiv'+i).hide();
      if($('#listString'+i).is(':hidden')){
        $('#listString'+i).show();
      }
    } 
  }else if(disPrice == 2){
    for(i=1;i<=newid;i++){
      $('#listString'+i).hide();
      $('#sellPriceDiv'+i).hide();
      if($('#costPriceDiv'+i).is(':hidden')){
        $('#costPriceDiv'+i).show();
      }
    }  
  }else if(disPrice == 3){
    for(i=1;i<=newid;i++){
      $('#listString'+i).hide();
      $('#costPriceDiv'+i).hide();
      if($('#sellPriceDiv'+i).is(':hidden')){
        $('#sellPriceDiv'+i).show();
      }
    }
  }
  $.each($('[name="selectDisPriceName"]'),function(){
    $(this).val(choice);
  });
});*/
$('[name="selectDisPriceName"]').change(function(){
  var choice = $(this).val();
  $.each($('td[data-name="listPriceTd"]'),function(){
    $(this).show();
  });
  $('#listColumn').show();
  if($(this).val() == 'sell'){
    if(savedTax.indexOf('%')>0){
      $('#taxPercIn').val(savedTax);
    }else{
      $('#taxPercIn').val(savedTax +'%');
    }
    $('#taxPercIn').removeAttr('disabled');
    priceMulti = $('#multiplierIn').val();
    var temp = $('#markupPercIn').val().replace('%','');
    costPriceMulti = ((priceMulti*(1+(temp/100))) * 100) - 100;
    $('#markupPercIn').val(costPriceMulti);
    doStuff();
    $('#markupPercIn').val(temp);
    disPrice = 3;
  }else if($(this).val() == 'netCost'){
    if(custTaxTerms != 2){
      if(savedTax.indexOf('%')>0){
        $('#taxPercIn').val(savedTax);
      }else{
        $('#taxPercIn').val(savedTax +'%');
      }
    }else{
      $('#taxPercIn').val('');
    }
    $('#taxPercIn').attr('disabled','disabled');
    priceMulti = $('#multiplierIn').val();
    var temp = $('#markupPercIn').val().replace('%','');
    costPriceMulti = (priceMulti * 100) - 100;
    $('#markupPercIn').val(costPriceMulti);
    doStuff();
    $('#markupPercIn').val(temp);
    disPrice = 2;
  }else if($(this).val() == 'list'){
    
    if(custTaxTerms != 2){
      if(savedTax.indexOf('%')>0){
        $('#taxPercIn').val(savedTax);
      }else{
       $('#taxPercIn').val(savedTax +'%');
     }
    }else{
      $('#taxPercIn').val('');
    }
    $('#taxPercIn').attr('disabled','disabled');
    var temp = $('#markupPercIn').val().replace('%','');
    $('#markupPercIn').val('');
    doStuff();
    $('#markupPercIn').val(temp);
    disPrice = 1;
  }else if($(this).val() == 'noPrice'){
    if(custTaxTerms != 2){
      $('#taxPercIn').val(savedTax);
    }else{
      $('#taxPercIn').val('');
    }
    $('#taxPercIn').attr('disabled','disabled');
    disPrice = 0;
    $.each($('td[data-name="listPriceTd"]'),function(){
      $(this).hide();
    });
    $('#listColumn').hide();
  }
  $.each($('[name="selectDisPriceName"]'),function(){
    $(this).val(choice);
  });
});
$('[name="pdfPriceType"]').click(function(){
  if($(this).attr('id') == "priceTotalOnly"){
    pdfPriceType = 1;
  }else{
    pdfPriceType = 0;
  }
});
$('#multiplierIn').keyup(function(){
  clearTimeout(timer);
  timer = setTimeout(function(){
    $('#selectDisPrice').change();
  },500);
})
function usrToSls(n){
  if(n == "dev"){
    return "KB";
  }else if(n == "kb"){
    return "KB";
  }else if(n == "aackles"){
    return "AA";
  }else if(n == "nmatthews"){
    return "NM";
  }else if(n=='eochoa'){
    return "EO";
  }else{
    return "HSE";
  }
}
/*function deleteFlag(){
  if(user == "dev"){
    freeUser = "TGC";
  }else if(user == "kb"){
    freeUser = "KBC";
  }else if(user == "aackles"){
    freeUser = "AA";
  }else if(user == "nmatthews"){
    freeUser = "NRM";
  }else if(user=="eochoa"){
    freeUser = "EO";
  }
  $.ajax({
    url: "http://customer.custom-aluminum.com/dltFlag.php",
    type: "POST",
    data: {user:freeUser},
    crossDomain: true,
    async:true,
    success:function(data){
      console.log(data);
    }
  });
}*/
$('#glasssendOrder').click(function(){
  $('#orderConfirmEmail').val(userInfoArr[0]);
  $('#orderConfirmPO').val($('#topGlassPOInput').val());
  showAddressForm('p');
});
function selectCust(e){
  $.ajax({
    url:"getCustInfo.php",
    type: "GET",
    data:{ci:$(e).attr('id'),
          },
    async:false,
    success:function(data){
      testCustInfo = JSON.parse(data);
        custInfoArr = $.map(JSON.parse(data), function(vv){
            return vv;
          /*
            0 CUS_CUSTNO
            1 CUS_LSTDTE
            2 CUS_SLSMAN
            3 CUS_ALPHA
            4 CUS_ATTN
            5 CUS_NAME
            6 CUS_ADDR
            7 CUS_ADDR2
            8 CUS_ADDR3
            9 CUS_CITY
            10 CUS_STATE
            11 CUS_ZIP
            12 CUS_CASTYP
            13 CUS_CUSTYP
            14 CUS_PRCMLT
            15 CUS_CLASS
            16 CUS_TAXABL
            17 CUS_TAX
            18 CUS_EXPNO
            19 CUS_PHONE
            20 CUS_CONTCT
            21 CUS_FAXNO
            22 CUS_FAXNO2
            23 CUS_SLSFAX
            24 CUS_TERMS
          */
        });
      }
  });
  $.ajax({
    url:"getMulti.php",
    type: "GET",
    data:{
        ci:$(e).attr('id'),
        },
    async:false,
    success:function(data){
      custMult = data;
    }
  });
  $.ajax({
    url:"getEmail.php",
    type: "GET",
    data:{
        ci:testCustInfo['CUS_CUSTNO'],
        },
    async:false,
    success:function(data){
      custEmail = data;
    }
  }); 
    if(custInfoArr[0]=="9999999"){
      $('#preparedInput').val(testCustInfo['CUS_SLSMAN']);
      $('#preparedInput').prop('disabled','true');
      $('#nameInput').val(testCustInfo['CUS_NAME']);
      $('#nameInput').prop('disabled','true');
      $('#clientInput').val(testCustInfo['CUS_CUSTNO']);
      $('#clientInput').prop('disabled','true');
      $('#address1').val(testCustInfo['CUS_ADDR']);
      $('#address2').val('');
      $('#address3').val('');
      $('#address1').prop('disabled','true'); 
      $('#address2').prop('disabled','true');
      $('#address3').prop('disabled','true');
      $('#city').val(testCustInfo['CUS_CITY']);
      $('#city').prop('disabled','true');
      $('#state').val(testCustInfo['CUS_STATE']);
      $('#state').prop('disabled','true');
      $('#zipCode').val(testCustInfo['CUS_ZIP']);
      $('#zipCode').prop('disabled','true');
      $('#contact').val(testCustInfo['CUS_NAME']);
      $('#contact').prop('disabled','true');
      $('#phoneNumber').val(custInfoArr[13]);
      $('#phoneNumber').prop('disabled','true');
      $('#faxNumber').val(testCustInfo['CUS_FAXNO']);
      $('#faxNumber').prop('disabled','true');
      $('#shipToRadio1').click();
      priceMulti = testCustInfo['CUS_PRCMLT'];
      $('#multiplierIn').val(custMult);
      $('#eMail').val(custEmail);
      orderTerms = testCustInfo['CUS_TERMS'];
      if(typeof orderTerms === 'undefined'){
        orderTerms = 1;
      }
      orderAlpha = testCustInfo['CUS_ALPHA'];
      custTaxTerms = testCustInfo['CUS_TAX'];
    }else{
      $('#preparedInput').val(testCustInfo['CUS_SLSMAN']);
      $('#preparedInput').prop('disabled','true');
      $('#nameInput').val(testCustInfo['CUS_NAME']);
      $('#nameInput').prop('disabled','true');
      $('#clientInput').val(testCustInfo['CUS_CUSTNO']);
      $('#clientInput').prop('disabled','true');
      $('#address1').val(testCustInfo['CUS_ADDR']);
      $('#address2').val(testCustInfo['CUS_ADDR2']);
      $('#address3').val(testCustInfo['CUS_ADDR3']);
      $('#address1').prop('disabled','true'); 
      $('#address2').prop('disabled','true');
      $('#address3').prop('disabled','true');
      $('#city').val(testCustInfo['CUS_CITY']);
      $('#city').prop('disabled','true');
      $('#state').val(testCustInfo['CUS_STATE']);
      $('#state').prop('disabled','true');
      $('#zipCode').val(testCustInfo['CUS_ZIP']);
      $('#zipCode').prop('disabled','true');
      $('#contact').val(testCustInfo['CUS_CONTCT']);
      $('#contact').prop('disabled','true');
      $('#phoneNumber').val(testCustInfo['CUS_PHONE']);
      $('#phoneNumber').prop('disabled','true');
      $('#faxNumber').val(testCustInfo['CUS_FAXNO']);
      $('#faxNumber').prop('disabled','true');
      $('#eMail').val(custEmail);
      
      $('#shipToRadio1').click();
      priceMulti = custMult;
      $('#multiplierIn').val(priceMulti);
      orderTerms = testCustInfo['CUS_TERMS'];
      if(typeof orderTerms === 'undefined'){
        orderTerms = 1;
      }
      orderAlpha = testCustInfo['CUS_ALPHA'];
      custTaxTerms = testCustInfo['CUS_TAX'];
    }  
  if(custTaxTerms == '1' || custTaxTerms == '3' || custTaxTerms == '4'){
    $('#taxPercIn').attr('disabled',true);
    if(custTaxTerms == '1'){
      $('#taxPercIn').val('7.5%');
      savedTax = "7.5%";
    }else if(custTaxTerms == '3'){
      $('#taxPercIn').val('5.5%');
      savedTax = "5.5%";
    }else if(custTaxTerms == '4'){
      $('#taxPercIn').val('6.25%');
      savedTax = "6.25%";
    }
  }
  if(custTaxTerms == '2'){
    $('#taxPercIn').val('');
    $('#taxPercIn').attr('disabled','false');
    savedTax = '0%';
  }
  $('#closeCustModal').click();
}
$('[name=glassOrderTypeName]').change(function(){
  /*if($(this).find('option:selected').text().toLowerCase().indexOf("lo-e") > -1){
    $('#glassOrderTint'+lookVal).hide();
    $('#glassTintLabel').hide();
    $('#noTintWarning').show();
  }else{
    $('#glassTintLabel').attr('style','color:black;');
    $('#glassTintLabel').html('Tint: ');
    $('#noTintWarning').hide();
    $('#glassTintLabel').show();
    $('#glassOrderTint'+lookVal).show();
  }*/
  if($(this).find('option:selected').text().toLowerCase().indexOf("clear")  == -1){
    $('[name=glassOrderStrengthName]').each(function(){
      $("#"+$(this).attr('id') + " > option").each(function(){
          if($(this).html().indexOf('7.0') > -1){
              $(this).attr('style','color:red;text-decoration: line-through');
              $(this).attr('disabled','disabled');
          }
      })
    })
  }else{
    $('[name=glassOrderStrengthName]').each(function(){
      $("#"+$(this).attr('id') + " > option").each(function(){
          if($(this).html().indexOf('7.0') > -1){
              $(this).attr('style','');
              $(this).removeAttr('disabled');
          }
      })
    })
  }
});
$('[name=glassOrderStrengthName]').change(function(){
  if(($(this).find('option:selected').text().toLowerCase().indexOf("tempered") > -1) && (Math.sqrt(Math.pow($('#glassWidth1').val(),2)+Math.pow($('#glassHeight1').val(),2)) <= 18)){
    alert("Tempered option only allowed for glass diagonal greater than 18 inches.");
    //$(this).prop('disabled',true);
    //$('#glassadd_row').prop('disabled',true);
  }else{
    $(this).prop('disabled',false);
    $('#glassadd_row').prop('disabled',false);
  }
});
$('#click8').click(function(){
  /*$('.searchDesc > option:selected').each(function(){
    if($(this).attr('data-desc')){
      windowPriceOpts.push($(this).attr('data-desc'));
    }
  });
  windowPriceOptsJson = JSON.stringify(windowPriceOpts);
  $.ajax({
    url:"getNewPrice.php",
    type: "POST",
    data:{d: windowPriceOpts},
    async:false,
    success:function(data){
      console.log(parseFloat(data * (($('#dimsW option:selected').attr('value') * $('#dimsH option:selected').attr('value'))/144)).toFixed(2));
    }    
  });*/
});
$('#searchCustButton').click(function(){
  $('#custSearch').click();
});
$('#addAccessories').click(function(){
  $('#bottomHalf').show();
    if(editTblRow == 0){
      newid++;
      lineNum = savedLineNum;
      lineNum++;
      /*if(deleteCount > 0){
        newid = newid - deleteCount;
      }*/
    var lineNumDiv = "<div id = line" + newid+ " name='lineNumDivName'>"+lineNum+"</div>";
    var tr = $("<tr></tr>", {
        id: "addr"+newid,
        "data-id": (newid)
     });
     
     // loop through each td and create new elements with name of newid
     $.each($("#tab_logic tbody tr:nth(0) td"), function(){
        var cur_td = $(this);
        var children = cur_td.children();
        // add new td and element if it has a name
        if($(this).data("name") != undefined){
          var td = $("<td></td>", {
            "data-name": $(cur_td).data("name")
          });
          var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
          c.attr("name", $(cur_td).data("name") + newid);
          var name10 = c.attr("name");
          c.attr("id",c.attr("name"));
          c.val(c.attr('placeholder'));
          var v = "window";
          c.appendTo($(td));
          td.appendTo($(tr));  
        }else{
          var td = $("<td></td>", {
            'text': $('#tab_logic tr').length
          }).appendTo($(tr));
       
        }
    });
    }
    
     // add the new row
     $(tr).appendTo($('#tab_logic'));
     var quantTextId = "quantText" + newid;
     var tblDelButtons = '<button name="del0" title="Delete Line" id="deleteRow" onclick="deleteRow(this)" class="btn btn-danger row-remove in" style="margin-top:8px;width:100%;"><span class="glyphicon glyphicon-remove"></span></button>';
     //var editButtons = '<button name="edit0" title="Edit Line" id="editBotRow" onclick="editTbl(this)"class="btn btn-primary row-remove in" style="margin-top:8px;width:100%"><span class="glyphicon glyphicon-pencil"></span></button>';
     var glassQuantity = $('#glassOrderQuant').val();
     var gOrderSum = "<div style=font-size:1.1em>";
     var count = 0;
     if($('#otherGlassOptions2').is(':hidden')){
        $('#showOtherOptions').click();
     }
     $('.accessoriesInput:visible').each(function(){
        if($('#'+$(this).attr('id')+' option:selected').text() != 'None'){
          accessItem = $('#'+$(this).attr('id')+' option:selected').text().replace('Casco','').replace(' - ','').replace('Foil Backed','').replace("4\"X75'",'').replace(' x ','x').replace('Glass Setting Block ','Settng Blck').replace('(','').replace(')','');
          accessItemQuant = $('#accessQuantInput').val();
          gOrderSum += " <strong>" + $('#'+$(this).attr('id')+'Label').html() + ":</strong> " + $('#'+$(this).attr('id')+' option:selected').text() + " - " + $('#accessQuantInput').val() +"<br>";
        }
      });
      gOrderSum +="</div>";
      if(use12){
        if($('#pieceQuantRadio').is(':checked')){
          tempNewPrice = ($('#osiSealantSelectId option:selected').attr('data-price') * $('#accessQuantInput').val()) + ($('#glazingSelectId option:selected').attr('data-price') * $('#accessQuantInput').val()) + ($('#foamSelectId option:selected').attr('data-price') * $('#accessQuantInput').val());
          perItem = +$('#osiSealantSelectId option:selected').attr('data-price') + +$('#glazingSelectId option:selected').attr('data-price') + +$('#foamSelectId option:selected').attr('data-price');
          caseDesc = 'Individual Pieces';
        }else if($('#caseQuantRadio').is(':checked')){
          tempNewPrice = ($('#osiSealantSelectId option:selected').attr('data-caseprice') * $('#accessQuantInput').val()) + ($('#glazingSelectId option:selected').attr('data-caseprice') * $('#accessQuantInput').val()) + ($('#foamSelectId option:selected').attr('data-caseprice') * $('#accessQuantInput').val());
          perItem = +$('#osiSealantSelectId option:selected').attr('data-caseprice') + +$('#glazingSelectId option:selected').attr('data-caseprice') + +$('#foamSelectId option:selected').attr('data-caseprice');
          caseDesc = 'Case (Pack of 12)';
        }else{
          tempNewPrice = 0;
          perItem = 0;
          caseDesc ='';
        }
      }else{
        if($('#block100').is(':checked')){
          tempNewPrice = $('#settingBlockSelectId option:selected').attr('data-price') * $('#accessQuantInput').val();
          perItem = +$('#settingBlockSelectId option:selected').attr('data-price');
          caseDesc = 'Case of 100';
        }else if($('#block1000').is(':checked')){
          tempNewPrice = $('#settingBlockSelectId option:selected').attr('data-thousand') * $('#accessQuantInput').val();
          perItem = +$('#settingBlockSelectId option:selected').attr('data-thousand');
          caseDesc = 'Case of 1000';
        }else if($('#block2500').is(':checked')){
          tempNewPrice = $('#settingBlockSelectId option:selected').attr('data-twothousand') * $('#accessQuantInput').val();
          perItem = +$('#settingBlockSelectId option:selected').attr('data-twothousand');
          caseDesc = 'Case of 2500';
        }else{
          tempNewPrice = 0;
          perItem = 0;
          caseDesc ='';
        }
      }
      accessExtPrice = tempNewPrice;
      var hiddenId = "hiddenInput" + newid;
      var hiddenIdTwo = "hiddenInputTwo" + newid;
      var hiddenPriceIn = "<input type ='hidden' id ="+hiddenId+" name ='hiddenInput' style='width:0%'></input>";
      var hiddenPriceIn2 = "<input type ='hidden' id ="+hiddenIdTwo+" name ='hiddenInput2' style='width:0%'></input>";
      var multiplierAmt = document.getElementById('multiplierIn').value;
      var markupPerc = 1 + (+document.getElementById('markupPercIn').value.replace('%','')/100);
      //storeHeight = $('#glassHeight1').val();
      //storeWidth = $('#glassWidth1').val();
      var oldPrice = $("#tab_logic").find('tr#addr'+(newid-1)).find('td:eq(11)').text().replace(/^\D+/g, "");
      var tempOldPrice = $('#priceFooter').html().replace(/^\D+/g, "");
      var price = $('#priceFooter').html().replace(/^\D+/g, "");
      var listId = "listString" + newid;
      var listString = "<div id ="+listId+" name ='listString'></div>";
      sellPrice = (tempNewPrice * markupPerc * multiplierAmt).toFixed(2);
      netPrice =  (tempNewPrice * multiplierAmt).toFixed(2);
      var deliveryCharge = 0;
      hGlassLabel = $('#hiddenGlassLabel').val();
      if(editTblRow == 0){
        lineLabelId = 'lineLabel'+newid;
      }
      glassQuantBot = 1;
      var glassLineLabel = "<input type='text' class = 'squareCorners in' name ='lineLabels' value='Accessory' id ='"+lineLabelId+"' disabled/>&nbsp;&nbsp;<span name = 'labelCheckName' class='glyphicon glyphicon-ok hidden' title='Label Saved' style='font-size:1.25em;color:green'></span>";
      var tblInputString = '<strong>Quantity:</strong><input type="text" name = "quantityText" class="form-control squareCorners" style ="height:30px;" placeholder="QTY." value = "'+glassQuantBot+'" id ='+ quantTextId+' style="width:100%" disabled>';
      var priceLevel = 0;
      //tempNewPrice *= priceMulti;
      
      tempNewPrice = parseFloat(Math.round(+tempNewPrice * 100) / 100).toFixed(2);
      drawingReq = "";
      /*if($('#glassOrderGrillePatt'+lookVal+' option:selected').text().toLowerCase().indexOf('custom') > -1 && $('#glassOrderGrillePatt'+lookVal).is(':visible')){
        drawingReq = "<b style='color:red;font-size:1.25em;'>&nbsp;&nbsp;&nbsp;***Grille Drawing Required***</b>";
      }else{
        drawingReq = "";
      }
      var glassWarranty = "";
      if($('#glassOrderLogo option:selected').text() == "No"){
        glassWarranty = "<b style='font-size:1.25em;'>***Warranty Void Without IG Logo***</b>";
      }else{
        gla*/
      //tempNewPrice = Math.round((+tempNewPrice + .00001) * 1000)/1000;
      $("#tab_logic").find('tr#addr'+newid).find('td:eq(1)').html(tblInputString + tblDelButtons + hiddenPriceIn + hiddenPriceIn2);
      $("#tab_logic").find('tr#addr'+newid).find('td:eq(0)').html(lineNumDiv);
      $('#tab_logic').find('tr#addr'+newid).find('td:eq(2)').html(glassLineLabel + "<br><br><br>"+gOrderSum);
      //displayWidth = Math.floor(displayWidth/12) +"' "+parseFloat(displayWidth%12).toFixed(2)+'"';
      //displayHeight = Math.floor(displayHeight/12) +"' "+parseFloat(displayHeight%12).toFixed(2)+'"';
      /*displayWidth = new Fraction(parseFloat(displayWidth).toFixed(2)).toString();
      displayHeight = new Fraction(parseFloat(displayHeight).toFixed(2)).toString();
      if($('#glassWidth1').val().indexOf('/') > -1){
        botWidth = $('#glassWidth1').val() + '"';
      }else{
        botWidth = $('#glassWidth1').val();
      }
      if($('#glassHeight1').val().indexOf('/') > -1){
        botHeight = $('#glassHeight1').val() + '"';
      }else{
        botHeight = $('#glassHeight1').val();
      }
      
      if(blankRow == 1){
        $('#tab_logic').find('tr#addr'+newid).find('td:eq(2)').html(addItmsLine);
      }*/
      $('#tab_logic').find('tr#addr'+newid).find('td:eq(3)').html(listString);
      $('#tab_logic').find('tr#addr'+newid).find('td:eq(3)').append('<div id="sellPriceDiv'+newid+'">$'+ (+tempNewPrice + +(tempNewPrice * ($('#taxPercIn').val().replace('%','')/100))).toFixed(2)+'</div>');
      $('#tab_logic').find('tr#addr'+newid).find('td:eq(3)').append('<div id="costPriceDiv'+newid+'">$'+ parseFloat(Math.round((+tempNewPrice  * $('#multiplierIn').val())*100)/100).toFixed(2)+'</div>');
      if(disPrice == 0){
        $('#tab_logic').find('tr#addr'+newid).find('td:eq(3)').html('');
      }else if(disPrice == 1){
        $('#costPriceDiv'+newid).hide();
        $('#sellPriceDiv'+newid).hide();
        if($('#'+listId).is(':hidden')){
          $('#'+listId).show();
        }
      }else if(disPrice == 2){
        $('#'+listId).hide();
        $('#sellPriceDiv'+newid).hide();
        if($('#costPriceDiv'+newid).is(':hidden')){
          $('#costPriceDiv'+newid).show();
        }
      }else if(disPrice == 3){
        $('#'+listId).hide();
        $('#costPriceDiv'+newid).hide();
        if($('#sellPriceDiv'+newid).is(':hidden')){
          $('#sellPriceDiv'+newid).show();
        }
      }
      $("#tab_logic").find('tr#addr'+newid).find('#hiddenInput' + newid).attr('value',tempNewPrice);
      $("#tab_logic").find('tr#addr'+newid).find('[name = "hiddenInput2"]').val($("#tab_logic").find('tr#addr'+newid).find('[name = "hiddenInput"]').val());
      if(blankRow == 0){
        $("#tab_logic").find('tr#addr'+newid).find('#listString' + newid).html("$" + tempNewPrice);
      }
      //$('#priceFooter').html("<strong>Total Price: </strong>$"+parseFloat(Math.round((+tempNewPrice + +tempOldPrice + +deliveryCharge)*100)/100).toFixed(2));
      if(disPrice == 0){
        $('#priceFooter').html("<strong>Total Price: </strong>");
      }else if(disPrice == 2){
        tempCostPrice = parseFloat(Math.round((+tempNewPrice  * $('#multiplierIn').val())*100)/100).toFixed(2);
        $('#priceFooter').html("<strong>Total Price: </strong>$"+parseFloat(Math.round((+tempCostPrice + +tempOldPrice + +deliveryCharge)*100)/100).toFixed(2));
      }else{
        $('#priceFooter').html("<strong>Total Price: </strong>$"+parseFloat(Math.round((+tempNewPrice + +tempOldPrice + +deliveryCharge)*100)/100).toFixed(2));
      }
      $(tr).find("td button.popover-dismiss").on("click", function(){
        if($(this).find("span.tblSpan").hasClass('glyphicon glyphicon-chevron-up')){
          $(this).find("span.tblSpan").removeClass('glyphicon glyphicon-chevron-up');
          $(this).find("span.tblSpan").addClass('glyphicon glyphicon-chevron-down');
        }else if($(this).find("span.tblSpan").hasClass('glyphicon glyphicon-chevron-down')){
          $(this).find("span.tblSpan").removeClass('glyphicon glyphicon-chevron-down');
          $(this).find("span.tblSpan").addClass('glyphicon glyphicon-chevron-up');
        }
      });
      accessArray.push({
        line: lineNum,
        item: accessItem.substring(0,25),
        itmQuant: accessItemQuant,
        itemDesc: caseDesc,
        price: perItem,
        total: accessExtPrice,
      });
     
      $('#foamSelectId').val('None');
      $('#osiSealantSelectId').val('None');
      $('#glazingSelectId').val('None');
      $('#accessQuantInput').val('');
});
/*$('#osiSealantSelectId').change(function(){
   if($(this).val() != 'None'){
      $('#accessQuantInput').show();
      $('#accessQuantLabel').show();
      $('#addAccessories').show();
   }else{
      $('#accessQuantInput').hide();    
      $('#accessQuantLabel').hide();
   }
});
$('#foamSelectId').change(function(){
   if($(this).val() != 'None'){
      $('#accessQuantInput').show();
      $('#accessQuantLabel').show();
      $('#addAccessories').show();
   }else{
      $('#accessQuantInput').hide();
      $('#accessQuantLabel').hide();
   }
});
$('#glazingSelectId').change(function(){
   if($(this).val() != 'None'){
      $('#accessQuantInput').show();
      $('#accessQuantLabel').show();
      $('#addAccessories').show();
   }else{
      $('#accessQuantInput').hide();
      $('#accessQuantLabel').hide();
   }
});*/
$('#accessoriesCatSelect').change(function(){
  if($(this).val() == 'osiSealantCat'){
    $('#foamSelectId').hide();
    $('#foamSelectId').val('None');
    $('#glazingSelectId').hide();
    $('#glazingSelectId').val('None');
    $('#foamSelectIdLabel').hide();
    $('#glazingSelectIdLabel').hide();
    $('#osiSealantSelectId').show();
    $('#osiSealantSelectIdLabel').show();
    $('#caseQuantRadio').show();
    $('#caseQuantRadioLabel').show();
    $('#settingBlockSelectId').hide();
    $('#settingBlockSelectIdLabel').hide();
    $('#pieceQuantRadio').show();
    $('#pieceQuantRadioLabel').show();
    $('#block1000').hide();
    $('#block1000Label').hide();
    $('#block100').hide();
    $('#block100Label').hide();
    $('#block2500').hide();
    $('#block2500Label').hide();
    use12 = true;
  }else if($(this).val() == 'qsiFoamCat'){
    $('#osiSealantSelectId').hide();
    $('#glazingSelectId').hide();
    $('#glazingSelectId').val('None');
    $('#osiSealantSelectIdLabel').hide();
    $('#osiSealantSelectId').val('None');
    $('#glazingSelectIdLabel').hide();
    $('#foamSelectIdLabel').show();
    $('#foamSelectId').show();
    $('#caseQuantRadio').hide();
    $('#caseQuantRadioLabel').hide();
    $('#settingBlockSelectId').hide();
    $('#settingBlockSelectIdLabel').hide();
    $('#block1000').hide();
    $('#block1000Label').hide();
    $('#block100').hide();
    $('#block100Label').hide();
    $('#block2500').hide();
    $('#block2500Label').hide();
    use12 = true;
  }else if($(this).val() == 'dowGlazingCat'){
    $('#foamSelectId').val('None');
    $('#osiSealantSelectId').val('None');
    $('#osiSealantSelectId').hide();
    $('#foamSelectId').hide();
    $('#osiSealantSelectIdLabel').hide();
    $('#foamSelectIdLabel').hide();
    $('#glazingSelectIdLabel').show();
    $('#glazingSelectId').show();
    $('#caseQuantRadio').show();
    $('#caseQuantRadioLabel').show();
    $('#pieceQuantRadio').show();
    $('#pieceQuantRadioLabel').show();
    $('#settingBlockSelectId').hide();
    $('#settingBlockSelectIdLabel').hide();
    $('#block1000').hide();
    $('#block1000Label').hide();
    $('#block100').hide();
    $('#block100Label').hide();
    $('#block2500').hide();
    $('#block2500Label').hide();
    use12 = true;
  }else if($(this).val() == 'glassBlock'){
    $('#foamSelectId').val('None');
    $('#osiSealantSelectId').val('None');
    $('#osiSealantSelectId').hide();
    $('#foamSelectId').hide();
    $('#osiSealantSelectIdLabel').hide();
    $('#foamSelectIdLabel').hide();
    $('#glazingSelectIdLabel').hide();
    $('#glazingSelectId').hide();
    $('#settingBlockSelectId').show();
    $('#settingBlockSelectIdLabel').show();
    $('#caseQuantRadio').hide();
    $('#caseQuantRadioLabel').hide();
    $('#pieceQuantRadio').hide();
    $('#pieceQuantRadioLabel').hide();
    $('#block1000').show();
    $('#block1000Label').show();
    $('#block100').show();
    $('#block100Label').show();
    $('#block2500').show();
    $('#block2500Label').show();
    use12 = false;
  }else{
    $('#foamSelectId').val('None');
    $('#glazingSelectId').val('None');
    $('#osiSealantSelectId').val('None');
    $('#foamSelectId').hide();
    $('#glazingSelectId').hide();
    $('#foamSelectIdLabel').hide();
    $('#glazingSelectIdLabel').hide();
    $('#osiSealantSelectId').hide();
    $('#osiSealantSelectIdLabel').hide();
    $('#settingBlockSelectId').hide();
    $('#settingBlockSelectIdLabel').hide();
    $('#block1000').hide();
    $('#block1000Label').hide();
    $('#block100').hide();
    $('#block100Label').hide();
    $('#block2500').hide();
    $('#block2500Label').hide();
    use12 = true;
  }
})
function appendToLog(s){
  $.ajax({
    url:"appendToLog.php",
    type: "POST",
    data:{
      string: s
    },
    async:true,
    success:function(data){
      alert(data);
    }
  });
}
function showAddressForm(e){
  if(e=='j'){
    $('#placeOrderAddressDiv').show();
    $('#jobsiteCharge').show();
    $('#displayOrderAddress').hide();
    $('#address1JobSE').val($('#address1JobS').val());
    $('#address2JobSE').val($('#address2JobS').val());
    $('#address3JobSE').val($('#address3JobS').val());
    $('#cityJobSE').val($('#cityJobS').val());
    $('#stateJobSE').val($('#stateJobS').val());
    $('#zipCodeJobSE').val($('#zipCodeJobS').val());
    $('#contactJobSE').val($('#contactJobS').val());
    $('#phoneNumberJobSE').val($('#phoneNumberJobS').val());
    $('#notesJobSE').val($('#notesJobS').val());
  }else if(e=='s'){
    $('#jobsiteCharge').hide();
    $('#displayOrderAddress').html('');
    $('#placeOrderAddressDiv').hide();
    $('#displayOrderAddress').show(); 
    $('#address1ShipTo').val($('#address1').val());
    $('#address2ShipTo').val($('#address2').val());
  $('#address3ShipTo').val($('#address3').val());
  $('#cityShipTo').val($('#city').val());
  $('#stateShipTo').val($('#state').val());
  $('#zipCodeShipTo').val($('#zipCode').val());
  $('#phoneNumberShipTo').val($('#phoneNumer').val());
  $('#displayOrderAddress').append('<p>'+$('#contactShipTo').val()+'<br>'+$('#address1ShipTo').val()+'<br>'+$('#city').val()+'<br>'+$('#state').val()+'<br>'+$('#zipCode').val()+'</p>')
    
  }else if(e=='p'){
    $('#jobsiteCharge').hide();
    $('#displayOrderAddress').html('');
    $('#placeOrderAddressDiv').hide();
    $('#displayOrderAddress').show();
    $('#address1ShipTo').val('540 Division Street');
  $('#address2ShipTo').val('');
  $('#address3ShipTo').val('');
  $('#cityShipTo').val('South Elgin');
  $('#stateShipTo').val('Illinois');
  $('#zipCodeShipTo').val('60177');
  $('#phoneNumberShipTo').val('(847) 741-9595');
  $('#shipViaPickup').click();
  $('#displayOrderAddress').append('<p>'+$('#contactShipTo').val()+'<br>'+$('#address1ShipTo').val()+'<br>'+$('#cityShipTo').val()+'<br>'+$('#stateShipTo').val()+'<br>'+$('#zipCodeShipTo').val()+'</p>');
    
  }
}
function returnToConfigure(){
  $('#startQuote').click();
  jobDate = $('#dateInput').val();
  jobPrepared = $('#preparedInput').val();
  jobPoId = $('#poIdInput').val();
  jobDesc = $('#descInput').val();
  jobClientId = $('#clientInput').val();
  jobClientName = $('#nameInput').val();
  jobAddress1 = $('#address1').val();
  jobAddress2 = $('#address2').val();
  jobAddress3 = $('#address3').val();
  jobCity = $('#city').val();
  jobState = $('#state').val();
  jobZip = $('#zipCode').val();
  jobContact = $('#contact').val();
  jobPhoneNumber = $('#phoneNumber').val();
  jobEmail = $('#eMail').val();
  jobFaxNumber = $('#faxNumber').val();
  jobSiteAddress1 = $('#address1JobS').val();
  jobSiteAddress2 = $('#address2JobS').val();
  jobSiteAddress3 = $('#address3JobS').val();
  jobSiteCity = $('#cityJobS').val();
  jobSiteState = $('#stateJobS').val();
  jobSiteZip = $('#zipCodeJobS').val();
  jobSiteContact = $('#contactJobS').val();
  jobSitePhone1 = $('#phoneNumberJobS').val();
  jobSitePhone2 = $('#altNumberNumber').val();
  jobSiteNotes = $('#notesJobS').val();
  shipToAddress1 = $('#address1ShipTo').val();
  shipToAddress2 = $('#address2ShipTo').val();
  shipToAddress3 = $('#address3ShipTo').val();
  shipToCity = $('#cityShipTo').val();
  shipToState = $('#stateShipTo').val();
  shipToZip = $('#zipCodeShipTo').val();
  shipToContact = $('#contactShipTo').val();
  shipToPhone = $('#phoneNumberShipTo').val();
  shipToNotes = $('#notesShipTo').val();
  if($('input[name="shipViaOpts"]:checked').val() == "option1"){
    pickOrShipArr = "PICK-UP";
  }else{
    pickOrShipArr = "DELIVERY";
  }
}
</script>
<?php 
  mysqli_close($conn); 
?>
</body> 
</html>
