<?php
session_start();

// Hapus semua data sesi
session_destroy();

// Alihkan pengguna ke halaman login setelah logout
header('Location: login.php');
exit();
?>
