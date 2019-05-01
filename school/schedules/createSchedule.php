<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	echo FALSE;
	die();
}

$level = $data->level;
$areas = $data->areas;
$day = $data->day;
$startTime = $data->startTime;
$endTime = $data->endTime;

if ($_GET['id']) {
	$id = $_GET['id'];
	$sql = "UPDATE schedules SET areas='$areas', day='$day', time_start='$startTime', time_end='$endTime' WHERE id='$id'";

} else {
	$sql = "INSERT INTO schedules (
				level,
				areas,
				day,
				time_start,
				time_end
			) VALUES (
				'$level',
				'$areas',
				'$day',
				'$startTime',
				'$endTime'
			)";

}

// echo $sql;

if ($conn->query($sql) === TRUE) {
	if ($_GET['id']) {
		echo $_GET['id'];
	} else {
    	echo $conn->insert_id;
	}
} else {
	echo FALSE;
}
