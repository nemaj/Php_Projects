<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	die();
}

$usersId = $data->usersId;
$productId = $data->productId;

$sql_res = $conn->query("SELECT * FROM feedback WHERE user_id='$usersId' AND product_id='$productId'");

if ($sql_res->num_rows > 0) {
	$review_arr = $sql_res->fetch_array();

	$result = array(
				'id' => $review_arr['id'],
				'message' => $review_arr['message'],
				'rate' => $review_arr['rate'],
			);

	echo json_encode($result);
} else {
	echo json_encode((object) array());
}
