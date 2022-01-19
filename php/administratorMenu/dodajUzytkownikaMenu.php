<?php
session_start();

if(!isset($_SESSION['uname'])){
    header('Location: ../index.php');
}

if($_SESSION['uprawnienia'] != 'administrator'){
    header('Location: ../brakUprawnien.php');
}

include "../config/adminLevel.php";

$username = $_SESSION['uname'];

if(isset($_POST['button_powrot'])){
    header('Location: ../administratorIndex.php');
}
?>

<!doctype html>
<html>
<head>
    <title>Dodaj użytkownika</title>
</head>
<body>
<h1>Dodaj użytkownika.</h1>
<form method='post' action="">

    <input type="text" name="txt_uzytkownik" placeholder="Nazwa użytkownika" /><br>
    <input type="text" name="txt_haslo" placeholder="Hasło" /><br>
    <label for="uprawnienia">Uprawnienia:</label>
    <select id="uprawnienia" name="uprawnienia">
        <option value="sprzedawca">sprzedawca</option>
        <option value="menadzer">menadżer</option>
        <option value="administrator">administrator</option>
    </select><br>
    <input type="submit" value="zatwierdź" name="button_dodajUzytkownika">
    <input type="submit" value="powróć" name="button_powrot">

</form>
<p>
    <?php
    if(isset($_POST['button_dodajUzytkownika'])){

        $uzytkownik = $_POST['txt_uzytkownik'];
        $pass = $_POST['txt_haslo'];
        $poziom_uprawnien = $_POST['uprawnienia'];

        $sql = "call dodajUzytkownika(?, ?, ?);";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $uzytkownik, $pass, $poziom_uprawnien);
            $stmt->execute();

            echo "Dodano<br>";

            $log = "Dodano użytkownika: ".$uzytkownik;

            $sql = "call logujDane(?, ?);";
            try {
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $username, $log);
                $stmt->execute();
            } catch (mysqli_sql_exception $e) {
                echo "Błąd logowania!!!";
            }


        } catch (mysqli_sql_exception $e) {
            echo "Nie dodano/Błąd";
        }
    }
    ?>
</p>

</body>
</html>



