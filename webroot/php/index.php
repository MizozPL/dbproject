<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>System obsługi rachunków</title>
</head>

<body>
<div class="container">
    <form method="post" action="">
        <div id="div_login">
            <h1>Login</h1>
            <div>
                <input type="text" class="textbox" name="txt_uname" placeholder="Username" />
            </div>
            <div>
                <input type="password" class="textbox" name="txt_pwd" placeholder="Password"/>
            </div>
            <div>
                <input type="submit" value="Submit" name="button_submit"/>
            </div>
        </div>
    </form>
</div>

<?php
require_once "./config/userLevel.php";

session_start();

if(isset($_SESSION["uname"]) && isset($_SESSION["uprawnienia"])) {
    if ($_SESSION['uprawnienia'] == 'sprzedawca'){
        header('Location: sprzedawcaIndex.php');
    } elseif ($_SESSION['uprawnienia'] == 'menadzer'){
        header('Location: menadzerIndex.php');
    } elseif ($_SESSION['uprawnienia'] == 'administrator') {
        header('Location: administratorIndex.php');
    }
}

if(isset($_POST['button_submit'])){

    $uname = $_POST['txt_uname'];
    $password = $_POST['txt_pwd'];

    if ($uname != "" && $password != ""){

        $sql = "call zweryfikujHaslo(?);";

        try {
            $stmt = $conn->prepare($sql); //podkreśla, ale git
            $stmt->bind_param("s", $uname);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $return = $result->fetch_assoc();

                //Weryfikacja hasła
                if(password_verify($password, $return["passwordHash"])) {
                    $_SESSION['uname'] = $uname;
                    $_SESSION['uprawnienia'] = $return["permissionLevel"];
                    if ($_SESSION['uprawnienia'] == 'sprzedawca') {
                        header('Location: sprzedawcaIndex.php');
                    } elseif ($_SESSION['uprawnienia'] == 'menadzer') {
                        header('Location: menadzerIndex.php');
                    } elseif ($_SESSION['uprawnienia'] == 'administrator') {
                        echo "admin";
                        header('Location: administratorIndex.php');
                    }
                } else {
                    echo "Złe hasło/login";
                }
            }else {
                echo "Złe hasło/login";
            }
        } catch (mysqli_sql_exception $e) {
            echo "Złe hasło/login";
        }
    }

} ?>
</body>
</html>