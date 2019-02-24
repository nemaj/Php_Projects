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
	$getInfo = $conn->query("SELECT * FROM customer_info WHERE users_id='$userId'");
	$info2 = $getInfo->fetch_array();

	$user_info = array(
		'id' => $info['id'],
		'customer_id' => $info2['id'],
		'firstName' => $info['first_name'],
		'lastName' => $info['last_name'],
		'street' => $info2['street'],
		'barangay' => $info2['barangay'],
		'city' => $info2['city'],
		'province' => $info2['province'],
		'country' => $info2['country'],
		'contactNumber' => $info2['contact_number']
	);

	echo json_encode($user_info);
} else {
	echo json_encode((object) array());
}