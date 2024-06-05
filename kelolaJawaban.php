<?php
include("config.php");
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

        .add_new {
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
        <a href="dashboard.php">Artikel</a>
        <a href="jenisTanaman.php">Tanaman</a>
        <a href="kategoriArtikel.php">Kategori Artikel</a>
        <a href="kelolaPertanyaan.php">Daftar Pertanyaan</a>
        <a class="active" href="kelolaJawaban.php">Daftar Jawaban</a>
        <a href="index.php">Log out</a>
    </div>

    <div class="content">
        <div class="table">
            <div class="table_header">
                <p>List Jawaban</p>
            </div>
            <div class="table_section">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jawaban</th>
                            <th>Laporan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT jawaban.id_jawaban, jawaban.jawaban, COUNT(laporan_jawaban.id_laporanJawaban) as jumlah_laporan 
                                FROM jawaban 
                                LEFT JOIN laporan_jawaban ON jawaban.id_jawaban = laporan_jawaban.id_jawaban GROUP BY jawaban.id_jawaban
                                ORDER BY jumlah_laporan DESC
";
                        $result = mysqli_query($koneksi, $sql);
                        $i = 1;

                        while ($jawaban = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>{$i}</td>";
                            echo "<td>{$jawaban['jawaban']}</td>";
                            echo "<td>{$jawaban['jumlah_laporan']}</td>";

                            echo "<td> 
                                <a href='deleteJawaban.php?id={$jawaban["id_jawaban"]}'><button class='delete'><i class='fa-solid fa-trash'></i></button></a>
                                </td>";
                            echo "</tr>";
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>