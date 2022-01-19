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
    $_SESSION["returnMessageString"] = "Wyczyszczono";
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
		<form method='post' action="../index.php">
			<input type="submit" value="powróć">
		</form>
		<p>
            <?php
            echo $_SESSION["returnMessageString"];
            unset($_SESSION["returnMessageString"]);
            ?>
		</p>
	</body>
</html>