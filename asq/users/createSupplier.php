<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

$firstName = $data->firstName;
$lastName = $data->lastName;
$username = $data->username;
$password = $data->password;
$userType = 2;

if (!isset($username)) {
	die();
}

$isComplete = 2;

$usernameChecker = $conn->query("SELECT * FROM users WHERE username='$username'");

if ($usernameChecker->num_rows > 0) {
	echo 0;
	die();
}

$sql = "INSERT INTO users
		(
			first_name,
			last_name,
			username,
			password,
			is_complete
		) VALUES (
			'$firstName',
			'$lastName',
			'$username',
			'$password',
			'$isComplete'
		)";

if ($conn->query($sql) === TRUE) {

	$users_id = $conn->insert_id;
	$roleSql = "INSERT INTO user_role (users_id, roles_id) VALUES ('$users_id','$userType')";
	if ($conn->query($roleSql) === TRUE) {
		echo $users_id;
	}

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}