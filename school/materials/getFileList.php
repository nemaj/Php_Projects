<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$list = $conn->query("SELECT * FROM materials");

if ($list->num_rows > 0) {
	$returnList = array();

	while ($row = $list->fetch_assoc()) {
		extract($row);

		$item = array(
				'id' => $id,
				'name' => $name,
				'type' => $type,
				'file' => $filename
			);

		array_push($returnList, $item);
	}

	echo json_encode($returnList);

} else {
	echo json_encode(array());
}
