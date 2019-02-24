<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
    die();
}

$productId = $_GET['id'];

$res = $conn->query("SELECT * FROM product_image WHERE product_id='$productId'");
if ($res->num_rows > 0) {
	$images = array();

    while ($row = $res->fetch_assoc()) {
        extract($row);
		$item = array(
			'id' => $id,
			'image' => $image
		);
        array_push($images, $item);
    }

	echo json_encode($images);
} else {
	echo false;
}