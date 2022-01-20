<?php
require_once "../config/userLevel.php";

$przedmiot = $_POST['id'];
$ilosc = $_POST['ilosc'];
$rabat = $_POST['rabat'];

$sql = "call dodajPozycje(?, ?, ?);";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iid", $przedmiot, $ilosc, $rabat);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_assoc()["returnValue"];
    echo $value;
} catch (mysqli_sql_exception $e) {
    echo -1;
}

$conn->close();
