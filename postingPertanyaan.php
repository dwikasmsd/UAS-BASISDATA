<?php 
include("config.php"); 
session_start();


if (isset($_POST["tambah"])) {
    $isi = $_POST['isi'];
    $id_user = $_SESSION['id_user'];
    $id_kategori = $_POST['jenisTanaman'];
    $target_file = null;

    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] == 0) {
        // Handle file upload
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES["gambar"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (!move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                echo "Sorry, there was an error uploading your file.";
                $target_file = null; // Reset target file if upload fails
            }
        }
    }

    if ($target_file) {
        $sql = "INSERT INTO pertanyaan (isi_pertanyaan, gambar, id_user, id_tanaman, tanggal) VALUES (?, ?, ?, ?, CURRENT_DATE())";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "ssii", $isi, $target_file, $id_user, $id_kategori);
    } else {
        $sql = "INSERT INTO pertanyaan (isi_pertanyaan, id_user, id_tanaman, tanggal) VALUES (?, ?, ?, CURRENT_DATE())";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "sii", $isi, $id_user, $id_kategori);
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: pertanyaan.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} elseif (isset($_POST["batal"])) {
    header("location: pertanyaan.php");
}

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
        <h2>Posting Pertanyaan Baru</h2>
    </header>

    <form action="postingPertanyaan.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <p>
                <label for="isi">Pertanyaan: </label>
                <textarea name="isi" required></textarea>
            </p>
            <p>
                <label for="gambar">Gambar:</label>
                <input type="file" id="gambar" name="gambar">
            </p>
            <p>
                <label for="kategori_artikel">jenis Tanaman: </label>
                <select id="kategori" name="jenisTanaman" required>
                    <?php
                    $sql = "SELECT * FROM tanaman";
                    $query = mysqli_query($koneksi, $sql);
                    while ($kategori = mysqli_fetch_array($query)) {
                        echo "<option value='{$kategori['id_tanaman']}'>{$kategori['jenis_tanaman']}</option>";
                    }
                    ?>
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