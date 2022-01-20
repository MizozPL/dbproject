<?php
session_start();

if (!isset($_SESSION["uname"])) {
    header("Location: ../index.php");
}

if ($_SESSION["uprawnienia"] != "sprzedawca" && $_SESSION["uprawnienia"] != "menadzer" && $_SESSION["uprawnienia"] != "administrator") {
    header("Location: ../brakUprawnien.php");
}

require_once "../config/userLevel.php";

$_SESSION["przedmiotyString"]="";


$sql = "SELECT * FROM przedmioty";
try{
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()){
        $_SESSION["przedmiotyString"] .= "<option value='".$row['id']."' >".$row['nazwa'].": ".$row['cena']."</option>";
    }
} catch (mysqli_sql_exception $e){}

    $conn->close();

?>

<!doctype html>
<html>
    <head>
        <script src="dodajRachunekMenu.js"></script>
        <title>Dodawanie Rachunku 2.0</title>
    </head>
    <body>
        <h1>Dodaj Rachunek:</h1>
        <label for="przedmioty">dostępne przedmioty:</label>
        <select id="przedmioty" name="przedmiot">
            <?php
            if (isset($_SESSION["przedmiotyString"])) {
                echo $_SESSION["przedmiotyString"];
                unset($_SESSION["przedmiotyString"]);
            }
            ?>
        </select>
        <button onclick="dodajPozycje()">dodaj Pozycje</button><br>
        <div id="listaPozycji"></div>
        <br>
        <button onclick="zatwierdz()">zatwierdź</button>
        <button onclick="wyczysc()">wyczyść</button><br>
        <p id="return">
        </p>
        <form action="../index.php">
            <input type="submit" value="Powróć" />
        </form>
    </body>
</html>
