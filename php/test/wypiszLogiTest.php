<?php
require_once "../config/adminLevel.php";

echo "wypiszLogiTest:<br/><br/>";
$sql = "call wypiszLogi();";
try {
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. " - data: " . $row["data"]. " uzytkownik: " . $row["uzytkownik"]. " opis_akcji:". $row["opis_akcji"] ."<br>";
        }
    } else {
        echo "0 results";
    }
} catch (mysqli_sql_exception $e) {
    echo "Błąd"; //Jakiś błąd? Raczej nie nastąpi
}

$conn->close();
?>