<?php
include '../databases/koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM data_produk WHERE id='$_GET[id]'");
$row = mysqli_fetch_array($data);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FurniSpace | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="icon" type="image/png" href="../gambar/logoonly.png">

</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <div class="logo">
                    <i class="fas fa-couch"></i>
                </div>
                <div class="brand-name">FURNISPACE</div>
            </div>
            
            
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1 class="page-title">EDIT PRODUK</h1>
                <div class="user-info">
                    <div class="user-avatar">A</div>
                    <span>Admin Furnispace</span>
                </div>
            </div>
            
            <!-- Products Section -->
            <div class="products-section">
                <h2 class="section-title">Data Produk</h2>
                <form enctype="multipart/form-data" method="POST" action="../databases/update.php">
                <div class="product-form">
                    <!-- Tambahkan input hidden untuk id -->
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                    <div class="form-group">
                        <label for="product-name">Nama Produk</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama produk" value="<?php echo $row['nama']; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="product-price">Harga</label>
                        <input type="number" name="harga" class="form-control" placeholder="Masukkan harga" value ="<?php echo $row['harga']; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="product-details">Detail Produk</label>
                        <input type="text" name="detail" class="form-control" placeholder="Masukkan detail produk" value ="<?php echo $row['detail']; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Input Gambar</label>
                        <input type="file" name="gambar" class="form-control">
                        <p>Gambar saat ini: <?php echo htmlspecialchars($row['gambar']); ?></p>
                        <?php if (!empty($row['gambar'])): ?>
                            <div style="margin-bottom:10px;">
                                <img src="../gambar/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Gambar Produk" style="max-width:150px; max-height:150px;">
                            </div>
                        <?php endif; ?>
                        
                    </div>
                    <div class="form-group">
                        <button type="submit" name="update" style="background: linear-gradient(90deg, #FFD600 0%, #FFC107 100%); color: #333; border: none; padding: 10px 24px; border-radius: 6px; font-weight: bold; cursor: pointer;">
                            Kirim
                        </button>
                    </div>
                </div>
                </form>
            <div class="admin-footer">
                <p>&copy; 2025 Furnispace Admin Portal. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>