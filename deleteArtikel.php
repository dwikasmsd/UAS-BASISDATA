<?php
include("config.php");

if (isset($_GET["id"])) {

    // ambil id dari query string 
    $id = $_GET["id"];

    // buat query hapus 
    $sql = "DELETE FROM artikel WHERE id_artikel=$id";
    $query = mysqli_query($koneksi, $sql);

    // // apakah query hapus berhasil? 
    if ($query) {
        header('Location: dashboard.php');
    } else {
        die("gagal menghapus...");
    }
} else {
    
}
