<?php
namespace Controllers;
use Controllers\KursyController;
use Content\Validation;

class PayController extends AppController
{
    use Validation;
    public function pay()
    {
        if (!empty($this->isSumPay($_POST['summaOplata'])) && !empty($this->inStr($_POST['selectCurrency'], '/^[A-Z]+$/'))
         && !empty($this->inNum($_POST['operator']))) {
            $oplata = round($_POST['summaOplata'],4); // Сумма валюты оплаты клиентом 
            $currency =  $_POST['selectCurrency']; // код валюты оплаты
            $id = $_POST['operator']; // id оператора для оплаты
        
            echo "Сумма оплаты $oplata $currency";
            $sum = ceil($oplata * (new KursyController)->get_kurs($currency) * 100) / 100; // Сумма на счёт рублей
            $sum_commis = ceil((new KursyController)->subtract_percent($id, $sum) * 100) / 100;// Сумма на счёт рублей минус комиссия оператора
            $commission = ceil(($sum - $sum_commis) * 100) / 100;// комиссия оператора
            echo "<p>Сумма на счёт $sum RUB<p>";
            echo "<p>Комиссия оператора $commission RUB<p>";
            echo "<p>Сумма на счёт с комиссией $sum_commis RUB<p>";
        }
    }


}