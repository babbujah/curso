<?php
class Encurtador implements IEncurtadorLink{
    const DOMINIO = 'http:www.fiern.org.br/';
    
    //private $enderecoAbsoluto;
    private $enderecoRelativoReal;
    //private $enderecoRelativoPersonalizado;
    private $enderecoRelativoEncurtado;
    public function __construct(){
        //$this->enderecoAbsoluto = SELF::DOMINIO;
        $this->enderecoRelativoReal = SELF::DOMINIO;
        //$this->enderecoRelativoPersonalizado = "";
        $this->enderecoRelativoEncurtado = SELF::DOMINIO;
    }
    
    public function encurtarLink(){
        return SELF::DOMINIO;   
    }
    
    
    /*
    private recuperarEnderecoRelativo(){
        $urlVetor = explode('/',  $this->enderecoAbsoluto);
        $this->enderecoRelativoReal = end($urlVetor);
        
        return $this->enderecoRelativoReal;
    }
    */
    
    /*
    public function get_enderecoAbsoluto(){
        return $this->enderecoAbsoluto;
    }
    */
    
    public function get_enderecoRelativoReal(){
        return $this->enderecoRelativoReal;
    }
    
    public function get_enderecoRelativoEncurtado(){
        return $this->enderecoRelativoEncurtado;
    }
    
    public function set_enderecoRelativoEncurtado($enderecoRelativoCifrado){
        $this->enderecoRelativoEncurtado .=  $enderecoRelativoCifrado;
    }
}
