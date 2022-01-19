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
include "./config/userLevel.php";

if(isset($_POST['button_submit'])){

    $uname = mysqli_real_escape_string($conn,$_POST['txt_uname']);
    $password = mysqli_real_escape_string($conn,$_POST['txt_pwd']);

    if ($uname != "" && $password != ""){

        $sql = "call zweryfikujHaslo(?, ?);";

        try {
            $stmt = $conn->prepare($sql); //podkreśla, ale git
            $stmt->bind_param("ss", $uname, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $uprawnienia =  $result->fetch_assoc()["returnValue"];
            } else {
                echo "Złe hasło/login";
            }
        } catch (mysqli_sql_exception $e) {
            echo "Złe hasło/login";
        }

        if(isset($uprawnienia)){
            $_SESSION['uname'] = $uname;
            $_SESSION['uprawnienia'] = $uprawnienia;
            header('Location: home.php');
        }
    }

} ?>
</body>
</html>