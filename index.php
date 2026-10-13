<?php
require "fungsi.php";
require "koneksi.php";

$kata = isset($_GET["cari"]) ? trim($_GET["cari"]) : "";

if ($kata != "") {
    $sql = $koneksi->prepare(
        "SELECT * FROM mahasiswa WHERE nim LIKE ? OR nama LIKE ? ORDER BY id DESC"
    );
    $sql->execute(["%$kata%", "%$kata%"]);
} else {
    $sql = $koneksi->query("SELECT * FROM mahasiswa ORDER BY id DESC");
}
$data = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="<?php echo $bahasa == 'en' ? 'en' : 'id'; ?>">

<head>
    <meta charset="UTF-8">
    <title><?php echo teks("Data Mahasiswa", "Student Data"); ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="top">
            <h2><?php echo teks("Sistem Data Mahasiswa", "Student Data System"); ?></h2>
            <div>
                <?php echo teks("Login sebagai", "Logged in as"); ?>:
                <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong>
                | <a href="bahasa.php?lang=id&kembali=index.php">Indonesia</a>
                | <a href="bahasa.php?lang=en&kembali=index.php">English</a>
                | <a href="logout.php"><?php echo teks("Keluar", "Logout"); ?></a>
            </div>
        </div>

        <p><a class="button" href="tambah.php"><?php echo teks("Tambah Mahasiswa", "Add Student"); ?></a></p>

        <form method="GET" action="index.php" class="search">
            <input type="text" name="cari" value="<?php echo htmlspecialchars($kata); ?>"
                placeholder="<?php echo teks("Cari NIM atau nama", "Search ID or name"); ?>">
            <button type="submit"><?php echo teks("Cari", "Search"); ?></button>
            <a href="index.php"><?php echo teks("Reset", "Reset"); ?></a>
        </form>

        <table>
            <tr>
                <th>NIM</th>
                <th><?php echo teks("Nama", "Name"); ?></th>
                <th>Email</th>
                <th><?php echo teks("Jenis Kelamin", "Gender"); ?></th>
                <th><?php echo teks("Program Studi", "Study Program"); ?></th>
                <th><?php echo teks("Aksi", "Actions"); ?></th>
            </tr>
            <?php if (count($data) > 0) { ?>
                <?php foreach ($data as $mhs) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($mhs["nim"]); ?></td>
                        <td><?php echo htmlspecialchars($mhs["nama"]); ?></td>
                        <td><?php echo htmlspecialchars($mhs["email"]); ?></td>
                        <td><?php echo htmlspecialchars($mhs["jenis_kelamin"]); ?></td>
                        <td><?php echo htmlspecialchars($mhs["prodi"]); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $mhs["id"]; ?>"><?php echo teks("Edit", "Edit"); ?></a> |
                            <a href="hapus.php?id=<?php echo $mhs["id"]; ?>"
                                onclick="return confirm('<?php echo teks("Yakin ingin menghapus data ini?", "Delete this record?"); ?>')">
                                <?php echo teks("Hapus", "Delete"); ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6"><?php echo teks("Data tidak ditemukan.", "No data found."); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>