<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	echo false;
	die();
}

$userId = $_GET['id'];

$sql = "UPDATE users SET
		is_complete='0'
		WHERE id='$userId'";

if ($conn->query($sql) === TRUE) {
	echo true;
} else {
    echo false;
}