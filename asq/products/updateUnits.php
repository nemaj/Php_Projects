<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	die();
}

$unit = $data->unit;
$typeId = $data->id;

$sql = "UPDATE product_unit SET unit='$unit' WHERE id='$typeId'";

if ($conn->query($sql) === TRUE) {

	echo 1;

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}