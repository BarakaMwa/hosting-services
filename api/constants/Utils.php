<?php

class Utils
{
    private $cipheringValue = "AES-128-CTR";
    private $cipherKey = "qwertyQWERTY";

    /**
     * @param array $data
     * @return string
     */
    public function cleanString(array $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    /**
     * @param int $length
     * @return string
     * @throws Exception
     */
    public function generateRandomString(int $length = 16): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return str_shuffle($randomString);
    }

    /**
     * @param $original_string
     * @return string
     */
    public function encryptString($original_string): string
    {
// Store the cipher method for encrypting
        $ciphering_value = $this->cipheringValue;

// Store the encryption key
        $encryption_key = $this->cipherKey;
// Use openssl_encrypt() function for encrypting the dat

// Return the encrypted string
        return openssl_encrypt($original_string, $ciphering_value, $encryption_key);
    }

    /**
     * @param $encryption_value
     * @return string
     */
    public function decryptString($encryption_value): string
    {
        $ciphering_value = $this->cipheringValue;
        $decryption_key = $this->cipherKey;
// Use openssl_decrypt() function to decrypt the data
// Return the decrypted string as an original data
        return openssl_decrypt($encryption_value, $ciphering_value, $decryption_key);
    }


}