<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['code'])) {
	die();
}

$code = $_GET['code'];

$sql = "UPDATE orders SET status='2' WHERE code='$code'";

if ($conn->query($sql) === TRUE) {
	echo true;
} else {
	echo false;
}