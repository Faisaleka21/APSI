<?php
    session_start();
    include '../databases/koneksi.php';

    $showChangePassword = false;
    $username = '';
    $email = '';

    if (isset($_POST['username']) && isset($_POST['email']) && !isset($_POST['new_password'])) {
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        $email = mysqli_real_escape_string($koneksi, $_POST['email']);

        $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND email='$email'");
        if (mysqli_num_rows($query) > 0) {
            $showChangePassword = true;
        } else {
            echo "<script>alert('Username dan email tidak cocok!');</script>";
        }
    }

    if (isset($_POST['new_password']) && isset($_POST['username']) && isset($_POST['email'])) {
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        $email = mysqli_real_escape_string($koneksi, $_POST['email']);
        $new_password = $_POST['new_password'];

        $update = mysqli_query($koneksi, "UPDATE user SET password='$new_password' WHERE username='$username' AND email='$email'");
        if ($update) {
            echo "<script>alert('Password berhasil diubah!');window.location='loginUser.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal mengubah password!');</script>";
            $showChangePassword = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FurniSpace | Ubah Password</title>
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
            <p>Lupa Password</p>
        </div>

        <div class="login-form">
            <?php if (!$showChangePassword): ?>
            <form method="POST">
                <div class="form-group">
                    <label for="username">USERNAME</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Masukkan Username Anda" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">EMAIL</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Masukkan Email Anda" required>
                    </div>
                </div>
                <button type="submit" class="login-btn">Mengecek</button>
            </form>
            <?php else: ?>
            <form method="POST">
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <div class="form-group">
                    <label for="new_password">Password Baru</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="new_password" id="new_password" placeholder="Masukkan Password Baru" required>
                        <span class="password-toggle" onclick="togglePassword()" style="right: 11px;">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="login-btn">Ubah Password</button>
            </form>
            <?php endif; ?>
        </div>

        <div class="login-footer">
            <p>Sudah ingat password? <a href="loginUser.php">Login</a></p>
        </div>
    </div>
    <script>
        function togglePassword() 
        {
            const passwordInput = document.getElementById('new_password');
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
