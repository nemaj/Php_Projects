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

$gender = $data->gender;
$level = $data->level;
$address = $data->address;
$contact = $data->contact;
$email = $data->email;
$usersId = $data->usersId;

$find = $conn->query("SELECT * FROM teacher_info WHERE users_id='$usersId'");

if ($find->num_rows > 0) {
	$arr = $find->fetch_array();

	$sql = "UPDATE teacher_info SET 
					gender='$gender',
					advisory='$level',
					address='$address',
					contact='$contact',
					email='$email'
				WHERE id='".$arr['id']."'";

} else {
	$sql = "INSERT INTO teacher_info (
				gender,
				advisory,
				address,
				contact,
				email,
				users_id
			) VALUES (
				'$gender',
				'$level',
				'$address',
				'$contact',
				'$email',
				'$usersId'
			)";
}

if ($conn->query($sql) === TRUE) {
	echo true;
} else {
	echo false;
}