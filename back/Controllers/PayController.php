<?php
namespace Controllers;
use Controllers\KursyController;

class PayController extends AppController
{
    public function pay()
    {
        if (isset($_POST['summaRub']) && preg_match('/^\d{1,8}(\.\d{1,2})?$/',$_POST['summaRub']) == 1) {
            $summa = round($_POST['summaRub'],2); //Сумма на счёт клиента, без комиссии оператора 
            echo "<p>Сумма на счёт $summa RUB<p>";
        }
        if (isset($_POST['summaOplata']) && preg_match('/^\d{1,8}(\.\d{1,4})?$/',$_POST['summaOplata']) == 1 && preg_match('/[A-Z]{1,10}/',$_POST['selectCurrency']) == 1) {
            $oplata = round($_POST['summaOplata'],4); // Сумма валюты оплаты клиентом 
            $currency =  $_POST['selectCurrency']; // код валюты оплаты
            $id = $_POST['operator']; // id оператора для оплаты
        
            echo "Сумма оплаты $oplata $currency";
            $sum = ceil($oplata * (new KursyController)->get_kurs($currency) * 100) / 100; // Сумма на счёт рублей PHP
            echo '<p>'.$sum.' RUB</p>';
            //echo '<p>Комиссия оператора '.commission_operator($id,$oplata).' RUB<p>';
            //echo '<p>Сумма на счёт '.get_summa($currency,$oplata, $id).' RUB<p>';
        }
    }


}