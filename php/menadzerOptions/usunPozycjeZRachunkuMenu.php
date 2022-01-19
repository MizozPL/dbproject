<?php
session_start();

if (!isset($_SESSION['uname'])) {
    header('Location: ../index.php');
}

if ($_SESSION['uprawnienia'] != 'administrator' && $_SESSION['uprawnienia'] != 'menadzer') {
    header('Location: ../brakUprawnien.php');
}

if (isset($_POST["Zatwierdź"]) && isset($_POST["rachunek"]) && isset($_POST["pozycja"])) {
    require_once "../config/menagerLevel.php";

    $sql = "call usunPozycjeZRachunku(?, ?);";
    try {
        $stmt = $conn->prepare($sql); //podkreśla, ale git
        $stmt->bind_param("ii", $_POST["rachunek"], $_POST["pozycja"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $value = $result->fetch_assoc()["returnValue"];
        $stmt->close();
        if($value == 1) {
            $_SESSION["returnMessageString"] = "Usunięto";

            $log = "Usunięto pozycje z rachunku (" . $_POST["rachunek"] . ", " . $_POST["pozycja"] . ")";
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
            $_SESSION["returnMessageString"] = "Nie usunięto";
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
		<title>Usuń Pozycje z Rachunku</title>
	</head>
	<body>
		<h1>Usuń Pozycje z Rachunku</h1>
		<form method='post' action="">
			<label for="rachunek">Rachunek:</label><br>
			<input id="rachunek" required="required" type="number" name="rachunek" min="0" step="1"
			       placeholder="Rachunek"/><br>
            <label for="pozycja">Pozycja:</label><br>
            <input id="pozycja" required="required" type="number" name="pozycja" min="0" step="1"
                   placeholder="Pozycja"/><br>
			<input type="submit" value="Zatwierdź" name="Zatwierdź">
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
