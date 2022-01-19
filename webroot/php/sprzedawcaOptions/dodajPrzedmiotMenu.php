<?php
session_start();

if (!isset($_SESSION["uname"])) {
    header("Location: ../index.php");
}

if ($_SESSION["uprawnienia"] != "sprzedawca" && $_SESSION["uprawnienia"] != "menadzer" && $_SESSION["uprawnienia"] != "administrator") {
    header("Location: ../brakUprawnien.php");
}

if(isset($_POST["Zatwierdź"]) && isset($_POST["cena"]) && isset($_POST["vat"]) && isset($_POST["nazwa"])){
    require_once "../config/userLevel.php";

    $sql = "call dodajPrzedmiot(?, ?, ?);";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dds", $_POST["cena"], $_POST["vat"], $_POST["nazwa"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $value = $result->fetch_assoc()["returnValue"];
        $_SESSION["returnMessageString"] = "Dodano przedmiot o ID: " . $value;

        $log = "Dodano przedmiot (" . $value . ", " . $_POST["cena"] . ", " . $_POST["vat"] . ", " . $_POST["nazwa"] . ")";

        $sql = "call logujDane(?, ?);";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $_SESSION["uname"], $log);
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $_SESSION["returnMessageString"] = "Dodano przedmiot o ID: " . $value . "\nBłąd zapisywania logów!";
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION["returnMessageString"] = "Błąd dodania przedmiotu";
    }

    $conn->close();
}
?>

<!doctype html>
<html>
    <head>
        <title>Dodawanie Przedmiotu</title>
    </head>
    <body>
        <h1>Dodaj przedmiot:</h1>
        <form method="post">
            <label for="cena">Cena:</label>
            <input id="cena" required="required" type="number" min="0" step="0.01" name="cena" placeholder="Cena" />
            <label for="vat">Vat:</label>
            <input id="vat" required="required" type="number" min="0" step="0.01" max="0.99" name="vat" placeholder="Vat" />
            <label for="nazwa">Nazwa:</label>
            <input id="nazwa" required="required" type="text" name="nazwa" placeholder="Nazwa" />
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
