<?php
session_start();

if (!isset($_SESSION["uname"])) {
    header("Location: ../index.php");
}

if ( $_SESSION["uprawnienia"] != "menadzer" && $_SESSION["uprawnienia"] != "administrator") {
    header("Location: ../brakUprawnien.php");
}

if(isset($_POST["Zatwierdz"]) && isset($_POST["id"]) && isset($_POST["cena"]) && isset($_POST["vat"]) && isset($_POST["nazwa"])){
    require_once "../config/menagerLevel.php";

    $sql = "call edytujPrzedmiot(?, ?, ?, ?);";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("idds", $_POST["id"], $_POST["cena"], $_POST["vat"], $_POST["nazwa"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $_SESSION["returnMessageString"] = "Zmieniono przedmiot o ID: " . $_POST["id"];

        $log = "Zmieniono przedmiot (" . $_POST["id"] . ", " . $_POST["cena"] . ", " . $_POST["vat"] . ", " . $_POST["nazwa"] . ")";

        $sql = "call logujDane(?, ?);";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $_SESSION["uname"], $log);
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $_SESSION["returnMessageString"] = "Zmieniono przedmiot o ID: " . $_POST["id"] . "\nBłąd zapisywania logów!";
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION["returnMessageString"] = "Błąd zmiany przedmiotu";
    }

    $conn->close();
}
?>

<!doctype html>
<html>
    <head>
        <title>Edytowanie Przedmiotu</title>
    </head>
    <body>
        <h1>Edytuj przedmiot:</h1>
        <form method="post">
            <label for="id">ID:</label><br>
            <input id="id" required="required" type="number" min="0" step="1" name="id" placeholder="ID" /><br>
            <label for="cena">Cena:</label><br>
            <input id="cena" required="required" type="number" min="0" step="0.01" name="cena" placeholder="Cena" /><br>
            <label for="vat">Vat:</label><br>
            <input id="vat" required="required" type="number" min="0" step="0.01" max="0.99" name="vat" placeholder="Vat" /><br>
            <label for="nazwa">Nazwa:</label><br>
            <input id="nazwa" required="required" type="text" name="nazwa" placeholder="Nazwa" /><br>
            <input type="submit" value="Zatwierdź" name="Zatwierdz" />
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
