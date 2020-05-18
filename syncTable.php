<?php
$servername = "localhost";
$username = "quotesca_test2";
$password = "test";
$dbname = "quotesca_test1"; 
$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

chdir("../Data Transfer");
//var_dump(getcwd());
//$syncTable = mysqli_escape_string($conn,$_GET['d']);
$syncTableOPTVALNEW = 'OPTVALNEWSYNCTEST';
$syncTableCUSTMULT = 'CUSTMULTNEW';
$syncTableGLASSLSTPC = 'GLASSLSTPCSYNCTESTTEST';
$syncTableCUSTINFO = 'CUSTINFO';
//$sql = "BULK INSERT INTO ".$syncTable." FROM 'CUSTMULT_EXPORT.csv' WITH (FORMAT = 'CSV')";
$sql1 = "TRUNCATE ".$syncTableOPTVALNEW;
$sql2 = "TRUNCATE ".$syncTableCUSTMULT;
$sql3 = "TRUNCATE ".$syncTableGLASSLSTPC;
$sql4 = "TRUNCATE ".$syncTableCUSTINFO;
/*
$sql = $sql = "LOAD DATA LOCAL INFILE '/home/quotescascoonlin/Data Transfer/OPTVALNEW_EXPORT.csv' INTO TABLE OPTVALNEW FIELDS TERMINATED by ','"; 

$conn->query($sql);*/
$sql0 = "TRUNCATE CUSTMULTNEWBK";
$result = $conn->query($sql0);

if($result){
    $sql = "INSERT INTO CUSTMULTNEWBK SELECT * FROM CUSTMULTNEW"; 
    $result = $conn->query($sql);
    if($result){
        $sql = "TRUNCATE CUSTMULTNEW";
        $result = $conn->query($sql);
        if($result){
            $sql = "LOAD DATA LOCAL INFILE '/home/quotescascoonlin/Data Transfer/CUSTMULT_EXPORT.csv' INTO TABLE CUSTMULTNEW FIELDS TERMINATED by ','"; 
            $result = $conn->query($sql);
            if($result){
                echo "CUSTMULTNEW Table updated!";
            }else{
                echo "Fail1";
            }
        }
    }else{
        echo "Fail1";
    }
}else{
    echo "Fail: " . $sql. " "." ---- ".var_dump($result);
}
$sql0 = "TRUNCATE CUSTINFOBK";
$result = $conn->query($sql0);
if($result){
    $sql = "INSERT INTO CUSTINFOBK SELECT * FROM CUSTINFO"; 
    $result = $conn->query($sql);
    if($result){
        $sql = "TRUNCATE CUSTINFO";
        $result = $conn->query($sql);
        if($result){
            $sql = "LOAD DATA LOCAL INFILE '/home/quotescascoonlin/Data Transfer/CUSTMAST_EXPORT.csv' INTO TABLE CUSTINFO FIELDS TERMINATED by ','"; 
            $result = $conn->query($sql);
            if($result){
                echo "CUSTINFO Table updated!";
            }else{
                echo "Fail1";
            }
        }
    }else{
        echo "Fail1";
    }
}else{
    echo "Fail: " . $sql. " "." ---- ".var_dump($result);
}

$sql0 = "TRUNCATE OPTVALNEWBK";
$result = $conn->query($sql0);
if($result){
    $sql = "INSERT INTO OPTVALNEWBK SELECT * FROM OPTVALNEW"; 
    $result = $conn->query($sql);
    if($result){
        $sql = "TRUNCATE OPTVALNEW";
        $result = $conn->query($sql);
        if($result){
            $sql = "LOAD DATA LOCAL INFILE '/home/quotescascoonlin/Data Transfer/OPTVALNEW_EXPORT.csv' INTO TABLE OPTVALNEW FIELDS TERMINATED by ','"; 
            $result = $conn->query($sql);
            if($result){
                echo "OPTVALNEW Table updated!";
            }else{
                echo "Fail1";
            }
        }
    }else{
        echo "Fail1";
    }
}else{
    echo "Fail: " . $sql. " "." ---- ".var_dump($result);
}

//--------------------------------------------------------------------------
//$sql = "INSERT INTO ".$syncTable." VALUES(1,1,1,1,1,1,1,1,1,1,1)";
//var_dump(scandir(getcwd()));
/*$result = $conn->query($sql1);
if($result){
	$sql = "LOAD DATA LOCAL INFILE '/home/quotescascoonlin/Data Transfer/OPTVALNEW_EXPORT.csv' INTO TABLE ".$syncTableOPTVALNEW. " FIELDS TERMINATED by ','"; 
    $result = $conn->query($sql);
    if($result){
    	echo "OPTVALNEW Table updated!";
    }else{
    	echo "Fail1";
    }
}else{
    echo "Fail: " . $sql. " "." ---- ".var_dump($result);
}

$result = $conn->query($sql2);
if($result){
	$sql = "LOAD DATA LOCAL INFILE '/home/quotescascoonlin/Data Transfer/CUSTMULT_EXPORT.csv' INTO TABLE ".$syncTableCUSTMULT. " FIELDS TERMINATED by ','"; 
    $result = $conn->query($sql);
    if($result){
    	echo "CUSTMULT Table updated!";
    }else{
    	echo "Fail2";
    }
}else{
    echo "Fail: " . $sql. " "." ---- ".var_dump($result);
}

$result = $conn->query($sql3);
if($result){
	$sql = "LOAD DATA LOCAL INFILE '/home/quotescascoonlin/Data Transfer/GLASSLSTPC_EXPORT.csv' INTO TABLE ".$syncTableGLASSLSTPC. " FIELDS TERMINATED by ','"; 
    $result = $conn->query($sql);
    if($result){
    	echo "GLASSLSTPC Table updated!";
    }else{
    	echo "Fail3";
    }
}else{
    echo "Fail: " . $sql. " "." ---- ".var_dump($result);
}

$result = $conn->query($sql4);
if($result){
	$sql = "LOAD DATA LOCAL INFILE '/home/quotescascoonlin/Data Transfer/CUSTMAST_EXPORT.csv' INTO TABLE ".$syncTableCUSTINFO. " FIELDS TERMINATED by ','"; 
    $result = $conn->query($sql);
    if($result){
    	echo "CUSTMAST Table updated!";
    }else{
    	echo "Fail4";
    }
}else{
    echo "Fail: " . $sql. " "." ---- ".var_dump($result);
} -- push back here
var_dump(mysqli_error($conn)); -- end comment*/ 
$conn->close();
?>