<?php
session_start();

if (!isset($_SESSION["uname"])) {
    header("Location: ../index.php");
}

if ($_SESSION["uprawnienia"] != "sprzedawca" && $_SESSION["uprawnienia"] != "menadzer" && $_SESSION["uprawnienia"] != "administrator") {
    header("Location: ../brakUprawnien.php");
}

if(isset($_POST["Zatwierdź"]) && isset($_POST["rachunek"]) && isset($_POST["pozycja"])){
    require_once "../config/userLevel.php";

    $sql = "call dodajPozycjeDoRachunku(?, ?);";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $_POST["rachunek"], $_POST["pozycja"]);
        $stmt->execute();
        $stmt->close();
        $_SESSION["returnMessageString"] = "Dodano pozycję do rachunku (" . $_POST["rachunek"] . ", " . $_POST["pozycja"] . ")";

        $log = "Dodano pozycję do rachunku (" . $_POST["rachunek"] . ", " . $_POST["pozycja"] . ")";

        $sql = "call logujDane(?, ?);";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $_SESSION["uname"], $log);
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $_SESSION["returnMessageString"] = "Dodano pozycję do rachunku (" . $_POST["rachunek"] . ", " . $_POST["pozycja"] . ")" . "\nBłąd zapisywania logów!";
        }

    } catch (mysqli_sql_exception $e) {
        $_SESSION["returnMessageString"] = "Błąd dodawania pozycji";
    }

    $conn->close();
}
?>

<!doctype html>
<html>
    <head>
        <title>Dodawanie Pozycji do Rachunku</title>
    </head>
    <body>
        <h1>Dodaj Pozycję do Rachunku:</h1>
        <form method="post">
            <label for="rachunek">Rachunek:</label>
            <input id="rachunek" required="required" type="number" min="0" step="1" name="rachunek" placeholder="Rachunek" />
            <label for="pozycja">Pozycja:</label>
            <input id="pozycja" required="required" type="number" min="0" step="1" name="pozycja" placeholder="Pozycja" />
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
