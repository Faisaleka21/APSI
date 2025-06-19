<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FurniSpace | Login</title>
    <link rel="icon" type="image/png" href="gambar/logoonly.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 40px 32px;
            width: 350px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 24px;
        }
        h2 {
            margin: 0 0 24px 0;
            color: #333;
        }
        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        input[type="text"], input[type="password"], input[type="email"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }
        button {
            padding: 10px;
            border: none;
            border-radius: 6px;
            background: #ffe066;
            color: #333;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover {
            background: #ffd700;
        }
        .toggle-link {
            margin-top: 16px;
            font-size: 14px;
            color: #888;
            cursor: pointer;
            text-decoration: underline;
            background: none;
            border: none;
        }
    </style>
</head>
<body>

    <?php
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        $password = $_POST['password']; // Hash password with md5

        // Cek apakah username dan password cocok
        $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");

        if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_array($query);
            $_SESSION['user'] = $data;
            $_SESSION['id'] = $data['id']; // Tambahkan id ke session
            header('Location: index.php');
            exit();
        } else {
            echo "<script>alert('Username atau password salah!');</script>";
        }
    }
    ?>

    <div class="container">
    <img src="gambar/logo.png" alt="Logo" class="logo" style="width: 150px; height: 150px;">
    <form id="login-form" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <br>
    <a href="register.php" style="text-decoration: none;">
    <button type="button" style="background: none;">Belum punya akun? Register</button>
    </a>
    </div>
    
</body>
</html>