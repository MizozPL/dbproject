<?php
session_start();

//// Check user login or not
if(!isset($_SESSION['uname'])){
    header('Location: index.php');
}

if($_SESSION['uprawnienia'] != 'administrator'){
    header('Location: brakUprawnien.php');
}

include "./config/adminLevel.php";

$username = $_SESSION['uname'];

// logout
if(isset($_POST['button_logout'])){
    session_destroy();
    header('Location: index.php');
}
?>

<!doctype html>
<html>
<head></head>
<body>
<h1>Witaj <?php echo $username?> na stronie dla administratorów.</h1>
<form method='post' action="">
    <input type="submit" value="dodaj użytkownika" name="button_dodajUzytkownika">
    <input type="submit" value="wpisz użytkowników" name="button_listujUzytkownikow">
    <input type="submit" value="usuń użytkownika" name="button_usunUzytkownika">
    <input type="submit" value="wpisz logi" name="button_wypiszLogi">
    <input type="submit" value="wyczyść logi" name="button_wyczyscLogi">
    <input type="submit" value="wyloguj" name="button_logout">
</form>
<p>
<?php

if(isset($_POST['button_dodajUzytkownika'])){
    echo "<form method='post' action=\"\">";
    echo "<input type=\"text\" name=\"txt_uzytkownik\" placeholder=\"Nazwa użytkownika\" /><br>";
    echo "<input type=\"text\" name=\"txt_haslo\" placeholder=\"Hasło\" /><br>";
    echo "<label for=\"uprawnienia\">Uprawnienia:</label>";
    echo "<select id=\"uprawnienia\" name=\"uprawnienia\">";
    echo "<option value=\"sprzedawca\">sprzedawca</option>";
    echo "<option value=\"menadzer\">menadżer</option>";
    echo "<option value=\"administrator\">administrator</option>";
    echo "</select><br>";
    echo "<input type=\"submit\" value=\"zatwierdź\" name=\"button_dodajUzytkownikaZatwierdz\">";
    echo "</form>";
}

if(isset($_POST['button_dodajUzytkownikaZatwierdz'])){

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

if(isset($_POST['button_listujUzytkownikow'])){
    $sql = "call listujUzytkownikow();";
    try {
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "login: " . $row["login"]. " - poziom_uprawnien: " . $row["poziom_uprawnien"] ."<br>";
            }
        } else {
            echo "0 wyników";
        }
    } catch (mysqli_sql_exception $e) {
        echo "Błąd";
    }
}

if(isset($_POST['button_usunUzytkownika'])){
    echo "<form method='post' action=\"\">";
    echo "<input type=\"text\" name=\"txt_uzytkownik\" placeholder=\"Nazwa użytkownika\" /><br>";
    echo "<input type=\"submit\" value=\"zatwierdź\" name=\"button_usunUzytkownikaZatwierdz\">";
    echo "</form>";
}

if(isset($_POST['button_usunUzytkownikaZatwierdz'])){
    $uzytkownik = $_POST['txt_uzytkownik'];
    $sql = "call usunUzytkownika(?);";
    try {
        $stmt = $conn->prepare($sql); //podkreśla, ale git
        $stmt->bind_param("s", $uzytkownik);
        $stmt->execute();
        $result = $stmt->get_result();
        $value = $result->fetch_assoc()["returnValue"];
        if($value == 1) {
            echo "Usunięto<br>";
            $stmt->close();

            $log = "Usunięto użytkownika: ".$uzytkownik;
            $sql = "call logujDane(?, ?);";
            try {
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $username, $log);
                $stmt->execute();
            } catch (mysqli_sql_exception $e) {
                echo $e;
//                echo "Błąd logowania!!!";
            }

        } else {
            echo "Nie usunięto";
        }
    } catch (mysqli_sql_exception $e) {
        echo "Błąd";
    }
}

if(isset($_POST['button_wypiszLogi'])){
    $sql = "call wypiszLogi();";
    try {
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"]. " - data: " . $row["data"]. " uzytkownik: " . $row["uzytkownik"]. " opis_akcji:". $row["opis_akcji"] ."<br>";
            }
        } else {
            echo "0 wyników";
        }
    } catch (mysqli_sql_exception $e) {
        echo "Błąd";
    }
}

if(isset($_POST['button_wyczyscLogi'])){
    $sql = "call wyczyscLogi();";
    try {
        $result = $conn->query($sql);
        echo "Wyczyszczono";
    } catch (mysqli_sql_exception $e) {
        echo "Błąd";
    }
}

?>
</p>
</body>
</html>