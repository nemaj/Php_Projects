<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < 15; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
}

$data = json_decode(file_get_contents("php://input"));

if (!$data) {	
	die();
}

$products = $data->products;

foreach ($products as $value) {
	$usersId = $value->usersId;
	$cartId = $value->cartId;
	$productId = $value->productId;
	$quantity = $value->quantity;

	$sql = "INSERT INTO orders (
				code,
				user_id,
				product_id,
				quantity,
				status
			) VALUES (
				'$randomString',
				'$usersId',
				'$productId',
				'$quantity',
				'1'
			)";

	if ($conn->query($sql) === TRUE) {

		$product_get = $conn->query("SELECT stock FROM products WHERE id='$productId'");
		$product_info = $product_get->fetch_array();
		$newStock = $product_info['stock'] - $quantity;

		$update = $conn->query("UPDATE products SET stock='$newStock' WHERE id='$productId'");
		$remove = $conn->query("DELETE FROM customer_cart WHERE id='$cartId'");

	} else {
    	echo "Error: " . $sql . "<br>" . $conn->error;
		die();
	}
}

echo true;

