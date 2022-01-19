<?php
require_once "../config/userLevel.php";

echo "zweryfikujHasloTest:<br/><br/>";
$uzytkownik = "TEST2";
$pass = "xxxxx";

$sql = "call zweryfikujHaslo(?, ?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("ss", $uzytkownik, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        echo "Poziom uprawnien: " . $result->fetch_assoc()["returnValue"];
    } else {
        echo "Złe hasło/login";
    }
} catch (mysqli_sql_exception $e) {
    echo "Błąd"; //Jakiś błąd? Raczej nie nastąpi
}

$conn->close();
?>