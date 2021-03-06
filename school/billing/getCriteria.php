<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$list = $conn->query("SELECT * FROM payment_criteria");

if ($list->num_rows > 0) {
	$result = array();

	while ($row = $list->fetch_array()) {
		extract($row);

		if ($grade_level !== '0') {
			$getlevel = $conn->query("SELECT * FROM grade_level WHERE id='$grade_level'");
			$levelArr = $getlevel->fetch_array();
		}

		$levelValue = $grade_level === '0' ? 'All' : $levelArr['level'];

		$item = array(
				'id' => $id,
				'name' => $name,
				'price' => $price,
				'level' => $grade_level,
				'levelValue' => $levelValue
			);

		array_push($result, $item);
	}

	echo json_encode($result);

} else {
	echo json_encode(array());
}