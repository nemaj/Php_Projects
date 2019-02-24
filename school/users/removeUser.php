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

$usersId = $_GET['id'];

$delete = "DELETE FROM users WHERE id='$usersId'";

if ($conn->query($delete) === TRUE) {

	$deleteRole = $conn->query("DELETE FROM user_role WHERE users_id='$usersId'");

	echo true;
	
} else {
	echo false;
}