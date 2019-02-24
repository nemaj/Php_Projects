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

$class = $_GET['id'];

$res = $conn->query("SELECT * FROM schedules 
	WHERE level='$class' GROUP BY day 
	ORDER BY FIELD(day,'Monday','Tuesday','Wednesday', 'Thursday', 'Friday')");

if ($res->num_rows > 0) {
	$result = array();
	while ($row = $res->fetch_assoc()) {
		$dayData = $row['day'];

		$dayArr = array(
					'day' => $dayData,
					'schedules' => array()
				);

		$schedule = $conn->query("SELECT * FROM schedules WHERE level='$class' AND day='$dayData' ORDER BY time_start");

		while ($sched = $schedule->fetch_assoc()) {
			extract($sched);

			$item = array(
				'id' => $id,
				'areas' => $areas,
				'startTime' => date('d/m/Y H:i:s', strtotime($time_start)),
				'endTime' => date('d/m/Y H:i:s', strtotime($time_end))
			);

			array_push($dayArr['schedules'], $item);
		}

		array_push($result, $dayArr);
	}

	echo json_encode($result);

} else {
	echo json_encode(array());
}
