<?php
require_once "../config/menagerLevel.php";

echo "edytujPozycjeTest:<br/><br/>";

//rabat od 0 do 0.99 - sql obcina, czyli tutaj będzie 0.99, tak samo obcina nazwę.....
//W taki sposób sprawdzamy czy edycja się powiodła
$id = 3;
$przedmiot = 1;
$ilosc = 122;
$rabat = 0.11;

$sql = "call edytujPozycje(?, ?, ?, ?);";
try {
    $stmt = $conn->prepare($sql); //podkreśla, ale git
    $stmt->bind_param("iiid", $id,$przedmiot, $ilosc, $rabat);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_assoc()["returnValue"];
    echo $value;
    if($value == 1) {
        echo "Edytowano/Zaktualizowano";
    } else {
        echo "Nie edytowano/Złe ID";
    }
} catch (mysqli_sql_exception $e) {
    echo "Błąd"; //Edycja może się nie powieść jeśli zmienimy id przedmiotu na nieistniejące
}

$conn->close();
?>