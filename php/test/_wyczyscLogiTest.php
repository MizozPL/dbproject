<?php
require_once "../config/adminLevel.php";

echo "wyczyscLogiTest:<br/><br/>";
$sql = "call wyczyscLogi();";
try {
    $result = $conn->query($sql);
    echo "Wyczyszczono";
} catch (mysqli_sql_exception $e) {
    echo "Błąd"; //Jakiś błąd? Raczej nie nastąpi
}

$conn->close();
?>