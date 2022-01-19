<?php
require_once "../config/userLevel.php";

echo "dodajPozycjeDoRachunkuTest:<br/><br/>";
$rachunek = 3;
$pozycja = 3;

$sql = "call dodajPozycjeDoRachunku(?, ?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("ii", $rachunek, $pozycja);
    $stmt->execute();
    echo "Dodano"; //Naszym id jest para pozycja, rachunek
} catch (mysqli_sql_exception $e) {
    echo "Nie dodano/Błąd"; //Dodanie może nie powieść się jeżeli pozycja lub rachunek nie istnieja, lub jeśli już para pozycja-rachunek istnieje
}

$conn->close();
?>