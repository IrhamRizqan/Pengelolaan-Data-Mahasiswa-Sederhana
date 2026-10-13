<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$bahasa = isset($_SESSION["bahasa"]) ? $_SESSION["bahasa"] : "id";

function teks($id, $en)
{
    global $bahasa;
    return $bahasa == "en" ? $en : $id;
}
?>