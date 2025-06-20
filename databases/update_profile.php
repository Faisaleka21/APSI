<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login dan id user tersedia di session
if (!isset($_SESSION['id'])) {
    die('Akses ditolak');
}

$id = $_SESSION['id'];

if (isset($_POST['update'])) {
    $fields = [];
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

    if (!empty($fields)) {
        $sql = "UPDATE user SET " . implode(', ', $fields) . " WHERE id='$id'";
        mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
        echo '<script>alert;
        location.href="../resources/home.php";</script>';
    } else {
        echo "Tidak ada data yang diubah.";
    }
}
?>