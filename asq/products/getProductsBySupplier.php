<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: multipart/form-data; boundary=MultipartBoundry');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
	die();
}

$id = $_GET['id'];

// $sql_info = "SELECT * FROM business_info WHERE users_id='$id'";
// $info = $conn->query($sql_info);

// if ($info->num_rows === 0) {
// 	die();
// }

// $info_arr = $info->fetch_array();

$sql = "SELECT * FROM products WHERE business_id='$id'";
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
            'image' => $image_arr['image']
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
