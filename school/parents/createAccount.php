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

$firstName = trim($data->firstName);
$lastName = trim($data->lastName);
$username = trim($data->username);
$password = trim($data->password);
$role = $data->role;

if (!$username) {
	echo false;
	die();
}

$insert = "INSERT INTO users (
				first_name,
				last_name,
				username,
				password
			) VALUES (
				'$firstName',
				'$lastName',
				'$username',
				'$password'
			)";

if ($conn->query($insert) === TRUE) {
	$id = $conn->insert_id;

        $roleSql = "INSERT INTO user_role (users_id, role_id) VALUES ('$id','$role')";
        if ($conn->query($roleSql) === TRUE) {
            echo $id;
        }

} else {
	echo false;
}