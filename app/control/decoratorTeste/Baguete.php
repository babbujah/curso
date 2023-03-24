<?php
class Baguete extends Pao{
    public function __construct(){
        $this->nome = "Baguete";
    }
    
    public function valor(){
        return 3;
    }
}
