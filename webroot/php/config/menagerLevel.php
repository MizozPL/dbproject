<?php
$ini_array = parse_ini_file($_SERVER["DOCUMENT_ROOT"]."/outside-webroot/credentials.ini");
$conn = new mysqli($ini_array["database_address"], $ini_array["menager_login"], $ini_array["menager_password"], $ini_array["database_name"]);
$ini_array = "";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}