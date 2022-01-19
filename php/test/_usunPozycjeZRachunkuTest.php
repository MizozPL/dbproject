<?php
require_once "../config/menagerLevel.php";

echo "usunPozycjeZRachunkuTest:<br/><br/>";
$rachunek = 3;
$pozycja = 3;

$sql = "call usunPozycjeZRachunku(?, ?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("ii", $rachunek, $pozycja);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_assoc()["returnValue"];
    if($value == 1) {
        echo "Usunięto";
    } else {
        echo "Nie usunięto";
    }
} catch (mysqli_sql_exception $e) {
    echo "Błąd"; //Usunięcie powinno zawsze dzialac
}

$conn->close();
?>