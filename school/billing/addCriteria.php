<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	echo false;
	die();
}

$payment = $data->payment;
$price = $data->price;
$level = $data->level;

if ($_GET['id']) {
	$id = $_GET['id'];
	$sql = "UPDATE payment_criteria SET name='$payment', price='$price', grade_level='$level' WHERE id='$id'";
} else {
	$sql = "INSERT INTO payment_criteria (name, price, grade_level) VALUES ('$payment', '$price', '$level')";
}

// echo $sql;

if ($conn->query($sql) === TRUE) {
	echo true;
} else {
	echo $conn->error;	
	// echo false;
}