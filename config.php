<?php

$server = "localhost";
$user = "root";
$password = "";
$namaDatabase = "halo_petani";

try {
    $koneksi = mysqli_connect($server, $user, $password, $namaDatabase);
} catch (mysqli_sql_exception $e) {
    echo "Koneksi database gagal: " . $e->getMessage();
}

?>
