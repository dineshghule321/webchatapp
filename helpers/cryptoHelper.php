<?php

/**
 * ----------------------------------------------------------------------------------------
 * this function used for triple encryption of MD5 and SHA512
 * ----------------------------------------------------------------------------------------
 * @param $hash
 * @return string
 */
function sha1Md5DualEncryption($hash)
{
    $salt = sha1(md5($hash));
    $hash = md5($hash . $salt);
    return $hash;
}

/**
 * ----------------------------------------------------------------------------------------
 * this function used to generate random string up to 15 characters
 * ----------------------------------------------------------------------------------------
 * @param int $length
 * @return string
 */
function generateRandomString($length = 15)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}



?>