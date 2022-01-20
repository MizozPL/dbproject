<?php
session_start();

if (!isset($_SESSION['uname'])) {
    header('Location: ../index.php');
}

if ($_SESSION['uprawnienia'] != 'administrator' && $_SESSION['uprawnienia'] != 'menadzer') {
    header('Location: ../brakUprawnien.php');
}

if (isset($_POST['button_usunRachunek']) && isset($_POST['id'])) {
    require_once "../config/menagerLevel.php";

    $_SESSION["returnMessageString"]="";

    $id = $_POST['id'];

    $sql = "SELECT * FROM rachunki_pozycje WHERE rachunek = ".$id.";";
    try {
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while ($pozycja = $result->fetch_assoc()){
                $sql = "CALL usunPozycjeZRachunku(?, ?);";
				$stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $id, $pozycja['pozycja']);
                $stmt->execute();
                $stmt->close();

				$sql = "SELECT * FROM rachunki_pozycje WHERE pozycja = ".$pozycja["pozycja"].";";
				$innerResult = $conn->query($sql);
				if($innerResult->num_rows == 0){
                    $sql = "CALL usunPozycje(?);";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $pozycja['pozycja']);
                    $stmt->execute();
                    $stmt->close();
				}
            }
        }
    } catch (mysqli_sql_exception $e){
        $_SESSION["returnMessageString"] = $_SESSION["returnMessageString"]."Błąd przy usuwaniu pozycji<br>";
    }

    $sql = "call usunRachunek(?);";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $value = $result->fetch_assoc()["returnValue"];
        if ($value == 1) {
            $stmt->close();
            $_SESSION["returnMessageString"] = $_SESSION["returnMessageString"]."Usunięto<br>";

            $log = "Usunięto rachunek: " . $id;
            $sql = "call logujDane(?, ?);";
            try {
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $_SESSION['uname'], $log);
                $stmt->execute();
                $stmt->close();
            } catch (mysqli_sql_exception $e) {
                $_SESSION["returnMessageString"] = $_SESSION["returnMessageString"] . "Błąd logowania!";
            }

        } else {
            $_SESSION["returnMessageString"] = $_SESSION["returnMessageString"]."Nie usunięto<br>";
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION["returnMessageString"] = $_SESSION["returnMessageString"]."Błąd<br>";
    }

    $conn->close();
}
?>

<!doctype html>
<html>
    <head>
        <title>Usuń cały rachunek</title>
    </head>
    <body>
        <h1>Usuń cały rachunek.</h1>
        <form method='post' action="">
            <label for="id">ID rachunku:</label><br>
            <input id="id" required="required" type="number" name="id" min="0" step="1"
                   placeholder="ID rachunku"/><br>
            <input type="submit" value="zatwierdź" name="button_usunRachunek">
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
            <input type="submit" value="Powróć"/>
        </form>
    </body>
</html>

