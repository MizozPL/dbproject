<?php
require_once "../config/userLevel.php";

echo "usunUzytkownikaTest:<br/><br/>";
$uzytkownik = "TEST2";

$sql = "call usunUzytkownika(?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("s", $uzytkownik);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_assoc()["returnValue"];
    if($value == 1) {
        echo "Usunięto";
    } else {
        echo "Nie usunięto";
    }
} catch (mysqli_sql_exception $e) {
    echo "Błąd"; //Usunięcie może się nie powieść jeśli użytkownik jest np. w logach/rachunkach
}

$conn->close();
?>