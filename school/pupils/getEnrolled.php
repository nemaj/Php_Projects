<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$get = $conn->query("SELECT * FROM enrolled");

if ($get->num_rows > 0) {
	$result = array();

	while ($row = $get->fetch_assoc()) {

		$getInfo = $conn->query("SELECT * FROM pupils WHERE id='".$row['pupil_id']."'");
		$infoArr = $getInfo->fetch_array();

		$getParent = $conn->query("SELECT * FROM users WHERE id='".$infoArr['parent_id']."'");
		$parentArr = $getParent->fetch_array();

		$getLevel = $conn->query("SELECT * FROM pupil_level WHERE pupil_id='".$row['pupil_id']."'");
		$levelArr = $getLevel->fetch_array();

		$getLevelDesc = $conn->query("SELECT * FROM grade_level WHERE id='".$levelArr['level_id']."'");
		$levelDescArr = $getLevelDesc->fetch_array();

		$item = array(
				'id' => $row['pupil_id'],
				'lastName' => ucwords($infoArr['last_name']),
				'firstName' => ucwords($infoArr['first_name']),
				'middleName' => ucwords($infoArr['middle_name']),
				'gender' => $infoArr['gender'],
				'birthdate' => $infoArr['birthdate'],
				'birthplace' => $infoArr['birthplace'],
				'level_id' => $levelArr['level_id'],
				'level' => $levelDescArr['level'],
				'parentName' => ucwords($parentArr['first_name'])." ".ucwords($parentArr['last_name']),
				'parentId' => $infoArr['parent_id'],
			);

		array_push($result, $item);

	}

	echo json_encode($result);

} else {
	echo json_encode(array());
}