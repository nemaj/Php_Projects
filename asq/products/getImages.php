<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])){
	echo json_encode((object) array());
    die();
}

$productId = $_GET['id'];

$getImages = $conn->query("SELECT * FROM product_image WHERE product_id='$productId'");

if ($getImages->num_rows > 0) {
	$result = array();

	while ($row = $getImages->fetch_assoc()) {
		extract($row);

		$item = array(
				'image' => $image
			);

		array_push($result, $item);
	}
	echo json_encode($result);

} else {
	echo json_encode((object) array());
}