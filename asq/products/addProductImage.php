<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: multipart/form-data; boundary=MultipartBoundry');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

// var_dump($_FILES);

// $tempPath = $_POST['path'];
// $actualName = $_FILES['file']['name'];

// $actualPath = "http://localhost:8080/#/assets/products/".$actualName;

// echo json_encode(array(
// 		'tempPath' => $tempPath,
// 		'actualPath' => $actualPath
// 	));

// if (move_uploaded_file($tempPath, $actualPath)) {
// 	echo true;
// }

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	die();
}

$id = $data->productId;
$image = $data->image;

$sql = "INSERT INTO product_image
		(product_id, image)
		VALUES
		('$id', '$image')";

if ($conn->query($sql) === TRUE) {
	echo true;
}else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



