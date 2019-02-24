<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	die();
}

$usersId = $_GET['id'];

$sql = "UPDATE users SET is_complete='1' WHERE id='$usersId'";

if ($conn->query($sql) === TRUE) {

	echo 1;

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}