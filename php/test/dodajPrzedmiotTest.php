<?php
require_once "../config/userLevel.php";

echo "dodajPrzedmiotTest:<br/><br/>";

//Cena dowolna z dwoma miejscami po przecinku, vat od 0 do 0.99 - sql obcina, czyli tutaj będzie 0.99, tak samo obcina nazwę...
//W taki sposób sprawdzamy czy dodanie powiodło się, raczej zawsze powinno
$cena = 10;
$vat = 0.99;
$nazwa = "ItemAAAAAAAAA";

$sql = "call dodajPrzedmiot(?, ?, ?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("dds", $cena, $vat, $nazwa);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_assoc()["returnValue"];
    echo "Dodano, ID:" . $value;
} catch (mysqli_sql_exception $e) {
    echo "Nie dodano/Błąd"; //Dodanie powinno zawsze się powieść
}

$conn->close();
?>