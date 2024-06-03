<?php

    include("config.php");

?>

<!DOCTYPE html>
<html>

<head>
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="aset/registrasi.css">
</head>

<body>
    <div class="container">
        <div class="login">
            <div class="header">
                <h1>SIGN UP</h1>
            </div>
            <div class="main">
                <form action="registrasi.php" method="post">
                    <input type="text" name="username" placeholder="Username">
                    <br>
                    <input type="text" name="nomorHp" placeholder="Nomor HP">
                    <br>
                    <input type="password" name="password" placeholder="password">
                    <br>
                    <p style="font-size: 15px;"><?php
                    if (isset($_POST["login"])) {
                        if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["nomorHp"])) {
                            echo"Isi username/password/Nomor Hp";
                        }
                        else {
                            $username = $_POST["username"];
                            $password1 = $_POST["password"];
                            $nomor = $_POST["nomorHp"];
                            $result = mysqli_query($koneksi,"SELECT no_hp FROM pengguna WHERE no_hp = '$nomor'");

                            if (mysqli_fetch_assoc($result)) {
                                echo"nomor HP sudah digunakan";
                            } else {

                                    $hashing = password_hash($password1, PASSWORD_DEFAULT);
                                    $sql = "INSERT INTO pengguna(nama_lengkap, no_hp, password) VALUES('$username', '$nomor', '$hashing')";

                                    mysqli_query($koneksi, $sql);

                                    header("location: index.php");
                            }
                            
                        }
                    }
                    ?></p>
                    <a href="index.php">sudah punya akun? masuk sini</a>
                    <input type="submit" name="login" value="submit">
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