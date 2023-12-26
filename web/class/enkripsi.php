<?php

class Enkripsi
{
   
    private static function generateIV()
    {
        return openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    }

 
    private static function generateKey($passphrase, $salt)
    {
        return hash_pbkdf2('sha256', $passphrase, $salt, 1000, 32, true);
    }

  
    public static function encrypt($data, $passphrase)
    {
        $salt = self::generateIV(); // Menghasilkan IV sebagai salt
        $key = self::generateKey($passphrase, $salt); // Menghasilkan KEY dari passphrase dan salt

        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $salt);

      
        $result = base64_encode($salt . $encrypted);

        return $result;
    }

   
    public static function decrypt($data, $passphrase)
    {
        $data = base64_decode($data);

     
        $salt = substr($data, 0, 16);
        $data = substr($data, 16);

        $key = self::generateKey($passphrase, $salt); // Menghasilkan KEY dari passphrase dan salt

        $decrypted = openssl_decrypt($data, 'aes-256-cbc', $key, 0, $salt);

        return $decrypted;
    }
}


$originalText = "Ini adalah teks yang akan dienkripsi";

$passphrase = "kunciRahasia123"; 


$encryptedText = Enkripsi::encrypt($originalText, $passphrase);
echo "Teks Enkripsi: $encryptedText\n";


$decryptedText = Enkripsi::decrypt($encryptedText, $passphrase);
echo "Teks Dekripsi: $decryptedText\n";

?>
