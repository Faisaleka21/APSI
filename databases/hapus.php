<?php
// hapus.php
require_once 'koneksi.php'; // Pastikan path ke file koneksi sudah benar

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Query hapus produk
    $hapus = mysqli_query($koneksi, "DELETE FROM data_produk WHERE id = $id");

    if ($hapus) {
        echo "<script>
            alert('Produk berhasil dihapus');
            window.location.href = '../resources/dashboard.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus produk');
            window.history.back();
        </script>";
    }
} else {
    echo "<script>
        alert('ID produk tidak ditemukan');
        window.history.back();
    </script>";
}
?>
