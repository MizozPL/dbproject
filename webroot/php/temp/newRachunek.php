<?php
require_once "../config/userLevel.php";

session_start();

$uzytkownik = $_SESSION['uname'];

$sql = "call dodajRachunek(?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("s", $uzytkownik);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_assoc()["returnValue"];
    echo $value;
} catch (mysqli_sql_exception $e) {
    echo -1;
}

$conn->close();
