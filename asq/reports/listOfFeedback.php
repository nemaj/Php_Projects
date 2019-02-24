<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$sql = "SELECT * FROM products";
$res = $conn->query($sql);

$return = array();
while ($row = $res->fetch_assoc()) {
	extract($row);

	$main_arr = array(
			'productId' => $id,
			'productName' => $name,
			'feedback' => array()
		);

	$getFeedback = $conn->query("SELECT * FROM feedback WHERE product_id='$id'");

	while ($feedback = $getFeedback->fetch_assoc()) {

		$getUser = $conn->query("SELECT * FROM users WHERE id='".$feedback['user_id']."'");
		$user = $getUser->fetch_array();

		$dateFeedback = date_create($feedback['date']);
		$formatDate = date_format($dateFeedback, "M j, Y");

		$item = array(
				'userName' => $user['first_name'].' '.$user['last_name'],
				'message' => $feedback['message'],
				'rate' => $feedback['rate'],
				'date' => $formatDate
			);
		array_push($main_arr['feedback'], $item);
	}

	if ($getFeedback->num_rows > 0) {
		array_push($return, $main_arr);
	}
}

echo json_encode($return);
