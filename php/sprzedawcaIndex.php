<?php
session_start();

// Check user login or not
if(!isset($_SESSION['uname'])){
    header('Location: index.php');
}

if($_SESSION['uprawnienia'] != 'sprzedawca'){
    header('Location: brakUprawnien.php');
}

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
<h1>Witaj <?php echo $_SESSION['uname']?> na stronie dla sprzedawców.</h1>
<form method='post' action="">
    <input type="submit" value="Logout" name="button_logout">
</form>
</body>
</html>