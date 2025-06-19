<?php
include 'koneksi.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil data gambar
    $stmt = $koneksi->prepare("SELECT gambar FROM data_produk WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($gambar);
    $stmt->fetch();
    $stmt->close();

    // Hapus file gambar jika ada
    if ($gambar && file_exists("gambar/" . $gambar)) {
        unlink("gambar/" . $gambar);
    }

    // Hapus data dari database
    $stmt = $koneksi->prepare("DELETE FROM data_produk WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit();
} else {
    echo "ID tidak valid.";
}
?>