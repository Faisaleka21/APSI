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
            
            <div class="menu">
                <div class="menu-item active">
                    <i class="fas fa-box"></i>
                    <span class="menu-text">PRODUK</span>
                </div>
                <div class="menu-item">
                    <i class="fas fa-users"></i>
                    <span class="menu-text">DATA PEMBELI</span>
                </div>
                <div class="menu-item exit" onclick="window.location.href='loginAdmin.php';">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="menu-text">EXIT</span>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1 class="page-title">PRODUK</h1>
                <div class="user-info">
                    <div class="user-avatar">A</div>
                    <span>Admin Furnispace</span>
                </div>
            </div>
            
            <!-- Products Section -->
            <div class="products-section">
                <h2 class="section-title">Daftar Produk</h2>
                <Form enctype="multipart/form-data" method="POST" action="../databases/upload.php">
                <div class="product-form">
                    <div class="form-group">
                        <label for="product-name">Nama Produk</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama produk">
                    </div>
                    
                    <div class="form-group">
                        <label for="product-price">Harga</label>
                        <input type="number" name="harga" class="form-control" placeholder="Masukkan harga">
                    </div>
                    
                    <div class="form-group">
                        <label for="product-details">Detail Produk</label>
                        <input type="text" name="detail" class="form-control" placeholder="Masukkan detail produk">
                    </div>
                    
                    <div class="form-group">
                        <label>Input Gambar</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" style="background: linear-gradient(90deg, #FFD600 0%, #FFC107 100%); color: #333; border: none; padding: 10px 24px; border-radius: 6px; font-weight: bold; cursor: pointer;">
                            Kirim
                        </button>
                    </div>
                </div>
                </form>

                <?php
                include "../databases/koneksi.php";
                $data = mysqli_query($koneksi, "SELECT * FROM data_produk ORDER BY id DESC");
                // Ambil semua data produk ke array
                $produk = [];
                while ($row = mysqli_fetch_array($data)) {
                    $produk[] = $row;
                }
                $totalProduk = count($produk);

                // Slider logic
                $perPage = 6; // 3 kolom x 2 baris
                $totalPages = ceil($totalProduk / $perPage);
                $page = isset($_GET['page']) ? max(1, min($totalPages, intval($_GET['page']))) : 1;
                $start = ($page - 1) * $perPage;
                $produkTampil = array_slice($produk, $start, $perPage);
                ?>

                <div class="products-list" id="products-list">
                    <h2 class="section-title">Produk Tersedia</h2>

                    <!-- Grid Produk -->
                    <div class="product-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; width: 100%;">
                        <?php foreach ($produkTampil as $row): ?>
                            <div class="product-card" style="background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.07); display: flex; flex-direction: column; min-height: 370px;">
                                <div class="product-image" style="width: 100%; height: 180px; display: flex; align-items: center; justify-content: center; background: #f7f7f7;">
                                    <img src="../gambar/<?php echo htmlspecialchars($row['gambar']); ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                </div>
                                <div class="product-details" style="padding: 16px; flex: 1 1 auto; display: flex; flex-direction: column; justify-content: space-between;">
                                    <h3 class="product-name" style="margin: 0 0 8px 0;"><?php echo htmlspecialchars($row['nama']); ?></h3>
                                    <div class="product-price" style="font-weight: bold; color: #FFC107; margin-bottom: 8px;">
                                        Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
                                    </div>
                                    <p class="product-description" style="margin-bottom: 16px; color: #555;"><?php echo htmlspecialchars($row['detail']); ?></p>
                                    <div class="product-actions" style="display: flex; gap: 8px;">
                                        <a href="edit.php?id=<?php echo $row['id'] ; ?>" style="text-decoration: none; flex: 1;">
                                            <button class="btn btn-edit" style="width: 100%; background: #FFD600; color: #333; border: none; padding: 8px 0; border-radius: 4px; font-weight: bold; cursor: pointer;">
                                                <i class="fas fa-edit"></i> EDIT
                                            </button>
                                        </a>
                                        <a href="../databases/hapus.php?id=<?php echo $row['id'] ; ?>" style="text-decoration: none; flex: 1;">
                                            <button class="btn btn-remove" style="width: 100%; background: #FF5252; color: #fff; border: none; padding: 8px 0; border-radius: 4px; font-weight: bold; cursor: pointer;">
                                                <i class="fas fa-trash"></i> REMOVE
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Slider angka -->
                    <div class="product-slider" style="display: flex; justify-content: center; align-items: center; margin-top: 24px; gap: 8px;">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>#products-list" style="text-decoration: none;">
                                <button style="width: 36px; height: 36px; border-radius: 50%; border: none; background: <?php echo $i == $page ? '#FFD600' : '#eee'; ?>; color: #333; font-weight: bold; cursor: pointer;">
                                    <?php echo $i; ?>
                                </button>
                            </a>
                        <?php endfor; ?>
                    </div>
                </div>
            <div class="admin-footer">
                <p>&copy; 2025 Furnispace Admin Portal. All rights reserved.</p>
            </div>
        </div>
    </div>
    
    <script>
        // Menu navigation
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                menuItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                
                // Update page title based on selected menu
                const menuText = this.querySelector('.menu-text').textContent;
                document.querySelector('.page-title').textContent = menuText;
            });
        });
        
        // Product actions
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productCard = this.closest('.product-card');
                const productName = productCard.querySelector('.product-name').textContent;
                alert(`Edit produk: ${productName}`);
            });
        });
    </script>
</body>
</html>