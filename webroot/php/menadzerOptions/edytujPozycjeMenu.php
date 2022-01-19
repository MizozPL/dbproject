<?php
session_start();

if (!isset($_SESSION["uname"])) {
    header("Location: ../index.php");
}

if ( $_SESSION["uprawnienia"] != "menadzer" && $_SESSION["uprawnienia"] != "administrator") {
    header("Location: ../brakUprawnien.php");
}

if(isset($_POST["Zatwierdź"]) && isset($_POST["id"]) && isset($_POST["przedmiot"]) && isset($_POST["ilość"]) && isset($_POST["rabat"])){
    require_once "../config/menagerLevel.php";

    $sql = "call edytujPozycje(?, ?, ?, ?);";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiid", $_POST["id"], $_POST["przedmiot"], $_POST["ilość"], $_POST["rabat"]);
        $stmt->execute();
        $stmt->close();
        $_SESSION["returnMessageString"] = "Zmieniono pozycje o ID: " . $_POST["id"];

        $log = "Zmieniono pozycję (" . $_POST["id"] . ", " . $_POST["przedmiot"] . ", " . $_POST["ilość"] . ", " . $_POST["rabat"] . ")";

        $sql = "call logujDane(?, ?);";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $_SESSION["uname"], $log);
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $_SESSION["returnMessageString"] = "Zmieniono pozycje o ID: " . $_POST["id"] . "<br>Błąd zapisywania logów!";
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
        <title>Edyjca Pozycji</title>
    </head>
    <body>
        <h1>Edytuj Pozycje:</h1>
        <form method="post">
            <label for="id">ID:</label><br>
            <input id="id" required="required" type="number" min="0" step="1" name="id" placeholder="ID" /><br>
            <label for="przedmiot">Przedmiot:</label><br>
            <input id="przedmiot" required="required" type="number" min="0" step="1" name="przedmiot" placeholder="Przedmiot" /><br>
            <label for="ilość">Ilość:</label><br>
            <input id="ilość" required="required" type="number" min="0" step="1" name="ilość" placeholder="Ilość" /><br>
            <label for="rabat">Rabat:</label><br>
            <input id="rabat" required="required" type="number" min="0" step="0.01" max="0.99" name="rabat" placeholder="Rabat" /><br>
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

