<?php

session_start();

// Hapus data sesi
session_destroy();

// Alihkan ke halaman login
header('Location: index.php');
?>
