<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$getOR = $conn->query("SELECT * FROM payments p
	INNER JOIN pupils pu ON p.pupil_id=pu.id
	INNER JOIN pupil_level pl ON p.pupil_id=pl.pupil_id
	INNER JOIN grade_level g ON pl.level_id=g.id
	GROUP BY or_num");

if ($getOR->num_rows > 0) {
	$result = array();
	while ($OR = $getOR->fetch_assoc()) {
		$OR_Num = $OR['or_num'];
		$pupilName = ucwords($OR['last_name'].", ".$OR['first_name']." ".$OR['middle_name']);
		$item = array(
				'or_num' => $OR_Num,
				'pupilName' => $pupilName,
				'level' => $OR['level'],
				'amount' => 0,
				'date' => date('d/m/Y H:i:s', strtotime($OR['date'])),
				'formatDate' => date('M j, Y', strtotime($OR['date']))
			);

		$get = $conn->query("SELECT * FROM payments WHERE or_num='$OR_Num'");
		$total = 0;

		while ($pay = $get->fetch_assoc()) {
		    $total = $total + $pay['price'];
		}

		$item['amount'] = $total;
		array_push($result, $item);
	}

	$totalAmount = 0;
	foreach ($result as &$value) {
	    $totalAmount = $totalAmount + $value['amount'];
	}
	$extra = array(
			'or_num' => "TOTAL",
			'pupilName' => "",
			'level' => "",
			'amount' => $totalAmount,
			'date' => "",
			'formatDate' => ""
		);
	array_push($result, $extra);

	echo json_encode($result);
} else {
	echo json_encode(array());
}