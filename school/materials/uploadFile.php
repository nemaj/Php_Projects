<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$fileName = $_FILES['file']['name'];
$fileTemp = $_FILES['file']['tmp_name'];
$fileError = $_FILES['file']['error'];
$fileType = $_FILES['file']['type'];
$name = $_POST['name'];

$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));

if ($fileError) {
	echo "File has Error";
	die();
}

$randName = uniqid('', true).'.'.$fileActualExt;

$location = '../docs/'.$randName;

move_uploaded_file($fileTemp, $location);

$sql = "INSERT INTO materials
		(name, type, filename)
		VALUES
		('$name', '$fileType', '$randName')";

if ($conn->query($sql) === TRUE) {
	echo $conn->insert_id;
}else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

