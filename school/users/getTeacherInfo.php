<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['username'])) {
	echo json_encode((object) array());
	die();
}

$username = $_GET['username'];

$getInfo = $conn->query("SELECT * FROM users WHERE username='$username'");

if ($getInfo->num_rows > 0) {
	$info_arr = $getInfo->fetch_array();

	$getRole = $conn->query("SELECT * FROM user_role WHERE users_id='".$info_arr['id']."'");
	$role = $getRole->fetch_array();

    $checkInfo = $conn->query("SELECT * FROM teacher_info WHERE users_id='".$info_arr['id']."'");
    $isInfoExist = $checkInfo->num_rows;

	$info = array(
			'id' => $info_arr['id'],
			'firstName' => ucwords($info_arr['first_name']),
			'lastName' => ucwords($info_arr['last_name']),
			'username' => $info_arr['username'],
			'role' => $role['role_id'],
			'isInfoExist' => $isInfoExist ? true : false,
			'info' => (object) array(),
			'createdAt' => $info_arr['created_at']
		);

    if ($isInfoExist) {
    	$infoItem = $checkInfo->fetch_array();
    	$info['info'] = $infoItem;
    }

	echo json_encode($info);

} else {
	echo json_encode((object) array());
}