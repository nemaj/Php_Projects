<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

$userId = $data->userId;
$username = $data->username;
$password = $data->password;

$sql = "UPDATE users SET
            username='$username',
            password='$password'
        WHERE id='$userId'";

if ($conn->query($sql) === TRUE) {
    echo true;
} else {
    echo false;
}
