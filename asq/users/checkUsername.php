<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

$username = $data->username;

if (!isset($username)) {
	die();
}

$usernameChecker = $conn->query("SELECT * FROM users WHERE username='$username'");

echo $usernameChecker->num_rows;
