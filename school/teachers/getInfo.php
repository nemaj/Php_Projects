<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	echo json_encode(array('isHasInfo' => false));
	die();
}

$id = $_GET['id'];

$sql = $conn->query("SELECT * FROM teacher_info WHERE users_id='$id'");

if ($sql->num_rows > 0) {
	extract($sql->fetch_array());

	$level = $conn->query("SELECT * FROM grade_level WHERE id='$advisory'");
	$levelInfo = $level->fetch_array();

	$res = array(
			'id' => $id,
			'usersId' => $users_id,
			'gender' => $gender,
			'level' => $advisory,
			'levelDesc' => $levelInfo['level'],
			'address' => $address,
			'contact' => $contact,
			'email' => $email,
			'isHasInfo' => true
		);

	echo json_encode($res);

} else {
	echo json_encode(array('isHasInfo' => false));
}