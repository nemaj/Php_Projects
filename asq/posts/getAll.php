<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$sql = 'SELECT * FROM posts';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $posts_arr = array(
        'data' => array()
    );

    while ($row = $result->fetch_assoc()) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'created_at' => $created_at
        );

        array_push($posts_arr['data'], $post_item);
    }

    echo json_encode($posts_arr);
} else {
    echo json_encode(
        array(
            'message' => 'No Posts Found'
        )
    );
}

