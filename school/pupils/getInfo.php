<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	echo json_encode((object) array());
	die();
}

$id = $_GET['id'];

$sql = $conn->query("SELECT * FROM pupils WHERE id='$id'");

if ($sql->num_rows > 0) {
	extract($sql->fetch_array());

	$getParent = $conn->query("SELECT * FROM users WHERE id='$parent_id'");
	$parent = $getParent->fetch_array();

	$getInfo = $conn->query("SELECT * FROM parent_info WHERE users_id='$parent_id'");
	$info = $getInfo->fetch_array();

	$getLevel = $conn->query("SELECT * FROM pupil_level p, grade_level g WHERE p.level_id=g.id AND p.pupil_id='$id'");
	$level = $getLevel->fetch_array();

	$res = array(
			'id' => $id,
			'lastName' => ucwords($last_name),
			'firstName' => ucwords($first_name),
			'middleName' => ucwords($middle_name),
			'gender' => $gender,
			'birthdate' => date('m/d/Y H:i:s', strtotime($birthdate)),
			'birthplace' => $birthplace,
			'address' => $address,
			'levelId' => $level['level_id'],
			'level' => $level['level'],
			'parentId' => $parent_id,
			'parentName' => ucwords($parent['first_name']).' '.ucwords($parent['last_name']),
		);

	echo json_encode($res);

} else {
	echo json_encode((object) array());
}