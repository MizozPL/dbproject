<?php
session_start();

if (!isset($_SESSION['uname'])) {
    header('Location: index.php');
}

if ($_SESSION['uprawnienia'] != 'administrator') {
    header('Location: brakUprawnien.php');
}

require_once "./config/adminLevel.php";

if (isset($_POST['button_dodajUzytkownika'])) {
    header('Location: administratorOptions/dodajUzytkownikaMenu.php');
}

if (isset($_POST['button_listujUzytkownikow'])) {
    header('Location: administratorOptions/listujUzytkownikowMenu.php');
}

if (isset($_POST['button_edytujUzytkownika'])) {
    header('Location: administratorOptions/edytujUzytkownikaMenu.php');
}

if (isset($_POST['button_usunUzytkownika'])) {
    header('Location: administratorOptions/usunUzytkownikaMenu.php');
}

if (isset($_POST['button_wypiszLogi'])) {
    header('Location: administratorOptions/wypiszLogiMenu.php');
}

if (isset($_POST['button_wyczyscLogi'])) {
    header('Location: administratorOptions/wyczyscLogiMenu.php');
}
if (isset($_POST['button_logout'])) {
    session_destroy();
    header('Location: index.php');
}
?>

<!doctype html>
<html>
	<head></head>
	<body>
		<h1>Witaj <?php echo $_SESSION['uname'] ?> na stronie dla administratorów.</h1>
		<form method='post' action="">
			<input type="submit" value="dodaj użytkownika" name="button_dodajUzytkownika">
			<input type="submit" value="wypisz użytkowników" name="button_listujUzytkownikow">
			<input type="submit" value="edytuj użytkownika" name="button_edytujUzytkownika">
			<input type="submit" value="usuń użytkownika" name="button_usunUzytkownika">
			<input type="submit" value="wypisz logi" name="button_wypiszLogi">
			<input type="submit" value="wyczyść logi" name="button_wyczyscLogi">
			<input type="submit" value="wyloguj" name="button_logout">
		</form>
	</body>
</html>