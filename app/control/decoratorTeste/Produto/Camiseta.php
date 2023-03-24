<?php
class Camiseta implements IProduto{

    private $nome;
    private $valor;
    
    public function __construct(){
        $this->nome = 'Camiseta';
        $this->valor = 49.9;
    }
    
    public function getNome(){
        return $this->nome;
    }
    
    public function getValor(){
        return $this->valor;
    }
}
