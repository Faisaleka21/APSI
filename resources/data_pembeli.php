<?php
include '../databases/koneksi.php';
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

            <div class="menu">
                <div class="menu-item active" onclick="window.location.href='dashboard.php';">
                    <i class="fas fa-box"></i>
                    <span class="menu-text">PRODUK</span>
                </div>
                <div class="menu-item " onclick="window.location.href='data_pembeli.php';">
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
                <h1 class="page-title">DATA PEMBELI</h1>
                <div class="user-info">
                    <div class="user-avatar">A</div>
                    <span>Admin Furnispace</span>
                </div>
            </div>


            <!--DATA PEMBELI -->
            <!-- data pembeli -->
            <!-- Data Pembeli Section -->
            <div class="buyers-section" style="margin-top: 48px;">
                <?php
                $dataPembeli = mysqli_query($koneksi, "SELECT * FROM data_pembeli ORDER BY id DESC");
                ?>
                <div class="buyers-table-container" style="overflow-x: auto;">
                    <table class="buyers-table" style="width: 100%; border-collapse: collapse; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.07);">
                        <thead>
                            <tr style="background: #FFD600;">
                                <th style="padding: 12px; text-align: left;">No</th>
                                <th style="padding: 12px; text-align: left;">Nama</th>
                                <th style="padding: 12px; text-align: left;">Alamat</th>
                                <th style="padding: 12px; text-align: left;">Barang</th>
                                <th style="padding: 12px; text-align: left;">Jumlah</th>
                                <th style="padding: 12px; text-align: left;">Total</th>
                                <th style="padding: 12px; text-align: left;">Tanggal</th>
                                <th style="padding: 12px; text-align: left;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($pembeli = mysqli_fetch_array($dataPembeli)): ?>
                                <tr>
                                    <td style="padding: 10px;"><?php echo $no++; ?></td>
                                    <td style="padding: 10px;"><?php echo htmlspecialchars($pembeli['username']); ?></td>
                                    <td style="padding: 10px;"><?php echo htmlspecialchars($pembeli['alamat']); ?></td>
                                    <td style="padding: 10px;"><?php echo htmlspecialchars($pembeli['nama_barang']); ?></td>
                                    <td style="padding: 10px;"><?php echo htmlspecialchars($pembeli['jumlah']); ?></td>
                                    <td style="padding: 10px;"><?php echo htmlspecialchars($pembeli['total']); ?></td>
                                    <td style="padding: 10px;"><?php echo htmlspecialchars($pembeli['tanggal']); ?></td>
                                    <td style="padding: 10px;">
                                        <button class="hapus-pembeli-btn" data-id="<?php echo $pembeli['id']; ?>" style="color: #FF5252; background: none; border: none; cursor: pointer; font-weight: bold;">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                document.querySelectorAll('.hapus-pembeli-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        if (confirm('Yakin ingin menghapus data pembeli ini?')) {
                            fetch('../databases/hapus_pembeli.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: `id=${id}`
                                })
                                .then(res => res.text())
                                .then(response => {
                                    alert('Data berhasil dihapus');
                                    // Hapus baris dari tabel langsung
                                    this.closest('tr').remove();
                                })
                                .catch(err => {
                                    alert('Gagal menghapus data');
                                    console.error(err);
                                });
                        }
                    });
                });
            </script>

            <!-- End of Data Pembeli Section -->

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