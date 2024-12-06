<?php
namespace Models;

trait Kursy 
{
    use Connect;
    /**
     * Создаёт массив курсов валют
     * @return array|bool|string
     */
    public function kurs(): array|bool|string
    {
        try {
            $result = $this->li->query("SELECT * FROM kursy WHERE id=1");
            return $result->fetch_assoc();
        } catch (\RuntimeException $th) {
            die($th->getMessage());
        }
        
    }
    
    /**
     * Создаёт массив комиссий по id оператора
     * @param int $id
     * @return array|bool|string
     */
    public function  commission($id): array|bool|string
    {
        try {
            $result = $this->li->query("SELECT * FROM commissions WHERE operator_id=$id");
            return $result->fetch_assoc();
        } catch (\RuntimeException $th) {
            die($th->getMessage());
        }
        
    }
}
