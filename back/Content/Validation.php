<?php
namespace Content;

trait Validation
{
    public function isSumPay($summa): bool|int
    {
        return preg_match('/^\d{1,8}(\.\d{1,4})?$/',$summa);
    }
    public function isEmail(string $str): bool|string
    {
        // проверяет строку на то, что она корректный email
        return filter_var($str, FILTER_VALIDATE_EMAIL);
    }
    
    public function isDomain($str): bool|string
    {
        // проверяет строку на то, что она корректное имя домена
        return filter_var($str, FILTER_VALIDATE_DOMAIN);
    }
    
    /**
     * проверяет число
     * @param int $num
     * @return bool|int
     */
    public function inNum($num): bool|int
    { 
        return  preg_match('/^[0-9]+$/',$num);
    }
    /**
     * // проверяет строку
     * @param string $str
     * @param string $pattern патерн для проверки
     * @return bool|int
     */
    public function inStr(string $str, string $pattern): bool|int
    {
        return  preg_match($pattern,$str);
        
        //in_array(mb_strlen($str),range($from, $to));
    }
}