<?php
session_start();

if (!isset($_SESSION['uname'])) {
    header('Location: index.php');
}

if ($_SESSION["uprawnienia"] != "administrator") {
    header('Location: brakUprawnien.php');
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

		<form method="get" action="sprzedawcaOptions/wypiszPrzedmiotMenu.php">
			<button type="submit">Wypisz Przedmiot</button>
		</form>

		<form method="get" action="sprzedawcaOptions/wypiszPozycjeMenu.php">
			<button type="submit">Wypisz Pozycje</button>
		</form>

		<form method="get" action="sprzedawcaOptions/wypiszRachunekMenu.php">
			<button type="submit">Wypisz Rachunek</button>
		</form>

		<form method="get" action="sprzedawcaOptions/listujPrzedmiotyMenu.php">
			<button type="submit">Listuj Przedmioty</button>
		</form>

		<form method="get" action="sprzedawcaOptions/listujPozycjeMenu.php">
			<button type="submit">Listuj Pozycje</button>
		</form>

		<form method="get" action="sprzedawcaOptions/listujRachunkiMenu.php">
			<button type="submit">Listuj Rachunki</button>
		</form>

		<form method="get" action="sprzedawcaOptions/dodajPrzedmiotMenu.php">
			<button type="submit">Dodaj Przedmiot</button>
		</form>

		<form method="get" action="sprzedawcaOptions/dodajPozycjeMenu.php">
			<button type="submit">Dodaj Pozycje</button>
		</form>

		<form method="get" action="sprzedawcaOptions/dodajRachunekMenu.php">
			<button type="submit">Dodaj Rachunek</button>
		</form>

		<form method="get" action="sprzedawcaOptions/dodajPozycjeDoRachunkuMenu.php">
			<button type="submit">Dodaj Pozycje do Rachunku</button>
		</form>

		<hr>

		<form method="get" action="menadzerOptions/edytujPrzedmiotMenu.php">
			<button type="submit">Edytuj Przedmiot</button>
		</form>

		<form method="get" action="menadzerOptions/edytujPozycjeMenu.php">
			<button type="submit">Edytuj Pozycje</button>
		</form>

		<form method="get" action="menadzerOptions/usunPrzedmiotMenu.php">
			<button type="submit">Usun Przedmiot</button>
		</form>

		<form method="get" action="menadzerOptions/usunPozycjeMenu.php">
			<button type="submit">Usun Pozycje</button>
		</form>

		<form method="get" action="menadzerOptions/usunPozycjeZRachunkuMenu.php">
			<button type="submit">Usun Pozycje z Rachunku</button>
		</form>

		<form method="get" action="menadzerOptions/usunRachunekMenu.php">
			<button type="submit">Usun Rachunek</button>
		</form>

		<hr>

		<form method="get" action="administratorOptions/listujUzytkownikowMenu.php">
			<button type="submit">Listuj Uzytkownikow</button>
		</form>

		<form method="get" action="administratorOptions/dodajUzytkownikaMenu.php">
			<button type="submit">Dodaj Uzytkownika</button>
		</form>

		<form method="get" action="administratorOptions/edytujUzytkownikaMenu.php">
			<button type="submit">Edytuj Uzytkownika</button>
		</form>

		<form method="get" action="administratorOptions/usunUzytkownikaMenu.php">
			<button type="submit">Usun Uzytkownika</button>
		</form>

		<form method="get" action="administratorOptions/wypiszLogiMenu.php">
			<button type="submit">Wypisz Logi</button>
		</form>

		<form method="get" action="administratorOptions/wyczyscLogiMenu.php">
			<button type="submit">Wyczysc Logi</button>
		</form>


		<form method='post' action="">
			<input type="submit" value="wyloguj" name="button_logout">
		</form>
	</body>
</html>