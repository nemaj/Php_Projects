<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {	
	die();
}

$usersId = $data->usersId;
$productId = $data->productId;
$businessId = $data->businessId;
$quantity = $data->quantity;

$check_res = $conn->query("SELECT * FROM customer_cart WHERE product_id='$productId' AND user_id='$usersId'");

if ($check_res->num_rows > 0) {
	$cart_info = $check_res->fetch_array();
	$cart_id = $cart_info['id'];
	$newQuantity = $cart_info['quantity'] + $quantity;

	$product_get = $conn->query("SELECT stock FROM products WHERE id='$productId'");

	$product_info = $product_get->fetch_array();

	$productQuantity = $newQuantity > $product_info['stock'] ? $product_info['stock'] : $newQuantity;

	$update = "UPDATE customer_cart SET quantity='$productQuantity' WHERE id='$cart_id'";

	if ($conn->query($update) === TRUE) {
		echo true;
	} else {
		echo false;
	}

	die();
}

$sql = "INSERT INTO customer_cart (
			user_id,
			product_id,
			business_id,
			quantity
		) VALUES (
			'$usersId',
			'$productId',
			'$businessId',
			'$quantity'
		)";

if ($conn->query($sql) === TRUE) {
	echo $conn->insert_id;
} else {
	echo false;
}