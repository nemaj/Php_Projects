<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

$userType = $data->userType;
$firstName = $data->firstName;
$lastName = $data->lastName;
$username = $data->username;
$password = $data->password;

if (!isset($username)) {
    die();
}

if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "UPDATE users SET
                first_name='$firstName',
                last_name='$lastName',
                username='$username',
                password='$password'
            WHERE id='$id'";
} else {
    $sql = "INSERT INTO users (
                first_name,
                last_name,
                username,
                password
            ) VALUES (
                '$firstName',
                '$lastName',
                '$username',
                '$password'
            )";
}

if ($conn->query($sql) === TRUE) {
    if ($_GET['id']) {
        echo true;
    } else {
        $users_id = $conn->insert_id;

        $roleSql = "INSERT INTO user_role (users_id, role_id) VALUES ('$users_id','$userType')";
        if ($conn->query($roleSql) === TRUE) {
            echo $users_id;
        }
    }

} else {
    echo FALSE;
}
