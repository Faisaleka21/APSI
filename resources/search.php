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
require_once '../databases/koneksi.php';

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

echo '<h2>Hasil Pencarian</h2>';

if ($keyword !== '') {
    $stmt = $koneksi->prepare("SELECT * FROM data_produk WHERE nama LIKE ? OR detail LIKE ?");
    $search = "%$keyword%";
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Tentukan jumlah minimal kolom grid (misal: 4)
        $minColumns = 5;
        $produk = [];
        while ($row = $result->fetch_assoc()) {
            $produk[] = $row;
        }
        $count = count($produk);


        echo '<div class="product-grid" style="
              display: grid;
              grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
              gap: 30px;
            ">';
        // Tampilkan produk yang ditemukan
        foreach ($produk as $row) {
            echo '<a href="detail.php?id=' . urlencode($row['id']) . '" style="text-decoration: none; color: inherit; height: 100%;">';
            echo '<div class="product-card" style="width: 100%; display: flex; flex-direction: column; height: 100%; min-height: 340px;">';
            echo '<div class="product-image" style="flex: 0 0 auto;">';
            echo '<img src="../gambar/' . htmlspecialchars($row['gambar']) . '" style="width: 100%; object-fit: cover; aspect-ratio: 1/1; border-radius: 8px;"' . htmlspecialchars($row['nama']) . '">';
            echo '<div class="product-details" style="flex: 1 1 auto; display: flex; flex-direction: column; justify-content: flex-end; padding: 14px; text-align: left;">';
            echo '<h3 style="margin-bottom: 6px;">' . htmlspecialchars($row['nama']) . '</h3>';
            echo '<div class="product-price" style="color: #fbc02d; font-size: 1.05rem; margin-bottom: 6px;">';
            echo '<p><strong>Rp ' . number_format($row['harga'], 0, ',', '.') . '</strong></p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</a>';
        }
        // Tambahkan card kosong jika jumlah produk kurang dari jumlah kolom grid
        for ($i = $count; $i < $minColumns; $i++) {
            echo '<div class="produk-card empty"></div>';
        }
        echo '</div>';
    } else {
        echo '<p>Tidak ada produk yang ditemukan untuk kata kunci: <strong>' . htmlspecialchars($keyword) . '</strong></p>';
    }
    $stmt->close();
} else {
    echo '<p>Silakan masukkan kata kunci pencarian.</p>';
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

