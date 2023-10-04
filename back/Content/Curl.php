<?php
namespace Content;

class Curl 
{
    public static function curl($data)
    {
        $ch = curl_init();
        curl_setopt_array($ch, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}