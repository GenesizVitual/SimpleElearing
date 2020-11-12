<?php
namespace App\Helper;

class SettingUrl
{
//    public static $baseUrl='http://localhost/SimpleElearing/public/';
    public static $baseUrl='';

    public static function getUrl(){
        return self::$baseUrl;
    }
}