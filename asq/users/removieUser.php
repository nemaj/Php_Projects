<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	die();
}

$userId = $_GET['id'];

$sql = "DELETE FROM users WHERE id='$userId'";

if ($conn->query($sql) === TRUE) {
	echo true;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}