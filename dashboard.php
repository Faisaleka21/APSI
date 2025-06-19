<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FurniSpace | Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style/dashboard.css">
    <link rel="icon" type="image/png" href="gambar/logoonly.png">

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
                <Form enctype="multipart/form-data" method="POST" action="upload.php">
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
                include "koneksi.php";
                $data = mysqli_query($koneksi, "SELECT * FROM data_produk ORDER BY id DESC");
                while ($row = mysqli_fetch_array($data)){
                ?>
                
                <div class="products-list">
                    <h2 class="section-title">Produk Tersedia</h2>
                    <?php
                    // Mulai grid setiap 3 produk
                    $counter = 0;
                    ?>
                    <div class="product-grid" style="display: flex; flex-wrap: wrap; gap: 24px;">
                        <?php
                        do {
                        ?>
                        <div class="product-card" style="flex: 1 1 calc(33.333% - 24px); max-width: calc(33.333% - 24px); box-sizing: border-box; margin-bottom: 24px;">
                            <div class="product-image">
                                <img src="gambar/<?php echo htmlspecialchars($row['gambar']); ?>" style="width: 100%">
                            </div>
                            <div class="product-details">
                                <h3 class="product-name"><?php echo htmlspecialchars($row['nama']); ?></h3>
                                <div class="product-price">
                                    Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
                                </div>
                                <p class="product-description"><?php echo htmlspecialchars($row['detail']); ?></p>
                                <div class="product-actions">
                                    <a href="edit.php?id=<?php echo $row['id'] ; ?>" style="text-decoration: none;">
                                    <button class="btn btn-edit">
                                        <i class="fas fa-edit"></i> EDIT
                                    </button>
                                    </a>
                                    <a href="hapus.php?id=<?php echo $row['id'] ; ?>" style="text-decoration: none;">
                                        <button class="btn btn-remove">
                                            <i class="fas fa-trash"></i> REMOVE
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                            $counter++;
                            if ($counter % 3 == 0) {
                                echo '<div style="flex-basis: 100%; height: 0;"></div>'; // Baris baru setiap 3 card
                            }
                        } while ($row = mysqli_fetch_array($data));
                        ?>
                    </div>
                </div>

                <?php } ?>
            </div>
            
            <div class="admin-footer">
                <p>&copy; 2023 Furnispace Admin Portal. All rights reserved.</p>
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
        
        // Image upload interaction
        const imageUpload = document.querySelector('.image-upload');
        imageUpload.addEventListener('click', function() {
            alert('Fungsi upload gambar diaktifkan. Pilih gambar produk untuk diunggah.');
            this.style.borderColor = '#FFC107';
            this.style.backgroundColor = 'rgba(255, 193, 7, 0.1)';
            this.querySelector('i').style.color = '#FFC107';
            this.querySelector('p').textContent = 'Gambar terpilih: produk.jpg';
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
        
        const removeButtons = document.querySelectorAll('.btn-remove');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productCard = this.closest('.product-card');
                const productName = productCard.querySelector('.product-name').textContent;
                if(confirm(`Apakah Anda yakin ingin menghapus produk: ${productName}?`)) {
                    productCard.style.opacity = '0';
                    setTimeout(() => {
                        productCard.style.display = 'none';
                    }, 300);
                }
            });
        });
    </script>
</body>
</html>