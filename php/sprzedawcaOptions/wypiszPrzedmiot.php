<?php
session_start();

if (!isset($_SESSION["uname"])) {
    header("Location: ../index.php");
}

if ($_SESSION["uprawnienia"] != "sprzedawca" && $_SESSION["uprawnienia"] != "menadzer" && $_SESSION["uprawnienia"] != "administrator") {
    header("Location: ../brakUprawnien.php");
}

if(isset($_POST["Zatwierdź"]) && isset($_POST["przedmiot"])){
    require_once "../config/userLevel.php";

    $sql = "call wypiszPrzedmiot(?);";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_POST["przedmiot"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows == 1) {
            $ret = $result->fetch_assoc()["returnValue"];
            if($ret == -1) {
                $_SESSION["returnMessageString"] = "Brak ID";
            } else {
                $_SESSION["returnMessageString"] = $ret;

                $log = "Wypisano przedmiot o id (" . $_POST["przedmiot"] . ")";

                $sql = "call logujDane(?, ?);";
                try {
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $_SESSION["uname"], $log);
                    $stmt->execute();
                    $stmt->close();
                } catch (mysqli_sql_exception $e) {
                    $_SESSION["returnMessageString"] = $_SESSION["returnMessageString"] . "\nBłąd zapisywania logów!";
                }
            }
        } else {
            $_SESSION["returnMessageString"] = "Brak ID";
        }

    } catch (mysqli_sql_exception $e) {
        $_SESSION["returnMessageString"] = "Błąd";
    }

    $conn->close();
}
?>

<!doctype html>
<html>
    <head>
        <title>Wypisywanie Przedmiotu</title>
    </head>
    <body>
        <h1>Wypisz Przedmiot:</h1>
        <form method="post">
            <label for="przedmiot">Przedmiot:</label>
            <input id="przedmiot" required="required" type="number" min="0" step="1" name="przedmiot" placeholder="Przedmiot" />
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
