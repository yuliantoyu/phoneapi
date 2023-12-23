<?php

session_start();

require_once 'vendor/autoload.php';

// Konfigurasi Google API
$clientID = '759166153431-jtg1rvjh2cudn77214rjnfbnpd837jjb.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'https://codego.cloud/callback.php';

// Buat objek Google Client
$googleClient = new Google_Client();
$googleClient->setClientId($clientID);
$googleClient->setClientSecret($clientSecret);
$googleClient->setRedirectUri($redirectUri);
$googleClient->addScope("email");
$googleClient->addScope("profile");

// Jika sudah login, alihkan ke halaman home
if (isset($_SESSION['access_token'])) {
    header('Location: home.php');
}

// Jika belum login, tampilkan tombol login dengan Google
if (!isset($_SESSION['access_token'])) {
    $loginURL = $googleClient->createAuthUrl();
    echo "<a href='$loginURL'>Login with Google</a>";
}
?>
