<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	echo array();
	die();
}

$pupilId = $_GET['id'];

$getLevel = $conn->query("SELECT * FROM pupil_level WHERE pupil_id='$pupilId'");
$levelInfo = $getLevel->fetch_array();

$list = $conn->query("SELECT * FROM payment_criteria");

if ($list->num_rows > 0) {

	$result = array();

	while ($row = $list->fetch_assoc()) {
		$criteriaId = $row['id'];

		$get = $conn->query("SELECT * FROM payments WHERE criteria_id='$criteriaId' AND pupil_id='$pupilId'");

		if ($row['grade_level'] === '0' || $row['grade_level'] === $levelInfo['level_id']) {

			if ($get->num_rows > 0) {
				$paid = 0;
				while ($pay = $get->fetch_assoc()) {
					$paid += $pay['price'];
				}

				$newPrice = $row['price'] - $paid;
				$item = array(
						'id' => $criteriaId,
						'name' => $row['name'],
						'original' => $row['price'],
						'price' => "$newPrice"
					);
			} else {
				$item = array(
						'id' => $criteriaId,
						'name' => $row['name'],
						'original' => $row['price'],
						'price' => $row['price']
					);
			}
		
			array_push($result, $item);
		}
	}

	echo json_encode($result);

} else {
	echo array();
}