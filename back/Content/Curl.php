<?php
namespace Content;

class Curl 
{
    public static function curl(array $data): array
    {
        $ch = curl_init();
        curl_setopt_array($ch, $data);
        $result['body'] = curl_exec($ch);
        $result['http_code'] = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $result['error']= curl_errno($ch);
        curl_close($ch);
        return $result;
    }
}