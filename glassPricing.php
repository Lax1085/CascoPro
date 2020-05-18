<?php session_start();
$loggedIn = $_SESSION['loggedOn'];
if($loggedIn == 'true'){
}else{
    header('Location: http://quotes.cascoonline.com/login.php');
    die();    
}
$servername = "localhost";
$username = "***";
$password = "**";
$dbname = "**"; 
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);
$p = mysqli_real_escape_string($conn,$_GET['p']);
$ty = mysqli_real_escape_string($conn,$_GET['ty']);
$g = mysqli_real_escape_string($conn,$_GET['g']);
$tm = mysqli_real_escape_string($conn,$_GET['tm']);
$ti = mysqli_real_escape_string($conn,$_GET['ti']);
$ob = mysqli_real_escape_string($conn,$_GET['ob']);
$gp = mysqli_real_escape_string($conn,$_GET['gp']);
$sp = mysqli_real_escape_string($conn,$_GET['sp']);
$h = mysqli_real_escape_string($conn,$_GET['h']);
$pl = mysqli_real_escape_string($conn,$_GET['pl']);
$pr = mysqli_real_escape_string($conn,$_GET['pr']);
$obsc = "";
if($ob == '#OBSC'){
	$obsc = '#OBSC';
}if($tm == '#TLAMI'){
	$tm = '#TEMP';
	$obsc = '#LAMI';
}else if($tm == '#LAMI2'){
	$obsc = '#LAMI2';
	$tm = '';
}else if($tm=='#LAMI'){
	$tm ='';
	$obsc = '#LAMI';
}
if($ti == '#SOLAR'){
	$ob ='#SOLAR';
    $ti = '';
}	
if($ty =='#240' || $ty == '#366' || $ty =='#340'){
    $ty2 = $ty;
    $ty = '#272';
}
if($ty=='#240-5' || $ty == '#340-5'){
    $ty2 = substr($ty,0,4);
    $ty ='#272-5';
    $p2 = 'RECTANGLE';
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
    pr = preserve

    p(rectangle)+ty+pl
    p(triple)+ty+pl
    p+ty+0
*/

$sql = "SELECT SUM(CGP_PRICE) FROM(
	SELECT CGP_PRICE FROM GLASSLSTPC WHERE CGP_TABLE = '".$p."' AND CGP_OPT01 = '".$ty."' AND CGP_OPT02 = '".$tm."' AND CGP_OPT03 = '".$ti."' AND CGP_OPT04 = '".$obsc."' AND CGP_PRCLEV = '".$pl."'
 	UNION ALL 
 	SELECT CGP_PRICE FROM GLASSLSTPC WHERE CGP_TABLE = '".$p."' AND CGP_OPT01 = '".$g."' AND CGP_OPT02 = '".$gp."' AND CGP_OPT03 = '' AND CGP_OPT04 = '' AND CGP_PRCLEV = '0'
 	UNION ALL 
 	SELECT CGP_PRICE FROM GLASSLSTPC WHERE CGP_TABLE = '".$p."' AND CGP_OPT01 = '".$ob."' AND CGP_OPT02 = '".$tm."' AND CGP_OPT03 = '' AND CGP_OPT04 = '' AND CGP_PRCLEV = '0'
 	UNION ALL 
 	SELECT CGP_PRICE FROM GLASSLSTPC WHERE CGP_TABLE = '".$p."' AND CGP_OPT01 = '".$sp."' AND CGP_OPT02 = '' AND CGP_OPT03 = '' AND CGP_OPT04 = '' AND CGP_PRCLEV = '0'
 	UNION ALL 
 	SELECT CGP_PRICE FROM GLASSLSTPC WHERE CGP_TABLE = '".$p."' AND CGP_OPT01 = '".$pr."' AND CGP_OPT02 = '' AND CGP_OPT03 = '' AND CGP_OPT04 = '' AND CGP_PRCLEV = '0'
 	UNION ALL 
 	SELECT CGP_PRICE FROM GLASSLSTPC WHERE CGP_TABLE = '".$p."' AND CGP_OPT01 = '".$h."' AND CGP_OPT02 = '".$ty."' AND CGP_OPT03 = '' AND CGP_OPT04 = '' AND CGP_PRCLEV = '0'
    UNION ALL 
    SELECT CGP_PRICE FROM GLASSLSTPC WHERE CGP_TABLE = '".$p."' AND CGP_OPT01 = '".$h."' AND CGP_OPT02 = '' AND CGP_OPT03 = '' AND CGP_OPT04 = '' AND CGP_PRCLEV = '0'
    UNION ALL 
    SELECT CGP_PRICE FROM GLASSLSTPC WHERE CGP_TABLE = '".$p."' AND CGP_OPT01 = '".$ty2."' AND CGP_OPT02 = '' AND CGP_OPT03 = '' AND CGP_OPT04 = '' AND CGP_PRCLEV = '0'
    UNION ALL 
    SELECT CGP_PRICE FROM GLASSLSTPC WHERE CGP_TABLE = '".$p2."' AND CGP_OPT01 = '".$ty2."' AND CGP_OPT02 = '' AND CGP_OPT03 = '' AND CGP_OPT04 = '' AND CGP_PRCLEV = '0'
    UNION ALL 
    SELECT CGP_PRICE FROM GLASSLSTPC WHERE CGP_TABLE = '".$p."' AND CGP_OPT01 = '".$ti."' AND CGP_OPT02 = '' AND CGP_OPT03 = '' AND CGP_OPT04 = '' AND CGP_PRCLEV = '0'
    UNION ALL 
    SELECT CGP_PRICE FROM GLASSLSTPC WHERE CGP_TABLE = '".$p."' AND CGP_OPT01 = '".$ti."' AND CGP_OPT02 = '".$tm."' AND CGP_OPT03 = '' AND CGP_OPT04 = '' AND CGP_PRCLEV = '0'
 	
 	)AS totalGlassPrice";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}		
$result = $conn->query($sql);
if ($result->num_rows > 0) {   
   while($row = $result->fetch_assoc()) {
        echo $row['SUM(CGP_PRICE)'];
    }
}else{
    echo 0;
}
mysqli_close($conn);
?>
