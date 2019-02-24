<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	echo json_encode(array());
	die();
}

$id = $_GET['id'];

$getLevel = $conn->query("SELECT * FROM pupil_level WHERE pupil_id='$id'");
$levelArr = $getLevel->fetch_array();

$result = array();

$getSubjects = $conn->query("SELECT * FROM subjects WHERE level='".$levelArr['level_id']."'");

while ($subject = $getSubjects->fetch_assoc()) {
	$subjectId = $subject['id'];

	$subjects = array(
				'subject' => $subject['subject'],
				'one' => '0',
				'two' => '0',
				'three' => '0',
				'four' => '0',
			);

	$getGrades = $conn->query("SELECT * FROM pupil_grade WHERE pupil_id='$id' AND subject_id='$subjectId' AND period='1'");
	if ($getGrades->num_rows > 0) {
		$gradesArr = $getGrades->fetch_array();
		$subjects['one'] = $gradesArr['grade'];
	}
	$getGrades = $conn->query("SELECT * FROM pupil_grade WHERE pupil_id='$id' AND subject_id='$subjectId' AND period='2'");
	if ($getGrades->num_rows > 0) {
		$gradesArr = $getGrades->fetch_array();
		$subjects['two'] = $gradesArr['grade'];
	}
	$getGrades = $conn->query("SELECT * FROM pupil_grade WHERE pupil_id='$id' AND subject_id='$subjectId' AND period='3'");
	if ($getGrades->num_rows > 0) {
		$gradesArr = $getGrades->fetch_array();
		$subjects['three'] = $gradesArr['grade'];
	}
	$getGrades = $conn->query("SELECT * FROM pupil_grade WHERE pupil_id='$id' AND subject_id='$subjectId' AND period='4'");
	if ($getGrades->num_rows > 0) {
		$gradesArr = $getGrades->fetch_array();
		$subjects['four'] = $gradesArr['grade'];
	}

	array_push($result, $subjects);
}

echo json_encode($result);


// for ($i=1; $i<=4; $i++) {
// 	$period = array(
// 			'period' => $i,
// 			'subjects' => array()
// 		);

// 	$getSubjects = $conn->query("SELECT * FROM subjects WHERE level='".$levelArr['level_id']."'");

// 	while ($subject = $getSubjects->fetch_assoc()) {
// 		$subjectId = $subject['id'];

// 		$getGrades = $conn->query("SELECT * FROM pupil_grade WHERE pupil_id='$id' AND subject_id='$subjectId' AND period='$i'");

// 		if ($getGrades->num_rows > 0) {
// 			$gradesArr = $getGrades->fetch_array();
// 			$grades = $gradesArr['grade'];
// 		} else {
// 			$grades = '0';
// 		}

// 		$item = array(
// 				'subject' => $subject['subject'],
// 				'grade' => $grades
// 			);

// 		array_push($period['subjects'], $item);

// 	}

// 	array_push($result, $period);
// }

// echo json_encode($result);