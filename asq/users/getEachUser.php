<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
    die();
}

$userId = $_GET['id'];

$res = $conn->query("SELECT * FROM users WHERE id='$userId'");
if ($res->num_rows > 0) {
	$info = $res->fetch_array();

	$user_info = array(
		'id' => $info['id'],
		'firstName' => $info['first_name'],
		'lastName' => $info['last_name'],
		'username' => $info['username'],
		'password' => $info['password']
	);

	echo json_encode($user_info);
} else {
	echo "No user found.";
}