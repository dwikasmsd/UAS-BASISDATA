<?php
include("config.php");

$idArtikel = $_GET['id'];
$sql = "SELECT * FROM artikel WHERE id_artikel = $idArtikel";
$result = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel</title>
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

        .content {
            margin-left: 200px;
            /* Adjust this value based on your sidebar width */
            padding: 20px;
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

        .add_new {
            padding: 10px 20px;
            color: #ffffff;
            background-color: #0298cf;
        }

        .table_section {
            height: 650px;
            overflow: auto;
            margin-top: 20px;
        }

        .article-title {
            font-size: 2em;
            margin-bottom: 25px;
            color: #333;
            text-align: center;
        }

        .article-content {
            font-size: 1.2em;
            line-height: 1.6;
            color: #555;
        }

        .article-content p {
            margin-bottom: 15px;
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
        <a class="active" href="halaman.php">Artikel</a>
        <a href="jenisTanaman.php">Tanaman</a>
        <a href="#contact">Daftar Pertanyaan</a>
        <a href="#about">Daftar Jawaban</a>
        <a href="index.php">Log out</a>
    </div>

    <div class="content">
        <div class="table">
            <div class="table_header">
                <a href="halaman.php"><button class="add_new">Kembali</button></a>
            </div>
            <div class="table_section">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $article = mysqli_fetch_assoc($result);
                    echo "<h1 class='article-title'>" . htmlspecialchars($article['judul_artikel']) . "</h1>";
                    echo "<div class='article-content'>" . nl2br(htmlspecialchars($article['isi_artikel'])) . "</div>";
                } else {
                    echo "<p>Article not found.</p>";
                }

                mysqli_close($koneksi);
                ?>
            </div>
        </div>
    </div>

</body>

</html>