<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$getlevel = $conn->query("SELECT * FROM schedules GROUP BY level");

if ($getlevel->num_rows > 0) {
	$schedules = array();

	while ($level = $getlevel->fetch_assoc()) {
		$class = $level['level'];

		$res = $conn->query("SELECT * FROM schedules 
			WHERE level='$class' GROUP BY day 
			ORDER BY FIELD(day,'Monday','Tuesday','Wednesday', 'Thursday', 'Friday')");

		if ($res->num_rows > 0) {

			$getL = $conn->query("SELECT * FROM grade_level WHERE id='$class'");
			$levelInfo = $getL->fetch_array();

			$result = array(
				'levelId' => $class,
				'level' => $levelInfo['level'],
				'classSchedules' => array()
			);
			while ($row = $res->fetch_assoc()) {
				$dayData = $row['day'];

				// $dayArr = array(
				// 			'day' => $dayData,
				// 			'schedules' => array()
				// 		);

				$schedule = $conn->query("SELECT * FROM schedules WHERE level='$class' AND day='$dayData' ORDER BY time_start");

				while ($sched = $schedule->fetch_assoc()) {
					extract($sched);

					$startT = date('h:i:s a', strtotime($time_start));
					$endT = date('h:i:s a', strtotime($time_end));
					$time = "$startT - $endT";

					$item = array(
						'id' => $id,
						'day' => $dayData,
						'areas' => $areas,
						'time' => $time,
						'startTime' => date('d/m/Y H:i:s', strtotime($time_start)),
						'endTime' => date('d/m/Y H:i:s', strtotime($time_end))
					);

					// array_push($dayArr['schedules'], $item);
					array_push($result['classSchedules'], $item);
				}

				// array_push($result['classSchedules'], $dayArr);
			}

			array_push($schedules, $result);
		}

	}

	echo json_encode($schedules);

} else {
	echo json_encode(array());
}
