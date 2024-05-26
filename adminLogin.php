<?php

include("config.php");

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM admin WHERE nama_admin = '$username'";
    $result = mysqli_query($koneksi, $sql);

    if (mysqli_num_rows($result) === 1) {
        $baris = mysqli_fetch_assoc($result);

        if (password_verify($password, $baris["password_admin"])) {
            header("location: dashboard.php");
        }
    }

    $error = true;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="aset/style.css">
</head>

<body>
    <div class="container">
        <div class="login">
            <div class="header">
                <h1>Admin Login</h1>
            </div>
            <div class="main">
                <form action="adminLogin.php" method="post">
                    <input type="text" name="username" placeholder="Username">
                    <br>
                    <input type="password" name="password" placeholder="password">
                    <br>
                    <a href="index.php">login as Member</a>
                    <p style="font-style:italic; color:red; font-size:13px;">
                        <?php
                        if (isset($_POST["login"])) {
                            if ($error = true) {
                                echo "Username/Password salah";
                            }
                        }
                        ?>
                    </p>
                    <input class="login" type="submit" name="login" value="Login">
                </form>
            </div>
        </div>
        <div class="img">
            <span>
                <h1>Halo Petani</h1>
                <p>solusi untuk keluhan para petani di indonesia<br></p>
            </span>
        </div>
    </div>
</body>

</html>