<?php
require_once "../config/userLevel.php";

$rachunek = $_POST['rachunek'];
$pozycja = $_POST['pozycja'];

$sql = "call dodajPozycjeDoRachunku(?, ?);";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $rachunek, $pozycja);
    $stmt->execute();
    echo "Dodano";
} catch (mysqli_sql_exception $e) {
    echo "Nie dodano/Błąd";
}

$conn->close();
