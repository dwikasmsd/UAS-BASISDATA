<?php include("config.php"); ?>

<?php
// Cek apakah tombol daftar sudah diklik atau belum
if (isset($_POST["tambah"])) {
    // Ambil data dari formulir
    $judul = $_POST["judul"];
    $isiArtikel = $_POST["isiArtikel"];
    $kategoriArtikel = $_POST["kategori_artikel"];

    // Buat query
    $sql = "INSERT INTO artikel (judul_artikel, isi_artikel, id_kategori, tanggal_artikel) 
            VALUES ('$judul', '$isiArtikel', $kategoriArtikel, CURRENT_DATE())";
    $query = mysqli_query($koneksi, $sql);

    // Apakah query simpan berhasil?
    if ($query) {
        // Kalau berhasil alihkan ke halaman dashboard.php dengan status=sukses
        header("location: dashboard.php");
    } else {
        // Kalau gagal alihkan ke halaman index.php dengan status=gagal
        header("location: index.php");
    }
} else if (isset($_POST["batal"])) {
    header("location: dashboard.php");
}

// Ambil data kategori dari database
$kategori_sql = "SELECT * FROM kategori_artikel";
$kategori_result = mysqli_query($koneksi, $kategori_sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Formulir Penambahan Artikel Baru | RS Santoso</title>
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
        input[type="date"],
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
        <h2>Penambahan Artikel Baru</h2>
    </header>

    <form action="tambahArtikel.php" method="POST">
        <fieldset>
            <p>
                <label for="judul">Judul: </label>
                <input type="text" name="judul" placeholder="judul artikel" required />
            </p>
            <p>
                <label for="isiArtikel">Isi Artikel: </label>
                <textarea name="isiArtikel" required></textarea>
            </p>
            <p>
                <label for="kategori_artikel">Kategori Artikel: </label>
                <select name="kategori_artikel" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php while ($row = mysqli_fetch_assoc($kategori_result)) { ?>
                        <option value="<?php echo $row['id_kategori']; ?>"><?php echo htmlspecialchars($row['nama_kategori']); ?></option>
                    <?php } ?>
                </select>
            </p>
            <p class="tombol">
                <input class="abort" type="submit" value="Batalkan" name="batal" />
                <input class="add" type="submit" value="Tambahkan" name="tambah" />
            </p>
        </fieldset>
    </form>
</body>

</html>