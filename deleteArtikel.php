<?php
include("config.php");

if (isset($_GET['id'])) {
    $id_artikel = $_GET['id'];

    // Query untuk menghapus rating terkait terlebih dahulu
    $sql_delete_rating = "DELETE FROM rating WHERE id_artikel = ?";
    $stmt_delete_rating = mysqli_prepare($koneksi, $sql_delete_rating);

    if ($stmt_delete_rating) {
        mysqli_stmt_bind_param($stmt_delete_rating, 'i', $id_artikel);
        mysqli_stmt_execute($stmt_delete_rating);
        mysqli_stmt_close($stmt_delete_rating);
    }

    // Query untuk menghapus artikel
    $sql_delete_artikel = "DELETE FROM artikel WHERE id_artikel = ?";
    $stmt_delete_artikel = mysqli_prepare($koneksi, $sql_delete_artikel);

    if ($stmt_delete_artikel) {
        mysqli_stmt_bind_param($stmt_delete_artikel, 'i', $id_artikel);
        mysqli_stmt_execute($stmt_delete_artikel);

        // Mengecek apakah query berhasil dijalankan
        if (mysqli_stmt_affected_rows($stmt_delete_artikel) > 0) {
            header("location: dashboard.php");
        } else {
            header("location: dashboard.php");
        }

        mysqli_stmt_close($stmt_delete_artikel);
    } else {
        header("location: dashboard.php");
    }
}
