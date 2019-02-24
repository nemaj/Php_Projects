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

$id = $_GET['id'];

$enroll = "INSERT INTO enrolled (pupil_id) VALUES ('$id')";

if ($conn->query($enroll) === TRUE) {
	echo $conn->insert_id;
} else {
	echo false;
}