<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	echo false;
	die();
}

$gradingId = $data->gradingId;
$details = $data->details;

foreach ($details as $value) {
	$c_id = $value->id;
	$grade = $value->grade;

	$check = $conn->query("SELECT * FROM grade_details WHERE grade_id='$gradingId' AND criteria_id='$c_id'");

	if ($check->num_rows > 0) {
		$arr = $check->fetch_array();
		$sql = "UPDATE grade_details SET grade='$grade' WHERE id='".$arr['id']."'";
	} else {
		$sql = "INSERT INTO grade_details
			(grade_id, criteria_id, grade)
			VALUES ('$gradingId','$c_id','$grade')";
	}

	$conn->query($sql);
}

echo true;
