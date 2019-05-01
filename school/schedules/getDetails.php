<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	echo json_encode((object) array());
	die();
}

$id = $_GET['id'];

$res = $conn->query("SELECT * FROM schedules WHERE id='$id'");

if ($res->num_rows > 0) {
	extract($res->fetch_array());

	$result = array(
			'id' => $id,
			'areas' => $areas,
			'day' => $day,
			'levelId' => $level,
			'startTime' => date('d/m/Y H:i:s', strtotime($time_start)),
			'endTime' => date('d/m/Y H:i:s', strtotime($time_end))
		);

	echo json_encode($result);

} else {
	echo json_encode((object) array());
}