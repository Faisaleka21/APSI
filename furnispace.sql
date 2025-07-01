-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Jul 2025 pada 04.55
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `furnispace`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pembeli`
--

CREATE TABLE `data_pembeli` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total` varchar(50) NOT NULL,
  `tanggal` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_pembeli`
--

INSERT INTO `data_pembeli` (`id`, `username`, `alamat`, `nama_barang`, `jumlah`, `total`, `tanggal`) VALUES
(4, 'cihuy', 'kanigoro', 'Lemari Pakaian Sonokeling Etnik Tropis', 1, '5200000', '2025-06-25 11:13:58'),
(6, 'cihuy', 'kanigoro', 'Meja Kopi Lift-Top Storage', 1, '2100000', '2025-06-25 11:17:39'),
(7, 'paijo', '', 'Rak Dapur Wall Mounted Slim', 1, '550000', '2025-07-01 04:21:22'),
(8, 'cihuy', 'kanigoro', 'Rak Dapur Dish Drying Rack Modern', 2, '760000', '2025-07-01 04:44:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_produk`
--

CREATE TABLE `data_produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_produk`
--

INSERT INTO `data_produk` (`id`, `nama`, `harga`, `detail`, `gambar`) VALUES
(29, 'Lemari Pakaian Jati Klasik Abadi', 4500000, 'Dibuat dari kayu jati solid pilihan dengan ukiran tangan yang halus, lemari ini menghadirkan sentuhan kemewahan klasik. Dilengkapi dua pintu besar dengan cermin di salah satu sisi, serta laci penyimpanan tersembunyi di bagian bawah. Ideal untuk Anda yang ', '../gambar/lemari10.jpeg'),
(30, 'Lemari Pakaian Mahogany Minimalis Modern', 3200000, 'Desain modern minimalis dengan finishing kayu mahoni berwarna gelap yang elegan. Lemari ini memiliki tiga pintu geser hemat ruang dan laci-laci internal yang terorganisir untuk pakaian dan aksesoris. Sangat cocok untuk apartemen atau kamar tidur dengan ru', 'lemari9.jpeg'),
(31, 'Lemari Pakaian Oak Scandinavia Kontemporer', 3800000, 'Terinspirasi gaya Skandinavia yang bersih dan fungsional, lemari ini terbuat dari kayu oak terang dengan sentuhan akhir natural. Dilengkapi dua pintu bukaan dan rak-rak yang dapat disesuaikan, serta kompartemen khusus untuk penyimpanan pakaian lipat. Memb', 'lemari2.jpeg'),
(32, 'Lemari Pakaian Maple Nordic Chic', 2950000, 'Lemari pakaian ramping dari kayu maple yang ringan dengan sentuhan warna pastel yang menenangkan. Desain dua pintu dengan gantungan baju dan dua laci bawah. Sempurna untuk kamar tidur remaja atau Anda yang menyukai tampilan bersih dan ceria.', 'lemari6.jpeg'),
(33, 'Lemari Pakaian Walnut Urban Loft', 4100000, 'Dengan nuansa kayu walnut gelap yang kaya, lemari ini memancarkan kesan urban dan maskulin. Desain empat pintu dengan kombinasi rak, laci, dan ruang gantung yang luas. Sangat cocok untuk kamar tidur bergaya industrial atau kontemporer.', 'lemari1.jpeg'),
(34, 'Lemari Pakaian Sonokeling Etnik Tropis', 5200000, 'Lemari unik dari kayu sonokeling dengan serat alami yang eksotis dan ukiran tangan bermotif etnik. Memiliki dua pintu dan laci penyimpanan, menawarkan tidak hanya fungsi tetapi juga nilai seni yang tinggi. Cocok untuk Anda yang ingin sentuhan budaya dan k', 'lemari8.jpeg'),
(35, 'Lemari Pakaian Pine Cottage Rustic', 2500000, 'Memberi sentuhan pedesaan yang hangat, lemari ini terbuat dari kayu pinus solid dengan finishing rustic yang menonjolkan serat kayu alami. Dilengkapi dua pintu dan satu laci besar. Ideal untuk kamar tidur bergaya farmhouse atau country.', 'lemari7.jpeg'),
(36, 'Lemari Pakaian Akasia Modern Tropis', 3600000, 'Lemari tiga pintu dari kayu akasia dengan warna cokelat keemasan yang hangat dan serat kayu yang menarik. Desain modern tropis yang cocok untuk iklim Indonesia, fungsional dengan banyak ruang gantung dan rak.', 'lemari4.jpeg'),
(37, 'Lemari Pakaian Duco Putih Klasik Elegan', 3000000, 'Terbuat dari kayu MDF berkualitas tinggi dengan finishing cat duco putih mulus yang memberikan kesan bersih dan mewah. Desain dua pintu dengan aksen lis profil klasik, serta laci di bagian bawah. Cocok untuk kamar tidur bergaya klasik atau shabby chic.', 'lemari5.jpeg'),
(38, 'Lemari Pakaian Jati Belanda Industrial Chic', 2700000, 'Memadukan keindahan kayu jati Belanda (pinus daur ulang) dengan rangka besi hitam minimalis. Desain dua pintu dengan kompartemen gantung dan rak terbuka di samping. Memberi sentuhan industrial yang chic dan fungsional untuk ruang yang dinamis.', 'lemari3.jpeg'),
(39, 'Kasur Cloud Nine Dream', 5800000, 'Rasakan sensasi tidur di atas awan dengan kasur memory foam gel premium setebal 30 cm ini. Dirancang untuk menyesuaikan kontur tubuh Anda, mengurangi titik tekanan, dan menjaga suhu tetap sejuk berkat teknologi gel infused. Lapisan atas kain knitted yang ', 'kasur8.jpeg'),
(40, 'Kasur OrthoPosture Pro', 6500000, 'Kasur orthopedic hybrid yang menggabungkan dukungan kokoh dari pegas saku individu (pocket spring) dengan kenyamanan lapisan latex alami. Dirancang khusus untuk menopang tulang belakang dengan optimal, mengurangi sakit punggung, dan memastikan tidur yang ', 'kasur6.jpeg'),
(41, 'Kasur ZenFlow Comfort', 4200000, 'Kasur busa kepadatan tinggi dengan teknologi open-cell yang memastikan sirkulasi udara maksimal, mencegah penumpukan panas. Lapisan atas Quilted Plush Pillow Top memberikan kelembutan ekstra. Sangat cocok untuk Anda yang mencari kasur empuk namun tetap me', 'kasur2.jpeg'),
(42, 'Kasur EcoSleep Bamboo', 5100000, 'Kasur ramah lingkungan dengan lapisan atas kain serat bambu organik yang breathable dan anti-bakteri alami. Inti kasur terbuat dari perpaduan latex sintetis dan high-resilience foam yang responsif. Memberikan kenyamanan sedang dengan dukungan yang baik. ', 'kasur1.jpeg'),
(43, 'Kasur SmartAdapt Pocket', 7300000, 'Kasur dengan sistem pegas saku 7 zona yang independen, memberikan dukungan berbeda pada setiap area tubuh untuk mengurangi transfer gerakan pasangan. Dilengkapi lapisan euro top tebal untuk kenyamanan ekstra. Tingkat kekerasan medium-firm. Sempurna untuk ', 'kasur7.jpeg'),
(44, 'Kasur CoolGel Breeze', 4900000, 'Kasur memory foam gel infused dengan teknologi airflow channels yang ditingkatkan untuk sirkulasi udara superior. Mencegah tubuh terasa panas saat tidur. Kain penutup cool-touch menambah sensasi sejuk. Cocok untuk Anda yang mudah berkeringat saat tidur. G', 'kasur9.jpeg'),
(45, 'Kasur Luxury Latex Touch', 8000000, 'Kasur premium dengan lapisan utama latex alami 100% yang hypoallergenic, anti-tungau, dan sangat responsif. Memberikan dukungan elastis dan kemampuan bernapas yang sangat baik. Cocok untuk penderita alergi dan mereka yang menginginkan material alami. Gara', 'kasur5.jpeg'),
(46, 'Kasur FirmSupport Hybrid', 5900000, 'Kombinasi ideal antara pegas saku independen yang kuat dan lapisan busa kepadatan tinggi untuk kekerasan firm yang stabil. Kasur ini sangat cocok bagi Anda yang menyukai dukungan ekstra kokoh tanpa mengorbankan kenyamanan. Ideal untuk menjaga postur tulan', 'kasur4.jpeg'),
(47, 'Kasur FlexiRoll Compact', 3500000, 'Kasur memory foam praktis yang dikemas dalam bentuk roll dan vakum, mudah dibawa dan dipasang. Mengembang sempurna dalam 24-48 jam. Memberikan kenyamanan adaptif dan dukungan merata. Sempurna untuk apartemen, kost, atau ruang tidur yang membutuhkan solusi', 'kasur3.jpeg'),
(48, 'Kasur Royal Plush Pillowtop', 6200000, 'Nikmati kemewahan tidur dengan kasur pegas bonnel berkualitas tinggi yang dilapisi dengan pillowtop super tebal dan empuk. Memberikan sensasi memeluk tubuh dengan dukungan pegas yang merata. Kain jacquard mewah menambah sentuhan elegan pada kamar tidur An', 'kasur10.jpeg'),
(49, 'Lampu Gantung Aurora Sphere', 850000, 'Desain elegan dengan kap lampu berbentuk bola kaca susu yang memancarkan cahaya lembut dan merata. Rangka terbuat dari logam matte hitam atau emas brushed, cocok untuk ruang makan, ruang tamu, atau kamar tidur dengan nuansa modern minimalis. Diameter 25 c', 'lampu9.png'),
(50, 'Lampu Gantung Geometrik Nordic', 720000, 'Menggabungkan bentuk geometris segitiga atau heksagonal dengan material besi hollow berwarna hitam doff atau putih. Memberikan kesan artistik dan terbuka, ideal untuk area tangga, koridor, atau sebagai fokus di ruang tamu. Ukuran 30x30 cm, bohlam exposed ', 'lampu7.png'),
(51, 'Lampu Gantung Linear Slimline', 980000, 'Lampu gantung panjang berbentuk batang LED linier ramping, memberikan pencahayaan langsung dan modern. Ideal untuk di atas meja makan, kitchen island, atau meja kerja. Tersedia dalam warna hitam, putih, atau perak, dengan panjang 80 cm hingga 120 cm. Caha', 'Lampu3.png'),
(52, 'Lampu Gantung Concrete Urban', 680000, 'Kap lampu terbuat dari material beton ringan dengan finishing natural abu-abu, memberikan nuansa industrial dan raw. Cocok untuk kafe, studio, atau rumah dengan desain urban/industri minimalis. Diameter 15 cm, kabel kain hitam.', 'lampu6.png'),
(53, 'Lampu Gantung Glass Teardrop', 1100000, 'lampu gantung dengan kap kaca bening berbentuk tetesan air mata dalam ukuran berbeda. Menampilkan keindahan bohlam Edison atau filamen LED. Memberikan efek cahaya dramatis dan elegan. Cocok untuk area void, ruang makan, atau sebagai centerpiece. Rangka ba', 'lampu9.png'),
(54, 'Lampu Gantung Wood Grain Simple', 580000, 'Kap lampu berbentuk silinder atau kerucut dengan lapisan luar motif serat kayu (material PVC/aluminium dengan finishing kayu). Menghadirkan kehangatan alam ke dalam ruang minimalis. Ideal untuk kamar tidur, ruang keluarga, atau kafe. Diameter 20 cm.', '../gambar/LAMPU2.png'),
(55, 'Lampu Gantung Minimalist Cone', 490000, 'Desain super minimalis dengan kap lampu berbentuk kerucut terbalik dari aluminium solid berwarna matte hitam, putih, atau abu-abu. Fokus cahaya ke bawah, cocok sebagai task lighting di atas meja samping atau sudut baca. Diameter 12 cm.', 'Lampu1.png'),
(56, 'Lampu Gantung Wireframe Mesh', 780000, 'Kap lampu berbentuk sangkar dengan desain wireframe terbuka dari kawat besi yang dicat hitam atau emas. Menciptakan bayangan menarik dan menonjolkan keindahan bohlam retro. Ideal untuk interior modern, industrial, atau Scandinavian. Diameter 28 cm.', 'lampu4.png'),
(57, 'Lampu Gantung Pulley System Retro', 920000, 'Lampu gantung dengan sistem katrol (pulley) yang memungkinkan pengaturan ketinggian lampu secara fleksibel. Rangka besi antik dengan kap lampu bergaya vintage atau industrial. Cocok untuk dapur, ruang makan, atau ruang kerja yang ingin sentuhan unik. Bohl', 'lampu5.png'),
(58, 'Lampu Gantung Circular Aura', 960000, 'Lampu gantung LED berbentuk cincin atau lingkaran yang elegan, memancarkan cahaya dari bagian dalam lingkaran. Desain futuristik dan bersih, memberikan pencahayaan ambient yang mewah. Tersedia dalam ukuran diameter 40 cm atau 60 cm, dengan pilihan warna r', 'lampu10.png'),
(59, 'Meja Kopi Zenith Square', 1250000, 'Meja kopi berbentuk persegi dengan desain ultra-minimalis. Terbuat dari MDF berkualitas tinggi dilapisi finishing duco matte putih bersih atau abu-abu gelap. Kaki-kaki ramping dari besi hollow berwarna senada menambah kesan ringan dan modern. Ideal untuk ', 'meja6.JPG'),
(60, 'Meja Kopi Horizon Oval', 1500000, 'Meja kopi berbentuk oval yang lembut dan elegan. Top table terbuat dari kayu solid mindi dengan finishing natural, dipadukan kaki-kaki kokoh berbentuk silinder dari besi hitam. Desain tanpa sudut tajam cocok untuk keluarga dengan anak kecil atau untuk men', 'meja1.JPG'),
(61, 'Meja Samping Cube Nesting', 980000, 'Meja samping berbentuk kubus yang dapat disatukan (nesting) atau dipisah sesuai kebutuhan. Material metal powder-coated dengan pilihan warna emas brushed atau hitam doff. Top table terbuat dari kaca temper bening untuk kesan mewah dan lapang. Fleksibel un', '../gambar/meja2.JPG'),
(62, 'Meja Kopi Industrial Loft', 1800000, 'Kombinasi sempurna antara material kayu jati Belanda dengan finishing rustic dan rangka besi hollow hitam yang kokoh. Dilengkapi dengan rak terbuka di bagian bawah untuk menyimpan majalah atau buku. Memberikan sentuhan raw dan autentik pada ruang tamu ber', 'meja4.JPG'),
(63, 'Meja Kopi Marble Elegance', 2700000, 'Meja kopi mewah dengan top table marmer putih Carrara asli yang elegan dan kaki-kaki stainless steel emas yang ramping. Memberikan sentuhan glamor dan sophistication pada ruang tamu modern. Permukaan marmer tahan panas dan mudah dibersihkan. Dimensi: 90x9', 'meja3.JPG'),
(64, 'Meja Kopi Split Level Modern', 1950000, 'Meja kopi menciptakan dimensi visual menarik. Material MDF laminasi HPL motif kayu dikombinasikan dengan kaki metal hitam. Desain ini memungkinkan penyimpanan atau pajangan yang lebih bervariasi. Dimensi: 110x50x35/45 cm.', 'meja7.JPG'),
(65, 'Meja Konsol Entryway Slim', 1400000, 'Meja konsol ramping dan panjang yang ideal untuk area pintu masuk atau di belakang sofa. Top table dari kayu solid mahoni dengan finishing espresso dan kaki-kaki lurus dari besi tipis. Sempurna untuk meletakkan kunci, vas bunga, atau dekorasi ringan. Dime', 'meja8.JPG'),
(66, 'Meja Kopi Lift-Top Storage', 2100000, ' Inovasi fungsional dengan top table yang dapat diangkat ke atas, mengungkap ruang penyimpanan tersembunyi di dalamnya. Cocok untuk menyimpan remote, buku, atau selimut. Terbuat dari kayu olahan kualitas tinggi dengan veneer kayu atau finishing matte puti', 'meja8.JPG'),
(67, 'Meja Samping C-Shape Portable', 750000, 'Meja samping berbentuk yang dapat digeser di bawah sofa, sangat praktis untuk meletakkan minuman, laptop, atau camilan. Rangka besi ringan dengan top table kayu solid atau akrilik bening. Minimalis dan sangat fungsional. Dimensi: 30x40x60 cm.', '../gambar/meja10.JPG'),
(68, 'Meja Kopi Round Glass Simplicity', 1350000, 'Meja kopi bulat dengan top table kaca temper bening berdiameter 80 cm, memberikan kesan ringan dan memperluas ruang. Kaki-kaki minimalis dari logam chrome atau hitam doff membentuk siluet yang elegan. Desain klasik yang tak lekang oleh waktu dan cocok unt', 'meja5.JPG'),
(69, 'Rak Dapur Chef Organizer Pro', 950000, 'Rak serbaguna 4 tingkat dengan rangka baja karbon hitam doff yang kokoh dan papan rak MDF berlapis HPL motif kayu terang. Dilengkapi pengait samping untuk peralatan gantung dan jaring kawat di bagian bawah untuk sirkulasi udara. Desain ramping dan tinggi,', 'rak3.png'),
(70, 'Rak Dapur Minimalist Corner', 780000, 'Rak sudut 4 tingkat yang dirancang khusus untuk memanfaatkan ruang sudut dapur yang sering terabaikan. Material baja tahan karat berkualitas tinggi yang anti-karat dan mudah dibersihkan. Cocok untuk menata bumbu, botol minyak, atau peralatan kecil. Desain', 'rak7.jpg'),
(71, 'Rak Dapur Bamboo Tiered Space', 620000, 'Rak bumbu atau piring 4 tingkat yang terbuat dari kayu bambu alami yang ramah lingkungan dan tahan lembap. Desain tangga bertingkat memudahkan akses ke barang-barang di belakang. Cocok untuk countertop atau di dalam lemari. Memberikan sentuhan hangat dan ', 'rak4.png'),
(72, 'Rak Dapur Wall Mounted Slim', 550000, 'Rak gantung dinding 2 tingkat dari aluminium anodized yang ringan namun kuat, dengan finishing silver matte. Ideal untuk menempatkan bumbu, stoples kecil, atau dekorasi dapur tanpa memakan ruang di countertop. Pemasangan mudah dengan sekrup tersembunyi. D', 'rak6.jpg'),
(73, 'Rak Dapur Pull Out Pantry', 1500000, 'Rak tarik stainless steel inovatif yang dirancang untuk dipasang di dalam lemari dapur bagian bawah. Sistem rel soft-close memastikan tarikan yang halus. Memiliki beberapa keranjang bertingkat untuk memaksimalkan penyimpanan botol, kaleng, atau bahan maka', 'rak8.jpg'),
(74, 'Rak Dapur Floating Wood Shelf', 1450000, 'Rak melayang tunggal dari kayu solid jati Belanda dengan finishing clear coat untuk menonjolkan serat kayunya. Pemasangan tersembunyi memberikan kesan minimalis dan modern, seolah rak melayang di dinding. Ideal untuk memajang piring cantik, vas bunga, ata', 'rak2.png'),
(75, 'Rak Dapur Modular Wire Grid', 1100000, 'Sistem rak modular dari kawat besi berlapis powder coating hitam yang dapat disesuaikan konfigurasi ketinggian raknya. Ringan, mudah dipasang, dan sangat fleksibel untuk menampung berbagai ukuran barang dapur. Cocok untuk penyimpanan di area laundry dapur', 'rak9.jpg'),
(76, 'Rak Dapur Microwave & Oven Stand', 1200000, 'Rak khusus dengan desain kokoh untuk menempatkan microwave atau oven kecil di bagian tengah. Dibuat dari kombinasi baja karbon dan papan MDF tebal. Dilengkapi rak atas untuk penyimpanan piring dan rak bawah untuk peralatan masak. Menghemat ruang counterto', 'rak5.png'),
(77, 'Rak Dapur Dish Drying Rack Modern', 380000, 'Rak pengering piring modern dari aluminium anti-karat dengan desain minimalis. Dilengkapi tempat sendok garpu terpisah dan tray penampung air yang dapat dilepas. Membuat area cuci piring Anda tetap rapi dan kering. Tersedia dalam warna hitam atau silver. ', 'rak10.jpg'),
(78, 'Rak Dapur Spice Jar Carousel', 1350000, 'Rak untuk bumbu dari stainless steel atau bambu, memudahkan Anda menemukan bumbu yang dibutuhkan tanpa mengacak. Desain ringkas dan modern, cocok untuk diletakkan di countertop atau di dalam lemari. Diameter 20 cm.', 'rak1.png'),
(79, 'Sofa Aurora L Shape Modular', 7800000, 'Sofa L shape dengan desain modular yang fleksibel, memungkinkan Anda menyesuaikan konfigurasi sesuai ruang. Dibungkus kain linen berkualitas tinggi berwarna abu abu muda atau krem, memberikan sentuhan lembut dan modern. Bantal duduk berisi busa high densi', 'sofa4.JPG'),
(80, 'Sofa Nordic Cloud 3-Seater', 5500000, 'Sofa 3-seater bergaya Skandinavia dengan siluet lembut dan bantal punggung yang empuk menyerupai awan. Material kain bludru halus dalam pilihan warna pastel (mint green, dusty pink, atau light grey) memberikan kesan chic dan nyaman. Kaki-kaki runcing dari', 'sofa3.JPG'),
(81, 'Sofa Urban Loft Convertible', 6200000, 'Sofa multifungsi 3-seater yang dapat diubah menjadi tempat tidur futon. Dibungkus dengan kain poliester tebal berwarna charcoal atau navy, tahan aus dan mudah dibersihkan. Rangka besi kokoh dengan sentuhan industrial, dilengkapi jahitan detail pada bantal', 'sofa10.JPG'),
(82, 'Sofa Timeless Chesterfield Minimalis', 9500000, 'Interpretasi modern dari gaya Chesterfield klasik, dengan desain lebih ramping dan kancing tarik yang minimalis. Balutan kulit sintetis premium berwarna cokelat tua atau hitam memberikan kesan mewah dan maskulin. Lengan sofa yang lebih rendah dan sandaran', 'sofa5.JPG'),
(83, 'Sofa Scandi Slim 2-Seater', 390000, 'Sofa 2-seater yang ringkas dan ramping, sempurna untuk ruang tamu minimalis atau apartemen studio. Kain pelapis tenun kasar dalam nuansa earthy (beige atau olive green) dan kaki-kaki kayu jati alami memberikan kesan sederhana namun stylish. Desain sandara', 'sofa9.JPG'),
(84, 'Sofa Contour Comfort Sectional', 8900000, 'Sofa sectional berukuran besar dengan desain kontemporer yang ergonomis. Bantal duduk dan punggung dirancang dengan lekukan untuk menopang tubuh dengan sempurna. Dilapisi kain chenille mewah dalam warna netral (taupe atau abu-abu gelap). Termasuk ottoman ', 'sofa7.JPG'),
(85, 'Sofa Velvet Embrace Armchair', 2800000, 'Kursi berlengan tunggal (armchair) yang nyaman dan elegan, ideal sebagai pelengkap sofa utama atau sudut baca. Material bludru beludru dalam pilihan warna vibrant (emerald green atau royal blue) dengan desain lekukan memeluk. Kaki-kaki metal ramping berwa', 'sofa8.JPG'),
(86, 'Sofa Modular Cube Ottoman', 2500000, 'Set tiga ottoman berbentuk kubus yang multifungsi: bisa menjadi tempat duduk tambahan, meja kopi (dengan tray), atau tempat kaki. Dibungkus kain rajut tebal yang empuk dan nyaman, serta mudah dipindahkan. Tersedia dalam kombinasi warna netral. Fleksibel u', 'sofa1.JPG'),
(87, 'Sofa Retro Mid-Century Modern', 3600000, 'Terinspirasi gaya mid-century modern dengan garis bersih dan kaki-kaki meruncing dari kayu solid. Kain pelapis poliester motif tweed atau kain jacquard memberikan tekstur dan karakter. Lengan sofa yang ramping memaksimalkan ruang duduk. Pilihan warna sepe', 'sofa2.JPG'),
(88, 'Sofa Floating Platform Sofa', 2300000, 'Sofa berukuran besar dengan desain platform rendah yang memberikan ilusi melayang. Bantal duduk dan punggung yang tebal dan lepas pasang memudahkan perawatan. Kain pelapis linen blend yang lembut dan nyaman. Rangka tersembunyi menciptakan tampilan minimal', 'sofa6.JPG');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `Email`, `alamat`) VALUES
(3, 'bagus123', 'bagusdwo', 'c@gmail.com', 'ds. krenceng'),
(7, 'cuaks', 'cuaks', 'cuaks@gmail.com', ''),
(8, 'cihuy', 'cihuy', 'cihuy@gmail.com', 'kanigoro'),
(9, 'o', 'o', 'o@gmail.com', 'o'),
(10, 'paijo', 'paijo', 'paijo@gmail.com', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_pembeli`
--
ALTER TABLE `data_pembeli`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_produk`
--
ALTER TABLE `data_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `data_pembeli`
--
ALTER TABLE `data_pembeli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `data_produk`
--
ALTER TABLE `data_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
