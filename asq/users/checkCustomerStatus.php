<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	die();
}

$id = $_GET['id'];

$sql = $conn->query("SELECT is_complete FROM users WHERE id='$id'");
$result = $sql->fetch_array();

echo $result['is_complete'];

