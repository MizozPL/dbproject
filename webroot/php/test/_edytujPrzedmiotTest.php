<?php
require_once "../config/menagerLevel.php";

echo "edytujPrzedmiotTest:<br/><br/>";

//Cena dowolna z dwoma miejscami po przecinku, vat od 0 do 0.99 - sql obcina, czyli tutaj będzie 0.99, tak samo obcina nazwę...
//W taki sposób sprawdzamy czy edycja powiodła się, raczej zawsze powinna (najwyżej 0 rekordów)
$id = 1;
$cena = 15;
$vat = 1;
$nazwa = "ItemAXXBX";

$sql = "call edytujPrzedmiot(?, ?, ?, ?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("idds", $id,$cena, $vat, $nazwa);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_assoc()["returnValue"];
    if($value == 1) {
        echo "Edytowano/Zaktualizowano";
    } else {
        echo "Nie edytowano/Złe ID";
    }
} catch (mysqli_sql_exception $e) {
    echo "Błąd"; //Edycja powinna zawsze się powieść - najwyżej 0 rekordów...
}

$conn->close();
?>