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

$res = $conn->query("SELECT * FROM products WHERE id='$productId'");
if ($res->num_rows > 0) {
	$item = $res->fetch_array();

    $image = $conn->query("SELECT * FROM product_image WHERE product_id='".$item['id']."'");
    $image_arr = $image->fetch_array();

    $review_get = $conn->query("SELECT * FROM feedback WHERE product_id='".$item['id']."'");

	$getType = $conn->query("SELECT * FROM product_type WHERE id='".$item['type']."'");
	$typeInfo = $getType->fetch_array();

    $productTotal = 0;
    $reviewCount = 0;

    if ($review_get->num_rows > 0) {
    	while ($review = $review_get->fetch_assoc()) {
    		$productTotal = $productTotal + $review['rate'];
    		$reviewCount++;
    	}
    }

    $unitInfo = (object) array();
    if ($item['unit']) {
    	$getUnit = $conn->query("SELECT * FROM product_unit WHERE id='".$item['unit']."'");

    	$unitInfo = $getUnit->fetch_array();
    }

    $productRate = $reviewCount ? $productTotal / $reviewCount : 0;

	$info = array(
		'id' => $item['id'],
		'name' => $item['name'],
		'type' => $item['type'],
		'typeDesc' => $typeInfo['type'],
		'unit' => $item['unit'] ? $item['unit'] : '',
		'unitInfo' => $unitInfo,
		'description' => $item['description'],
		'price' => $item['price'],
		'stock' => $item['stock'],
		'image' => $image_arr['image'],
		'businessId' => $item['business_id'],
		'rate' => $productRate,
		'reviewCounts' => $reviewCount
	);

	echo json_encode($info);
} else {
	echo false;
}