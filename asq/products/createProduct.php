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

$name = $data->name;
$type = $data->type;
$unit = $data->unit;
$desc = $data->desc;
$price = $data->price;
$stock = $data->stock;
$businessId = $data->business_id;

if (isset($_GET['id'])){
	$id = $_GET['id'];

	$sql = "UPDATE products SET
			name='$name',
			type='$type',
			unit='$unit',
			description='$desc',
			price='$price',
			stock='$stock'
			WHERE id='$id'";

	if ($conn->query($sql) === TRUE) {
		echo true;
	} else {
	    echo false;
	}

	die();
}

$sql = "INSERT INTO products
		(
			name,
			type,
			unit,
			description,
			price,
			stock,
			business_id
		) VALUES (
			'$name',
			'$type',
			'$unit',
			'$desc',
			'$price',
			'$stock',
			'$businessId'
		)";

if ($conn->query($sql) === TRUE) {
	echo $conn->insert_id;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}