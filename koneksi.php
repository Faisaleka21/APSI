<?php
$koneksi = mysqli_connect("localhost", "root", "", "furnispace");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>