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

$list = $conn->query("SELECT * FROM subjects WHERE level='$level'");

if ($list->num_rows > 0) {
	$result = array();

	while ($row = $list->fetch_assoc()) {
		extract($row);

		$item = array(
				'subjectId' => $id,
				'subject' => ucwords($subject)
			);

		array_push($result, $item);
	}
	echo json_encode($result);

} else {
	echo json_encode(array());
}