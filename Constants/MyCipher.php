<?php
namespace Constants;
// Store a string into the variable which
// need to be Encrypted
//$simple_string = "Welcome to GeeksforGeeks\n";

// Display the original string
//echo "Original String: " . $simple_string;

// Store the cipher method
$ciphering = "AES-128-CTR";

// Non-NULL Initialization Vector for decryption
$decryption_iv = '1234567891011121';

// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;

// Non-NULL Initialization Vector for encryption
$encryption_iv = '1234567891011121';
function encrypt($simple_string, $ciphering, $encryption_iv, $options){
    // Store the encryption key
    $encryption_key = "QwErTyqWeRtY1234567890";

// Use openssl_encrypt() function to encrypt the data
    $encryption = openssl_encrypt($simple_string, $ciphering,
        $encryption_key, $options, $encryption_iv);
}

// Display the encrypted string
//echo "Encrypted String: " . $encryption . "\n";

 function decrypt($encryption, $ciphering, $options, $decryption_iv){
// Store the decryption key
     $decryption_key = "QwErTyqWeRtY1234567890";
// Use openssl_decrypt() function to decrypt the data
     $decryption=openssl_decrypt ($encryption, $ciphering,
         $decryption_key, $options, $decryption_iv);
 }

// Display the decrypted string
//echo "Decrypted String: " . $decryption;
