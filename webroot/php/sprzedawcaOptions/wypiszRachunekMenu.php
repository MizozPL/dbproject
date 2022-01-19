<?php
session_start();

if (!isset($_SESSION["uname"])) {
    header("Location: ../index.php");
}

if ($_SESSION["uprawnienia"] != "sprzedawca" && $_SESSION["uprawnienia"] != "menadzer" && $_SESSION["uprawnienia"] != "administrator") {
    header("Location: ../brakUprawnien.php");
}

if(isset($_POST["Zatwierdź"]) && isset($_POST["rachunek"])){
    require_once "../config/userLevel.php";

    $sql = "call wypiszRachunek(?);";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_POST["rachunek"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows == 1) {
            $ret = $result->fetch_assoc()["returnValue"];
            if($ret == -1) {
                $_SESSION["returnMessageString"] = "Brak ID";
            } else {
                $_SESSION["returnMessageString"] = str_replace("\n", "<br/>", $ret);

                $log = "Wypisano rachunek o id (" . $_POST["rachunek"] . ")";

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
        <title>Wypisywanie Rachuneku</title>
    </head>
    <body>
        <h1>Wypisz Rachunek:</h1>
        <form method="post">
            <label for="rachunek">Rachunek:</label>
            <input id="rachunek" required="required" type="number" min="0" step="1" name="rachunek" placeholder="Rachunek" />
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
