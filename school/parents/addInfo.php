<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	echo false;
	die();
}

$usersId = $data->usersId;
$email = $data->email;
$address = $data->address;
$gender = $data->gender;
$contact = $data->contact;

if (!$_GET['id']) {
	$insert = "INSERT INTO parent_info (
				users_id,
				gender,
				address,
				contact,
				email
			) VALUES (
				'$usersId',
				'$gender',
				'$address',
				'$contact',
				'$email'
			)";
} else {
	$insert = "UPDATE parent_info SET 
				users_id = '$usersId',
				gender = '$gender',
				address = '$address',
				contact = '$contact',
				email = '$email'
			WHERE id='".$_GET['id']."'";
}

if ($conn->query($insert) === TRUE) {
	echo true;
} else {
	echo false;
}