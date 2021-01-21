<?php

namespace App\Helpers;

class Token
{

    private $cipher;
    private $key;
    private $options;
    private $iv;

    public function __construct()
    {
        $this->cipher = 'AES-128-CTR';
        $this->key = openssl_digest(php_uname(), 'MD5', TRUE);
        $this->options = 0;
        $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));   
    }

    public function encrypt(string $apitoken) : string
    {     
        $hash = openssl_encrypt($apitoken, $this->cipher, $this->key, $this->options, $this->iv) . '::' . bin2hex($this->iv);
        unset($apitoken, $this->cipher, $this->key, $this->iv);
        return $hash;
    }

    public function decrypt(string $token) : string
    {
        list($hash, $iv) = explode('::', $token);
        $decryptedHash = openssl_decrypt($hash, $this->cipher, $this->key, $this->options, hex2bin($iv));
        unset($hash, $this->cipher, $this->key, $iv);
        return $decryptedHash;
    }
}