<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$supplier =$conn->query("SELECT * FROM user_role WHERE roles_id='2'");

$list = array();

while ($row = $supplier->fetch_assoc()) {
	$id = $row['users_id'];

	$getUserInfo = $conn->query("SELECT * FROM users WHERE id='$id'");
	$userInfo = $getUserInfo->fetch_array();
	$getInfo = $conn->query("SELECT * FROM business_info WHERE users_id='$id'");
	$info = $getInfo->fetch_array();

	$item = array(
			'id' => $id,
			'firstName' => $userInfo['first_name'],
			'lastName' => $userInfo['last_name'],
			'businessName' => $info['name'],
			'businessLicense' => $info['license'],
			'businessAddress' => $info['address'],
		);

	array_push($list, $item);
}

echo json_encode($list);