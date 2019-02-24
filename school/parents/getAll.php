<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$sql = $conn->query("SELECT * FROM user_role WHERE role_id=4");

if ($sql->num_rows > 0) {
	$result = array();

	while($row = $sql->fetch_assoc()) {
		$userInfo = $conn->query("SELECT * FROM users WHERE id='".$row['users_id']."'");
		$user = $userInfo->fetch_array();

		$item = array(
				'id' => $row['users_id'],
				'firstName' => ucwords($user['first_name']),
				'lastName' => ucwords($user['last_name'])
			);

		array_push($result, $item);
	}

	echo json_encode($result);

} else {
	echo json_encode(array());
}