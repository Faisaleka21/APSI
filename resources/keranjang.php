<?php
        session_start();

        // Koneksi ke database
        require_once '../databases/koneksi.php';

        // Hapus item dari keranjang jika ada permintaan hapus
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
            $remove_id = (int)$_POST['remove_id'];
            if (isset($_SESSION['add_to_cart'])) {
                $_SESSION['add_to_cart'] = array_values(array_filter($_SESSION['add_to_cart'], function($item) use ($remove_id) {
                    return $item['id'] != $remove_id;
                }));
            }
            // Redirect agar tidak resubmit form saat refresh
            header("Location: keranjang.php");
            exit;
        }

       // Update quantity jika ada permintaan update (AJAX style)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id']) && isset($_POST['update_quantity'])) {
            $update_id = (int)$_POST['update_id'];
            $update_quantity = max(1, min(10, (int)$_POST['update_quantity']));
            if (isset($_SESSION['add_to_cart'])) {
                foreach ($_SESSION['add_to_cart'] as &$cart_item) {
                    if ($cart_item['id'] == $update_id) {
                        $cart_item['quantity'] = $update_quantity;
                        break;
                    }
                }
                unset($cart_item);
            }
            echo json_encode(['success' => true]);
            exit;
        }

        // Tangkap data dari detail.php (misal via POST)
        // Cegah penambahan barang saat refresh dengan redirect setelah POST (PRG pattern)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && !isset($_POST['remove_id']) && !isset($_POST['update_id'])) {
            $id = (int)$_POST['id'];
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            // Ambil data produk dari database
            $stmt = $koneksi->prepare("SELECT * FROM data_produk WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $produk = $stmt->get_result()->fetch_assoc();

            if ($produk) {
                // Siapkan data item untuk keranjang
                $item = [
                    'id' => $produk['id'],
                    'nama' => $produk['nama'],
                    'harga' => $produk['harga'],
                    'gambar' => $produk['gambar'],
                    'quantity' => $quantity
                ];

                // Tambahkan ke session keranjang
                if (!isset($_SESSION['add_to_cart'])) {
                    $_SESSION['add_to_cart'] = [];
                }

                // Jika produk sudah ada di keranjang, update quantity
                $found = false;
                foreach ($_SESSION['add_to_cart'] as &$cart_item) {
                    if ($cart_item['id'] == $item['id']) {
                        $cart_item['quantity'] += $quantity;
                        $found = true;
                        break;
                    }
                }
                unset($cart_item);

                if (!$found) {
                    $_SESSION['add_to_cart'][] = $item;
                }
            }
            // Redirect agar tidak resubmit form saat refresh
            header("Location: keranjang.php");
            exit;
        }

        // Ambil data keranjang dari session
        $cart = isset($_SESSION['add_to_cart']) ? $_SESSION['add_to_cart'] : [];
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

<main class="container" style="display: flex; flex-direction: row; justify-content: center; gap: 40px; align-items: flex-start; margin-top: 30px; margin-left: auto; margin-right: auto;">
    <div style="flex: 1 1 0; max-width: 700px;"> 
         <div class="cart-items" style="margin-top: 0px;">
                <h1 class="cart-title" style="font-size: 1.5rem;">Keranjang Saya</h1>
            <form id="checkout-form" action="checkout.php" method="post">
                            <!-- Optional: Checkbox untuk pilih semua item -->
                            <?php if (!empty($cart)): ?>     
                                <div style="margin-bottom:10px;">
                                    <label style="cursor:pointer;">
                                        <input type="checkbox" class="item-checkbox" id="select-all-checkbox" style="vertical-align:middle; margin-right:5px;">
                                        Pilih Semua
                                    </label>
                                </div>
                            <?php endif; ?>

                <?php if (empty($cart)): ?>
                    <p>Keranjang belanja kosong.</p>
                <?php else: ?>
                    <?php foreach ($cart as $item): ?>
                        <div class="cart-item" data-id="<?php echo $item['id']; ?>">
                            <input type="checkbox" name="selected_items[]" value="<?= $item['id'] ?>" class="item-checkbox">
                            <a href="detail.php?id=<?php echo urlencode($item['id']); ?>">
                                <img src="../gambar/<?php echo htmlspecialchars($item['gambar']); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>" class="item-image">
                            </a>
                            <div class="item-details">
                                <h3 class="item-name"><?php echo htmlspecialchars($item['nama']); ?></h3>
                                <p class="item-price">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                            </div>
                            <div class="item-actions">
                                <div method="post" class="quantity-form" style="display:inline;">
                                    <input type="hidden" name="update_id" value="<?php echo $item['id']; ?>">
                                    <div class="quantity-control">
                                        <button type="button" class="quantity-btn minus-btn">-</button>
                                        <input type="text" name="update_quantity" class="quantity-input" value="<?php echo (int)$item['quantity']; ?>" readonly>
                                        <button type="button" class="quantity-btn plus-btn">+</button>
                                    </div>
                                </div>
                                <div method="post" class="remove-form" style="display:inline;">
                                    <input type="hidden" name="remove_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" class="remove-btn" title="Hapus item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div style="flex: 0 0 500px; max-width: 500px; display: flex; flex-direction: column; gap: 30px;">
            <div class="order-summary" style="background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #0001; padding: 28px;">
                <h2 class="summary-title" style="font-size: 1.5rem; margin-bottom: 18px;">Ringkasan Pesanan</h2>
                <div id="selected-items-list"></div>
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
                $total = $subtotal;
                ?>
                <div class="summary-row">
                    <span>Subtotal (<span id="selected-count"><?php echo $selectedCount; ?></span> produk)</span>
                    <span id="subtotal">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                </div>
                <div class="summary-row summary-total">
                    <span>Total Pembayaran</span>
                    <span id="total">Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                </div>
                    <button type="submit" class="checkout-btn">Lanjut ke Pembayaran</button>
            </form>
        </div>
    </div>
</main>

</body>
</html>

<script>
    document.querySelectorAll('.cart-item').forEach((itemEl, index) => {
        const minusBtn = itemEl.querySelector('.minus-btn');
        const plusBtn = itemEl.querySelector('.plus-btn');
        const qtyInput = itemEl.querySelector('.quantity-input');
        const productId = itemEl.getAttribute('data-id');

        function animateChange(element, newValue) {
            element.style.transition = 'transform 0.2s ease';
            element.style.transform = 'scale(1.2)';
            setTimeout(() => {
                element.textContent = newValue;
                element.style.transform = 'scale(1)';
            }, 100);
        }

        function updateQuantity(newQty) {
            fetch('keranjang.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `update_id=${productId}&update_quantity=${newQty}`
            }).then(response => response.json())
            .then(() => {
                qtyInput.value = newQty;
                products[index].quantity = newQty;
                updateOrderSummary();
                const subtotalEl = document.getElementById('subtotal');
                const totalEl = document.getElementById('total');
                animateChange(subtotalEl, subtotalEl.textContent);
                animateChange(totalEl, totalEl.textContent);
            });
        }

        minusBtn.addEventListener('click', function() {
            let value = parseInt(qtyInput.value);
            if (value > 1) updateQuantity(value - 1);
        });

        plusBtn.addEventListener('click', function() {
            let value = parseInt(qtyInput.value);
            if (value < 10) updateQuantity(value + 1);
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('checkout-form');
    const button = form.querySelector('button.checkout-btn');
    const checkboxes = form.querySelectorAll('input.item-checkbox');

    function toggleButton() {
        const anyChecked = [...checkboxes].some(cb => cb.checked);
        button.disabled = !anyChecked;
    }

    checkboxes.forEach(cb => cb.addEventListener('change', toggleButton));
    toggleButton(); // inisialisasi
});
</script>

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
        let total = subtotal;

        document.getElementById('selected-items-list').innerHTML = html;
        document.getElementById('selected-count').textContent = selectedCount;
        document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');

        // Tampilkan diskon jika ada
        let diskonRow = document.getElementById('diskon');
        if (diskon > 0) {
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkoutForm = document.querySelector('form[action="checkout.php"]');
        const checkboxes = document.querySelectorAll('.item-checkbox');

        checkoutForm.addEventListener('submit', function (event) {
            let isAnyChecked = false;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    isAnyChecked = true;
                }
            });

            if (!isAnyChecked) {
                alert("Silakan pilih minimal satu barang sebelum melanjutkan ke pembayaran.");
                event.preventDefault(); // Mencegah form dikirim
            }
        });
    });
</script>
<script>
    document.getElementById('select-all-checkbox')?.addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
