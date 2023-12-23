<?php

class Enkripsi
{
   
    private static function generateIV()
    {
        return openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    }

    // Fungsi untuk menghasilkan KEY (kunci) dari passphrase dengan menggunakan PBKDF2
    private static function generateKey($passphrase, $salt)
    {
        return hash_pbkdf2('sha256', $passphrase, $salt, 1000, 32, true);
    }

    // Fungsi untuk melakukan enkripsi menggunakan OpenSSL
    public static function encrypt($data, $passphrase)
    {
        $salt = self::generateIV(); // Menghasilkan IV sebagai salt
        $key = self::generateKey($passphrase, $salt); // Menghasilkan KEY dari passphrase dan salt

        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $salt);

        // Menggabungkan IV dan teks terenkripsi menjadi satu string
        $result = base64_encode($salt . $encrypted);

        return $result;
    }

    // Fungsi untuk melakukan dekripsi menggunakan OpenSSL
    public static function decrypt($data, $passphrase)
    {
        $data = base64_decode($data);

        // Mengambil IV dari data terenkripsi
        $salt = substr($data, 0, 16);
        $data = substr($data, 16);

        $key = self::generateKey($passphrase, $salt); // Menghasilkan KEY dari passphrase dan salt

        $decrypted = openssl_decrypt($data, 'aes-256-cbc', $key, 0, $salt);

        return $decrypted;
    }
}

// Contoh penggunaan
$originalText = "Ini adalah teks yang akan dienkripsi";

$passphrase = "kunciRahasia123"; // Ganti passphrase dengan yang lebih aman di lingkungan produksi

// Enkripsi
$encryptedText = Enkripsi::encrypt($originalText, $passphrase);
echo "Teks Enkripsi: $encryptedText\n";

// Dekripsi
$decryptedText = Enkripsi::decrypt($encryptedText, $passphrase);
echo "Teks Dekripsi: $decryptedText\n";

?>
