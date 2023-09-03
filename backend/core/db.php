<?php

require_once("backend/config/env.php");

$hostname = EnvironmentVar::hostname;
$username = EnvironmentVar::username;
$password = EnvironmentVar::password;
$dbname = EnvironmentVar::dbname;
$port = EnvironmentVar::port;

try {
    $conn = new mysqli($hostname, $username, $password, $dbname, $port);
} catch (Exception $e) {
    echo $e->getMessage();
}

//if connection is successfully you will see message below
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
