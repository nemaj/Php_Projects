<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$customer =$conn->query("SELECT * FROM user_role WHERE roles_id='3'");

$list = array();

while ($row = $customer->fetch_assoc()) {
	$id = $row['users_id'];

	$getUserInfo = $conn->query("SELECT * FROM users WHERE id='$id'");
	$userInfo = $getUserInfo->fetch_array();
	$getInfo = $conn->query("SELECT * FROM customer_info WHERE users_id='$id'");
	$info = $getInfo->fetch_array();

	$address = $info['street'].', '.$info['barangay'].', '.$info['city'].', '.$info['province'];

	$item = array(
			'id' => $id,
			'firstName' => $userInfo['first_name'],
			'lastName' => $userInfo['last_name'],
			'address' => $address,
			'contactNumber' => $info['contact_number']
		);

	array_push($list, $item);
}

echo json_encode($list);