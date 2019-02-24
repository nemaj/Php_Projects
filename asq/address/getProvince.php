<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$sql = "SELECT * FROM province WHERE regCode=12";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users_arr = array();

    while ($row = $result->fetch_assoc()) {
        extract($row);

        $user_item = array(
            'id' => $id,
            'provCode' => $provCode,
            'provDesc' => $provDesc,
        );

        array_push($users_arr, $user_item);
    }

    echo json_encode($users_arr);
} else {
    echo json_encode(
        array(
            'message' => 'No City Found'
        )
    );
}

