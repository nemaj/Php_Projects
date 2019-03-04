<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

$username = $data->username;
$password = $data->password;

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $arr = $result->fetch_array();

    $getRole = $conn->query("SELECT * FROM user_role WHERE users_id='".$arr['id']."'");
    $role = $getRole->fetch_array();

    $checkInfo = $conn->query("SELECT * FROM parent_info WHERE users_id='".$arr['id']."'");
    $isInfoExist = $checkInfo->num_rows;

    $verify = true;
    if ($role['role_id'] === '3') {
        $checkVerify = $conn->query("SELECT * FROM teacher_info WHERE users_id='".$arr['id']."'");

        if ($checkVerify->num_rows > 0) {
            $verifyArr = $checkVerify->fetch_array();
            $verify = $verifyArr['verify'] ? true : false;
        } else {
            $verify = false;
        }
    }

    $res = array(
    	"usersId" => $arr['id'],
    	"firstName" => $arr['first_name'],
    	"lastName" => $arr['last_name'],
    	"username" => $arr['username'],
        "role" => $role['role_id'],
        "verify" => $verify,
        "infoExist" => $isInfoExist ? true : false,
    	"created_at" => $arr['created_at']
    );

    echo json_encode($res);
} else {
    echo json_encode((object) array());
}
