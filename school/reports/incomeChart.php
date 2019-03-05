<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$sql = "SELECT *, EXTRACT( YEAR FROM `date` ) as year, 
	EXTRACT( MONTH FROM `date` ) as month FROM payments 
	GROUP BY MONTH(date), YEAR(date) ORDER BY id";
$res = $conn->query($sql);

$return = array();

$init_arr = array(
		'date' => "",
		'month' => "",
		'year' => "",
		'amount' => 0,
	);
array_push($return, $init_arr);

while ($row = $res->fetch_assoc()) {
	$month = $row['month'];
	$year = $row['year'];

	$dateO = date_create($row['date']);
	$formatD = date_format($dateO, "M Y");

	$main_arr = array(
			'date' => $formatD,
			'month' => $month,
			'year' => $year,
			'amount' => 0,
		);

	$total = 0;

	$get = $conn->query("SELECT * FROM payments WHERE YEAR(date)='$year' AND MONTH(date)='$month'");

	while ($data = $get->fetch_assoc()) {
		extract($data);

		$total = $total + $price;
	}
	$main_arr['amount'] = $total;
	array_push($return, $main_arr);
}

echo json_encode($return);
