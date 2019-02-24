<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	echo json_encode((object) array());
	die();
}

$usersId = $_GET['id'];

$getInfo = $conn->query("SELECT * FROM users WHERE id='$usersId'");

if ($getInfo->num_rows > 0) {
	$info_arr = $getInfo->fetch_array();

	$getRole = $conn->query("SELECT * FROM user_role WHERE users_id='$usersId'");
	$role = $getRole->fetch_array();

	$info = array(
			'id' => $info_arr['id'],
			'firstName' => ucwords($info_arr['first_name']),
			'lastName' => ucwords($info_arr['last_name']),
			'username' => $info_arr['username'],
			'role' => $role['role_id'],
			'createdAt' => $info_arr['created_at']
		);

	echo json_encode($info);

} else {
	echo json_encode((object) array());
}