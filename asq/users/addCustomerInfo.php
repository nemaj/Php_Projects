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
$street = $data->street;
$country = $data->country;
$province = $data->province;
$city = $data->city;
$brgy = $data->brgy;
$contactNo = $data->contactNo;

if ($_GET['id']) {
	$id = $_GET['id'];
	$sql = "UPDATE customer_info SET
			street = '$street',
			barangay = '$brgy',
			city = '$city',
			province = '$province',
			country = '$country',
			contact_number = '$contactNo'
		WHERE id='$id'";
} else {
	$sql = "INSERT INTO customer_info
		(
			users_id,
			street,
			barangay,
			city,
			province,
			country,
			contact_number
		) VALUES (
			'$usersId',
			'$street',
			'$brgy',
			'$city',
			'$province',
			'$country',
			'$contactNo'
		)";
}

if ($conn->query($sql) === TRUE) {
	if ($_GET['id']) {
		echo TRUE;
	}else {
		$insertId = $conn->insert_id;
		$update = $conn->query("UPDATE users SET is_complete='1' WHERE id='$usersId'");

		echo $insertId;
	}
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}