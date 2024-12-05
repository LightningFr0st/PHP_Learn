<?php
class CryptoManager{
    private string $METHOD;
    private string $key;
    public function __construct(string $method, string $key){
        $this->METHOD = $method;
        $this->key = $key;
    }
    public function encrypt($message, $encode = false): string
    {
        $nonceSize = openssl_cipher_iv_length($this->METHOD);
        $nonce = openssl_random_pseudo_bytes($nonceSize);

        $ciphertext = openssl_encrypt(
            $message,
            $this->METHOD,
            $this->key,
            OPENSSL_RAW_DATA,
            $nonce
        );

        if ($encode) {
            return base64_encode($nonce.$ciphertext);
        }
        return $nonce.$ciphertext;
    }

    public function decrypt($message, $encoded = false): string
    {
        if ($encoded) {
            $message = base64_decode($message, true);
            if ($message === false) {
                throw new Exception('Encryption failure');
            }
        }

        $nonceSize = openssl_cipher_iv_length($this->METHOD);
        $nonce = mb_substr($message, 0, $nonceSize, '8bit');
        $ciphertext = mb_substr($message, $nonceSize, null, '8bit');

        $plaintext = openssl_decrypt(
            $ciphertext,
            $this->METHOD,
            $this->key,
            OPENSSL_RAW_DATA,
            $nonce
        );

        return $plaintext;
    }
}