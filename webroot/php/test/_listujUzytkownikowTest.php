<?php
require_once "../config/adminLevel.php";

echo "listujUzytkownikowTest:<br/><br/>";
$sql = "call listujUzytkownikow();";
try {
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "login: " . $row["login"]. " - poziom_uprawnien: " . $row["poziom_uprawnien"] ."<br>";
        }
    } else {
        echo "0 results";
    }
} catch (mysqli_sql_exception $e) {
    echo "Błąd"; //Jakiś błąd? Raczej nie nastąpi
}

$conn->close();
?>