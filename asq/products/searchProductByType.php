<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	echo json_encode(array());
	die();
}

$id = $_GET['id'];

$product_res = $conn->query("SELECT * FROM products WHERE type='$id'");

if ($product_res->num_rows > 0) {
    $products = array();

    while ($row = $product_res->fetch_assoc()) {
        extract($row);

        $image = $conn->query("SELECT * FROM product_image WHERE product_id='$id'");
        $image_arr = $image->fetch_array();

        $item = array(
            'id' => $id,
            'name' => $name,
            'type' => $type,
            'description' => $description,
            'price' => $price,
            'stock' => $stock,
            'image' => $image_arr['image'],
            'businessId' => $business_id
        );

        array_push($products, $item);
    }

    echo json_encode($products);

} else {
	echo json_encode(array());
}
