<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$getPupils = $conn->query("SELECT * FROM pupils p INNER JOIN pupil_level l ON p.id=l.pupil_id INNER JOIN grade_level g ON l.level_id=g.id");

if ($getPupils->num_rows > 0) {
	$result = array();

	while ($row = $getPupils->fetch_assoc()) {
	    $pupilId = $row['pupil_id'];
	    $pupilLevel = $row['level_id'];

		$getPayments = $conn->query("SELECT * FROM payment_criteria");
	    $totalPayment = 0;
	    while ($pay = $getPayments->fetch_assoc()) {
	        if ($pay['grade_level'] === $pupilLevel || $pay['grade_level'] === '0') {
	        	$totalPayment = $totalPayment + $pay['price'];
	        }
	    }

	    $getPupilPaid = $conn->query("SELECT * FROM payments WHERE pupil_id='$pupilId'");
	    $totalPaid = 0;
	    while ($pay = $getPupilPaid->fetch_assoc()) {
	    	$totalPaid = $totalPaid + $pay['price'];
	    }

	    $item = array(
	    		'pupilId' => $pupilId,
	    		'firstName' => ucwords($row['first_name']),
	    		'lastName' => ucwords($row['last_name']),
	    		'middleName' => ucwords($row['middle_name']),
	    		'sex' => $row['gender'],
	    		'gradeLevel' => ucwords($row['level']),
	    		'paid' => $totalPayment == $totalPaid,
	    		'bankAccount' => $totalPayment - $totalPaid
	    	);

	    array_push($result, $item);

	}

	echo json_encode($result);

} else {
	echo json_encode(array());
}