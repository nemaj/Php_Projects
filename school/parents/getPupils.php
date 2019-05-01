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

$parentId = $_GET['id'];

$res = $conn->query("SELECT * FROM pupils WHERE parent_id='$parentId'");

if ($res->num_rows > 0) {
	$result = array();

	while ($row = $res->fetch_assoc()) {
		extract($row);

		$getLevel = $conn->query("SELECT * FROM pupil_level p, grade_level g WHERE p.level_id=g.id AND p.pupil_id='$id'");
		$level = $getLevel->fetch_array();

		$item = array(
				'id' => $id,
				'lastName' => ucwords($last_name),
				'firstName' => ucwords($first_name),
				'middleName' => ucwords($middle_name),
				'levelId' => $level['level_id'],
				'level' => $level['level']
			);

		array_push($result, $item);
	}

	echo json_encode($result);

} else {
	echo json_encode(array());
}