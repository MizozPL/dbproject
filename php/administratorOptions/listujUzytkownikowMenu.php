<?php
session_start();

if (!isset($_SESSION['uname'])) {
    header('Location: ../index.php');
}

if ($_SESSION['uprawnienia'] != 'administrator') {
    header('Location: ../brakUprawnien.php');
}

require_once "../config/adminLevel.php";

$_SESSION["returnMessageString"] = "";

$sql = "call listujUzytkownikow();";
try {
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION["returnMessageString"] = $_SESSION["returnMessageString"] . "login: " . $row["login"] . " - poziom_uprawnien: " . $row["poziom_uprawnien"] . "<br>";
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
		<title>Lista użytkowników</title>
	</head>
	<body>
		<h1>Użytkownicy:</h1>
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
