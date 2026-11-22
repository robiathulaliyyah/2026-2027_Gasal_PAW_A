<?php
session_start();

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem Penjualan</title>

    <style>
        body {
            font-family: Arial;
            background: #fce4ec;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: white;
            padding: 30px;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0 2px 10px #ccc;
        }

        h2 {
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #e75480;
            color: white;
            border: none;
            cursor: pointer;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h2>Login Sistem Penjualan</h2>

    <?php if (isset($_GET['pesan'])): ?>
        <p class="error">
            <?= htmlspecialchars($_GET['pesan']) ?>
        </p>
    <?php endif; ?>

    <form action="proses_login.php" method="POST">

        <label>Username</label>
        <input type="text" name="username"
               placeholder="Masukkan username" required>

        <label>Password</label>
        <input type="password" name="password"
               placeholder="Masukkan password" required>

        <button type="submit" name="login">Login</button>

    </form>

</div>

</body>
</html>