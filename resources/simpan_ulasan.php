<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ulasan = trim($_POST['ulasan']);

            echo "<script>
                alert('Terima kasih atas ulasan Anda!');
                window.location.href = 'home.php';
            </script>";

}
?>
