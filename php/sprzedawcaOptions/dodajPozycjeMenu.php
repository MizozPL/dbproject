<?php
session_start();

if (!isset($_SESSION["uname"])) {
    header("Location: ../index.php");
}

if ($_SESSION["uprawnienia"] != "sprzedawca" && $_SESSION["uprawnienia"] != "menadzer" && $_SESSION["uprawnienia"] != "administrator") {
    header("Location: ../brakUprawnien.php");
}

if(isset($_POST["Zatwierdź"]) && $_POST["przedmiot"] && $_POST["ilość"] && $_POST["rabat"]){
    require_once "../config/userLevel.php";

    $sql = "call dodajPozycje(?, ?, ?);";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iid", $_POST["przedmiot"], $_POST["ilość"], $_POST["rabat"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $value = $result->fetch_assoc()["returnValue"];
        $_SESSION["returnMessageString"] = "Dodano pozycje o ID: " . $value;

        $log = "Dodano pozycję (" . $value . ", " . $_POST["przedmiot"] . ", " . $_POST["ilość"] . ", " . $_POST["rabat"] . ")";

        $sql = "call logujDane(?, ?);";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $_SESSION["uname"], $log);
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $_SESSION["returnMessageString"] = "Dodano pozycje o ID: " . $value . "\nBłąd zapisywania logów!";
        }

    } catch (mysqli_sql_exception $e) {
        $_SESSION["returnMessageString"] = "Błąd dodania pozycji";
    }

    $conn->close();
}
?>

<!doctype html>
<html>
    <head>
        <title>Dodawanie Pozycji</title>
    </head>
    <body>
        <h1>Dodaj Pozycje:</h1>
        <form method="post">
            <label for="przedmiot">Przedmiot:</label>
            <input id="przedmiot" required="required" type="number" min="0" step="1" name="przedmiot" placeholder="Przedmiot" />
            <label for="ilość">Ilość:</label>
            <input id="ilość" required="required" type="number" min="0" step="1" name="ilość" placeholder="Ilość" />
            <label for="rabat">Rabat:</label>
            <input id="rabat" required="required" type="number" min="0" step="0.01" max="0.99" name="rabat" placeholder="Rabat" />
            <input type="submit" value="Zatwierdź" name="Zatwierdź" />
        </form>
        <p>
            <?php
            if (isset($_SESSION["returnMessageString"])) {
                echo $_SESSION["returnMessageString"];
                unset($_SESSION["returnMessageString"]);
            }
            ?>
        </p>
        <form action="../index.php">
            <input type="submit" value="Powróć" />
        </form>
    </body>
</html>
