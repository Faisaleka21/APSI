<?php
include '../databases/koneksi.php';

if (mysqli_connect_errno()) {
    echo "Gagal terhubung ke MySQL: " . mysqli_connect_error();
    exit();
}

$search_query = "";
if (isset($_GET['search'])) {
    $search_query = mysqli_real_escape_string($koneksi, $_GET['search']);
}

$sql = "SELECT * FROM data_pembeli";
if (!empty($search_query)) {
    $sql .= " WHERE username LIKE '%$search_query%' OR nama_barang LIKE '%$search_query%'";
}
$sql .= " ORDER BY id DESC";

$dataPembeli = mysqli_query($koneksi, $sql);

$no = 1;
if (mysqli_num_rows($dataPembeli) > 0) {
    while ($pembeli = mysqli_fetch_array($dataPembeli)): ?>
        <tr>
            <td style="padding: 10px;"><?php echo $no++; ?></td>
            <td style="padding: 10px;"><?php echo htmlspecialchars($pembeli['username']); ?></td>
            <td style="padding: 10px;"><?php echo htmlspecialchars($pembeli['alamat']); ?></td>
            <td style="padding: 10px;"><?php echo htmlspecialchars($pembeli['nama_barang']); ?></td>
            <td style="padding: 10px;"><?php echo htmlspecialchars($pembeli['jumlah']); ?></td>
            <td style="padding: 10px;"><?php echo number_format($pembeli['total'], 0, ',', '.'); ?></td>
            <td style="padding: 10px;"><?php echo htmlspecialchars($pembeli['pembayaran']); ?></td>
            <td style="padding: 10px;"><?php echo htmlspecialchars($pembeli['tanggal']); ?></td>
            <td style="padding: 10px;">
                <button class="hapus-pembeli-btn" data-id="<?php echo $pembeli['id']; ?>" style="color: #FF5252; background: none; border: none; cursor: pointer; font-weight: bold;">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </td>
        </tr>
    <?php endwhile;
} else { ?>
    <tr>
        <td colspan="8" style="padding: 10px; text-align: center;">Tidak ada data ditemukan.</td>
    </tr>
<?php }

mysqli_close($koneksi);
?>