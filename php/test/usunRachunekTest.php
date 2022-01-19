<?php
require_once "../config/userLevel.php";

echo "usunRachunekTest:<br/><br/>";
$id = 1;
$sql = "call usunRachunek(?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_assoc()["returnValue"];
    if($value == 1) {
        echo "Usunięto";
    } else {
        echo "Nie usunięto";
    }
} catch (mysqli_sql_exception $e) {
    echo "Błąd"; //Usunięcie powinno się powieść, w sensie,  bez błędów
}

$conn->close();
?>