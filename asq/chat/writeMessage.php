<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	echo FALSE;
	die();
}

$customerId = $data->customerId;
$businessId = $data->businessId;
$role = $data->role;
$message = str_replace("'", "\\'", $data->message);

$insert = "INSERT INTO chat (
				customer_id,
				business_id,
				sender_role,
				message
			) VALUES (
				'$customerId',
				'$businessId',
				'$role',
				'$message'
			)";

if ($conn->query($insert) === TRUE) {
	echo $conn->insert_id;
} else {
	echo FALSE;
}
