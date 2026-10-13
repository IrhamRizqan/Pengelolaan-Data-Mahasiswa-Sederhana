<?php
session_start();

if (isset($_GET["lang"])) {
    if ($_GET["lang"] == "id" || $_GET["lang"] == "en") {
        $_SESSION["bahasa"] = $_GET["lang"];
    }
}

$kembali = isset($_GET["kembali"]) ? $_GET["kembali"] : "index.php";
header("Location: " . $kembali);
exit;
?>