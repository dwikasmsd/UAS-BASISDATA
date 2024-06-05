<?php
session_start();
include("config.php");

$id_pertanyaan = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['jawaban'])) {
        $jawaban = $_POST['jawaban'];
        $id_user = $_SESSION['id_user']; // Ambil ID pengguna dari sesi

        $sql = "INSERT INTO jawaban (id_pertanyaan, jawaban, id_user, tanggal) VALUES (?, ?, ?, CURRENT_DATE())";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "isi", $id_pertanyaan, $jawaban, $id_user);
        mysqli_stmt_execute($stmt);
    } elseif (isset($_POST['like'])) {
        $id_jawaban = $_POST['id_jawaban'];
        $id_user = $_SESSION['id_user'];

        $sql = "UPDATE jawaban SET likes = likes + 1 WHERE id_jawaban = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_jawaban);
        mysqli_stmt_execute($stmt);

        $sql = "SELECT id_user FROM jawaban WHERE id_jawaban = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_jawaban);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $jawaban = mysqli_fetch_array($result);

        $id_user_jawaban = $jawaban['id_user'];

        $sql = "UPDATE pengguna SET quality_points = quality_points + 2 WHERE id = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_user_jawaban);
        mysqli_stmt_execute($stmt);
    } elseif (isset($_POST['report'])) {
        $type = $_POST['type'];
        $id = $_POST['id'];

        if ($type == 'pertanyaan') {
            $sql = "INSERT INTO laporan_pertanyaan (id_pertanyaan, id_user, tanggal) VALUES (?, ?, CURRENT_DATE())";
        } else {
            $sql = "INSERT INTO laporan_jawaban (id_jawaban, id_user, tanggal) VALUES (?, ?, CURRENT_DATE())";
        }

        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $id, $_SESSION['id_user']);
        mysqli_stmt_execute($stmt);
    }
}

$sql = "SELECT pertanyaan.*, pengguna.nama_lengkap FROM pertanyaan JOIN pengguna ON pertanyaan.id_user = pengguna.id WHERE id_pertanyaan = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_pertanyaan);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pertanyaan = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pertanyaan</title>
    <style>
        <?php include("aset/sidebar.css"); ?>* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
        }

        .sidebar a.active {
            background-color: #04AA6D;
            color: white;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: white;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table_header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table_header button {
            padding: 10px 20px;
            background-color: #04AA6D;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .table_header button:hover {
            background-color: #039e63;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        h3 {
            margin-bottom: 15px;
            color: #555;
        }

        p {
            margin-bottom: 15px;
            color: #666;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        form textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        form button {
            padding: 10px 20px;
            background-color: #04AA6D;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #039e63;
        }

        .jawaban {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .jawaban strong {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .jawaban p {
            margin: 0;
            color: #555;
        }

        .jawaban small {
            display: block;
            margin-top: 5px;
            color: #888;
        }

        .jawaban .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .jawaban .actions form {
            margin: 0;
        }

        .jawaban .actions button {
            padding: 5px 10px;
            background-color: #04AA6D;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .jawaban .actions button.report {
            background-color: #f44336;
        }

        .jawaban .actions button:hover {
            background-color: #039e63;
        }

        .jawaban .actions button.report:hover {
            background-color: #e31b0c;
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
                <a href="pertanyaan.php"><button class="add_new">Kembali</button></a>
            </div>
            <h2>Detail Pertanyaan</h2>
            <p><?php echo "<h3 style='font-weight: 200;'>" . $pertanyaan['isi_pertanyaan'] . "</h3>" ?></p>

            <?php if ($pertanyaan['gambar']) : ?>
                <p>
                    <img style="width: 400px; height: 340px;" src="<?php echo $pertanyaan['gambar']; ?>" alt="Question Image">
                </p>
            <?php endif; ?>

            <div class="actions">
                <form action="detailPertanyaan.php?id=<?php echo $id_pertanyaan; ?>" method="POST">
                    <input type="hidden" name="type" value="pertanyaan">
                    <input type="hidden" name="id" value="<?php echo $id_pertanyaan; ?>">
                    <button type="submit" name="report" class="report">Laporkan Pertanyaan</button>
                </form>
            </div>

            <h3>Jawaban</h3>
            <?php
            $sql = "SELECT jawaban.*, pengguna.nama_lengkap, COUNT(laporan_jawaban.id_laporanJawaban) AS laporan_count
                FROM jawaban 
                JOIN pengguna ON jawaban.id_user = pengguna.id
                LEFT JOIN laporan_jawaban ON laporan_jawaban.id_jawaban = jawaban.id_jawaban
                WHERE jawaban.id_pertanyaan = ?
                GROUP BY jawaban.id_jawaban, jawaban.jawaban, jawaban.id_user, jawaban.tanggal, pengguna.nama_lengkap
                ORDER BY jawaban.tanggal DESC";
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id_pertanyaan);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($jawaban = mysqli_fetch_array($result)) {
                echo "
                    <div class='jawaban'>
                        <strong>{$jawaban['nama_lengkap']}:</strong>
                        <p>{$jawaban['jawaban']}</p>
                        <small>({$jawaban['tanggal']})</small>
                        <small>Laporan: {$jawaban['laporan_count']}</small>
                        <div class='actions'>
                            <form action='detailPertanyaan.php?id={$id_pertanyaan}' method='POST'>
                                <input type='hidden' name='id_jawaban' value='{$jawaban['id_jawaban']}'>
                                <button type='submit' name='like'>Like ({$jawaban['likes']})</button>
                            </form>
                            <form action='detailPertanyaan.php?id={$id_pertanyaan}' method='POST'>
                                <input type='hidden' name='type' value='jawaban'>
                                <input type='hidden' name='id' value='{$jawaban['id_jawaban']}'>
                                <button type='submit' name='report' class='report'>Laporkan Jawaban</button>
                            </form>
                        </div>
                    </div>";
            }
            ?>

            <h3>Post a Jawaban</h3>
            <form action="detailPertanyaan.php?id=<?php echo $id_pertanyaan; ?>" method="POST">
                <textarea name="jawaban" required></textarea>
                <br>
                <button type="submit">Post Jawaban</button>
            </form>
        </div>
    </div>
</body>

</html>