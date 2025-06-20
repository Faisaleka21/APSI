<?php
session_start();
include 'koneksi.php';
// Pastikan user sudah login
if (!isset($_SESSION['id'])) {
    die('Akses ditolak');
}  

// Pastikan id produk dikirim lewat POST
if (!isset($_POST['id'])) {
    die('ID produk tidak ditemukan');
}

$id = intval($_POST['id']);

if (isset($_POST['update'])) {
    $fields = [];

    if (!empty($_POST['nama'])) {
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $fields[] = "nama='$nama'";
    }
    if (!empty($_POST['harga'])) {
        $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
        $fields[] = "harga='$harga'";
    }
    if (!empty($_POST['detail'])) {
        $detail = mysqli_real_escape_string($koneksi, $_POST['detail']);
        $fields[] = "detail='$detail'";
    }

    // Penanganan upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "../gambar/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar = mysqli_real_escape_string($koneksi, $target_file);
            $fields[] = "gambar='$gambar'";
        }
    }

    if (!empty($fields)) {
        $sql = "UPDATE data_produk SET " . implode(', ', $fields) . " WHERE id='$id'";
        mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
        echo '<script>alert("Data berhasil diubah");location.href="../resources/dashboard.php";</script>';
    } else {
        echo "Tidak ada data yang diubah.";
    }
}
?>