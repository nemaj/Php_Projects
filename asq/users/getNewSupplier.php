<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$sql = "SELECT * FROM users WHERE is_complete = 2";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users_arr = array();

    while ($row = $result->fetch_assoc()) {
        extract($row);

        $role = $conn->query("SELECT roles_id FROM user_role WHERE users_id='$id'");

        $role_data = $role->fetch_array();

        $role_res = $conn->query("SELECT title FROM roles WHERE id='".$role_data['roles_id']."'");

        $role_desc = $role_res->fetch_array();

        $user_item = array(
            'id' => $id,
            'firstName' => $first_name,
            'lastName' => $last_name,
            'username' => $username,
            'created_at' => $created_at,
            'roleId' => $role_data['roles_id'],
            'role' => $role_desc['title']
        );

        array_push($users_arr, $user_item);
    }

    echo json_encode($users_arr);
} else {
    echo json_encode(
        array()
    );
}
