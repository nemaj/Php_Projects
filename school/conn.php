<?php

$conn = mysqli_connect("localhost","root","","iup_new");

if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>