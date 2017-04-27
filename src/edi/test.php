<?php
$connection=Yii::app()->db;
$conn = new mysqli('127.0.0.1', $connection->username, $connection->password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "USE `comparatio_edi`;";
$conn->query($sql);

$keyNumber = 950000;
$i=0;

while($i<100000){
	$sql = "INSERT INTO `comparatio_edi`.`ed1_edi` (`ED1_ID`, `ED1_TYPE`, `ED1_DOCUMENT_NO`, `ED1_STATUS`, `CU1_ID`, `VD1_ID`, `ED1_MODIFIED_BY`, `ED1_CREATED_BY`, `ED1_SHOW_DEFAULT`, `ED1_IN_OUT`, `ED1_RESEND`, `ED1_ACKNOWLEDGED`, `ED1_TEST_MODE`) VALUES (" . $keyNumber . ", '880', '403', '1', '0', '2', '1', '1', 'X', '1', '0', '1', '0');";
	$conn->query($sql);
	$i=$i+1;
	$keyNumber=$keyNumber+1;
}


?>