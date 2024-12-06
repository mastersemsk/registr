<?php
namespace Controllers;

use Models\Kursy;

class KursyController
{
    use Kursy;
    /**
     * Создаёт JSON в браузер, из массива курсов
     * @return void
     */
    public function get_kursy(): void {
  
        header('Content-Type: application/json');
        echo json_encode($this->kurs(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Выводит курс по коду валюты
     * @param string $currency
     * @return float|int
     */
    public function get_kurs ($currency): float|int 
    {
        $kursy = $this->kurs();
        
        $kurs = match ($currency) {
            'BTC' => $kursy['kursBtc'],
            'USDT' => $kursy['kursUsdt'],
            'WMZ' => $kursy['kursWMZ'],
            'WMX' => $kursy['kursWMX'],
            'WMT' => $kursy['kursWMT'],
            default => 0,
        };
        return $kurs;
    }

    /**
     * * Вычитает из сумма на зачисления на счёт комиссию оператора
     * * @param int $id оператора
     * * @param float|int $price сумма на счёт рублей
     * * @return float|int сумма минус комиссия оператора
     * */
    public function subtract_percent($id, $price): float|int
{
    $comis = $this->commission($id);
    $sum = $price;
    if (!empty($comis) && $price > 0) {
        $pct = $comis['pct']; // procent commission
        $fixed = $comis['fixed']; // fixed commission
        $from_pay = $comis['from_pay']; //start sum commission
        $to_pay = $comis['to_pay']; //end sum commission
    
        if ($pct != 0 ||  $fixed != 0) {
            //no limits on the amount
            if ($from_pay == 0 && $to_pay == 0) {
                $sum = $price - $price * ($pct / 100) - $fixed;
            }
            //limits amount from and to
            if ($price >= $from_pay && $price <=  $to_pay) {
                $sum = $price - $price * ($pct / 100) - $fixed;
            }
        }
    }
    return $sum;
}
}