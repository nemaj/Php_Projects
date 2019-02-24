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
$name = $data->name;
$license = $data->license;
$contactNo = $data->contactNo;
$address = $data->address;

if ($_GET['id']) {
	$id = $_GET['id'];
	$sql = "UPDATE business_info SET
			name = '$name',
			license = '$license',
			contact_number = '$contactNo',
			address = '$address'
		 WHERE id='$id'";
} else {
	$sql = "INSERT INTO business_info
		(
			users_id,
			name,
			license,
			contact_number,
			address
		) VALUES (
			'$usersId',
			'$name',
			'$license',
			'$contactNo',
			'$address'
		)";
}

if ($conn->query($sql) === TRUE) {

	if ($_GET['id']) {
		echo true;
	} else {
		$id = $conn->insert_id;
		$setSql = "UPDATE users SET is_complete='1' WHERE id='$usersId'";
		if ($conn->query($setSql) === TRUE) {
			echo $id;
		} else {
			echo false;
		}
	}

} else {
    echo false;
}