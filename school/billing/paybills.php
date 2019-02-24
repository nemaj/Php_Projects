<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	echo 0;
	die();
}

$bills = $data->bills;
$pupilId = $data->pupilId;

if (empty($bills)) {
	echo 0;
	die();
}

$orNum = "iUP".date('YmdHis');
// echo $orNum;

foreach ($bills as $key => $value) {

	$criteriaId = $value->id;
	$amount = $value->amount;

	$sql = "INSERT INTO payments 
			(or_num, pupil_id, criteria_id, price)
			VALUES
			('$orNum', '$pupilId', '$criteriaId', '$amount')";

	if ($conn->query($sql) !== TRUE) {
		echo $conn->error;
		break;
	}

}

echo true;