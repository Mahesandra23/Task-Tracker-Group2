<?php
session_start();
session_destroy();
$loginSuccess = false;
echo "<script>alert('Logout berhasil! Anda akan menuju halaman utama.'); window.location.href='index.php';</script>";
exit;
?>
