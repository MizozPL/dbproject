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
    <title>Usuń użytkownika</title>
</head>
<body>
<h1>Usuń użytkownika.</h1>
<form method='post' action="">
    <input type="text" name="txt_uzytkownik" placeholder="Nazwa użytkownika" /><br>
    <input type="submit" value="zatwierdź" name="button_usunUzytkownika">
    <input type="submit" value="powróć" name="button_powrot">
</form>
<p>
    <?php
    if(isset($_POST['button_usunUzytkownika'])){
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
    ?>
</p>

</body>
</html>
