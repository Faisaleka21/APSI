<?php
    session_start();
    include '../databases/koneksi.php';
?>

<?php
    if (isset($_POST['username'])) 
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Cek apakah username dan password cocok
        $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");

        if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_array($query);
            $_SESSION['user'] = $data;
            $_SESSION['id'] = $data['id']; // Tambahkan id ke session
            header('Location: home.php');
            exit();
        } else {
            echo "<script>alert('Username atau password salah!');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FurniSpace | Login</title>
    <link rel="icon" type="image/png" href="../gambar/logoonly.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/loginstyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo-container">
                <div class="logo">
                    <i class="fas fa-couch"></i>
                </div>
            </div>
            <h1>FURNISPACE</h1>
            <p>User Login</p>
        </div>

        <div class="login-form">
        <form method="POST">
            <div class="form-group">
                <label for="username">USERNAME</label>
                <div class="input-with-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Masukkan Username Anda" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">PASSWORD</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Masukkan Password Anda" required>
                    <span class="password-toggle" onclick="togglePassword()" style="right: 11px;">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <div class="login-footer" style="text-align: right; padding: 0; background: none; border: none;">
                    <br>
                    <a href="lupa_password.php">Lupa Password?</a>
                </div>
            </div>
            <button type="submit" class="login-btn">LOGIN</button>
        </form >
        </div>

        <div class="login-footer">
            <p>Belum punya akun? <a href="register.php" >Register</p>
        </div>
    </div>

    <script>
        function togglePassword() 
        {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Loading animation on login button
        document.addEventListener('DOMContentLoaded', function () 
        {
            const form = document.querySelector('form');
            const loginBtn = document.querySelector('.login-btn');
            form.addEventListener('submit', function (e) 
            {
            loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            loginBtn.disabled = true;
            // Tambahkan waktu animasi (misal 1.5 detik) sebelum submit
            e.preventDefault();
            setTimeout(function () 
            {
                form.submit();
            }, 1500); // 1500 ms = 1.5 detik
            });
        });
    </script>
</body>
</html>