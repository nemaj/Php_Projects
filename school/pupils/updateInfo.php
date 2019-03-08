<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../conn.php';

$data = json_decode(file_get_contents("php://input"));

$pupilId = $data->pupilId;
$fname = $data->fname;
$lname = $data->lname;
$mname = $data->mname;
$gender = $data->gender;
$birthdate = $data->birthdate;
$birthplace = $data->birthplace;
$address = $data->address;
$level = $data->level;

$sql = "UPDATE pupils SET
            first_name='$fname',
            last_name='$lname',
            middle_name='$mname',
            gender='$gender',
            birthplace='$birthplace',
            address='$address',
            birthdate='$birthdate'
        WHERE id='$pupilId'";

if ($conn->query($sql) === TRUE) {

    $update = $conn->query("UPDATE pupil_level SET level_id='$level' WHERE pupil_id='$pupilId'");

    echo true;

} else {
    echo false;
}
