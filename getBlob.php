<?php
/*	ini_set("xdebug.var_display_max_children", -1);
	ini_set("xdebug.var_display_max_data", -1);
	ini_set("xdebug.var_display_max_depth", -1);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);*/
$servername = "localhost";

$username = "quotesca_test2";

$password = "test";

$dbname = "quotesca_test1"; 

$conn = new mysqli($servername, $username, $password,$dbname);

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}

$jn = mysqli_escape_string($conn,$_REQUEST['jn']);

$sql = "SELECT windows_options FROM saved_quotes WHERE job_number ='".$jn."'";


$result = $conn->query($sql);

if ($result->num_rows > 0) {   
	$row = $result->fetch_assoc();
 	echo $row['windows_options'];
} 
else {
		echo "failed";
}
$conn->close();
?>