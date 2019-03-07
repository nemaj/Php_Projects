<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$get = $conn->query("SELECT * FROM activties WHERE event_start >= CURRENT_DATE() ORDER BY event_start ASC LIMIT 1");

if ($get->num_rows > 0) {
	extract($get->fetch_array());

	$date1 = strtotime(date("Y-m-d"));  
	$date2 = strtotime($event_start);  
	  
	// Formulate the Difference between two dates 
	$diff = abs($date2 - $date1);
	$years = floor($diff / (365*60*60*24)); 
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 -  
             $months*30*60*60*24)/ (60*60*24)); 

	$item = array(
			'id' => $id,
			'title' => $title,
			'start' => $event_start,
			'end' => $event_end == $event_start ? '' : $event_end,
			'formatDate' => date('F j', strtotime($event_start)),
			'days' => "$days"
		);

	echo json_encode($item);
} else {
	echo json_encode(new stdClass());
}
