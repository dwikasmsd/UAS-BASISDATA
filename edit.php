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
        input[type="date"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
            height: 200px;
        }

        input[type="radio"] {
            margin-right: 5px;
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

        .radio-group label {
            display: flex;
            margin-right: 10px;
        }

        .tombol {
            display: flex;
            justify-content: space-evenly;
        }
    </style>
</head>

<body>
    <header>
        <h3>Edit Pasien</h3>
    </header>

    <form action="edited.php" method="POST">

        <fieldset>

            <input type="hidden" name="id" value="<?php echo $artikel["id_artikel"]
                                                    ?>" />

            <p>
                <label for="judul">Judul Artikel: </label>
                <input type="text" name="judul" placeholder="Judul Artikel" value="<?php echo $artikel["judul_artikel"] ?>" />
            </p>
            <p>
                <label for="isi_artikel">Isi Artikel: </label>
                <textarea name="isiArtikel"><?php echo $artikel['isi_artikel']
                                            ?></textarea>
            </p>
            <p>
                <label for="jenis_kelamin">Kategori: </label>
                <?php $kategoriArtikel = $artikel["kategori_artikel"]; ?>
                <label><input type="radio" name="kategori_artikel" value="Hidroponik" <?php echo ($kategoriArtikel == 'Hidroponik') ? "checked" : "" ?>> Hidroponik</label>
                <label><input type="radio" name="kategori_artikel" value="Tanaman pangan" <?php echo ($kategoriArtikel == 'Tanaman pangan') ? "checked" : "" ?>> Tanaman pangan</label>
                <label><input type="radio" name="kategori_artikel" value="Tanaman jamur" <?php echo ($kategoriArtikel == 'Tanaman jamur') ? "checked" : "" ?>> Tanaman jamur</label>
                <label><input type="radio" name="kategori_artikel" value="Teknologi pertanian" <?php echo ($kategoriArtikel == 'Teknologi pertanian') ? "checked" : "" ?>> Teknologi pertanian</label>
                <label><input type="radio" name="kategori_artikel" value="Penyakit tanaman" <?php echo ($kategoriArtikel == 'L') ? "Penyakit tanaman" : "" ?>> Penyakit tanaman</label>

            </p>
            <p class="tombol">
     
                <input class="add" type="submit" value="Edit Artikel" name="tambah" />
            </p>
        </fieldset>
    </form>
</body>

</html>