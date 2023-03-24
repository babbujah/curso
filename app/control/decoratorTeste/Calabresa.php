<?php
class Calabresa extends RecheioDecorator{
    
    private $pao;
    
    public function __construct(Pao $pao){
        $this->pao = $pao;
    }
    
    public function getNome(){
        return $this->pao->getNome(). ", Calabresa";
    }
    
    public function valor(){
        return 2 + $this->pao->valor();
    }
}
