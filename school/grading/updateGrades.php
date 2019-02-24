<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	echo false;
	die();
}

$gradingId = $_GET['id'];

$list = $conn->query("SELECT * FROM grade_details WHERE grade_id='$gradingId'");

if ($list->num_rows > 0) {

	$AVG = 0;

	while ($row = $list->fetch_assoc()) {
		extract($row);

		$get = $conn->query("SELECT * FROM grade_criteria WHERE id='$criteria_id'");
		$cInfo = $get->fetch_array();

		$base = "0.".$cInfo['percentage'];
		$points = $grade * floatval($base);

		$AVG = $AVG + $points;
	}

	$sql = "UPDATE pupil_grade SET grade='$AVG' WHERE id='$gradingId'";

	if ($conn->query($sql) === TRUE) {
		echo true;
	} else {
		echo false;
	}

} else {
	echo true;
}