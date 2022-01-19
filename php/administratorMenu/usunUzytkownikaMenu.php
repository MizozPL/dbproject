<?php
session_start();

if (!isset($_SESSION['uname'])) {
    header('Location: ../index.php');
}

if ($_SESSION['uprawnienia'] != 'administrator') {
    header('Location: ../brakUprawnien.php');
}

if (isset($_POST['button_usunUzytkownika']) && isset($_POST['txt_uzytkownik'])) {
    require_once "../config/adminLevel.php";

    $uzytkownik = $_POST['txt_uzytkownik'];
    $sql = "call usunUzytkownika(?);";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $uzytkownik);
        $stmt->execute();
        $result = $stmt->get_result();
        $value = $result->fetch_assoc()["returnValue"];
        if ($value == 1) {
            $_SESSION["returnMessageString"] = "Usunięto użytkownika: " . $uzytkownik . "<br>";
            $stmt->close();

            $log = "Usunięto użytkownika: " . $uzytkownik;
            $sql = "call logujDane(?, ?);";
            try {
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $_SESSION['uname'], $log);
                $stmt->execute();
            } catch (mysqli_sql_exception $e) {
                $_SESSION["returnMessageString"] = $_SESSION["returnMessageString"] . "Błąd logowania!";
            }
        } else {
            $_SESSION["returnMessageString"] = "Nie usunięto";
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION["returnMessageString"] = "Błąd";
    }
}
?>

<!doctype html>
<html>
	<head>
		<title>Usuń użytkownika</title>
	</head>
	<body>
		<h1>Usuń użytkownika.</h1>
		<form method='post' action="">
			<label for="nazwa_uzytkownika">Nazwa użytkownika:</label><br>
			<input id="nazwa_uzytkownika" required="required" type="text" name="txt_uzytkownik"
			       placeholder="Nazwa użytkownika"/><br>
			<input type="submit" value="zatwierdź" name="button_usunUzytkownika">
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
