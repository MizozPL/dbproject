<?php
require_once "../config/userLevel.php";

echo "dodajRachunekTest:<br/><br/>";

//W taki sposób sprawdzamy czy dodanie powiodło się
$uzytkownik = "TEST";

$sql = "call dodajRachunek(?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("s", $uzytkownik);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_assoc()["returnValue"];
    echo "Dodano, ID:" . $value;
} catch (mysqli_sql_exception $e) {
    echo "Nie dodano/Błąd"; //Powinno się powieść, no chyba że skaszanimy użytkownika, ale powinien być z sesji, więc git
}

$conn->close();
?>