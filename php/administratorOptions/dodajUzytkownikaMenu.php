<?php
session_start();

if (!isset($_SESSION['uname'])) {
    header('Location: ../index.php');
}

if ($_SESSION['uprawnienia'] != 'administrator') {
    header('Location: ../brakUprawnien.php');
}

if (isset($_POST['button_dodajUzytkownika']) && isset($_POST['txt_uzytkownik']) && isset($_POST['txt_haslo']) && isset($_POST['uprawnienia'])) {

    require_once "../config/adminLevel.php";

    $uzytkownik = $_POST['txt_uzytkownik'];
    $pass = $_POST['txt_haslo'];
    $poziom_uprawnien = $_POST['uprawnienia'];
	$hash = password_hash($pass, PASSWORD_ARGON2ID);

    $sql = "call dodajUzytkownika(?, ?, ?);";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $uzytkownik, $hash, $poziom_uprawnien);
        $stmt->execute();

        $_SESSION["returnMessageString"] = "Dodano użytkownika: " . $uzytkownik . "<br>";

        $stmt->close();
        $log = "Dodano użytkownika: " . $uzytkownik;
        $sql = "call logujDane(?, ?);";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $_SESSION['uname'], $log);
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $_SESSION["returnMessageString"] = $_SESSION["returnMessageString"] . "Błąd logowania!";
        }


    } catch (mysqli_sql_exception $e) {
        $_SESSION["returnMessageString"] = "Nie dodano/Błąd";
    }

    $conn->close();
}
?>

<!doctype html>
<html>
	<head>
		<title>Dodaj użytkownika</title>
	</head>
	<body>
		<h1>Dodaj użytkownika.</h1>
		<form method='post'>
			<label for="nazwa_uzytkownika">Nazwa użytkownika:</label><br>
			<input id="nazwa_uzytkownika" required="required" type="text" name="txt_uzytkownik"
			       placeholder="Nazwa użytkownika"/><br>
			<label for="haslo">Hasło:</label><br>
			<input id="haslo" required="required" type="password" name="txt_haslo" placeholder="Hasło"/><br>
			<label for="uprawnienia">Uprawnienia:</label>
			<select id="uprawnienia" name="uprawnienia">
				<option value="sprzedawca">sprzedawca</option>
				<option value="menadzer">menadżer</option>
				<option value="administrator">administrator</option>
			</select><br>
			<input type="submit" value="zatwierdź" name="button_dodajUzytkownika">
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



