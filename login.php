<?php
session_start();
require "koneksi.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if ($username == "" || $password == "") {
        $error = "Username dan password wajib diisi.";
    } else {
        $sql = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
        $sql->execute([$username]);
        $user = $sql->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            session_regenerate_id(true);
            $_SESSION["username"] = $user["username"];
            if (!isset($_SESSION["bahasa"])) {
                $_SESSION["bahasa"] = "id";
            }
            header("Location: index.php");
            exit;
        } else {
            $error = "Username atau password salah.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container small">
        <h2>Login Admin</h2>
        <?php if ($error != "") { ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php } ?>
        <form method="POST" action="login.php">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <p class="hint">login: admin / admin123</p>
    </div>
</body>

</html>