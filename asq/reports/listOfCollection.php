<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$sql = "SELECT *, EXTRACT( YEAR FROM `date` ) as year, EXTRACT( MONTH FROM `date` ) as month FROM orders WHERE status=2 GROUP BY MONTH(date), YEAR(date) ORDER BY id DESC";
$res = $conn->query($sql);

$return = array();
while ($row = $res->fetch_assoc()) {
	$month = $row['month'];
	$year = $row['year'];

	$dateO = date_create($row['date']);
	$formatD = date_format($dateO, "M Y");

	$main_arr = array(
			'date' => $formatD,
			'month' => $month,
			'year' => $year,
			'total' => 0,
			'orders' => array()
		);

	$total = 0;

	$get = $conn->query("SELECT * FROM orders WHERE YEAR(date)='$year' AND MONTH(date)='$month' AND status=2");

	while ($data = $get->fetch_assoc()) {
		extract($data);

		$getProduct = $conn->query("SELECT * FROM products WHERE id='$product_id'");
		$product = $getProduct->fetch_array();

		$tempTotal = $product['price']*$quantity;
		$discount = $quantity >= '5' ? $tempTotal * 0.05 : 0;
		$price = $tempTotal - $discount;
		$dateOrder = date_create($date);
		$formatDate = date_format($dateOrder, "M j, Y");

		$item = array(
				'code' => $code,
				'productId' => $product_id,
				'productName' => $product['name'],
				'productPrice' => $product['price'],
				'quantity' => $quantity,
				'totalPrice' => $price,
				'formatDate' => $formatDate,
				'date' => $date
			);
		$total = $total + $price;
		array_push($main_arr['orders'], $item);
	}
	$main_arr['total'] = $total;
	array_push($return, $main_arr);
}

echo json_encode($return);
