<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$sql = $conn->query("SELECT * FROM learning_areas");

if ($sql->num_rows > 0) {
	$result = array();

	while($row = $sql->fetch_assoc()) {
		extract($row);

		$item = array(
				'id' => $id,
				'area' => ucwords($area)
			);
		array_push($result, $item);
	}

	echo json_encode($result);

} else {
	echo json_encode(array());
}