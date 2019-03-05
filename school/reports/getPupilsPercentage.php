<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$getPupils = $conn->query("SELECT * FROM enrolled e 
	INNER JOIN pupils p ON e.pupil_id=p.id");

$count = 0;
if ($getPupils->num_rows > 0) {
	while ($row = $getPupils->fetch_assoc()) {
	    $count++;
	}
}

$lastPupilCount = 35;
$AVG = ($count / $lastPupilCount) * 100;

echo json_encode(array('value' => round($AVG, 2)));