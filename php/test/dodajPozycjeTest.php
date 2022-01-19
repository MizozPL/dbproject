<?php
require_once "../config/userLevel.php";

echo "dodajPozycjeTest:<br/><br/>";

//rabat od 0 do 0.99 - sql obcina, czyli tutaj będzie 0.99, tak samo obcina nazwę...
//W taki sposób sprawdzamy czy dodanie powiodło się
$przedmiot = 1;
$ilosc = 919;
$rabat = 999;

$sql = "call dodajPozycje(?, ?, ?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("iid", $przedmiot, $ilosc, $rabat);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_assoc()["returnValue"];
    echo "Dodano, ID:" . $value;
} catch (mysqli_sql_exception $e) {
    echo "Nie dodano/Błąd"; //Dodanie może nie powieść się jeżeli nie ma id przedmiotu.
}

$conn->close();
?>