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

$sql = "INSERT INTO product_unit
		(
			unit
		) VALUES (
			'$unit'
		)";

if ($conn->query($sql) === TRUE) {

	echo $conn->insert_id;

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}