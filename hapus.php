<?php
require "fungsi.php";
require "koneksi.php";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {
    $id = (int) $_GET["id"];
    $sql = $koneksi->prepare("DELETE FROM mahasiswa WHERE id = ?");
    $sql->execute([$id]);
}

header("Location: index.php");
exit;
?>