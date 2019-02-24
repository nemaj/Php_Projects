<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$sql = "SELECT * FROM users WHERE id!='1'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $products = array();

    while ($row = $result->fetch_assoc()) {
        extract($row);

        $getRole = $conn->query("SELECT * FROM user_role WHERE users_id='$id'");
        $role = $getRole->fetch_array();

        $roleD = $conn->query("SELECT * FROM roles WHERE id='".$role['role_id']."'");
        $roleDesc = $roleD->fetch_array();

        $item = array(
            'id' => $id,
            'firstName' => ucwords($first_name),
            'lastName' => ucwords($last_name),
            'username' => $username,
            'role' => $role['role_id'],
            'roleDesc' => $roleDesc['title'],
            'createdAt' => $created_at
        );

        array_push($products, $item);
    }

    echo json_encode($products);
} else {
    echo json_encode(array());
}