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

$usersId = $data->usersId;
$productId = $data->productId;
$message = $data->message;
$rate = $data->rate;

$id = $_GET['id'];

if ($id) {
	$sql = "UPDATE feedback SET
				message='$message',
				rate='$rate'
			WHERE id='$id'";
} else {
	$sql = "INSERT INTO feedback (
				user_id,
				product_id,
				message,
				rate
			) VALUES (
				'$usersId',
				'$productId',
				'$message',
				'$rate'
			)";
}

if ($conn->query($sql) === TRUE) {
	echo TRUE;
} else {
	echo FALSE;
}
