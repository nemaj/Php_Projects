<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	die();
}

$usersId = $_GET['id'];

$info = $conn->query("SELECT * FROM teacher_info WHERE users_id='$usersId'");

if ($info->num_rows > 0) {
	$arr = $info->fetch_array();

	echo $arr['verify'];

} else {
	echo false;
}

