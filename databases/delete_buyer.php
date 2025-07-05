<?php
include '../databases/koneksi.php';

if (mysqli_connect_errno()) {
    echo json_encode(['status' => 'error', 'message' => 'Gagal terhubung ke MySQL: ' . mysqli_connect_error()]);
    exit();
}

// Pastikan permintaan adalah POST dan ID pembeli diterima
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id_pembeli = mysqli_real_escape_string($koneksi, $_POST['id']);

    $sql = "DELETE FROM data_pembeli WHERE id = '$id_pembeli'";

    if (mysqli_query($koneksi, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Data pembeli berhasil dihapus.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data: ' . mysqli_error($koneksi)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Permintaan tidak valid.']);
}

mysqli_close($koneksi);
?>