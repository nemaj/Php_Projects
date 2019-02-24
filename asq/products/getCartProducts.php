<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	die();
}

$id = $_GET['id'];

$sql = "SELECT * FROM customer_cart WHERE user_id='$id' GROUP BY business_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $return = array();

    while ($row = $result->fetch_assoc()) {
        extract($row);

        $cart_sql = $conn->query("SELECT * FROM customer_cart WHERE business_id='$business_id' AND user_id='$user_id'");

        $supplier_sql = $conn->query("SELECT * FROM business_info WHERE id='$business_id'");
        $supplier_value = $supplier_sql->fetch_array();

        $supplier_arr = array(
            'info' => array(
                'business_id' => $business_id,
                'name' => $supplier_value['name']
                ),
            'products' => array()
        );

        while ($cart = $cart_sql->fetch_assoc()) {
            $prod_id = $cart['product_id'];

            $product_sql = $conn->query("SELECT * FROM products WHERE id='$prod_id'");
            $prod_info = $product_sql->fetch_array();

            $image = $conn->query("SELECT * FROM product_image WHERE product_id='$prod_id'");
            $image_arr = $image->fetch_array();

            $item = array(
                'id' => $cart['id'],
                'product_id' => $prod_id,
                'name' => $prod_info['name'],
                'price' => $prod_info['price'],
                'description' => $prod_info['description'],
                'image' => $image_arr['image'],
                'stock' => $prod_info['stock'],
                'quantity' => $cart['quantity']
            );

            array_push($supplier_arr['products'], $item);
        }

        array_push($return, $supplier_arr);
    }

    echo json_encode($return);
} else {
    echo json_encode(
        array()
    );
}
