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
    <title>Logi</title>
</head>
<body>
<h1>Logi:</h1>
<form method='post' action="">
    <input type="submit" value="powróć" name="button_powrot">
</form>
<p>
    <?php
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
    ?>
</p>

</body>
</html>
