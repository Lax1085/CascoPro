<?php session_start();
error_log("************* SENDING EMAIL START*********************");
$loggedIn = $_SESSION['loggedOn'];

$currentUser = $_SESSION['currUser'];

$currCompany = $_SESSION['currCompany'];

$isLeader = $_SESSION['isLeader'];

if($loggedIn == 'true'){

}else{

    header('Location: http://quotes.cascoonline.com/login.php');

    die();

}

$servername = "***";

$username = "****";

$password = "***";

$dbname = "***";

$conn = new mysqli($servername, $username, $password,$dbname);

if ($conn->connect_error){

    die("Connection failed: " . $conn->connect_error);

}

if(isset($_SESSION['test'])){

}else{

}

$jn = mysqli_real_escape_string($conn,$_REQUEST['jn']);

$email = mysqli_real_escape_string($conn,$_REQUEST['e']);

$firstName = mysqli_real_escape_string($conn, $_REQUEST['fn']);

$lastName = trim(mysqli_real_escape_string($conn, $_REQUEST['ln']));

$orderNum = mysqli_real_escape_string($conn, $_REQUEST['n']);

$poNum = mysqli_real_escape_string($conn, $_REQUEST['po']);

$attachPdf = mysqli_real_escape_string($conn, $_REQUEST['at']);

$pdfNum = mysqli_real_escape_string($conn,$_REQUEST['n2']);

error_log("Email being sent ".date('m/d/y h:i:s'));
$text=print_r($_REQUEST,1);
error_log($text);
//ror_log($jn);
//ror_log($email);
//rror_log($orderNum);
///error_log($attachPdf);
//e/rror_log($pdfNum);

require 'PHPMailer-master/PHPMailer-master/PHPMailerAutoload.php';

//Create a new PHPMailer instance

$mail = new PHPMailer;

$mail->Debugoutput = 'html';


$mail->setFrom('quotescascoonlin@quotes.cascoonline.com', 'Casco Quotes');

//Set an alternative reply-to address

$mail->addReplyTo('orders@cascoonline.com');

//Set who the message is to be sent to

$mail->addAddress($email, $firstName . " " . $lastName);

$mail->AddBCC("orders@cascoonline.com", "Casco Orders");

//Set the subject line

$mail->Subject = 'CASCOPRO Order: #'.$orderNum.'/'.$poNum;

//Read an HTML message body from an external file, convert referenced images to embedded,

//convert HTML into a basic plain-text alternative body

$mailBody = nl2br("$firstName $lastName,\nYour Casco order #$orderNum, PO #$poNum has been sent!");

$mail->msgHTML($mailBody);



//Replace the plain text body with one created manually

$mail->AltBody = 'Your Casco glass order has been sent!';



//Attach an image file

if($attachPdf == 1){

  if(file_exists('uploads/pdfs/'.$pdfNum.'.pdf'))
	 $mail->addAttachment('uploads/pdfs/'.$pdfNum.'.pdf',$name = $orderNum.'.pdf', $encoding = 'base64', $type = 'application/pdf');

}

/*foreach($_POST['imgs'] as $base){

	foreach ($base as $url){

		if($url != ""){

			$mail->addAttachment(ltrim($url,"/"));

		}

	}

}*/

//send the message, check for errors

if(!$mail->send()){
  error_log("Mailer Error: " . $mail->ErrorInfo);
  echo "Error Sending Email.";
  exit;

}else{
  
  error_log("Order Confirmation sent to " . $email.". ".$firstName . " " . $lastName."!");
  echo "Order Confirmation sent to " . $email ."!";
  $sql = "UPDATE saved_quotes SET isQuote = 0 WHERE job_number = " .$jn;
  if(file_exists('uploads/pdfs/'.$pdfNum.'.pdf'))
    unlink('uploads/pdfs/'.$pdfNum.'.pdf');

  if($conn->query($sql) === TRUE){
  }

}

error_log("***************SENDING EMAIL END*******************");
?>

