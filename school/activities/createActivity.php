<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
	echo FALSE;
	die();
}

$title = $data->title;
$start = $data->start;
$end = $data->end;

if ($_GET['id']) {
	$id = $_GET['id'];
	$sql = "UPDATE activties SET title='$title', event_end='$end' WHERE id='$id'";

} else {
	$sql = "INSERT INTO activties (
				title,
				event_start,
				event_end
			) VALUES (
				'$title',
				'$start',
				'$end'
			)";

}

if ($conn->query($sql) === TRUE) {
	if ($_GET['id']) {
		echo $_GET['id'];
	} else {
    	echo $conn->insert_id;
	}
} else {
	echo FALSE;
}
