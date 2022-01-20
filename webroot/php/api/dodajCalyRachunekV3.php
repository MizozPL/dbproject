<?php
session_start();

if (!isset($_SESSION["uname"])) {
    header("Location: ../index.php");
}

if ($_SESSION["uprawnienia"] != "sprzedawca" && $_SESSION["uprawnienia"] != "menadzer" && $_SESSION["uprawnienia"] != "administrator") {
    header("Location: ../brakUprawnien.php");
}

require_once "../config/userLevel.php";

if (!isset($_POST["ids"]) || !isset($_POST["ilosci"]) || !isset($_POST["rabaty"])) {
    echo "Błąd";

} else {
    $ids = json_decode($_POST["ids"]);
    $ilosci = json_decode($_POST["ilosci"]);
    $rabaty = json_decode($_POST["rabaty"]);

    $uzytkownik = $_SESSION['uname'];

    $sql = "call dodajRachunek(?);";
    try {
        $conn->begin_transaction();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $uzytkownik);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $rachunek_id = $result->fetch_assoc()["returnValue"];

        for ($i = 0; $i < count($ids); $i++) {
            $sql = "call dodajPozycje(?, ?, ?);";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iid", $ids[$i], $ilosci[$i], $rabaty[$i]);
            $stmt->execute();
            $result = $stmt->get_result();
            $pozycja_id = $result->fetch_assoc()["returnValue"];
            $stmt->close();

            $sql = "call dodajPozycjeDoRachunku(?, ?);";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $rachunek_id, $pozycja_id);
            $stmt->execute();
            $stmt->close();
        }

        $conn->commit();


    } catch (mysqli_sql_exception $e) {
        $conn->rollback();
        $conn->close();
        echo "Błąd";
        return;
    }
    $conn->close();




    echo "Dodano rachunek o id: " . $rachunek_id;
}

?>