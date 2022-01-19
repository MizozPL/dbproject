<?php
session_start();

if (!isset($_SESSION['uname'])) {
    header('Location: ../index.php');
}

if ($_SESSION["uprawnienia"] != "sprzedawca" && $_SESSION["uprawnienia"] != "menadzer" && $_SESSION["uprawnienia"] != "administrator") {
    header('Location: ../brakUprawnien.php');
}

require_once "../config/userLevel.php";

$_SESSION["returnMessageString"] = "";

$sql = "SELECT * FROM rachunki;";
try {
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION["returnMessageString"] = $_SESSION["returnMessageString"] . "id: " . $row["id"] . " data: " . $row["data"] . " uzytkownik: " . $row["uzytkownik"] . "<br>";
        }
        $log = "Wypisano rachunki";

        $sql = "call logujDane(?, ?);";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $_SESSION["uname"], $log);
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $_SESSION["returnMessageString"] = $_SESSION["returnMessageString"] . "\nBłąd zapisywania logów!";
        }
    } else {
        $_SESSION["returnMessageString"] = "0 wyników";
    }
} catch (mysqli_sql_exception $e) {
    $_SESSION["returnMessageString"] = "Błąd";
}

?>

<!doctype html>
<html>
	<head>
		<title>Rachunki</title>
	</head>
	<body>
		<h1>Rachunki:</h1>
		<p>
            <?php
            echo $_SESSION["returnMessageString"];
            unset($_SESSION["returnMessageString"]);
            ?>
		</p>
		<form method='post' action="../index.php">
			<input type="submit" value="powróć">
		</form>
	</body>
</html>
