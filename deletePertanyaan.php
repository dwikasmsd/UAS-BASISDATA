<?php
include("config.php");

if (isset($_GET['id'])) {
    $delete_id = $_GET['id'];
    $delete_sql = "DELETE FROM pertanyaan WHERE id_pertanyaan = ?";
    $stmt = mysqli_prepare($koneksi, $delete_sql);
    mysqli_stmt_bind_param($stmt, "i", $delete_id);
    mysqli_stmt_execute($stmt);
    header("Location: kelolaPertanyaan.php");
    exit();
}
?>