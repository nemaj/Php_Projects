<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	die();
}

$usersId = $_GET['id'];

$sql = "UPDATE teacher_info SET verify='1' WHERE users_id='$usersId'";

if ($conn->query($sql) === TRUE) {
	echo true;
} else {
	echo false;
}

