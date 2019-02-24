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
    $roleArr = $getRole->fetch_array();

    if ($roleArr['roles_id'] == 3) {
        $info_sql = "SELECT * FROM customer_info WHERE users_id='".$arr['id']."'";
    } else if ($roleArr['roles_id'] == 2) {
        $info_sql = "SELECT * FROM business_info WHERE users_id='".$arr['id']."'";
    }

    $otherId = 0;
    if (isset($info_sql)) {
        $getInfo = $conn->query($info_sql);
        if ($getInfo->num_rows > 0) {
            $infoArr = $getInfo->fetch_array();
        }
        $otherId = $arr['is_complete']==1 ? $infoArr['id'] : 0;
    }

    $res = array(
    	"usersId" => $arr['id'],
    	"firstName" => $arr['first_name'],
    	"lastName" => $arr['last_name'],
    	"username" => $arr['username'],
    	"created_at" => $arr['created_at'],
    	"role" => $roleArr['roles_id'],
        "isComplete" => $arr['is_complete'],
        "otherId" => $otherId
    );

    echo json_encode($res);
} else {
    $posts_arr = array(
        'message' => 'Users not found.',
    );
    echo json_encode($posts_arr);
}
