<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

$new_array = array();
$return = true;

foreach ($data as $row) {
	// array_push($new_array, $row);
	$sql = "INSERT INTO barangay 
		(brgyCode,brgyDesc,regCode,provCode,citymunCode) 
		VALUES 
		(
			'".$row->brgyCode."', 
			'".$row->brgyDesc."', 
			'".$row->regCode."', 
			'".$row->provCode."', 
			'".$row->citymunCode."'
		)";
	if ($conn->query($sql)===TRUE) {
		$return = true;
	} else {
		echo "Error: ". $conn->error;
		echo "</br> SQL: ".$sql;
		die();
	}
}

// echo json_encode($new_array);
echo "Ok";