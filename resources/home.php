<?php
  session_start();

  if (!isset($_SESSION['user'])) 
  {
    header('Location: loginUser.php');
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
    <form class="search-bar" action="search.php" method="get" style="display: flex; align-items: center;">
      <input type="search" name="keyword" placeholder="Search furniture..." aria-label="Search furniture" required />
      <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;">
      <span class="material-icons search-icon" aria-label="Search icon">search</span>
      </button>
    </form>
    <div class="header-icons" role="navigation" aria-label="Header navigation icons">
    <button class="icon-button" aria-label="View shopping cart" onclick="window.location.href='keranjang.php';">
      <span class="material-icons" style="font-size: 30px;">shopping_cart</span>
    </button>
    
    <!-- User Profile Dropdown -->
    <div style="position: relative; display: inline-block;">
      <button class="icon-button" aria-label="User profile" id="profileBtn" type="button">
        <span class="material-icons" style="font-size: 30px;">account_circle</span>
      </button>
      <div id="profileDropdown" style="display: none; position: absolute; right: 0; top: 48px; background: #fffde7; box-shadow: 0 4px 16px rgba(251,192,45,0.18); border-radius: 12px; min-width: 260px; z-index: 200; padding: 20px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 18px;">
        <span class="material-icons" style="font-size: 48px; color: #fbc02d;">account_circle</span>
        <div>
          <div style="font-weight: 700; color: #5a4700;">
            <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
          </div>
          <div style="font-size: 0.95em; color: #a17b00;">
            <?php echo htmlspecialchars($_SESSION['user']['Email']); ?>
          </div>
        </div>
        </div>
        <!-- Update Profile Toggle Button -->
        <button id="showProfileFormBtn" type="button" style="margin-bottom: 10px; background: #fbc02d; color: #fff; border: none; border-radius: 6px; padding: 8px 0; font-weight: 600; width: 100%; cursor: pointer;">
            Update Profile
        </button>
        <!-- Hidden Profile Update Form -->
        <form id="profileForm" method="post" action="../databases/update_profile.php" style="display: none; flex-direction: column; gap: 10px;">
            <label style="font-size: 0.95em; color: #7a6500;">Username
              <input type="text" name="username" value="<?php echo htmlspecialchars($_SESSION['user']['username']); ?>" required style="width: 100%; margin-top: 2px; padding: 6px; border-radius: 6px; border: 1px solid #fbc02d; font-family: inherit;">
            </label>
            <label style="font-size: 0.95em; color: #7a6500;">Password
              <input type="password" name="password" value="<?php echo htmlspecialchars($_SESSION['user']['password']); ?>" style="width: 100%; margin-top: 2px; padding: 6px; border-radius: 6px; border: 1px solid #fbc02d; font-family: inherit;">
            </label>
            <label style="font-size: 0.95em; color: #7a6500;">Email
              <input type="email" name="Email" value="<?php echo htmlspecialchars($_SESSION['user']['Email']); ?>" required style="width: 100%; margin-top: 2px; padding: 6px; border-radius: 6px; border: 1px solid #fbc02d; font-family: inherit;">
            </label>
            <label style="font-size: 0.95em; color: #7a6500;">Alamat
              <textarea name="alamat" required style="width: 100%; margin-top: 2px; padding: 6px; border-radius: 6px; border: 1px solid #fbc02d; resize: vertical; font-family: inherit;"><?php echo isset($_SESSION['user']['alamat']) ? htmlspecialchars($_SESSION['user']['alamat']) : ''; ?></textarea>
            </label>
<script>
    // Prevent dropdown from closing when clicking inside the form
    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = document.getElementById('profileDropdown');
        const form = document.getElementById('profileForm');
        if (form && dropdown) {
            form.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
</script>
        <button type="submit" style="margin-top: 8px; background: #fbc02d; color: #fff; border: none; border-radius: 6px; padding: 8px 0; font-weight: 600; cursor: pointer;" name="update">Save Changes</button>
        <div style="font-size: 0.65em; color: #b26a00; margin-top: 2px;">
            *Harap login kembali untuk menerapkan pembaruan
        </div>
        </form>
        <script>
            // Toggle profile form visibility
            document.addEventListener('DOMContentLoaded', function() {
                const showBtn = document.getElementById('showProfileFormBtn');
                const form = document.getElementById('profileForm');
                showBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    form.style.display = form.style.display === 'flex' ? 'none' : 'flex';
                });
            });
    </script>
        <hr style="margin: 16px 0; border: none; border-top: 1px solid #fbc02d;">
        <a href="../databases/logout.php" style="display: block; text-align: center; color: #d84315; font-weight: 600; text-decoration: none; padding: 8px 0; border-radius: 6px; background: #fff3e0;">Logout</a>
      </div>
    </div>
    <script>
      // Simple dropdown toggle for profile
      document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('profileBtn');
        const dropdown = document.getElementById('profileDropdown');
        btn.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
        document.addEventListener('click', function(e) {
        if (!btn.contains(e.target)) dropdown.style.display = 'none';
        });
      });
    </script>
    </div>
  </div>
</header>
<main class="container" role="main" tabindex="-1">

<section class="main-slider" aria-label="Featured furniture products image slider" style="max-width: 1500px; height:600px; margin-left: auto; margin-right: auto;">
    <div class="slider-wrapper" id="slider-wrapper">
        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/5c71b6cc-51c7-41a6-a1bd-30026073c362.png" alt="Featured modern yellow sofa with bright background" class="slide" />
        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/98a74d7a-da02-4a6e-9efe-70b377fb452a.png" alt="Elegant wooden chair with yellow cushions" class="slide" />
        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/10f1afde-213f-4e62-a67f-30c8987f9590.png" alt="Stylish yellow table lamp in living room" class="slide" />
    </div>
    <div class="slider-dots" role="tablist" aria-label="Slider navigation dots">
        <button class="slider-dot active" role="tab" aria-selected="true" aria-controls="slide1" tabindex="0" data-index="0"></button>
        <button class="slider-dot" role="tab" aria-selected="false" aria-controls="slide2" tabindex="-1" data-index="1"></button>
        <button class="slider-dot" role="tab" aria-selected="false" aria-controls="slide3" tabindex="-1" data-index="2"></button>
    </div>
</section>

  <section class="products-section" aria-labelledby="featured-products">
    <h2 class="products-title" id="featured-products">Featured Products</h2>
    <div class="products-grid">
      <article class="product-card" tabindex="0" role="group" aria-label="Modern Yellow Armchair">
        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/3cec8ea8-8b76-49aa-aff0-9261f184bc1f.png" alt="Modern Yellow Armchair on light background" class="product-image" />
        <div class="product-info">Modern Yellow Armchair</div>
      </article>
      <article class="product-card" tabindex="0" role="group" aria-label="Wooden Dining Table">
        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/bc8c9d03-f5b5-4bf8-8dd5-fc6e1c2b73f1.png" alt="Wooden Dining Table with yellow accent chair" class="product-image" />
        <div class="product-info">Wooden Dining Table</div>
      </article>
      <article class="product-card" tabindex="0" role="group" aria-label="Yellow Desk Lamp">
        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/f7be070e-9675-48b2-a75e-a71cb2b2cb50.png" alt="Yellow desk lamp glowing on white desk" class="product-image" />
        <div class="product-info">Yellow Desk Lamp</div>
      </article>
      <article class="product-card" tabindex="0" role="group" aria-label="Comfortable Yellow Couch">
        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/c9dbff7d-0e24-4245-b2eb-19ea1570a68f.png" alt="Comfortable yellow couch in modern living room" class="product-image" />
        <div class="product-info">Comfortable Yellow Couch</div>
      </article>
      <article class="product-card" tabindex="0" role="group" aria-label="Minimalist Yellow Shelves">
        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/f94a394b-e3c0-4050-911c-1ed3a0c999c1.png" alt="Minimalist yellow shelves with decoration" class="product-image" />
        <div class="product-info">Minimalist Yellow Shelves</div>
      </article>
    </div>
  </section>
  <section class="products-section" aria-labelledby="featured-products">
      <?php
        include "../databases/koneksi.php";
        $data = mysqli_query($koneksi, "SELECT * FROM data_produk ORDER BY id DESC");
        while ($row = mysqli_fetch_array($data)){
      ?>
        
        <div class="products-list">
            <h2 class="section-title" style="text-align: center;">Rekomendasi</h2>
            <?php
            // Ambil semua data produk ke array
            $produk = [];
            while ($row = mysqli_fetch_array($data)) {
              $produk[] = $row;
            }

            // Acak urutan produk
            shuffle($produk);

            // Ambil maksimal 20 produk
            $produk = array_slice($produk, 0, 20);

            // Tampilkan produk dalam grid, baris baru setiap 5 produk
            ?>
            <div class="product-grid" style="
              display: grid;
              grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
              gap: 30px;
            ">
              <?php foreach ($produk as $row): ?>
              <a href="detail.php?id=<?php echo urlencode($row['id']); ?>" style="text-decoration: none; color: inherit;">
                <div class="product-card" style="width: 100%; display: flex; flex-direction: column; height: 100%; min-height: 340px;">
                <div class="product-image" style="flex: 0 0 auto;">
                  <img src="../gambar/<?php echo htmlspecialchars($row['gambar']); ?>" style="width: 100%; object-fit: cover; aspect-ratio: 1/1; border-radius: 8px;">
                </div>
                <div class="product-details" style="flex: 1 1 auto; display: flex; flex-direction: column; justify-content: flex-end; padding: 14px; text-align: left;">
                  <h3 class="product-name" style="font-size: 1.1rem; font-weight: 700; color:rgb(10, 10, 10); margin: 0 0 6px;">
                  <?php echo htmlspecialchars($row['nama']); ?>
                  </h3>
                  <div class="product-price" style="color: #fbc02d; font-size: 1.05rem; margin-bottom: 6px;">
                  <span style="font-weight:600;">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                  </div>
                </div>
                </div>
              </a>
              <?php endforeach; ?>
            </div>
            </div>
            </div>
            <?php } ?>
  </section>
</main>
<footer role="contentinfo">
  <div class="container footer-container">
    &copy; 2025 Furnispace. All rights reserved.
  </div>
</footer>
<script>
  // Simple slider functionality for main slider with dots navigation
  (() => {
    const sliderWrapper = document.getElementById('slider-wrapper');
    const dots = document.querySelectorAll('.slider-dot');
    let activeIndex = 0;
    const totalSlides = dots.length;

    function setActiveSlide(index) {
      activeIndex = index;
      sliderWrapper.style.transform = `translateX(-${index * 100}%)`;
      dots.forEach((dot, i) => {
        const isActive = i === index;
        dot.classList.toggle('active', isActive);
        dot.setAttribute('aria-selected', isActive);
        dot.tabIndex = isActive ? 0 : -1;
      });
    }

    dots.forEach(dot =>
      dot.addEventListener('click', () => setActiveSlide(Number(dot.dataset.index)))
    );

    // Optional automatic slide change every 5 seconds
    setInterval(() => {
      let nextIndex = (activeIndex + 1) % totalSlides;
      setActiveSlide(nextIndex);
    }, 5000);
  })();
</script>
</body>
</html>

