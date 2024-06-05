<?php
include("config.php");

$search_query = "";
if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $search_query = " WHERE isi_pertanyaan LIKE '%$keyword%'";
}

$filter_query = "";
if (isset($_GET['kategori']) && !empty($_GET['kategori'])) {
    $kategori = $_GET['kategori'];
    $filter_query = " WHERE tanaman.id_tanaman = $kategori";
}

$sql = "SELECT pertanyaan.*, pengguna.nama_lengkap, tanaman.jenis_tanaman 
        FROM pertanyaan 
        JOIN pengguna ON pertanyaan.id_user = pengguna.id 
        JOIN tanaman ON pertanyaan.id_tanaman = tanaman.id_tanaman
        $search_query
        $filter_query
        ORDER BY pertanyaan.tanggal DESC";
$query = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        <?php include("aset/sidebar.css"); ?>* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .sidebar a.active {
            background-color: #04AA6D;
            color: white;
        }

        .table {
            width: 100%;
        }

        .table_header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: rgb(240, 240, 240);
        }

        .table_header p {
            color: #000000;
        }

        button {
            outline: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            padding: 10px;
            color: #ffffff;
        }

        td .edit {
            background-color: #0298cf;
        }

        td .delete {
            background-color: #f80000;
        }

        .search {
            padding: 10px 20px;
            color: #ffffff;
            background-color: #0298cf;
        }

        input {
            padding: 10px 20px;
            margin: 0 10px;
            outline: none;
            border: 1px solid #0298cf;
            border-radius: 6px;
            color: #0298cf;
        }

        .table_section {
            height: 650px;
            overflow: auto;
        }

        table {
            width: 100%;
            table-layout: fixed;
            min-width: 1000px;
            border-collapse: collapse;
        }

        thead th {
            position: sticky;
            top: 0;
            background-color: #f6f9fc;
            color: #8493a5;
            font-size: 15px;
        }

        th,
        td {
            border-bottom: 1px solid #dddddd;
            padding: 10px 20px;
            word-break: break-all;
            text-align: center;
        }

        ::placeholder {
            color: #0298cf;
        }

        ::-webkit-scrollbar {
            height: 5px;
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        }

        ::-webkit-scrollbar-thumb {
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <a href="halaman.php">Artikel</a>
        <a class="active" href="pertanyaan.php">Pertanyaan</a>
        <a href="topArtikel.php">TOP ARTIKEL</a>
        <a href="topTen.php">TOP MEMBER</a>
        <a href="index.php">Log out</a>
    </div>

    <div class="content">
        <div class="table">
            <div class="table_header">
                <a href="postingPertanyaan.php">tambah pertanyaan</a>
                <p>Pertanyaan</p>
                <form action="pertanyaan.php" method="GET">
                    <input type="text" name="keyword" placeholder="Cari pertanyaan...">
                    <select name="kategori">
                        <option value="">Semua Kategori</option>
                        <?php
                        $sql_kategori = "SELECT * FROM tanaman";
                        $query_kategori = mysqli_query($koneksi, $sql_kategori);
                        while ($tanaman = mysqli_fetch_array($query_kategori)) {
                            echo "<option value='{$tanaman['id_tanaman']}'>{$tanaman['jenis_tanaman']}</option>";
                        }
                        ?>
                    </select>
                    <button class="search" type="submit">Cari & Filter</button>
                </form>
            </div>
            <div class="table_section">
                <table>
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Pengguna</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($pertanyaan = mysqli_fetch_array($query)) {
                            echo "<tr>";
                            echo "<td>{$pertanyaan['isi_pertanyaan']}</td>";
                            echo "<td>{$pertanyaan['nama_lengkap']}</td>";
                            echo "<td>{$pertanyaan['jenis_tanaman']}</td>";
                            echo "<td>{$pertanyaan['tanggal']}</td>";
                            echo "<td><a href='detailPertanyaan.php?id={$pertanyaan['id_pertanyaan']}'>Lihat Detail</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>