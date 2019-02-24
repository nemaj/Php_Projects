<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: multipart/form-data; boundary=MultipartBoundry');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$sql = "SELECT * FROM products ORDER BY RAND() LIMIT 6";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $products = array();

    while ($row = $result->fetch_assoc()) {
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
    echo json_encode(
        array(
            'message' => 'No Products Found'
        )
    );
}