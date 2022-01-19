<?php
require_once "../config/adminLevel.php";

echo "edytujUzytkownikaTest:<br/><br/>";
$uzytkownik = "TEST2";
$pass = "xxxxx";
$poziom_uprawnien = "sprzedawca";

$sql = "call edytujUzytkownika(?, ?, ?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("sss", $uzytkownik, $pass, $poziom_uprawnien);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_assoc()["returnValue"];
    if($value == 1) {
        echo "Edytowano";
    } else {
        echo "Nie edytowanp";
    }
} catch (mysqli_sql_exception $e) {
    echo "Błąd"; //Edycja może się nie powieść jeśli o nazwie nie istnieje
}

$conn->close();
?>