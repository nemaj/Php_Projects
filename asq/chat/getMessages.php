<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	echo json_encode(array());
	die();
}

$customerId = $data->customerId;
$businessId = $data->businessId;

$sql = "SELECT * FROM chat WHERE customer_id='$customerId' AND business_id='$businessId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	$return = array();

	while ($row = $result->fetch_assoc()) {
		extract($row);

		$userGET = $conn->query("SELECT * FROM customer_info WHERE id='$customerId'");
		$userArr = $userGET->fetch_array();
		$customerGet = $conn->query("SELECT * FROM users WHERE id='".$userArr['users_id']."'");
		$customerInfo = $customerGet->fetch_array();

		$businessGet = $conn->query("SELECT * FROM business_info WHERE id='$businessId'");
		$businessInfo = $businessGet->fetch_array();

		$item = array(
				'customerId' => $customer_id,
				'customerName' => $customerInfo['first_name'].' '.$customerInfo['last_name'],
				'businessId' => $business_id,
				'businessName' => $businessInfo['name'],
				'senderRole' => $sender_role,
				'message' => $message,
				'date' => $date
			);

        array_push($return, $item);
	}

	echo json_encode($return);

} else {
	echo json_encode(array());
}

