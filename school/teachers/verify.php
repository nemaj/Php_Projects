<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	die();
}

$usersId = $_GET['id'];

$check = $conn->query("SELECT * FROM teacher_info WHERE users_id='$usersId'");

if ($check->num_rows === 0) {
	$insert = "INSERT INTO teacher_info (
				gender,
				address,
				contact,
				email,
				users_id,
				verify
			) VALUES (
				'',
				'',
				'',
				'',
				'$usersId',
				'1'
			)";

	$conn->query($insert);
}

$sql = "UPDATE teacher_info SET verify='1' WHERE users_id='$usersId'";

if ($conn->query($sql) === TRUE) {
	echo true;
} else {
	echo false;
}

