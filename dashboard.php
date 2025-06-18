<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furnispace Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style/dashboard.css">

</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
         <?php include 'components/sidebar.php'; ?>
        
        <!-- Main Content -->
        <?php include 'components/header.php'; ?>
            
            <!-- Products Section -->
            <div class="products-section">
                <h2 class="section-title">Daftar Produk</h2>
                
                <div class="product-form">
                    <div class="form-group">
                        <label for="product-name">Nama Produk</label>
                        <input type="text" id="product-name" class="form-control" placeholder="Masukkan nama produk">
                    </div>
                    
                    <div class="form-group">
                        <label for="product-price">Harga</label>
                        <input type="number" id="product-price" class="form-control" placeholder="Masukkan harga">
                    </div>
                    
                    <div class="form-group">
                        <label for="product-details">Detail Produk</label>
                        <textarea id="product-details" class="form-control" rows="4" placeholder="Deskripsi produk"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Input Gambar</label>
                        <div class="image-upload">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Klik untuk mengunggah gambar produk</p>
                        </div>
                    </div>
                </div>
                
                <div class="products-list">
                    <h2 class="section-title">Produk Tersedia</h2>
                    
                    <div class="product-grid">
                        <!-- Product 1 -->
                        <div class="product-card">
                            <div class="product-image">
                                <i class="fas fa-couch"></i>
                            </div>
                            <div class="product-details">
                                <h3 class="product-name">Sofa Minimalis</h3>
                                <div class="product-price">Rp 2.499.000</div>
                                <p class="product-description">Sofa 3 dudukan dengan bahan kulit sintetis berkualitas tinggi, nyaman dan tahan lama.</p>
                                <div class="product-actions">
                                    <button class="btn btn-edit">
                                        <i class="fas fa-edit"></i> EDIT
                                    </button>
                                    <button class="btn btn-remove">
                                        <i class="fas fa-trash"></i> REMOVE
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product 2 -->
                        <div class="product-card">
                            <div class="product-image">
                                <i class="fas fa-chair"></i>
                            </div>
                            <div class="product-details">
                                <h3 class="product-name">Kursi Kayu Jati</h3>
                                <div class="product-price">Rp 1.250.000</div>
                                <p class="product-description">Kursi makan berbahan kayu jati asli dengan finishing natural, elegan dan kokoh.</p>
                                <div class="product-actions">
                                    <button class="btn btn-edit">
                                        <i class="fas fa-edit"></i> EDIT
                                    </button>
                                    <button class="btn btn-remove">
                                        <i class="fas fa-trash"></i> REMOVE
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product 3 -->
                        <div class="product-card">
                            <div class="product-image">
                                <i class="fas fa-bed"></i>
                            </div>
                            <div class="product-details">
                                <h3 class="product-name">Tempat Tidur King</h3>
                                <div class="product-price">Rp 4.999.000</div>
                                <p class="product-description">Tempat tidur ukuran king size dengan rangka besi dan kayu solid, dilengkapi 2 laci penyimpanan.</p>
                                <div class="product-actions">
                                    <button class="btn btn-edit">
                                        <i class="fas fa-edit"></i> EDIT
                                    </button>
                                    <button class="btn btn-remove">
                                        <i class="fas fa-trash"></i> REMOVE
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
        
       // Exit button functionality
        document.querySelector('.exit').addEventListener('click', function() {
            if(confirm('Apakah Anda yakin ingin keluar dari admin panel?')) {
            window.location.href = 'loginAdmin.php';
            }
        });
    </script>
    <script src="alur.js"></script>

</body>
</html>