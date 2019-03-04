<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	echo json_encode(array());
	die();
}

$teacherId = $_GET['id'];

$getInfo = $conn->query("SELECT * FROM teacher_info WHERE users_id='$teacherId'");

$info = $getInfo->fetch_array();

$getPupils = $conn->query("SELECT * FROM pupil_level WHERE level_id='".$info['advisory']."'");

if ($getPupils->num_rows > 0) {
	$result = array();

	while ($pupil = $getPupils->fetch_assoc()) {
		$pupilId = $pupil['pupil_id'];
		$pupilLevel = $pupil['level_id'];
	    $getPupilInfo = $conn->query("SELECT * FROM pupils WHERE id='$pupilId'");
	    $pupilInfo = $getPupilInfo->fetch_array();

	    $getGradeLevel = $conn->query("SELECT * FROM grade_level WHERE id='$pupilLevel'");
	    $levelInfo = $getGradeLevel->fetch_array();

	    $pupilItem = array(
	    		'pupilId' => $pupilId,
	    		'firstName' => ucwords($pupilInfo['first_name']),
	    		'middleName' => ucwords($pupilInfo['middle_name']),
	    		'lastName' => ucwords($pupilInfo['last_name']),
	    		'level' => $levelInfo['level'],
	    		'periods' => array()
	    	);

	    for($i=1;$i<=4;$i++) {

	    	$period = array(
	    			'Period' => "Period $i",
	    			'subjects' => array()
	    		);

		    $getSubjects = $conn->query("SELECT * FROM subjects WHERE level='$pupilLevel'");

		   	if ($getSubjects->num_rows > 0) {
		   		while ($subject = $getSubjects->fetch_assoc()) {
		   		    $subjectId = $subject['id'];

		   		    $getGrade = $conn->query("SELECT * FROM pupil_grade WHERE pupil_id='$pupilId' AND subject_id='$subjectId' AND period= '$i'");

		   		    if ($getGrade->num_rows > 0) {
		   		    	$gradeInfo = $getGrade->fetch_array();
		   		    	$grade = $gradeInfo['grade'];
		   		    } else {
		   		    	$grade = 0;
		   		    }

		   		    $subjects = array(
		   		    		'subjectId' => $subjectId,
		   		    		'subject' => $subject['subject'],
		   		    		'grade' => $grade
		   		    	);

		   		    array_push($period['subjects'], $subjects);
		   		}
		   	}

   		    array_push($pupilItem['periods'], $period);

		}

		array_push($result, $pupilItem);

	}

	echo json_encode($result);

} else {	
	echo json_encode(array());
}
