<?php

namespace App\Utils;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Exception;

class EncryptionHelper
{
    private const ALGORITHM = 'AES-256-CBC';
    private const SECRET_KEY = 'A1b2C3d4E5f6G7h8A1b2C3d4E5f6G7h8';

    /**
     * Encrypts a given string using AES-256-CBC.
     *
     * @param string $data
     * @return string|false Base64 encoded encrypted data with IV prepended, or false on failure.
     */
    public static function encrypt(string $data)
    {
        $key = 'A1b2C3d4E5f6G7h8'; // Must be 16 bytes
        $iv = random_bytes(16); // Generate IV
        $cipher = 'AES-128-CBC';
        
        $encrypted = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        
        return base64_encode($iv . $encrypted);
    }

    /**
     * Decrypts a given string using AES-256-CBC.
     *
     * @param string $encryptedData
     * @return string|false Decrypted data, or false on failure.
     */
    function decryptData($encryptedData) {
        $key = 'A1b2C3d4E5f6G7h8'; // Must be 16 bytes
        $cipher = 'AES-128-CBC';
    
        $decoded = base64_decode($encryptedData);
        $iv = substr($decoded, 0, 16); // Extract IV
        $encryptedBytes = substr($decoded, 16);
    
        return openssl_decrypt($encryptedBytes, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    }
}
