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

$sql = "SELECT * FROM orders GROUP BY code ORDER BY status";
$res = $conn->query($sql);

$return = array();
while ($row = $res->fetch_assoc()) {
	extract($row);
	$dateO = date_create($date);
	$formatD = date_format($dateO, "M j, Y");

	$main_arr = array(
			'code' => $code,
			'date' => $formatD,
			'status' => $status === 1 ? 'Processing' : 'Received',
			'total' => 0,
			'orders' => array()
		);

	$total = 0;

	$getOrders = $conn->query("SELECT * FROM orders WHERE code='$code'");

	while ($order = $getOrders->fetch_assoc()) {

		$getProduct = $conn->query("SELECT * FROM products WHERE id='".$order['product_id']."' AND business_id='$supplierId'");

		if ($getProduct->num_rows > 0) {
			$product = $getProduct->fetch_array();

			$tempTotal = $product['price']*$quantity;
			$discount = $quantity >= '5' ? $tempTotal * 0.05 : 0;
			$price = $tempTotal - $discount;

			$item = array(
					'productId' => $order['product_id'],
					'productName' => $product['name'],
					'productPrice' => $product['price'],
					'quantity' => $order['quantity'],
					'totalPrice' => $price
				);
			$total = $total + $price;
			array_push($main_arr['orders'], $item);
		}
	}
	if ($total) {
		$main_arr['total'] = $total;
		array_push($return, $main_arr);
	}
}

echo json_encode($return);
