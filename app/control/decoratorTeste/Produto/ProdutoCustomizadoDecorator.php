<?php
class ProdutoCustomizadoDecorator extends ProdutoDecorator{
    
    public function getNome(){
        return $this->produto->getNome() . ' (Customizada)';
    }
    
    public function getValor(){
        return $this->produto->getValor() + 50;
    }
}
