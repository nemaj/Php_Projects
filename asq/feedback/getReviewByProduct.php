<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	die();
}

$productId = $_GET['id'];

$sql_res = $conn->query("SELECT * FROM feedback WHERE product_id='$productId' ORDER BY date DESC");

if ($sql_res->num_rows > 0) {
	$result = array();

	while ($row = $sql_res->fetch_assoc()) {
		extract($row);

		$user_get = $conn->query("SELECT * FROM users WHERE id='$user_id'");
		$user_arr = $user_get->fetch_array();

		$item = array(
				'id' => $id,
				'usersId' => $user_id,
				'name' => ucfirst($user_arr['first_name']).' '.strtoupper($user_arr['last_name'][0]).'.',
				'message' => $message,
				'rate' => $rate,
				'date' => $date
			);

        array_push($result, $item);
	}

	echo json_encode($result);
} else {
	echo json_encode(array());
}
