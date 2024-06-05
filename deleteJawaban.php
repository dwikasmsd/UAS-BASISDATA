<?php
include("config.php");

if (isset($_GET['id'])) {
    $delete_id = $_GET['id'];
    $delete_sql = "DELETE FROM jawaban WHERE id_jawaban = ?";
    $stmt = mysqli_prepare($koneksi, $delete_sql);
    mysqli_stmt_bind_param($stmt, "i", $delete_id);
    mysqli_stmt_execute($stmt);
    header("Location: kelolaJawaban.php");
    exit();
}
