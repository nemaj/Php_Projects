<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	echo json_encode(array());
	die();
}

$budget = $data->budget;
$type = $data->type;

$sql = $conn->query("SELECT * FROM products WHERE type=$type AND price<=$budget AND stock>0");

if ($sql->num_rows > 0) {
	$result = array();

	while ($row = $sql->fetch_assoc()) {
		extract($row);

		$getImage = $conn->query("SELECT * FROM product_image WHERE product_id='$id'");
		$imageArr = $getImage->fetch_array();

		$item = array(
				'id' => $id,
				'name' => $name,
				'description' => $description,
				'price' => $price,
				'image' => $imageArr['image']
			);

		array_push($result, $item);

	}
	echo json_encode($result);

} else {
	echo json_encode(array());
}