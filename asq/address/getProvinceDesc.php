<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data)) {
    die();
}

$sql = "SELECT * FROM province WHERE provCode='$data->code'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $brgy = $result->fetch_array();

    echo json_encode($brgy);
} else {
    echo json_encode(
        array(
            'message' => 'No Province Found'
        )
    );
}
