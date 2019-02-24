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

$sql = "SELECT * FROM barangay WHERE brgyDesc LIKE '$data->address%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

	$res = array();

	while ($item = $result->fetch_assoc()) {
		array_push($res, $item);
	}
    // $brgy = $result->fetch_assoc();

    echo json_encode($res);
} else {
    echo json_encode(
        array(
            'message' => 'No Barangay Found'
        )
    );
}
