<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$sql = $conn->query("SELECT * FROM user_role ur
	INNER JOIN users u ON u.id=ur.users_id
	INNER JOIN teacher_info t ON u.id=t.users_id
	INNER JOIN grade_level g ON t.advisory=g.id
	WHERE role_id=3");

if ($sql->num_rows > 0) {
	$result = array();

	while($row = $sql->fetch_assoc()) {
		extract($row);

		$item = array(
				'id' => $users_id,
				'firstName' => ucwords($first_name),
				'lastName' => ucwords($last_name),
				'sex' => $gender,
				'advisory' => $level,
			);

		array_push($result, $item);
	}

	echo json_encode($result);

} else {
	echo json_encode(array());
}