<?php
include 'koneksi.php';

if (isset($_GET['id']) && is_numeric($_GET['id']) && !isset($_POST['confirm'])) {
    $id = intval($_GET['id']);
    // Ambil data gambar untuk ditampilkan jika perlu
    $stmt = $koneksi->prepare("SELECT gambar FROM data_produk WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($gambar);
    $stmt->fetch();
    $stmt->close();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Konfirmasi Hapus</title>
    </head>
    <body>
        <h3>Apakah Anda yakin ingin menghapus data ini?</h3>
        <?php
        // Ambil juga nama, harga, dan detail barang
        $stmt2 = $koneksi->prepare("SELECT nama, harga, detail FROM data_produk WHERE id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->bind_result($nama, $harga, $detail);
        $stmt2->fetch();
        $stmt2->close();
        ?>
        <ul>
            <li><strong>Nama:</strong> <?php echo htmlspecialchars($nama); ?></li>
            <li><strong>Harga:</strong> <?php echo htmlspecialchars($harga); ?></li>
            <li><strong>Detail:</strong> <?php echo htmlspecialchars($detail); ?></li>
        </ul>
        <?php if ($gambar): ?>
            <img src="../gambar/<?php echo htmlspecialchars($gambar); ?>" width="150"><br>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="confirm" value="yes">
            <button type="submit">Ya, Hapus</button>
            <a href="../resources/dashboard.php"><button type="button">Batal</button></a>
        </form>
    </body>
    </html>
    <?php
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_POST['confirm'])) {
    $id = intval($_GET['id']);

    // Ambil data gambar
    $stmt = $koneksi->prepare("SELECT gambar FROM data_produk WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($gambar);
    $stmt->fetch();
    $stmt->close();

    // Hapus file gambar jika ada
    if ($gambar && file_exists("../gambar/" . $gambar)) {
        unlink("../gambar/" . $gambar);
    }

    // Hapus data dari database
    $stmt = $koneksi->prepare("DELETE FROM data_produk WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../resources/dashboard.php");
    exit();
} else if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID tidak valid.";
}
?>