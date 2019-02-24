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

$g_id = $_GET['id'];

$list = $conn->query("SELECT * FROM grade_criteria");

$result = array();

while ($row = $list->fetch_assoc()) {
	extract($row);

	$get = $conn->query("SELECT * FROM grade_details WHERE criteria_id='$id' AND grade_id='$g_id'");

	if ($get->num_rows > 0) {
		$info = $get->fetch_array();
		$grade = $info['grade'];
	} else {
		$grade = '0';
	}

	$item = array(
			'id' => $id,
			'criteria' => $criteria,
			'grade' => $grade
		);

	array_push($result, $item);
}

echo json_encode($result);