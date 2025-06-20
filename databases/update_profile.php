<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['id'])) {
    die('Akses ditolak');
}

$id = $_SESSION['id'];

// Hanya jalankan jika tombol "update" diklik
if (isset($_POST['update'])) {
    $fields = [];

    // Ambil dan amankan input
    if (!empty($_POST['username'])) {
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        $fields[] = "username='$username'";
    }
    if (!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($koneksi, $_POST['password']);
        $fields[] = "password='$password'";
    }
    if (!empty($_POST['Email'])) {
        $email = mysqli_real_escape_string($koneksi, $_POST['Email']);
        $fields[] = "Email='$email'";
    }
    if (!empty($_POST['alamat'])) {
        $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
        $fields[] = "alamat='$alamat'";
    }

    // Jalankan query jika ada data yang diubah
    if (!empty($fields)) {
        $sql = "UPDATE user SET " . implode(', ', $fields) . " WHERE id='$id'";
        $update = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

       // Perbarui data session setelah update
        $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id='$id'");
        if ($row = mysqli_fetch_assoc($query)) {
            $_SESSION['user'] = $row;
        }


        // Redirect dengan alert
        echo '<script>
            alert("Profil berhasil diperbarui!");
            window.location.href = "../resources/home.php?t=" + new Date().getTime();
        </script>';
    } else {
        echo '<script>
            alert("Tidak ada data yang diubah.");
            history.back();
        </script>';
    }
}
