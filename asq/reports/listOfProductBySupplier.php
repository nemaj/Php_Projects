<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	die();
}

$supplierId = $_GET['id'];

$products =$conn->query("SELECT * FROM products WHERE business_id='$supplierId'");

$list = array();

while ($row = $products->fetch_assoc()) {
	extract($row);

	$getInfo = $conn->query("SELECT * FROM product_type WHERE id='$type'");
	$info = $getInfo->fetch_array();

	$item = array(
			'id' => $id,
			'name' => $name,
			'typeId' => $type,
			'type' => $info['type'],
			'description' => $description,
			'price' => $price,
			'stock' => $stock
		);

	array_push($list, $item);
}

echo json_encode($list);