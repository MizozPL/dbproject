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

$sql = "call wypiszLogi();";
try {
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION["returnMessageString"] = $_SESSION["returnMessageString"] . "id: " . $row["id"] . " - data: " . $row["data"] . " uzytkownik: " . $row["uzytkownik"] . " opis_akcji:" . $row["opis_akcji"] . "<br>";
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
		<title>Logi</title>
	</head>
	<body>
		<h1>Logi:</h1>
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
