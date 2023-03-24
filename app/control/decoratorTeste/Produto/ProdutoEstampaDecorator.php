<?php
class ProdutoEstampaDecorator extends ProdutoDecorator{

    public function getNome(){
        return $this->produto->getNome() . ' (Estampada)';
    }
    
    public function getValor(){
        return $this->produto->getValor() + 10;
    }
}
