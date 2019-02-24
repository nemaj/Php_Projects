<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['level'])) {
	echo json_encode(array());
	die();
}

$level = $_GET['level'];

$list = $conn->query("SELECT * FROM pupil_level l, pupils p WHERE l.pupil_id = p.id AND l.level_id='$level'");

if ($list->num_rows > 0) {
	$result = array();

	while ($row = $list->fetch_assoc()) {
		extract($row);

		$item = array(
				'pupilId' => $pupil_id,
				'lastName' => ucwords($last_name),
				'firstName' => ucwords($first_name),
				'middleName' => ucwords($middle_name),
				'gender' => $gender,
				'levelId' => $level_id,
			);

		array_push($result, $item);
	}

	echo json_encode($result);
} else {
	echo json_encode(array());
}