<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $hapus = mysqli_query($koneksi, "DELETE FROM data_pembeli WHERE id = $id");

    if ($hapus) {
        echo "sukses";
    } else {
        http_response_code(500);
        echo "gagal";
    }
} else {
    http_response_code(400);
    echo "permintaan tidak valid";
}
?>
