<?php
session_start();

// Check user login or not
if(!isset($_SESSION['uname'])){
    header('Location: index.php');
}

if($_SESSION['uprawnienia'] != 'menadzer'){
    header('Location: brakUprawnien.php');
}

include "./config/menagerLevel.php";

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
<h1>Witaj <?php echo $_SESSION['uname']?> na stronie dla menadżerów.</h1>
<form method='post' action="">
    <input type="submit" value="wyloguj" name="button_logout">
</form>
</body>
</html>