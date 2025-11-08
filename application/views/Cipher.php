<?php
// Cipher.php - OpenSSL-based, kompatibel PHP 7.x+
// Simpel, aman (pakai AES-256-CBC default), tidak menggunakan fitur PHP 8 seperti named args atau typed properties.

class Cipher
{
    private $cipher;
    private $ivlen;

    /**
     * Constructor
     * @param string $cipher_name Nama cipher openssl. Default 'aes-256-cbc'.
     */
    public function __construct($cipher_name = 'aes-256-cbc')
    {
        // normalisasi nama
        $cipher_name = strtolower($cipher_name);

        // peta nama-nama mcrypt ke openssl agar sedikit backward-compatible
        $map = array(
            'mcrypt_blowfish'  => 'bf-ecb',
            'mcrypt_blowfish2' => 'bf-cbc',
            'mcrypt_3des'      => 'des-ede3-cbc',
            'mcrypt_aes'       => 'aes-256-cbc',
        );

        if (isset($map[$cipher_name])) {
            $cipher_name = $map[$cipher_name];
        }

        // pastikan openssl mendukung cipher tersebut
        $available = array_map('strtolower', openssl_get_cipher_methods(true));
        if (!in_array($cipher_name, $available, true)) {
            $cipher_name = 'aes-256-cbc';
        }

        $this->cipher = $cipher_name;
        // iv length mungkin false jika cipher tanpa IV (mis. ECB) -> cast ke int untuk aman
        $this->ivlen = (int) openssl_cipher_iv_length($this->cipher);
    }

    /**
     * Encrypt
     * @param string $data Plaintext
     * @param string $key  Key/password (akan di-hash menjadi 32 byte)
     * @return string Base64 encoded payload (IV + ciphertext) atau ciphertext jika cipher tanpa IV
     */
    public function encrypt($data, $key)
    {
        // derivasi key: buat 32-byte key dari password (sha256)
        $key_bin = hash('sha256', $key, true);

        if ($this->ivlen > 0) {
            $iv = openssl_random_pseudo_bytes($this->ivlen);
            $ciphertext_raw = openssl_encrypt($data, $this->cipher, $key_bin, OPENSSL_RAW_DATA, $iv);
            $payload = $iv . $ciphertext_raw;
        } else {
            // cipher tanpa IV (mis. bf-ecb)
            $ciphertext_raw = openssl_encrypt($data, $this->cipher, $key_bin, OPENSSL_RAW_DATA);
            $payload = $ciphertext_raw;
        }

        return base64_encode($payload);
    }

    /**
     * Decrypt
     * @param string $payload_base64 Base64 hasil encrypt
     * @param string $key
     * @return string Plaintext (kosong jika gagal)
     */
    public function decrypt($payload_base64, $key)
    {
        $key_bin = hash('sha256', $key, true);
        $payload = base64_decode($payload_base64, true);

        if ($payload === false) {
            return '';
        }

        if ($this->ivlen > 0) {
            if (strlen($payload) <= $this->ivlen) {
                return '';
            }
            $iv = substr($payload, 0, $this->ivlen);
            $ciphertext_raw = substr($payload, $this->ivlen);
            $original = openssl_decrypt($ciphertext_raw, $this->cipher, $key_bin, OPENSSL_RAW_DATA, $iv);
        } else {
            $original = openssl_decrypt($payload, $this->cipher, $key_bin, OPENSSL_RAW_DATA);
        }

        return ($original === false) ? '' : $original;
    }
}
