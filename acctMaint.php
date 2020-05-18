<?php session_start();
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
$servername = "localhost";
$username = "****";
$password = "**";
$dbname = "***";
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
  <script type="text/javascript">
    var currentUser = <?php echo "'". $currentUser ."'"?>;
  </script>
  <div class="col-lg-3">
  </div>
  <div class="col-lg-6 stardust">
    <a href="/"><button class="btn btn-lg btn-info" style="display: inline-block;margin: 10px"><span class="glyphicon glyphicon-home"></span></button></a><center style="display: inline-block;margin: 10px"><h1>Account Maintenance</h1></center>
    <br>
    <label for="compSelect">Company:</label>
    <select id="compSelect">
      <?php
        $sql = "SELECT DISTINCT CUS_NAME, CUS_CUSTNO FROM CUSTINFO  INNER JOIN Info ON CUSTINFO.CUS_CUSTNO = Info.company";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
          while($row = $result->fetch_assoc()){
              echo "<option value =".$row['CUS_CUSTNO'].">".ucwords(strtolower($row['CUS_NAME']))."</option>";
            //}  
          }
        }

      ?>
      <option value="casco">Casco</option>
    </select>
    <script type="text/javascript">
      var options = $('#compSelect option');
var arr = options.map(function(_, o) { return { t: $(o).text(), v: o.value }; }).get();
arr.sort(function(o1, o2) { return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0; });
options.each(function(i, o) {
  o.value = arr[i].v;
  $(o).text(arr[i].t);
});
    </script>
    <br>
    <br>
    <label  for="usrSelect">User:</label>
    <select  id="usrSelect">
      
    </select>
    <br>
    <br>
    <h3 id="userReal"></h3>
    <br>
    <label for="userFirstInput">First Name:</label>
    <input type="text" autocomplete="off" style="width:40%" id="userFirstInput">
    <br><br>
    <label for="userLastInput">Last Name:</label>
    <input type="text" autocomplete="off" style="width:40%" id="userLastInput">
    <br><br>
    <!--<label for="companyNameInput">Company Name:</label>
    <input type="text" style="width:40%" id="companyNameInput">
    <br><br>-->
    <label for="companyNumberInput">Company Number:</label>
    <input type="text" autocomplete="off" style="width:40%" id="companyNumberInput">
    <br><br>
    <label for="userPass">Password:</label>
    <input type="password" autocomplete="off" style="width:40%" id="userPass">
    <br><br>
    <label for="userEmail">Email:</label>
    <input type="text"  autocomplete="off" style="width:40%" id="userEmail">
    <br><br>
    <button class="btn btn-primary" data-toggle="modal" data-target="#maintModal" id="changeInfo">Update Info</button>
    <button class="btn btn-danger" style="float: right" data-toggle="modal" data-target="#maintModal" id="deleteAcct">Delete Account</button>
    <br><br>
    <div class="modal" id="maintModal" tabindex="-1" role="dialog" aria-labelledby="acctMaintModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Confirm Change</h4>
          </div>
          <div class="modal-body">
            <label for="confirmPass">Enter your password to confirm changes:</label>&nbsp;<input type="password" autocomplete="off"  id="confirmPassIn">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id='confirmPassBut'>Save changes</button>
            <button type="button" class="btn btn-danger" style ="display: none;" id='deleteConfirm'>Delete Account</button>
          </div>
        </div>
      </div>
    </div>
  </div>  
  <div class="col-lg-3">
  </div>
  <script type="text/javascript">
  var userEmail = "";
  var userFirstName = "";
  var userLastName = "";
  var user = "";
  var userInfoArr = [];


  $('#compSelect').change(function(){
    //$('html,body').css('cursor','wait');
      comp = $('#compSelect option:selected').val();
      $.ajax({
        url:"getCompInfo.php",
        type: "POST",
        async:false,
        data:
        {
          c: comp,
        },
        async:true,
        success:function(data){
          $('#usrSelect').html(data);
          $('#usrSelect').change();
          $('html,body').css('cursor','default');
        }
      })
  })

    $('#usrSelect').change(function(){
      
      user = $('#usrSelect option:selected').val();
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
            userEmail = userInfoArr[0];
            userFirstName = userInfoArr[1];
            userLastName = userInfoArr[2];
            $('#userReal').html(userFirstName + " " + userLastName);
            $('#userEmail').val(userEmail);
            $('#userFirstInput').val(userFirstName);
            $('#userLastInput').val(userLastName);
            //$('#companyNameInput').val(userInfoArr[3]);
            $('#companyNumberInput').val(userInfoArr[4]);
            
          }
      })
       
    });  
    $('#confirmPassBut').click(function(){
      currentPass = $('#confirmPassIn').val();
      $.ajax({
        url:"verifyLogin.php",
        type: "POST",
        data:
        {
          user: currentUser,
          pass: currentPass,
          reload: 0
        },
        async:false,
        success:function(data){
            if(data != "false"){
              $.ajax({
                  url:"changeAcct.php",
                  type: "POST",
                data:
                {
                  user: user,
                  pass: $('#userPass').val(),
                  email: $('#userEmail').val(),
                  fName: $('#userFirstInput').val(),
                  lName: $('#userLastInput').val(),
                  //cName: $('#companyNameInput').val(),
                  cNum: $('#companyNumberInput').val()
                },
                async:false,
                success:function(data){
                  alert("Account information updated!");
                }
              });
            }else{
              alert("Password is incorrect");
            }
          }
      })


    });
    $('#compSelect').change();
    $('#deleteAcct').click(function(){
      $('#deleteConfirm').show();
      $('#confirmPassBut').hide(); 
    });
    $('#deleteConfirm').click(function(){
      var result = confirm("Are you sure you want to delete this account?");
      currentPass = $('#confirmPassIn').val();
      if(result){
        $.ajax({
          url:"verifyLogin.php",
          type: "POST",
          data:
          {
            user: currentUser,
            pass: currentPass,
            reload: 0
          },
          async:false,
          success:function(data){
            $.ajax({
              url:"deleteAcct.php",
              type: "POST",
              data:
              {
                delUser: user,
                email: $('#userEmail').val(),
                fName: $('#userFirstInput').val(),
                lName: $('#userLastInput').val(),
                //cName: $('#companyNameInput').val(),
                cNum: $('#companyNumberInput').val()
              },
              async:false,
              success:function(data){
                alert(data);
                if(data == 'Customer Deleted!'){
                  location.reload();
                }
              }
            })
          }
        })
    }else{
      return;
    }
    });
  </script>
  </body>
  </html>
