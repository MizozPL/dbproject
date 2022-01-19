<?php
require_once "./config/userLevel.php";

session_start();

if (isset($_SESSION["uname"]) && isset($_SESSION["uprawnienia"])) {
    if ($_SESSION['uprawnienia'] == 'sprzedawca') {
        header('Location: sprzedawcaIndex.php');
    } elseif ($_SESSION['uprawnienia'] == 'menadzer') {
        header('Location: menadzerIndex.php');
    } elseif ($_SESSION['uprawnienia'] == 'administrator') {
        header('Location: administratorIndex.php');
    }
}

if (isset($_POST['button_submit'])) {

    $uname = $_POST['txt_uname'];
    $password = $_POST['txt_pwd'];

    if ($uname != "" && $password != "") {

        $sql = "call zweryfikujHaslo(?);";

        try {
            $stmt = $conn->prepare($sql); //podkreśla, ale git
            $stmt->bind_param("s", $uname);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $return = $result->fetch_assoc();

                //Weryfikacja hasła
                if (password_verify($password, $return["passwordHash"])) {
                    $_SESSION['uname'] = $uname;
                    $_SESSION['uprawnienia'] = $return["permissionLevel"];
                    if ($_SESSION['uprawnienia'] == 'sprzedawca') {
                        header('Location: sprzedawcaIndex.php');
                    } elseif ($_SESSION['uprawnienia'] == 'menadzer') {
                        header('Location: menadzerIndex.php');
                    } elseif ($_SESSION['uprawnienia'] == 'administrator') {
                        header('Location: administratorIndex.php');
                    }
                } else {
                    $_SESSION["returnMessageString"] = "Złe hasło/login";
                }
            } else {
                $_SESSION["returnMessageString"] = "Złe hasło/login";
            }
        } catch (mysqli_sql_exception $e) {
            $_SESSION["returnMessageString"] = "Złe hasło/login";
        }
    }

} ?>
<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>System obsługi rachunków</title>
	</head>

	<body>
		<form method="post" action="">
			<h1>Login</h1>
			<label for="nazwaUzytkownika">Nazwa Użytkownika:</label><br>
			<input id="nazwaUzytkownika" type="text" class="textbox" name="txt_uname" placeholder="Username"/><br>
			<label for="haslo">Hasło:</label><br>
			<input id="haslo" type="password" class="textbox" name="txt_pwd" placeholder="Password"/><br>
			<input type="submit" value="Submit" name="button_submit"/>
		</form>
		<p>
            <?php
            if (isset($_SESSION["returnMessageString"])) {
                echo $_SESSION["returnMessageString"];
                unset($_SESSION["returnMessageString"]);
            }
            ?>
		</p>
	</body>
</html>