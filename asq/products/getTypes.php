<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$sql = "SELECT * FROM product_type";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $types = array();

    while ($row = $result->fetch_assoc()) {
        extract($row);

        $item = array(
            'id' => $id,
            'type' => $type
        );

        array_push($types, $item);
    }

    echo json_encode($types);
} else {
    echo json_encode(
        array(
            'message' => 'No Product Types Found'
        )
    );
}
