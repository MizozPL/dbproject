<?php
    $username = "admin";
    $password = "admin123";

    $hash = password_hash($password, PASSWORD_ARGON2ID);
    echo $hash
?>