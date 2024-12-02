<?php
namespace Controllers;

use Models\Kursy;

class KursyController
{
    use Kursy;
    public function get_kursy(): void {
  
        header('Content-Type: application/json');
        echo json_encode($this->kurs(), JSON_UNESCAPED_UNICODE);
    }

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
}