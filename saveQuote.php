<?php session_start();
error_log("****************START***********************");
$loggedIn = $_SESSION['loggedOn'];

if($loggedIn == 'true'){

}else{

    header('Location: http://quotes.cascoonline.com/login.php');

    die();

    

}

$servername = "localhost";

$username = "****";

$password = "***";

$dbname = "****"; 

$conn = new mysqli($servername, $username, $password,$dbname);

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}

$jn = mysqli_real_escape_string($conn,$_POST['jn']);

$qd = mysqli_real_escape_string($conn,$_POST['qd']);

$cn = mysqli_real_escape_string($conn,$_POST['cn']);

$pb = mysqli_real_escape_string($conn,$_POST['pb']);

$qn = mysqli_real_escape_string($conn,$_POST['qn']);

$qt = mysqli_real_escape_string($conn,$_POST['qt']);

$poid = mysqli_real_escape_string($conn,$_POST['poid']);

$ci = mysqli_real_escape_string($conn,$_POST['ci']);

$ca = mysqli_real_escape_string($conn,$_POST['ca']);

$ca2 = mysqli_real_escape_string($conn,$_POST['ca2']);

$ca3 = mysqli_real_escape_string($conn,$_POST['ca3']);

$wo = mysqli_real_escape_string($conn,$_POST['wo']);

$cc = mysqli_real_escape_string($conn,$_POST['cc']);

$cs = mysqli_real_escape_string($conn,$_POST['cs']);

$cz = mysqli_real_escape_string($conn,$_POST['cz']);

$cco = mysqli_real_escape_string($conn,$_POST['cco']);

$cp = mysqli_real_escape_string($conn,$_POST['cp']);

$cf = mysqli_real_escape_string($conn,$_POST['cf']);

$ce = mysqli_real_escape_string($conn,$_POST['ce']);

$ja = mysqli_real_escape_string($conn,$_POST['ja']);

$ja2 = mysqli_real_escape_string($conn,$_POST['ja2']);

$ja3 = mysqli_real_escape_string($conn,$_POST['ja3']);

$jc = mysqli_real_escape_string($conn,$_POST['jc']);

$js = mysqli_real_escape_string($conn,$_POST['js']);

$jz = mysqli_real_escape_string($conn,$_POST['jz']);

$jco = mysqli_real_escape_string($conn,$_POST['jco']);

$jp1 = mysqli_real_escape_string($conn,$_POST['jp1']);

$jp2 = mysqli_real_escape_string($conn,$_POST['jp2']);

$jnotes = mysqli_real_escape_string($conn,$_POST['jnotes']);

$sa = mysqli_real_escape_string($conn,$_POST['sa']);

$sa2 = mysqli_real_escape_string($conn,$_POST['sa2']);

$sa3 = mysqli_real_escape_string($conn,$_POST['sa3']);

$sc = mysqli_real_escape_string($conn,$_POST['sc']);

$ss = mysqli_real_escape_string($conn,$_POST['ss']);

$sz = mysqli_real_escape_string($conn,$_POST['sz']);

$sco = mysqli_real_escape_string($conn,$_POST['sco']);

$sp = mysqli_real_escape_string($conn,$_POST['sp']);

$si = mysqli_real_escape_string($conn,$_POST['si']);

$ji = mysqli_real_escape_string($conn,$_POST['ji']);

$qmark = mysqli_real_escape_string($conn,$_POST['qmark']);

$qmulti = mysqli_real_escape_string($conn,$_POST['qmulti']);

$nq = mysqli_real_escape_string($conn,$_POST['nq']);

$aa = mysqli_real_escape_string($conn,$_POST['aa']);

$sv = mysqli_real_escape_string($conn,$_POST['sv']);

$product = mysqli_real_escape_string($conn, $_POST['product']);


$qn=$jn;
$ji=$qn;
$ji=$qn;
if($nq == 0){

	$sql ="INSERT INTO saved_quotes (job_number,quote_date,customer_name,prepared_by,quote_number,quote_total,po_id,client_id,customer_address,customer_address2,customer_address3,windows_options,customer_city,customer_state,customer_zip,customer_contact,customer_phone,customer_fax,customer_email,jobsite_address,jobsite_address2,jobsite_address3,jobsite_city,jobsite_state,jobsite_zip,jobsite_contact,jobsite_phone1,jobsite_phone2,jobsite_notes,shipto_address1,shipto_address2,shipto_address3,shipto_city,shipto_state,shipto_zip,shipto_contact,shipto_phone,shipto_instructions,ship_via,job_id,quote_markup,quote_multiplier,additional_items,product) VALUES ('".$jn."','".$qd."','".$cn."','".$pb."','".$qn."','".$qt."','".$poid."','".$ci."','".$ca."','".$ca2."','".$ca3."','".$wo."','".$cc."','".$cs."','".$cz."','".$cco."','".$cp."','".$cf."','".$ce."','".$ja."','".$ja2."','".$ja3."','".$jc."','".$js."','".$jz."','".$jco."','".$jp1."','".$jp2."','".$jnotes."','".$sa."','".$sa2."','".$sa3."','".$sc."','".$ss."','".$sz."','".$sco."','".$sp."','".$si."','".$sv."','".$ji."','".$qmark."','".$qmulti."','".$aa."','".$product."')";
	if ($conn->query($sql) === TRUE) {

    	error_log("New qoute created for :".$jn);

	}else{
    	
        error_log("Error while creating for ".$jn.": " . $sql . "<br>" . $conn->error);

	}

}else if($nq == 1){

   $sql = "UPDATE saved_quotes SET windows_options ='".$wo."',quote_total = '".$qt."',quote_markup ='".$qmark."',quote_multiplier='".$qmulti."',additional_items='".$aa."',po_id='".$poid."',customer_name='".$cn."',prepared_by='".$pb."',client_id='".$ci."',customer_address='".$ca."',customer_address2='".$ca2."',customer_address3='".$ca3."',customer_city='".$cc."',customer_state='".$cs."',customer_zip='".$cz."',customer_contact='".$cco."',customer_phone='".$cp."',customer_fax='".$cf."',customer_email='".$ce."',jobsite_address='".$ja."',jobsite_address2='".$ja2."',jobsite_address3='".$ja3."',jobsite_city='".$jc."',jobsite_state='".$js."',jobsite_zip='".$jz."',jobsite_contact='".$jco."',jobsite_phone1='".$jp1."',jobsite_phone2='".$jp2."',jobsite_notes='".$jnotes."',shipto_address1='".$sa."',shipto_address2='".$sa2."',shipto_address3='".$sa3."',shipto_city='".$sc."',shipto_state='".$ss."',shipto_zip='".$sz."',shipto_contact='".$sco."',shipto_phone='".$sp."',shipto_instructions='".$si."',ship_via='".$sv."',product='".$product."' WHERE job_number='".$jn."'";    
   	if ($conn->query($sql) === TRUE) {

    	error_log("quote updated for :".$jn);

	}else{

    	error_log("Error while updating for ".$jn.": " . $sql . "<br>" . $conn->error);

	}
}

$conn->close();
error_log("***************************************");
?>
