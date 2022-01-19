<?php
require_once "../config/adminLevel.php";

echo "dodajUzytkownikaTest:<br/><br/>";

//W taki sposób sprawdzamy czy dodanie powiodło się
$uzytkownik = "TEST2";
$pass = "test2";
$poziom_uprawnien = "administrator";
$passHash =  password_hash($pass, PASSWORD_ARGON2ID);

$sql = "call dodajUzytkownika(?, ?, ?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("sss", $uzytkownik, $passHash, $poziom_uprawnien);
    $stmt->execute();
    echo "Dodano"; //Naszym id login
} catch (mysqli_sql_exception $e) {
    echo "Nie dodano/Błąd"; //Dodanie może nie powieść się jeżeli uzytkownik o loginie istnieje/skkopalismy enum
}

$conn->close();
?>