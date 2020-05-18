<?php
ini_set('session.gc_maxlifetime', 3600);session_set_cookie_params(3600);session_start();
$loggedIn = $_SESSION['loggedOn'];
$currentUser = $_SESSION['currUser'];
$currCompany = $_SESSION['currCompany'];
$isLeader = $_SESSION['isLeader'];
$isCasco = $_SESSION['isCasco'];
if($loggedIn == 'true'){
}else{
    header('Location: localhost/login.php');
    die();
}
$servername = "***";
$username = "***";
$password = "***";
$dbname = "**";
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
    <title>Casco Quote Tool</title>
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
    <!-- check here -->
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
  </head>
  <body>
  <input type="hidden" id="currUser" value='<?php echo $currentUser ?>'/>
  <!--Quotes Modal-->
    <div class="modal" id="quotesModal" tabindex="-1" role="dialog" aria-labelledby="View Quotes Modal" aria-hidden="true">
            <div class="modal-dialog modal-lg"  id = "quoteModalDialog">
                <div class="modal-content" id='quoteContent'>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="myModalLabel">Quotes</h3>
                    </div>
                    <div class="modal-body">
                    <input type="checkbox" id="stopWarning" style="cursor:pointer"><label for="stopWarning" style="cursor:pointer">&nbsp;Do not ask before deleting quotes.</label>
                    <p></p>
                        <div class="input-group"> <span class="input-group-addon">Filter</span>
                          <input id="filter" name = "filter" type="text" class="form-control" placeholder="Type here...">
                        </div>
                        
                        <div style="max-height:700px;overflow:auto;">
                          <table class="table table-hover">
                            <thead>
                                <tr>
                                  <th style="border-bottom:#ffffff;">Quote Number</th>
                                  <th style="border-bottom:#ffffff;">P.O.</th>
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
          <ol class="breadcrumb collapse navbar-collapse" style="padding-left: 10px;padding-bottom: 10px;padding-right: 10px">
        <div style="margin-left:50px;"class="alignRight">
            <strong>Customer #: <span id ='getUser'><?php echo $currCompany; ?></span></strong>
        </div>
        <div style="margin-left:50px;"class="alignRight">
            <strong>Signed In As: <?php echo $currentUser;?></strong>
        </div>
        <!--<div id="dateTopBar" class="alignRight">

        </div>-->
        <li><a href="/logout.php">Sign Out</a></li>
        <li><a href="/newUser.php"><?php 
            if($currentUser =='dev' || $currentUser =='kb'){
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
  <div class="col-lg-1"></div>
  <div class="col-lg-10" style="height:900px;margin-top: 87px">
    <p>
    <div class="col-lg-7 stardust" style="padding: 0px">
      <div class="col-lg-12" style="margin-top:50px;padding:0px; width: 100%">
      <div class="col-lg-12 col-sm-12" style="height:100%; margin-bottom: 10px">
        <div style="text-align: center;"><u style="font-size: 1.75em"><b>Start Quote</b></u></div>
        <br>
        <div class="col-lg-4"><a href="/configure.php" style="color:white"><button class="btn btn-default btn-lg" style="width: 200px;height:200px;background-image: url('GlassQuote.jpg');background-size: cover;background-repeat: no-repeat;border: none" ></button></a></div>
        <div class="col-lg-4"><a href="/storm.php" style="color:white"><button class="btn btn-default btn-lg" style="width: 200px;height:200px;background-image: url('StormWindowQuote.jpg');background-size: cover;background-repeat: no-repeat;border: none;" ></button></a></div>
        <div class="col-lg-4"><a href="/stormDoors.php" style="color:white"><button class="btn btn-default btn-lg" style="width: 200px;height:200px;background-image: url('StormDoorQuote.jpg');background-size: cover;background-repeat: no-repeat;border: none;" ></button></a></div>
      </div>
      <div class="col-lg-12 col-sm-12"  >
       <!--<div id="hzroot5147794" style="text-align:center;font-size:12px;padding:0;border:0;margin:0;"><div style="font-size:18px;margin-bottom:3px;"></div><div style="padding:0;margin:0;border:0;margin-bottom:3px;"><iframe data-hzvt="MjAxNzAyMDI6MjQ4MTpidXR0b25zQW5kQmFkZ2Vz" name="HouzzWidget2678772" id="HouzzWidget2678772" border=0 frameborder="0" SCROLLING=NO style="border:0 none;width:600px;height:310px;" src="http://www.houzz.com/jsGalleryWidget/query/casco industries, Inc./new_window=yes/title_on=yes"></iframe></div></div><div></div>-->
       <img src="http://cascoonline.com/upload/CASCOPRO_homegraphic.jpg" width="100%" height="100%">
      </div>
        
      </div>
      <div class="col-lg-12 col-sm-0" style="height:442.5px;margin: 10px;margin-top: 50px">

        <center><h3>Most Recent Quotes</h3></center>
        <input type="checkbox" id="stopWarning" style="cursor:pointer"><label for="stopWarning" style="cursor:pointer">&nbsp;Do not ask before deleting quotes.</label>
        <div class="input-group"> <span class="input-group-addon">Filter</span>
            <input id="filter" name = "filter" type="text" class="form-control" placeholder="Type here...">
          </div>
          <div style="max-height:350px;overflow:auto;">

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
            <tbody id="recentQuotesBody" class ="searchable sortable">
              
            </tbody>
            </table>
            </div>
      </div>
      

    </div>
    </p>
    <div class="col-lg-5 stardust" style="border-left:0px;padding: 0px">
      <center><h3>Social Media</h3></center>
      <div class="fb-page" style="padding:20px;margin-left: 50px" data-width="1200px" data-height="350px" data-href="https://www.facebook.com/cascoonline/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/cascoonline/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/cascoonline/">Casco Industries</a></blockquote></div>
      <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
          fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));
      </script>
      <div>
       <center><a href="http://www.cascoonline.com/" onclick="this.blur();" target="_blank" style="color:white"><button class="btn btn-lg" style="background-color:#e66e2b;">Contact Casco</button></a>
        <!--<p><a target="_blank" href="https://www.facebook.com/cascoonline"><button class="btn btn-primary btn-lg" style="width:100%"><img style ="padding: 5px" src="/facebook/FB-f-Logo__blue_29.png"></img><span style="padding: 0px;margin:0px">Casco Facebook</span></button><br></a></p>-->
        <a href="http://www.houzz.com/pro/cascoonline/casco-industries-inc" target="_blank" style="color:black"><button class="btn btn-default btn-lg"><img src="houzz_logo.png" style="width:100px;height: 30px"/></button></a>
        <a href="https://www.pinterest.com/cascoindustries/" target="_blank" ><button class="btn btn-default"><img style="height:40px;width:40px;" src="badgeRGB.png"/></button></a>
       </div>
       <hr>
      <center><h3>Updates</h3></center><span><button id="addUpdate" style="display: none;margin-right: 18px" data-toggle="modal" data-target="#addUpdateModal" class="btn btn-info alignRight" >Add Update</button></span></center>
      <div id="updateDiv" style="max-height:307px;overflow: auto"></div>
    </div>
    
  </div>
  </div>
  <div class="col-lg-1" style="height:900px"></div>
  <div class="modal" id="addUpdateModal" tabindex="-1" role="dialog" aria-labelledby="Add Update Modal" aria-hidden="true">
    <div class="modal-dialog" id="addUpdateModalDialog">
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="addUpdateModalTitle">Add Update</h3>
          </div>
        <div class="modal-body">
        <label for ="updateInput">Add Update: </label>
          <textarea class ="form-control" id="updateInput" placeholder="Enter Text Here..."></textarea>
          <br><br>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelAddUpdate">Cancel</button>
          <button type="button" class="btn btn-success" id="confirmAddUpdate">Add Update</button>
        </div>
      </div>
    </div>
  </div>
</div><!--end modal-->
</body>
<script type="text/javascript">
$(document).ready(function(){
  console.log('doc ready');
  var currentUser = $('#currUser').val()
  if(currentUser == 'dev' || currentUser == 'kb'){
    $('#addUpdate').show();
  } 
  (function($){
    $('[name="filter"]').keyup(function(){
      console.log("keyup");
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
  
  $.post("getQuotes.php",function(data){$('#recentQuotesBody').html(data);});
  $.post("getComments.php",function(data){$('#updateDiv').html(data)});
  $('#removeComs').click(function(){
    alert('click1');
  });
  $('#removeComment').click(function(){
    alert('click2');
  });
  $("[name='removeCom']").click(function(){
    alert('click3');
  });
});
  

$('#confirmAddUpdate').click(function(){
  var d = new Date();
  var mm = d.getMonth()+1;
  var dd = d.getDate();
  if(dd<10){
    dd ='0'+dd;
  }
  if(mm<10){
    mm ='0'+mm;
  }
  commentDate = d.getFullYear()+'-'+mm+'-'+dd;
  $.ajax({
    url: "addComment.php",
    type: "POST",
    data: {
      user:$('#currUser').val(),
      date:commentDate,
      comment: $('#updateInput').val()
    },
    async:true,
    success:function(data){
      alert(data);
      $.post("getComments.php",function(data){$('#updateDiv').html(data)});
    }
  });
});
function deleteUpdate(e){
  var result = confirm("Are you sure you want to delete this comment?");
  if(result){
    deleteId = document.getElementById(e.id).id.replace(/^\D+/g, "");
    $.ajax({
    url: "deleteComment.php",
    type: "POST",
    data: {
      id: deleteId
    },
    async:false,
    success:function(data){
      alert(data);
    }
  });
  }
}
function editGlassQuote(e,u){
  window.location='/'+u+'.php?homeId='+e;
}
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
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111681800-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-111681800-2');
</script>
</html>
