<?php
session_start();

if (!isset($_SESSION['uname'])) {
    header('Location: ../index.php');
}

if ($_SESSION['uprawnienia'] != 'administrator' && $_SESSION['uprawnienia'] != 'menadzer') {
    header('Location: ../brakUprawnien.php');
}

if (isset($_POST['button_usunPrzedmiot']) && isset($_POST['id'])) {
    require_once "../config/menagerLevel.php";

    $id = $_POST['id'];
    $sql = "call usunPrzedmiot(?);";
    try {
        $stmt = $conn->prepare($sql); //podkreśla, ale git
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $value = $result->fetch_assoc()["returnValue"];
        if ($value == 1) {
            $stmt->close();
            $_SESSION["returnMessageString"] = "Usunięto";

            $log = "Usunięto przedmiot: " . $id;
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
		<title>Usuń przedmiot</title>
	</head>
	<body>
		<h1>Usuń przedmiot.</h1>
		<form method='post' action="">
			<label for="id">ID przedmiotu:</label><br>
			<input id="id" required="required" type="number" name="id" min="0" step="1"
			       placeholder="0"/><br>
			<input type="submit" value="zatwierdź" name="button_usunPrzedmiot">
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
