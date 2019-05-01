<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$getEnrolled = $conn->query("SELECT * FROM enrolled e
	INNER JOIN pupils p ON e.pupil_id=p.id
	INNER JOIN pupil_level pl ON pl.pupil_id=p.id
	INNER JOIN grade_level g ON g.id=pl.level_id");

if ($getEnrolled->num_rows > 0) {

	$result = array();

	while ($row = $getEnrolled->fetch_assoc()) {
	    extract($row);

	    $item = array(
	    		'pupilId' => $pupil_id,
	    		'lastName' => ucwords($last_name),
	    		'firstName' => ucwords($first_name),
	    		'middleName' => ucwords($middle_name),
	    		'sex' => $gender,
	    		'levelId' => $level_id,
	    		'gradeLevel' => $level,
	    		'enrolledDate' => $enroll_date
	    	);

	    array_push($result, $item);
	}

	echo json_encode($result);

} else {
	echo json_encode(array());
}
