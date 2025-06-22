<?php
  session_start();

  if (!isset($_SESSION['user'])) 
  {
    header('');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>FurniSpace</title>
  <link rel="icon" type="image/png" href="../gambar/logoonly.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../css/home.css">
</head>
<body>
<header role="banner">
  <div class="container header-inner">
    
    <a class="logo" aria-label="Furnispace homepage" href="home.php" style="text-decoration: none;">
        <img src="../gambar/logoonly.png" alt="Logo" class="logo" style="width: 50px; height: 50px;">
         Furnispace
    </a>
    <form class="search-bar" action="search.php" method="get" style="display: flex; align-items: center; margin-left: -39px;">
      <input type="search" name="keyword" placeholder="Search furniture..." aria-label="Search furniture" required />
      <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;">
        <span class="material-icons search-icon" aria-label="Search icon">search</span>
      </button>
    </form>
    <div class="header-icons" role="navigation" aria-label="Header navigation icons">
    <?php if (isset($_SESSION['user'])): ?>
      <button class="icon-button" aria-label="View shopping cart" onclick="window.location.href='keranjang.php';">
        <span class="material-icons" style="font-size: 30px;">shopping_cart</span>
      </button>
    <?php else: ?>
      <button class="icon-button" aria-label="Login to view shopping cart" onclick="window.location.href='loginUser.php';">
        <span class="material-icons" style="font-size: 30px;">shopping_cart</span>
      </button>
    <?php endif; ?>
  </div>
</header>
<main class="container" role="main" tabindex="-1">
    <?php
    // Ambil ID produk dari parameter GET
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        // Koneksi ke database
        require_once '../databases/koneksi.php';

        // Query ambil data produk
        $stmt = $koneksi->prepare("SELECT * FROM data_produk WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($produk = $result->fetch_assoc()) {
            // Tampilkan detail produk dalam container
            ?>
            <div class="product-detail-container" style="background: #fffde7; border-radius: 16px; box-shadow: 0 4px 24px rgba(251,192,45,0.12); padding: 32px; margin-top: 40px;">
            <div style="display: flex; gap: 32px; align-items: flex-start;">
                <div style="flex: 0 0 600px;">
                    <img src="../gambar/<?php echo htmlspecialchars($produk['gambar']); ?>" alt="<?php echo htmlspecialchars($produk['nama']); ?>" style="width: 100%; max-width: 600px; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                </div>
                <div style="flex: 1; margin-left: 40px;">
                    <!-- Geser nama, harga, detail ke atas -->
                    <h2 style="margin-top: 0; color: #5a4700; font-size: 1.8em;"><?php echo htmlspecialchars($produk['nama']); ?></h2>
                    <div style="font-size: 2.5em; color: #fbc02d; font-weight: bold; margin-bottom: 18px; margin-top: 40px;">
                        Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
                    </div>
                    <div style="font-size: 0.95em; color: #7a6500; margin-bottom: 20px; margin-top: 50px;">
                        <strong>Detail Produk:</strong>
                    </div>
                    <div style="text-align: justify; margin-right: 30px;">
                        <?php echo nl2br(htmlspecialchars($produk['detail'])); ?>
                    </div>
                    <!-- Tambahkan jarak antara detail dan tombol aksi -->
                    <div style="height: 100px;"></div>
                    <!-- Tombol aksi -->
                    <div style="display: flex; flex-direction: column; gap: 18px;">
                        <form method="post" action="" style="display: flex; align-items: center; gap: 12px;">
                            <input type="hidden" name="product_id" value="<?php echo $produk['id']; ?>">
                            <label for="qty_all" style="margin-right: 8px; color: #7a6500;">Jumlah:</label>
                            <input type="number" id="qty_all" name="quantity" value="1" min="1" style="width: 60px; padding: 6px; border-radius: 6px; border: 1px solid #fbc02d; margin-right: 12px;">
                            <!-- Tombol dipindahkan ke bawah -->
                        </form>
                        <div style="display: flex; gap: 18px;">
                            <?php if (isset($_SESSION['user'])): ?>
                                <form id="addToCartForm" method="post" action="" style="margin: 0;">
                                    <input type="hidden" name="id" value="<?php echo $produk['id']; ?>">
                                    <input type="hidden" name="nama" value="<?php echo htmlspecialchars($produk['nama']); ?>">
                                    <input type="hidden" name="harga" value="<?php echo $produk['harga']; ?>">
                                    <input type="hidden" name="gambar" value="<?php echo htmlspecialchars($produk['gambar']); ?>">
                                    <input type="hidden" name="quantity" id="cart_quantity" value="1">
                                    <button type="submit" name="add_to_cart" style="background: #fbc02d; color: #fff; border: none; border-radius: 8px; padding: 12px 28px; font-weight: 600; font-size: 1em; cursor: pointer;">
                                        <i class="fa fa-cart-plus"></i> Masukkan ke Keranjang
                                    </button>
                                </form>
                            <?php else: ?>
                                <button onclick="window.location.href='loginUser.php';" style="background: #fbc02d; color: #fff; border: none; border-radius: 8px; padding: 12px 28px; font-weight: 600; font-size: 1em; cursor: pointer;">
                                    <i class="fa fa-cart-plus"></i> Masukkan ke Keranjang
                                </button>
                            <?php endif; ?>
                            <div id="cart-notification-popup" style="display:none; position: fixed; top: 30px; left: 50%; transform: translateX(-50%); background: #388e3c; color: #fff; font-weight: bold; padding: 18px 36px; border-radius: 10px; box-shadow: 0 4px 16px rgba(0,0,0,0.18); z-index: 9999; font-size: 1.1em;">
                                Barang berhasil ditambahkan ke keranjang!
                            </div>
                            <script>
                                document.getElementById('addToCartForm').addEventListener('submit', function(e) {
                                    e.preventDefault();
                                    var formData = new FormData(this);
                                    fetch('keranjang.php', {
                                        method: 'POST',
                                        body: formData
                                    })
                                    .then(response => response.ok ? response.text() : Promise.reject())
                                    .then(() => {
                                        var popup = document.getElementById('cart-notification-popup');
                                        popup.style.display = 'block';
                                        setTimeout(function() {
                                            popup.style.display = 'none';
                                        }, 2000);
                                    })
                                    .catch(() => {
                                        alert('Gagal menambahkan ke keranjang.');
                                    });
                                });
                            </script>
                        </div>
                        <script>
                            // Sinkronkan input jumlah ke kedua form tombol
                            document.addEventListener('DOMContentLoaded', function() {
                                var qtyInput = document.getElementById('qty_all');
                                var cartQty = document.getElementById('cart_quantity');
                                var checkoutQty = document.getElementById('checkout_quantity');
                                qtyInput.addEventListener('input', function() {
                                    cartQty.value = qtyInput.value;
                                    checkoutQty.value = qtyInput.value;
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
            </div>
            <?php
            // Proses form jika ada submit
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['quantity'])) {
            $product_id = intval($_POST['id']);
            $quantity = intval($_POST['quantity']);
            if (isset($_POST['add_to_cart'])) {
                // Redirect ke keranjang.php dengan POST
                echo "<form id='cartForm' method='post' action='keranjang.php' style='display:none;'>
                <input type='hidden' name='id' value='{$product_id}'>
                <input type='hidden' name='quantity' value='{$quantity}'>
                </form>
                <script>document.getElementById('cartForm').submit();</script>";
            } 
            }
        } else {
            echo "<div style='color: #d84315; font-weight: bold;'>Produk tidak ditemukan.</div>";
        }
        $stmt->close();
        $koneksi->close();
    } else {
        echo "<div style='color: #d84315; font-weight: bold;'>Tidak ada produk yang dipilih.</div>";
    }
    ?>
</main>
<br><br>
<footer role="contentinfo">
  <div class="container footer-container">
    &copy; 2025 Furnispace. All rights reserved.
  </div>
</footer>

</body>
</html>

