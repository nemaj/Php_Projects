<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	echo json_encode(array());
	die();
}

$id = $_GET['id'];

$getUsers = $conn->query("SELECT * FROM chat WHERE business_id='$id' AND id IN (SELECT MAX(id) FROM chat GROUP BY customer_id);");

if ($getUsers->num_rows > 0) {
	$return = array();

	while ($row = $getUsers->fetch_assoc()) {
		extract($row);

		$userGET = $conn->query("SELECT * FROM customer_info WHERE id='$customer_id'");
		$userArr = $userGET->fetch_array();
		$customerGet = $conn->query("SELECT * FROM users WHERE id='".$userArr['users_id']."'");
		$customerInfo = $customerGet->fetch_array();

		$item = array(
				'customer_id' => $customer_id,
				'customerName' => $customerInfo['first_name'].' '.$customerInfo['last_name'],
				'date' => $date
			);
        array_push($return, $item);
	}

	echo json_encode($return);

} else {
	echo json_encode(array());
}
