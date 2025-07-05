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
                <div class="menu-item" onclick="window.location.href='dashboard.php';">
                    <i class="fas fa-box"></i>
                    <span class="menu-text">PRODUK</span>
                </div>
                <div class="menu-item active" onclick="window.location.href='data_pembeli.php';">
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
            <!-- Data Pembeli Section -->
            <div class="buyers-section" style="margin-top: 48px;">
                <div class="search-bar" style="margin-bottom: 20px;">
                    <input type="text" id="live-search-input" placeholder="Cari nama pembeli atau barang..." style="flex-grow: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; width: 100%;">
                </div>

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
                                <th style="padding: 12px; text-align: left;">Pembayaran</th>
                                <th style="padding: 12px; text-align: left;">Tanggal</th>
                                <th style="padding: 12px; text-align: left;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="buyers-table-body">
                            <?php
                            $dataPembeli = mysqli_query($koneksi, "SELECT * FROM data_pembeli ORDER BY id DESC");
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
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End of Data Pembeli Section -->
            <div class="admin-footer">
                <p>&copy; 2025 Furnispace Admin Portal. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('live-search-input');
            const buyersTableBody = document.getElementById('buyers-table-body');
            let searchTimeout;

            // Fungsi untuk mengambil dan menampilkan data
            function fetchBuyersData(query) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', '../databases/fetch_buyers.php?search=' + encodeURIComponent(query), true);

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        buyersTableBody.innerHTML = xhr.responseText;
                        // PENTING: Setelah konten diperbarui, delegasikan kembali event listener untuk tombol hapus
                        attachDeleteEventListeners();
                    } else {
                        console.error('Permintaan fetch_buyers gagal. Status: ' + xhr.status);
                    }
                };

                xhr.onerror = function() {
                    console.error('Terjadi kesalahan jaringan saat fetch_buyers.');
                };

                xhr.send();
            }

            // Fungsi untuk menangani penghapusan data
            function deleteBuyer(buyerId) {
                if (confirm('Anda yakin ingin menghapus data ini?')) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '../databases/delete_buyer.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onload = function() {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            const response = JSON.parse(xhr.responseText);
                            if (response.status === 'success') {
                                alert(response.message);
                                // Perbarui tabel setelah penghapusan berhasil
                                // Panggil kembali fetchBuyersData dengan query pencarian saat ini
                                fetchBuyersData(searchInput.value);
                            } else {
                                alert('Gagal menghapus: ' + response.message);
                                console.error('Error saat menghapus:', response.message);
                            }
                        } else {
                            console.error('Permintaan delete_buyer gagal. Status: ' + xhr.status);
                        }
                    };

                    xhr.onerror = function() {
                        console.error('Terjadi kesalahan jaringan saat delete_buyer.');
                    };

                    xhr.send('id=' + encodeURIComponent(buyerId));
                }
            }

            // Fungsi untuk melampirkan event listeners ke semua tombol hapus
            // Ini harus dipanggil SETIAP KALI tabel diperbarui (misal: setelah pencarian atau penghapusan)
            function attachDeleteEventListeners() {
                const deleteButtons = document.querySelectorAll('.hapus-pembeli-btn');
                deleteButtons.forEach(button => {
                    button.onclick = function() { // Gunakan .onclick untuk menghindari penumpukan listener
                        const buyerId = this.dataset.id;
                        deleteBuyer(buyerId);
                    };
                });
            }

            // Event listener untuk input pencarian
            searchInput.addEventListener('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    const query = searchInput.value;
                    fetchBuyersData(query);
                }, 300);
            });

            // Panggil fungsi untuk melampirkan event listeners saat halaman pertama kali dimuat
            // agar tombol hapus pada data awal berfungsi
            attachDeleteEventListeners();

        });
    </script>
    <!-- End of Data Pembeli Section -->

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