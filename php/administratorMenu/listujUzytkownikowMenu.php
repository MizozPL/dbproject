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
    <title>Lista użytkowników</title>
</head>
<body>
<h1>Użytkownicy:</h1>
<form method='post' action="">
    <input type="submit" value="powróć" name="button_powrot">
</form>
<p>
    <?php
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
    ?>
</p>

</body>
</html>
