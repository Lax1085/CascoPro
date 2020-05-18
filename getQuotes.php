<?php session_start();
$loggedIn = $_SESSION['loggedOn'];
$custId = $_SESSION['currCompany'];
if($loggedIn == 'true'){
}else{
    header('Location: localhost/login.php');
    die();
    
}
$servername = "localhost";
$username = "****";
$password = "***";
$dbname = "****"; 
$prod ="";
$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if($custId != '9999999' && $custId != 0 && $custId !=1000){
  $sql = "SELECT id,customer_name,job_number,prepared_by,quote_total,quote_date,isQuote,po_id,product FROM saved_quotes WHERE client_id = ". $custId ." AND isQuote = 1 ORDER BY id DESC LIMIT 50";
}else if($custId == 0 || $custId == 1000){
  $sql = "SELECT id,customer_name,job_number,prepared_by,quote_total,quote_date,isQuote,po_id,product FROM saved_quotes WHERE isQuote = 1 AND client_id != '9999999' ORDER BY id DESC LIMIT 200";
}else{
  $sql = "SELECT id,customer_name,job_number,prepared_by,quote_total,quote_date,isQuote,po_id,product FROM saved_quotes WHERE isQuote = 1 ORDER BY id DESC LIMIT 200";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {   
  while($row = $result->fetch_assoc()) {
    if($row['product'] =='configure'){
      $prod = 'Glass';
    }else if($row['product'] =='storm'){
      $prod = 'Storm Window';
    }else if($row['product'] =='stormDoors'){
      $prod = 'Storm Door';
    }else{
      $prod ='';
    }
  echo "<tr><td name = 'job_number'>".$row['job_number']."</td>";
  echo "<td name = 'po_id'>".$row['po_id']."</td>";
  echo "<td name='product' data-url='".$row['product']."'>".$prod."</td>";
  echo "<td name = 'customer_name'>".$row['customer_name']."</td>";
  echo "<td name = 'prepared_by'>".$row['prepared_by']."</td>";
  echo "<td name = 'quote_total'>$".$row['quote_total']."</td>";
  echo "<td name = 'quote_date'>".$row['quote_date']."</td>";
  echo "<td><button name='edit' data-url='".$row['product']."' id=".$row['job_number'] . " onclick=editGlassQuote(this.id,this.getAttribute('data-url')) class = 'btn btn-sm btn-success'><span class ='glyphicon glyphicon-pencil'></span></button></td>";
  echo "<td><button name='remove' onclick=removeQuoteRow(this) class = 'btn btn-sm btn-danger'><span class ='glyphicon glyphicon-remove'></span></button></td></tr>";
}
}else{
  echo "<font style='color:red'>Database contains no quotes".$custId.".</font>";
}
$conn->close();
?> 
                                    
