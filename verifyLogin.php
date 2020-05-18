<?php session_start();
$servername = "localhost";
$username = "quotesca_test2";
$password = "test";
$dbname = "quotesca_test1";
$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$pass=mysqli_escape_string($conn,$_POST['pass']);
$user=mysqli_escape_string($conn,$_POST['user']);
$reload = mysqli_escape_string($conn,$_POST['reload']);
$sql ="SELECT pass,company,leader,isCasco FROM Info WHERE usr ='".$user."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
 		if(password_verify($pass,$row['pass'])){
 			echo 'true';
 			$_SESSION['loggedOn'] = true;
 			$_SESSION['currUser'] = $user;
 			$_SESSION['currCompany'] = $row['company'];
 			$_SESSION['isCasco'] = $row['isCasco'];
 			if($row['leader'] == '1'){
 				$_SESSION['isLeader'] = true;
 			}else{
 				$_SESSION['isLeader'] = false;
 			}
 		}else{
 			echo "false";
 			if($reload){
 				$_SESSION['loggedOn'] = false;
 			}	
 		}
 	}		
}else{
 	echo "That username does not exist.";
 	$_SESSION['loggedOn'] = false;
}

$conn->close();
?>