<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

function getMonth($month) {
	switch ($month) {
		case '1':
			return 'January';
		case '2':
			return 'February';
		case '3':
			return 'March';
		case '4':
			return 'April';
		case '5':
			return 'May';
		case '6':
			return 'June';
		case '7':
			return 'July';
		case '8':
			return 'August';
		case '9':
			return 'September';
		case '10':
			return 'October';
		case '11':
			return 'November';
		case '12':
			return 'December';
		default:
	}
}

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

$totalAmount = 0;
$count = 0;

while ($row = $res->fetch_assoc()) {
	$month = $row['month'];
	$year = $row['year'];

	$dateO = date_create($row['date']);
	$formatD = date_format($dateO, "M Y");

	$main_arr = array(
			'date' => $formatD,
			'month' => getMonth($month),
			'year' => $year,
			'amount' => 0,
		);

	$total = 0;

	$get = $conn->query("SELECT * FROM payments WHERE YEAR(date)='$year' AND MONTH(date)='$month'");
	$lastYear = $year;
	$lastMonth = $month;

	while ($data = $get->fetch_assoc()) {
		extract($data);

		$total = $total + $price;
	}
	$totalAmount = $totalAmount + $total;
	$main_arr['amount'] = $total;
	array_push($return, $main_arr);
	$count++;
}

$lastAmount = $totalAmount / $count;

$last = array(
		'date' => '',
		'month' => getMonth($lastMonth),
		'year' => $lastYear,
		'amount' => $lastAmount,
	);
array_push($return, $last);

echo json_encode($return);
