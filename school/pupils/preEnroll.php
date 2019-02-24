<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	echo false;
	die();
}

$fname = $data->fname;
$mname = $data->mname;
$lname = $data->lname;
$gender = $data->gender;
$birthdate = $data->bdate;
$birthplace = $data->birthplace;
$address = $data->address;
$level = $data->level;
$parentId = $data->parentId;

$insert = "INSERT INTO pupils (
				last_name,
				first_name,
				middle_name,
				gender,
				birthdate,
				birthplace,
				address,
				parent_id
			) VALUES (
				'$lname',
				'$fname',
				'$mname',
				'$gender',
				'$birthdate',
				'$birthplace',
				'$address',
				'$parentId'
			)";

if ($conn->query($insert) === TRUE) {
	$id = $conn->insert_id;

	$preEnroll = $conn->query("INSERT INTO pre_enroll (pupil_id) VALUES ('$id')");

	$addLevel = $conn->query("INSERT INTO pupil_level (pupil_id, level_id) VALUES ('$id', '$level')");

	echo $id;
} else {
	echo $conn->error;
}