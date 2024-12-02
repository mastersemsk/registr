<?php
namespace Models;

trait Kursy 
{
    use Connect;
    public function kurs(): array|bool|string
    {
        try {
            $result = $this->li->query("SELECT * FROM kursy WHERE id=1");
            return $result->fetch_assoc();
        } catch (\RuntimeException $th) {
            die($th->getMessage());
        }
        
    }
    
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
