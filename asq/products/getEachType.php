<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])){
    die();
}

$typeId = $_GET['id'];

$sql = "SELECT * FROM product_type WHERE id='$typeId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $type = $result->fetch_array();

    echo json_encode($type);
} else {
    echo json_encode(
        array(
            'message' => 'No Product Types Found'
        )
    );
}
