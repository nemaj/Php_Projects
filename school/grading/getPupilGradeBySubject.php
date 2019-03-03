<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	echo json_encode(array());
	die();
}

$pupilId = $data->pupilId;
$subjectId = $data->subjectId;
$period = $data->period;

$list = $conn->query("SELECT * FROM subjects WHERE id='$subjectId'");

if ($list->num_rows > 0) {
	$arr = $list->fetch_array();

	// while ($row = $list->fetch_assoc()) {
	extract($arr);

	$check = $conn->query("SELECT * FROM pupil_grade WHERE pupil_id='$pupilId' AND subject_id='$id' AND period='$period'");

	if (!$check->num_rows) {
		$create = $conn->query("INSERT INTO pupil_grade
				( pupil_id, subject_id, period, grade )
				VALUES ('$pupilId','$id','$period','0')");
		$isGradeReady = false;
		$gradingId = $conn->insert_id;
	} else {
		$gradeInfo = $check->fetch_array();
		$isGradeReady = true;
		$gradingId = $gradeInfo['id'];
	}

	$item = array(
			'subjectId' => $id,
			'subject' => ucwords($subject),
			'gradingId' => "$gradingId",
			'grade' => $isGradeReady ? $gradeInfo['grade'] : '0',
		);

	// }
	echo json_encode($item);

} else {
	echo json_encode(Object array());
}
