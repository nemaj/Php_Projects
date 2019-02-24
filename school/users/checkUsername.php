<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['username'])) {
	die();
}

$username = $_GET['username'];

$check = $conn->query("SELECT * FROM users WHERE username='$username'");

if ($check->num_rows > 0) {
	echo 1;
} else {
	echo 0;
}
