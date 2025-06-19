<?php
    include 'koneksi.php';
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $detail = $_POST['detail'];
    $gambar = $_FILES['gambar']['name'];
    $file_tmp = $_FILES['gambar']['tmp_name'];

    // Validasi agar data tidak kosong
    if(empty($nama) || empty($harga) || empty($detail) || empty($gambar)) {
        echo '<script>alert("Semua field harus diisi!");history.back();</script>';
        exit;
    }

    move_uploaded_file($file_tmp, 'gambar/'.$gambar);

    $query = "INSERT INTO data_produk SET 
        nama = '$nama',
        harga = '$harga',
        detail = '$detail',
        gambar = '$gambar'
    ";
    mysqli_query($koneksi, $query)
    or die("SQL Error " .mysqli_error($koneksi));
    echo '<script>alert("Data berhasil disimpan");
        location.href="dashboard.php";</script>';
?>