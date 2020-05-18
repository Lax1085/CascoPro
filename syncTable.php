<?php
$servername = "localhost";
$username = "****";
$password = "****";
$dbname = "***"; 
$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

chdir("../Data Transfer");

$syncTableOPTVALNEW = 'OPTVALNEWSYNCTEST';
$syncTableCUSTMULT = 'CUSTMULTNEW';
$syncTableGLASSLSTPC = 'GLASSLSTPCSYNCTESTTEST';
$syncTableCUSTINFO = 'CUSTINFO';
$sql1 = "TRUNCATE ".$syncTableOPTVALNEW;
$sql2 = "TRUNCATE ".$syncTableCUSTMULT;
$sql3 = "TRUNCATE ".$syncTableGLASSLSTPC;
$sql4 = "TRUNCATE ".$syncTableCUSTINFO;

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
$conn->close();
?>
