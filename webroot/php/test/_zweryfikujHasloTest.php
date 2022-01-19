<?php
require_once "../config/userLevel.php";

echo "zweryfikujHasloTest:<br/><br/>";
$uzytkownik = "admin";
$pass = "admin723";

$sql = "call zweryfikujHaslo(?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("s", $uzytkownik);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $return = $result->fetch_assoc();
        if(password_verify($pass, $return["passwordHash"])) {
            echo "Poziom uprawnien: " . $return["permissionLevel"];
            echo "<br/> Hasło poprawne";
        } else {
            echo "<br/> Hasło niepoprawne";
        }
    } else {
        echo "Złe hasło/login";
    }
} catch (mysqli_sql_exception $e) {
    echo "Błąd"; //Jakiś błąd? Raczej nie nastąpi
}

$conn->close();
?>