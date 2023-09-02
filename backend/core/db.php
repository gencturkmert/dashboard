<?php

$hostname = "localhost";
$username = "dashboard_user";
$password = "12341234";
$dbname = "dashboard";

try {
    $conn = new mysqli($hostname, $username, $password, $dbname, 3306);
} catch (Exception $e) {
    echo $e->getMessage();
}

//if connection is successfully you will see message below
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
