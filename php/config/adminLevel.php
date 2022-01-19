<?php
$servername = "localhost";
$username = "administrator";
$password = "";
$dbname = "db_project";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}