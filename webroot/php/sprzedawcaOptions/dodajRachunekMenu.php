<?php
session_start();

if (!isset($_SESSION["uname"])) {
    header("Location: ../index.php");
}

if ($_SESSION["uprawnienia"] != "sprzedawca" && $_SESSION["uprawnienia"] != "menadzer" && $_SESSION["uprawnienia"] != "administrator") {
    header("Location: ../brakUprawnien.php");
}

if(isset($_POST["Zatwierdź"])){
    require_once "../config/userLevel.php";

    $sql = "call dodajRachunek(?);";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION["uname"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $value = $result->fetch_assoc()["returnValue"];
        $_SESSION["returnMessageString"] = "Dodano rachuenk o ID: " . $value;

        $log = "Dodano rachunek (" . $value . ", x, " . $_SESSION["uname"] . ")";

        $sql = "call logujDane(?, ?);";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $_SESSION["uname"], $log);
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $_SESSION["returnMessageString"] = "Dodano rachunek o ID: " . $value . "\nBłąd zapisywania logów!";
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION["returnMessageString"] = "Błąd dodania rachunku";
    }

    $conn->close();
}
?>

<!doctype html>
<html>
    <head>
        <title>Dodawanie Rachunku</title>
    </head>
    <body>
        <h1>Dodaj Rachunek:</h1>
        <form method="post">
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
