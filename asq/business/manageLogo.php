<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: multipart/form-data; boundary=MultipartBoundry');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	die();
}

$id = $data->businessId;
$logo = $data->logo;

$check_sql = $conn->query("SELECT * FROM business_logo WHERE business_id='$id'");

if ($check_sql->num_rows > 0) {

	$sql = "UPDATE business_logo SET
			logo='$logo'
			WHERE business_id='$id'";

} else {

	$sql = "INSERT INTO business_logo
			(business_id, logo)
			VALUES
			('$id', '$logo')";

}

if ($conn->query($sql) === TRUE) {
	echo true;
}else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



