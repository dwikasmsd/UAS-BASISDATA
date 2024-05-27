<?php include("config.php"); ?>
<?php

// cek apakah tombol daftar sudah diklik atau blum? 
if (isset($_POST["tambah"])) {

    // ambil data dari formulir 
    $judul = $_POST["judul"];
    $isiArtikel = $_POST["isiArtikel"];
    $kategoriArtikel = $_POST["kategori_artikel"];
  

    // buat query 
    $sql = "INSERT INTO artikel (judul_artikel, isi_artikel, kategori_artikel, tanggal_artikel) 
    VALUES ('$judul', '$isiArtikel', '$kategoriArtikel', NOW())";
    $query = mysqli_query($koneksi, $sql);

    // apakah query simpan berhasil? 
    if ($query) {
        // kalau berhasil alihkan ke halaman index.php dengan status=sukses 
        header("location: dashboard.php");
    } else {
        // kalau gagal alihkan ke halaman index.php dengan status=gagal 
        header("location: index.php");
    }
} else if (isset($_POST["batal"])) {
    header("location: dashboard.php");
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Formulir Pendaftaran Pasien Baru | RS Santoso</title>
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
        <h2>Penambahan Artikel Baru</h2>
    </header>

    <form action="tambahArtikel.php" method="POST">

        <fieldset>

            <p>
                <label for="judul">Judul: </label>
                <input type="text" name="judul" placeholder="judul artikel" />
            </p>
            <p>
                <label for="isiArtikel">isi artikel: </label>
                <textarea name="isiArtikel"></textarea>
            </p>
            <p>
                <label for="Kategori_Artikel">Kategori Artikel: </label>
            <div class="radio-group">
                <label><input type="radio" name="kategori_artikel" value="Hidroponik"> Hidroponik</label>
                <label><input type="radio" name="kategori_artikel" value="Tanaman pangan"> Tanaman pangan</label>
                <label><input type="radio" name="kategori_artikel" value="Tanaman jamur"> Tanaman jamur</label>
                <label><input type="radio" name="kategori_artikel" value="Teknologi pertanian"> Teknologi pertanian</label>
                <label><input type="radio" name="kategori_artikel" value="Penyakit tanaman"> Penyakit tanaman</label>
            </div>
            </p>
            <p class="tombol">
                <input class="abort" type="submit" value="Batalkan" name="batal" />
                <input class="add" type="submit" value="Tambahkan" name="tambah" />
            </p>

        </fieldset>

    </form>

</body>

</html>