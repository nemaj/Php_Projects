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

$area = $data->area;

if (isset($_GET['id']) && $_GET['id']) {
	$id = $_GET['id'];
	$sql = "UPDATE learning_areas SET area='$area' WHERE id='$id'";
} else {
	$sql = "INSERT INTO learning_areas (area) VALUES ('$area')";
}

if ($conn->query($sql) === TRUE) {
	echo true;
} else {
	echo false;
}