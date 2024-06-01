<?php

include("config.php");

// cek apakah tombol edit sudah diklik atau blum?
if (isset($_POST["edit"])) {

    // ambil data dari formulir
    $id = $_POST["id"];
    $judul = $_POST["judul"];
    $isiArtikel = $_POST["isiArtikel"];
    $kategoriArtikel = $_POST["kategori_artikel"];

    // buat query update
    $sql = "UPDATE artikel SET judul_artikel='$judul', isi_artikel='$isiArtikel', id_kategori=$kategoriArtikel WHERE id_artikel=$id";
    $query = mysqli_query($koneksi, $sql);

    // apakah query update berhasil?
    if ($query) {
        // kalau berhasil alihkan ke halaman index.php dengan status=sukses
        header("location: dashboard.php");
    } else {
        // kalau gagal alihkan ke halaman index.php dengan status=gagal
        header("location: dashboard.php");
    }
} else {
    die("Akses dilarang...");
}
