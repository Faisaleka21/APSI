<?php
// status_pengiriman.php
session_start();
require_once '../databases/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_items'])) {
    $selected_ids = $_POST['selected_items'];
    $cart = isset($_SESSION['add_to_cart']) ? $_SESSION['add_to_cart'] : [];
    $user = $_SESSION['user'];
    $username = $user['username'];
    $alamat = $user['alamat'];
    $tanggal = date("Y-m-d H:i:s");

    $totalKeseluruhan = 0;

    foreach ($cart as $item) {
        if (in_array($item['id'], $selected_ids)) {
            $nama_barang = $item['nama'];
            $jumlah = (int)$item['quantity'];
            $total = $item['harga'] * $jumlah;
            $totalKeseluruhan += $total;

            // Simpan ke database
            $stmt = $koneksi->prepare("INSERT INTO data_pembeli (username, alamat, nama_barang, jumlah, total, tanggal) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssids", $username, $alamat, $nama_barang, $jumlah, $total, $tanggal);
            $stmt->execute();
        }
    }

    // Hapus item yang telah dibeli dari session
    $_SESSION['add_to_cart'] = array_filter($cart, function($item) use ($selected_ids) {
        return !in_array($item['id'], $selected_ids);
    });

    // Reset indeks array
    $_SESSION['add_to_cart'] = array_values($_SESSION['add_to_cart']);

} else {
    // Jika tidak ada item dipilih
    header("Location: keranjang.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Status Pengiriman</title>
    <link rel="icon" type="image/png" href="../gambar/logoonly.png">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/keranjang.css">
</head>
<body>
<header role="banner">
  <div class="container header-inner">
    
    <a class="logo" aria-label="Furnispace homepage" href="home.php" style="text-decoration: none; margin-left: 20px;">
        <img src="../gambar/logoonly.png" alt="Logo" class="logo" style="width: 50px; height: 50px;">
         Furnispace
    </a>
  </div>
</header>
<main class="container" style="display: flex; flex-direction: row; justify-content: center; gap: 40px; align-items: flex-start; margin-top: 30px; margin-left: auto; margin-right: auto;">
    <div style="flex: 1 1 0; max-width: 700px; justify-content: center; align-items: center; text-align: center;">
        <div class="cart-items" style="margin-bottom: 30px;">
            <h1>Terima kasih telah berbelanja!</h1>
            <br><br><br>
            <div id="status" style="font-size: 28px;">✅ Pembayaran berhasil</div>
            <br><br>

            <!-- Tombol Selesaikan -->
            <button id="complete-btn" class="checkout-btn" style="width:100%; margin-top:18px; display: none;">
                Selesaikan Pesanan
            </button>

            <!-- Form ulasan, disembunyikan saat awal -->
            <form id="review-form" method="post" action="simpan_ulasan.php" style="display: none;">
                <h3>Berikan Ulasan Anda:</h3>
                <textarea name="ulasan" required style="width: 100%; height: 150px; font-size: 18px;"></textarea>
                <br>
                <button type="submit" id="complete-btn" class="checkout-btn" style="width:100%; margin-top:18px;">Kirim Ulasan</button>
            </form>
        </div>
    </div>
</main>
</body>
</html>

<script>
    document.getElementById('complete-btn').addEventListener('click', function() {
        // Sembunyikan tombol
        this.style.display = 'none';

        // Tampilkan form ulasan
        document.getElementById('review-form').style.display = 'block';
    });
</script>

    <script>
        const statusElement = document.getElementById('status');
        const completeBtn = document.getElementById('complete-btn');
        const reviewForm = document.getElementById('review-form');

        setTimeout(() => {
            statusElement.textContent = "📦 Barang sedang dibungkus";
        }, 10000);

        setTimeout(() => {
            statusElement.textContent = "🚚 Barang dalam perjalanan";
        }, 20000);

        setTimeout(() => {
            statusElement.textContent = "🏠 Barang telah sampai";
            completeBtn.style.display = 'inline-block';
        }, 30000);

        completeBtn.addEventListener('click', () => {
            completeBtn.style.display = 'none';
            reviewForm.style.display = 'block';
        });
    </script>