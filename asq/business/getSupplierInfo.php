<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

if (!isset($_GET['id'])) {
    die();
}

$id = $_GET['id'];

$sql = "SELECT * FROM business_info WHERE users_id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $info = $result->fetch_array();

    $logo_query = $conn->query("SELECT * FROM business_logo WHERE business_id='".$info['id']."'");
    $isLogoExist = false;
    if ($logo_query->num_rows > 0) {
        $logo_res = $logo_query->fetch_array();
        $isLogoExist = true;
    }

    $item = array(
        'id' => $info['id'],
        'name' => $info['name'],
        'license' => $info['license'],
        'address' => $info['address'],
        'contactNumber' => $info['contact_number'],
        'isLogoExist' => $isLogoExist,
        'logo' => $isLogoExist ? $logo_res['logo'] : null
    );

    echo json_encode($item);
} else {
    echo json_encode(
        array(
            'message' => 'No Users Found'
        )
    );
}
