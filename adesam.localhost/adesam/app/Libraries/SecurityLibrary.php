<?php

namespace App\Libraries;


use Base64Url\Base64Url;
use \MrShan0\CryptoLib\CryptoLib;



/**
 * 
 */
class SecurityLibrary
{

    public static function encrypt($password)
    {
        $options = [
            'cost' => 15,
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public static function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function check($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public static function salt16()
    {
        return bin2hex(random_bytes(16));
    }

    public static function encryptUrlId($data)
    {
        $encryption = new CryptoLib();
        return Base64Url::encode($encryption->encryptPlainTextWithRandomIV($data, session()->get('userKey')));
    }

    public static function decryptUrlId($cipher)
    {
        $encryption = new CryptoLib();
        return $encryption->decryptCipherTextWithRandomIV(Base64Url::decode($cipher), session()->get('userKey'));

    }

    public static function generateCookies(): array
    {
        $selector = bin2hex(random_bytes(16));
        $validator = bin2hex(random_bytes(32));

        return [$selector, $validator, $selector . ':' . $validator];
    }

}