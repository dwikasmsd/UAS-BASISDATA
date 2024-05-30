<?php

include("config.php");

// cek apakah tombol simpan sudah diklik atau blum? 
if (isset($_POST["tambah"])) {

    // ambil data dari formulir 
    $id = $_POST["id"];
    $judul = $_POST["judul"];
    $isi = $_POST["isiArtikel"];
    $kategoriArtikel = $_POST["kategori_artikel"];
   

    // buat query update 
    $sql = "UPDATE artikel SET judul_artikel='$judul', isi_artikel='$isi', 
kategori_artikel='$kategoriArtikel', tanggal_artikel = NOW() WHERE id_artikel=$id";
    $query = mysqli_query($koneksi, $sql);

    // apakah query update berhasil? 
    if ($query) {
        // kalau berhasil alihkan ke halaman list-pasien.php 
        header('Location: dashboard.php');
    } else {
        // kalau gagal tampilkan pesan 
        die("Gagal menyimpan perubahan...");
    }
} else {
    
}
