<?php
require "fungsi.php";
require "koneksi.php";

if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET["id"];
$sql = $koneksi->prepare("SELECT * FROM mahasiswa WHERE id = ?");
$sql->execute([$id]);
$mhs = $sql->fetch(PDO::FETCH_ASSOC);

if (!$mhs) {
    header("Location: index.php");
    exit;
}

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
                "UPDATE mahasiswa SET nim = ?, nama = ?, email = ?, jenis_kelamin = ?, prodi = ? WHERE id = ?"
            );
            $sql->execute([$nim, $nama, $email, $jenis_kelamin, $prodi, $id]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error = "Data gagal diubah. Pastikan NIM tidak dipakai mahasiswa lain.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container small">
        <h2>Edit Mahasiswa</h2>
        <?php if ($error != "") { ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p><?php } ?>
        <form method="POST" action="edit.php?id=<?php echo $id; ?>">
            <label>NIM</label>
            <input type="text" name="nim" required
                value="<?php echo htmlspecialchars(isset($nim) ? $nim : $mhs["nim"]); ?>">

            <label>Nama Lengkap</label>
            <input type="text" name="nama" required
                value="<?php echo htmlspecialchars(isset($nama) ? $nama : $mhs["nama"]); ?>">

            <label>Email</label>
            <input type="email" name="email" required
                value="<?php echo htmlspecialchars(isset($email) ? $email : $mhs["email"]); ?>">

            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" required>
                <option value="Laki-laki" <?php echo (isset($jenis_kelamin) ? $jenis_kelamin : $mhs["jenis_kelamin"]) == "Laki-laki" ? "selected" : ""; ?>>Laki-laki</option>
                <option value="Perempuan" <?php echo (isset($jenis_kelamin) ? $jenis_kelamin : $mhs["jenis_kelamin"]) == "Perempuan" ? "selected" : ""; ?>>Perempuan</option>
            </select>

            <label>Program Studi</label>
            <select name="prodi" required>
                <option value="Teknik Informatika" <?php echo (isset($prodi) ? $prodi : $mhs["prodi"]) == "Teknik Informatika" ? "selected" : ""; ?>>Teknik Informatika</option>
                <option value="Sistem Informasi" <?php echo (isset($prodi) ? $prodi : $mhs["prodi"]) == "Sistem Informasi" ? "selected" : ""; ?>>Sistem Informasi</option>
                <option value="Manajemen Informatika" <?php echo (isset($prodi) ? $prodi : $mhs["prodi"]) == "Manajemen Informatika" ? "selected" : ""; ?>>Manajemen Informatika</option>
            </select>

            <button type="submit">Simpan Perubahan</button>
            <a href="index.php">Kembali</a>
        </form>
    </div>
</body>

</html>