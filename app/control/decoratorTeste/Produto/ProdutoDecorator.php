<?php
class ProdutoDecorator implements IProduto{

    protected $produto;

    public function __construct(IProduto $produto){
        $this->produto = $produto;
    }
    
     public function getNome(){
        return $this->produto->getNome();
    }
    
    public function getValor(){
        return $this->produto->getValor();
    }
}
