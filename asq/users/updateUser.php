<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

$userId = $data->id;
$firstName = $data->firstName;
$lastName = $data->lastName;
$username = $data->username;
$password = $data->password;

if (!isset($userId)) {
	die();
}

$sql = "UPDATE users SET
		first_name='$firstName',
		last_name='$lastName',
		username='$username',
		password='$password'
		WHERE id='$userId'";

if ($conn->query($sql) === TRUE) {

	echo true;

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}