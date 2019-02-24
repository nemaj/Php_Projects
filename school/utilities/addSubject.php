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

$subject = $data->subject;
$level = $data->level;

if (isset($_GET['id']) && $_GET['id']) {
	$id = $_GET['id'];
	$sql = "UPDATE subjects SET subject='$subject', level='$level' WHERE id='$id'";
} else {
	$sql = "INSERT INTO subjects (subject, level) VALUES ('$subject', '$level')";
}

if ($conn->query($sql) === TRUE) {
	echo true;
} else {
	echo false;
}