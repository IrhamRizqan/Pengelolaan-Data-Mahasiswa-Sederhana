<?php
require "fungsi.php";
require "koneksi.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = trim($_POST["nim"]);
    $nama = trim($_POST["nama"]);
    $email = trim($_POST["email"]);
    $jenis_kelamin = isset($_POST["jenis_kelamin"]) ? $_POST["jenis_kelamin"] : "";
    $prodi = trim($_POST["prodi"]);

    if ($nim == "" || $nama == "" || $email == "" || $jenis_kelamin == "" || $prodi == "") {
        $error = "Semua kolom wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } else {
        try {
            $sql = $koneksi->prepare(
                "INSERT INTO mahasiswa (nim, nama, email, jenis_kelamin, prodi) VALUES (?, ?, ?, ?, ?)"
            );
            $sql->execute([$nim, $nama, $email, $jenis_kelamin, $prodi]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error = "Data gagal disimpan. Pastikan NIM belum digunakan.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container small">
        <h2>Tambah Mahasiswa</h2>
        <?php if ($error != "") { ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p><?php } ?>
        <form method="POST" action="tambah.php">
            <label>NIM</label>
            <input type="text" name="nim" required value="<?php echo isset($nim) ? htmlspecialchars($nim) : ''; ?>">

            <label>Nama Lengkap</label>
            <input type="text" name="nama" required value="<?php echo isset($nama) ? htmlspecialchars($nama) : ''; ?>">

            <label>Email</label>
            <input type="email" name="email" required
                value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">

            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" required>
                <option value="">Pilih</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>

            <label>Program Studi</label>
            <select name="prodi" required>
                <option value="">Pilih</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Sistem Informasi">Sistem Informasi</option>
                <option value="Manajemen Informatika">Manajemen Informatika</option>
            </select>

            <button type="submit">Simpan</button>
            <a href="index.php">Kembali</a>
        </form>
    </div>
</body>

</html>