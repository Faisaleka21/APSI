<?php
session_start();
require_once '../databases/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="../gambar/logoonly.png">
<link rel="stylesheet" href="../css/home.css">
<link rel="stylesheet" href="../css/keranjang.css">
<title>FurniSpace | Keranjang</title>

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

<main class="container" style="display: flex; flex-direction: row; justify-content: center; gap: 40px; align-items: flex-start; margin-top: 30px;">
    <!-- Kiri: Alamat & Checkout Barang -->
    <div style="flex: 1 1 0; max-width: 700px;">
        <!-- Alamat Pengiriman -->
        <div class="cart-items" style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; margin-bottom: 18px;">
                <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" alt="Alamat" style="width: 25px; height: 25px; margin-right: 10px;">
                <h2 style="margin: 0; font-size: 1.5rem;">Alamat Pengiriman</h2>
            </div>
            <div>
                <span style="font-weight: 700; color: #5a4700;"><?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>, 
                <span style="font-size: 0.95em; color: #a17b00;"><?php echo htmlspecialchars($_SESSION['user']['alamat']); ?></span>
            </div>
        </div>
        <!-- Checkout Barang -->
        <div class="cart-items">
            <?php
            // Ambil data keranjang dari session
            $cart = isset($_SESSION['add_to_cart']) ? $_SESSION['add_to_cart'] : [];
            ?>
            <h1 class="checkout-title" style="margin-bottom: 30px; font-size: 1.5rem;">Checkout Barang</h1>
            <?php if (empty($cart)): ?>
                <p>Keranjang belanja kosong.</p>
            <?php else: ?>
                <table class="checkout-table" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f6f6f6;">
                            <th style="padding:12px 8px; text-align:left;">Gambar</th>
                            <th style="padding:12px 8px; text-align:left;">Nama</th>
                            <th style="padding:12px 8px; text-align:right;">Harga</th>
                            <th style="padding:12px 8px; text-align:center;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item): ?>
                            <tr style="border-bottom:1px solid #eee;">
                                <td style="padding:10px 8px;">
                                    <img src="../gambar/<?php echo htmlspecialchars($item['gambar']); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>" style="width:70px; height:70px; object-fit:cover; border-radius:6px;">
                                </td>
                                <td style="padding:10px 8px; font-weight:500;">
                                    <?php echo htmlspecialchars($item['nama']); ?>
                                </td>
                                <td style="padding:10px 8px; text-align:right;">
                                    Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?>
                                </td>
                                <td style="padding:10px 8px; text-align:center;">
                                    <?php echo (int)$item['quantity']; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <!-- Kanan: Metode & Rincian Pembayaran -->
    <div style="flex: 0 0 500px; max-width: 500px; display: flex; flex-direction: column; gap: 30px;">
        <!-- Metode Pembayaran (Card) -->
        <div class="order-summary" style="background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #0001; padding: 28px 28px 18px 28px;">
            <h2 class="summary-title" style="font-size: 1.5rem; margin-bottom: 18px;">Metode Pembayaran</h2>
            <form method="post" action="proses_checkout.php" id="checkout-form">
                <div style="margin-bottom: 10px;">
                    <label>
                        <input type="radio" name="metode_pembayaran" value="transfer_bank" required onchange="updateMetodePembayaranLabel(this)">
                        Transfer Bank
                    </label>
                    <label style="margin-left: 20px;">
                        <input type="radio" name="metode_pembayaran" value="cod" required onchange="updateMetodePembayaranLabel(this)">
                        Cash On Delivery (COD)
                    </label>
                </div>
        </div>
        <!-- Rincian Pembayaran (Card) -->
        <div class="order-summary" style="background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #0001; padding: 28px;">
            <h2 class="summary-title" style="font-size: 1.5rem; margin-bottom: 18px;">Rincian Pembayaran</h2>
            <div id="selected-items-list"></div>
            <div class="summary-row" id="metode-pembayaran-row" style="display:none;">
                <span>Metode Pembayaran</span>
                <span id="metode-pembayaran-value"></span>
            </div>
            <?php
            // Hitung subtotal, jumlah produk, biaya pengiriman, diskon, dan total
            $selectedCount = 0;
            $subtotal = 0;
            foreach ($cart as $item) {
                $selectedCount += 1;
                $subtotal += $item['harga'] * $item['quantity'];
            }
            $diskon = 0;
            if ($subtotal >= 5000000) {
                $diskon = 0.1 * $subtotal;
            }
            $total = $subtotal - $diskon;
            ?>
            <div class="summary-row">
                <span>Subtotal (<span id="selected-count"><?php echo $selectedCount; ?></span> produk)</span>
                <span id="subtotal">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
            </div>
            <?php if ($diskon > 0): ?>
            <div class="summary-row" style="color:green;">
                <span>Diskon 10%</span>
                <span id="diskon">-Rp <?php echo number_format($diskon, 0, ',', '.'); ?></span>
            </div>
            <?php endif; ?>
            <div class="summary-row summary-total" style="font-weight:700;">
                <span>Total Pembayaran</span>
                <span id="total">Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
            </div>
            <button class="checkout-btn" style="width:100%;margin-top:18px;">Checkout</button>
            </form>
        </div>
    </div>
    <script>
    function updateMetodePembayaranLabel(radio) {
        var value = radio.value;
        var label = '';
        if (value === 'transfer_bank') {
            label = 'Transfer Bank';
        } else if (value === 'cod') {
            label = 'Cash On Delivery (COD)';
        }
        document.getElementById('metode-pembayaran-value').textContent = label;
        document.getElementById('metode-pembayaran-row').style.display = 'flex';
    }

    // Inisialisasi jika sudah ada yang terpilih saat reload
    document.addEventListener('DOMContentLoaded', function() {
        var checked = document.querySelector('input[name="metode_pembayaran"]:checked');
        if (checked) {
            updateMetodePembayaranLabel(checked);
        }
        // Tambahkan event listener jika user memilih setelah reload
        document.querySelectorAll('input[name="metode_pembayaran"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                updateMetodePembayaranLabel(this);
            });
        });
    });
    </script>
</main>

<script>
    // Ambil data produk dari PHP ke JavaScript
    const products = <?php echo json_encode(array_map(function($item) {
        return [
            'id' => $item['id'],
            'nama' => $item['nama'],
            'harga' => $item['harga'],
            'gambar' => $item['gambar'],
            'quantity' => $item['quantity'],
        ];
    }, $cart)); ?>;

    // Simpan status ceklist di localStorage
    function getCheckedStatus() {
        try {
            return JSON.parse(localStorage.getItem('cartCheckedStatus') || '{}');
        } catch (e) {
            return {};
        }
    }
    function setCheckedStatus(status) {
        localStorage.setItem('cartCheckedStatus', JSON.stringify(status));
    }

    // Update ringkasan pesanan dan tampilkan detail barang yang dipilih
    function updateOrderSummary() {
        const checkedStatus = getCheckedStatus();
        products.forEach(product => {
            product.selected = !!checkedStatus[product.id];
        });
        const selectedProducts = products.filter(product => product.selected);
        const selectedCount = selectedProducts.length;
        let subtotal = 0;
        let html = '';

        if (selectedProducts.length > 0) {
            html += '<table style="width:100%;margin-bottom:10px;font-size:15px;"><thead><tr><th style="text-align:left;">Nama</th><th style="text-align:center;">Jumlah</th><th style="text-align:right;">Subtotal</th></tr></thead><tbody>';
            selectedProducts.forEach(product => {
                const sub = product.harga * product.quantity;
                subtotal += sub;
                html += `<tr>
                    <td>${product.nama}</td>
                    <td style="text-align:center;">${product.quantity}</td>
                    <td style="text-align:right;">Rp ${sub.toLocaleString('id-ID')}</td>
                </tr>`;
            });
            html += '</tbody></table>';
        } else {
            html = '<p style="color:#888;">Belum ada barang dipilih.</p>';
        }

        // Hitung diskon 10% jika subtotal >= 5.000.000
        let diskon = 0;
        if (subtotal >= 5000000) {
            diskon = 0.1 * subtotal;
        }
        let total = subtotal - diskon;

        document.getElementById('selected-items-list').innerHTML = html;
        document.getElementById('selected-count').textContent = selectedCount;
        document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');

        // Tampilkan diskon jika ada
        let diskonRow = document.getElementById('diskon');
        if (diskon > 0) {
            if (!diskonRow) {
                // Tambahkan elemen diskon jika belum ada
                const summaryRow = document.createElement('div');
                summaryRow.className = 'summary-row';
                summaryRow.style.color = 'green';
                summaryRow.innerHTML = '<span>Diskon 10%</span><span id="diskon"></span>';
                document.querySelector('.order-summary .summary-row.summary-total').before(summaryRow);
                diskonRow = document.getElementById('diskon');
            }
            diskonRow.textContent = '-Rp ' + diskon.toLocaleString('id-ID');
        } else if (diskonRow) {
            diskonRow.parentElement.remove();
        }

        document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    // Inisialisasi ceklist dari localStorage
    function initCheckboxes() {
        const checkedStatus = getCheckedStatus();
        document.querySelectorAll('.cart-item').forEach((itemEl, index) => {
            const checkbox = itemEl.querySelector('.item-checkbox');
            const product = products[index];
            checkbox.checked = !!checkedStatus[product.id];
            checkbox.addEventListener('change', function() {
                checkedStatus[product.id] = this.checked;
                setCheckedStatus(checkedStatus);
                updateOrderSummary();
                updateSelectAllCheckbox();
            });
        });
        updateSelectAllCheckbox();
    }

    // Fungsi untuk update status "Pilih Semua"
    function updateSelectAllCheckbox() {
        const selectAll = document.getElementById('select-all-checkbox');
        if (!selectAll) return;
        const checkboxes = document.querySelectorAll('.cart-item .item-checkbox');
        if (checkboxes.length === 0) {
            selectAll.checked = false;
            selectAll.indeterminate = false;
            return;
        }
        let checkedCount = 0;
        checkboxes.forEach(cb => { if (cb.checked) checkedCount++; });
        if (checkedCount === checkboxes.length) {
            selectAll.checked = true;
            selectAll.indeterminate = false;
        } else if (checkedCount === 0) {
            selectAll.checked = false;
            selectAll.indeterminate = false;
        } else {
            selectAll.checked = false;
            selectAll.indeterminate = true;
        }
    }

    // Event handler untuk tombol "Pilih Semua"
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select-all-checkbox');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const checked = this.checked;
                const checkedStatus = getCheckedStatus();
                products.forEach(product => {
                    checkedStatus[product.id] = checked;
                });
                setCheckedStatus(checkedStatus);
                document.querySelectorAll('.cart-item .item-checkbox').forEach(cb => {
                    cb.checked = checked;
                });
                updateOrderSummary();
                updateSelectAllCheckbox();
            });
        }
    });

    // Kuantitas produk
    document.querySelectorAll('.cart-item').forEach((itemEl, index) => {
        const minusBtn = itemEl.querySelector('.minus-btn');
        const plusBtn = itemEl.querySelector('.plus-btn');
        const qtyInput = itemEl.querySelector('.quantity-input');
        const quantityForm = itemEl.querySelector('.quantity-form');

        minusBtn.addEventListener('click', function() {
            let value = parseInt(qtyInput.value);
            if (value > 1) {
                qtyInput.value = value - 1;
                // Simpan status ceklist sebelum submit
                setCheckedStatus(getCheckedStatus());
                setTimeout(() => {
                    quantityForm.submit();
                }, 100);
            }
        });

        plusBtn.addEventListener('click', function() {
            let value = parseInt(qtyInput.value);
            if (value < 10) {
                qtyInput.value = value + 1;
                // Simpan status ceklist sebelum submit
                setCheckedStatus(getCheckedStatus());
                setTimeout(() => {
                    quantityForm.submit();
                }, 100);
            }
        });

        // Remove button: submit form agar hapus di server
        const removeForm = itemEl.querySelector('.remove-form');
        removeForm.addEventListener('submit', function(e) {
            // Optional: animasi sebelum submit
            itemEl.style.animation = 'fadeOut 0.3s ease';
            // Hapus status ceklist dari localStorage
            const checkedStatus = getCheckedStatus();
            delete checkedStatus[products[index].id];
            setCheckedStatus(checkedStatus);
            setTimeout(() => {
                removeForm.submit();
            }, 300);
            e.preventDefault();
        });
    });

    // Inisialisasi ceklist dan ringkasan pesanan
    initCheckboxes();
    updateOrderSummary();
</script>
</body>
</html>
