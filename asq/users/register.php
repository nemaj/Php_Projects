<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

$firstName = $data->firstName;
$lastName = $data->lastName;
$street = $data->street;
$brgy = $data->brgy;
$city = $data->city;
$province = $data->province;
$country = $data->country;
$contactNumber = $data->contactNumber;
$username = $data->username;
$password = $data->password;

if (!isset($username)) {
	die();
}

$usernameChecker = $conn->query("SELECT * FROM users WHERE username='$username'");

if ($usernameChecker->num_rows > 0) {
	echo "Username is already used.";
	die();
}

$sql = "INSERT INTO users
		(
			first_name,
			last_name,
			street,
			barangay,
			city,
			province,
			country,
			contact_number,
			username,
			password
		) VALUES (
			'$firstName',
			'$lastName',
			'$street',
			'$brgy',
			'$city',
			'$province',
			'$country',
			'$contactNumber',
			'$username',
			'$password'
		)";

if ($conn->query($sql) === TRUE) {

	$users_id = $conn->insert_id;
	$roleSql = "INSERT INTO user_role (users_id, roles_id) VALUES ('$users_id','3')";
	if ($conn->query($roleSql) === TRUE) {
		echo $users_id;
	}

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}