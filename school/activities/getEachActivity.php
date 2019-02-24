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

$list = $conn->query("SELECT * FROM activties WHERE id='$id'");

if ($list->num_rows > 0) {
	extract($list->fetch_array());

	$item = array(
			'id' => $id,
			'title' => $title,
			'start' => $event_start,
			'end' => $event_end,
			'allDay' => true
		);

	echo json_encode($item);

} else {
	echo json_encode((object) array());
}
