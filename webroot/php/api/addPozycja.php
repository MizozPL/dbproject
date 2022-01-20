<?php
require_once "../config/userLevel.php";

$przedmiot = $_POST['id'];
$ilosc = $_POST['ilosc'];
$rabat = $_POST['rabat'];

//id zmienione

if(!is_int($ilosc)) {
    $ilosc = 1;
}

if($ilosc <= 0) {
    $ilosc = 1;
}

if(!is_float($rabat)) {
    $rabat = 0;
}

if($rabat < 0 || $rabat >= 1) {
    $rabat = 0;
}

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
