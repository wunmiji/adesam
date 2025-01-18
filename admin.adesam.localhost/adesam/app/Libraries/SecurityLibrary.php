<?php

namespace App\Libraries;


use \CodeIgniter\Exceptions\PageNotFoundException;

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
        if (is_null($data))
            return null;
        else {
            $encryption = new CryptoLib();
            return Base64Url::encode($encryption->encryptPlainTextWithRandomIV($data, session()->get('familyKey')));
        }
    }

    public static function decryptUrlId($cipher)
    {
        if (is_null($cipher))
            return null;
        else {

            $encryption = new CryptoLib();
            return $encryption->decryptCipherTextWithRandomIV(Base64Url::decode($cipher), session()->get('familyKey'));

        }


    }

}