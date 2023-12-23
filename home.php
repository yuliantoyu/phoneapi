<?php

session_start();
require_once 'vendor/autoload.php';

// Jika sudah login, tampilkan informasi pengguna
if (isset($_SESSION['access_token'])) {
    $token = $_SESSION['access_token'];

    $googleClient = new Google_Client();
    $googleClient->setAccessToken($token);

    $google_oauth = new Google_Service_Oauth2($googleClient);
    $googleAccountInfo = $google_oauth->userinfo->get();

    $userEmail = $googleAccountInfo->getEmail();
    $userName = $googleAccountInfo->getName();
    $userId = $googleAccountInfo->getId();

    echo "Selamat datang, $userName! (Email: $userEmail, ID: $userId)";

    // Tambahan: Tombol logout
    echo '<br><a href="logout.php">Logout</a>';
} else {
    // Jika belum login, alihkan ke halaman login
    header('Location: index.php');
}
?>
