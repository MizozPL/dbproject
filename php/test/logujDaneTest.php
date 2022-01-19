<?php
require_once "../config/userLevel.php";

echo "logujDaneTest:<br/><br/>";

//W taki sposób sprawdzamy czy dodanie powiodło się
$uzytkownik = "TEST2";
$opis_akcji = "AAAAAAAADDDDDFFFF";

$sql = "call logujDane(?, ?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("ss", $uzytkownik, $opis_akcji);
    $stmt->execute();
    echo "Dodano log"; //Jesli nie ma wyjatku to git
} catch (mysqli_sql_exception $e) {
    echo "Nie dodano/Błąd"; //Dodanie może nie powieść się jeżeli uzytkownik o loginie istnieje
}

$conn->close();
?>