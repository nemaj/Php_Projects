<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$sql = "SELECT *,
	EXTRACT( YEAR FROM `created_at` ) as year,
	EXTRACT( MONTH FROM `created_at` ) as month FROM users as u, user_role as ur
		WHERE u.id = ur.users_id AND ur.roles_id=2
		GROUP BY MONTH(u.created_at), YEAR(u.created_at) ORDER BY u.created_at";
$res = $conn->query($sql);

$return = array();
while ($row = $res->fetch_assoc()) {
	$month = $row['month'];
	$year = $row['year'];

	$dateO = date_create($row['created_at']);
	$formatD = date_format($dateO, "M Y");

	$main_arr = array(
			'date' => $formatD,
			'month' => $month,
			'year' => $year,
			'usersCount' => 0
		);

	$get = $conn->query("SELECT * FROM users as u, user_role as ur 
			WHERE u.id = ur.users_id AND ur.roles_id=2
				AND YEAR(created_at)='$year' 
				AND MONTH(created_at)='$month'");

	$main_arr['usersCount'] = $get->num_rows;
	array_push($return, $main_arr);
}

echo json_encode($return);
