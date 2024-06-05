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
        <?php

        include("aset/sidebar.css");
        ?>* {
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
            margin-left: 10px;
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

        th {
            border-bottom: 1px solid #dddddd;
            padding: 10px 20px;
            word-break: break-all;
            text-align: center;

        }

        .category,
        .aksi,
        .rate {
            text-align: center;
        }

        .titel {
            width: 200px;
        }

        td {
            border-bottom: 1px solid #dddddd;
            padding: 10px 20px;
            word-break: break-all;
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
        <a href="pertanyaan.php">Pertanyaan</a>
        <a href="topArtikel.php">TOP ARTIKEL</a>
        <a class="active" href="topTen.php">TOP MEMBER</a>
        <a href="index.php">Log out</a>
    </div>

    <div class="content">
        <div class="table">
            <div class="table_section">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Quality Points</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $sql = "SELECT nama_lengkap, quality_points FROM PENGGUNA ORDER BY quality_points DESC LIMIT 10";
                        $query = mysqli_query($koneksi, $sql);

                        // Tampilkan hasil query
                        while ($user = mysqli_fetch_array($query)) {
                            echo "<tr>";
                            echo "<td class='titel'>{$user['nama_lengkap']}</td>";
                            echo "<td class='category'>{$user['quality_points']}</td>";

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