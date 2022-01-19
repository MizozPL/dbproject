<?php
session_start();

if (!isset($_SESSION['uname'])) {
    header('Location: ../index.php');
}

if ($_SESSION['uprawnienia'] != 'administrator') {
    header('Location: ../brakUprawnien.php');
}

require_once "../config/adminLevel.php";

$sql = "call wyczyscLogi();";
try {
    $result = $conn->query($sql);
    $_SESSION["returnMessageString"] = "Wyczyszczono<br>";
} catch (mysqli_sql_exception $e) {
    $_SESSION["returnMessageString"] = "Błąd<br>";
}

$log = "Wyczysc logi.";
$sql = "call logujDane(?, ?);";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $_SESSION['uname'], $log);
    $stmt->execute();
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    $_SESSION["returnMessageString"] = $_SESSION["returnMessageString"]."Błąd logowania!";
}

$conn->close();

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