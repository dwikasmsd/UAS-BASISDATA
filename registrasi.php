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
                    <input type="password" name="password" placeholder="password">
                    <br>
                    <input type="password" name="confirmPassword" placeholder="confirm password">
                    <br>
                    <p style="font-size: 15px;"><?php
                    if (isset($_POST["login"])) {
                        if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["confirmPassword"])) {
                            echo"Isi username/password";
                        }
                        else {
                            $username = $_POST["username"];
                            $password1 = $_POST["password"];
                            $password2 = $_POST["confirmPassword"];
                            $result = mysqli_query($koneksi,"SELECT Nama FROM pengguna WHERE Nama = '$username'");

                            if (mysqli_fetch_assoc($result)) {
                                echo"Username sudah digunakan";
                            } else {
                                
                                if ($password1 != $password2) {
                                    echo "Pastikan password yang diisi benar";
                                } else{
                                    $hashing = password_hash($password1, PASSWORD_DEFAULT); 
                                    $sql = "INSERT INTO pengguna(Nama, password) VALUES('$username', '$hashing')";
    
                                    mysqli_query($koneksi, $sql);
    
                                    header("location: index.php");
                                }
                            }
                            
                        }
                    }
                    ?></p>
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