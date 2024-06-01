<?php

include("config.php");

// kalau tidak ada id di query string 
if (!isset($_GET["id"])) {
    header('Location: dashboard.php');
}

//ambil id dari query string 
$id = $_GET["id"];

// buat query untuk ambil data dari database 
$sql = "SELECT * FROM artikel WHERE id_artikel=$id";
$query = mysqli_query($koneksi, $sql);
$artikel = mysqli_fetch_assoc($query);

// jika data yang di-edit tidak ditemukan 
if (mysqli_num_rows($query) < 1) {
    die("data tidak ditemukan...");
}

// Query untuk mengambil data kategori dari database
$sql_kategori = "SELECT * FROM kategori_artikel";
$query_kategori = mysqli_query($koneksi, $sql_kategori);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Artikel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
            width: 100%;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 1300px;
        }

        fieldset {
            border: none;
        }

        p {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        select {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
            height: 200px;
        }

        .add {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            margin-left: 5px;
        }

        .add:hover {
            background-color: #0056b3;
        }

        .abort {
            width: 100%;
            padding: 10px;
            background-color: red;
            border: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            margin-right: 5px;
        }

        .abort:hover {
            background-color: #870202;
        }

        .tombol {
            display: flex;
            justify-content: space-evenly;
        }
    </style>
</head>

<body>
    <header>
        <h3>Edit Artikel</h3>
    </header>

    <form action="edited.php" method="POST">

        <fieldset>

            <input type="hidden" name="id" value="<?php echo $artikel["id_artikel"] ?>" />

            <p>
                <label for="judul">Judul Artikel: </label>
                <input type="text" name="judul" placeholder="Judul Artikel" value="<?php echo $artikel["judul_artikel"] ?>" />
            </p>
            <p>
                <label for="isi_artikel">Isi Artikel: </label>
                <textarea name="isiArtikel"><?php echo $artikel['isi_artikel'] ?></textarea>
            </p>
            <p>
                <label for="kategori_artikel">Kategori: </label>
                <select name="kategori_artikel">
                     <?php
                    while ($kategori = mysqli_fetch_array($query_kategori)) {
                        $selected = ($artikel["id_kategori"] == $kategori["id_kategori"]) ? "selected" : "";
                        echo "<option value='{$kategori["id_kategori"]}' {$selected}>{$kategori["nama_kategori"]}</option>";
                    }
                    ?>
                </select>
            </p>
            <p class="tombol">
                <input class="add" type="submit" value="Edit Artikel" name="edit" />
            </p>
        </fieldset>
    </form>
</body>

</html>