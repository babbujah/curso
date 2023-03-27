<?php
class EncurtadorHashBasicoServiceDecorator extends UrlDecorator{
    public function encurtarLink(){
        if(!empty($this->encurtadorLink->get_enderecoAbsoluto())){
            
            $enderecoRelativo = $this->recuperarEnderecoRelativo($this->encurtadorLink->get_enderecoAbsoluto());
            $enderecoRelativoCifrado = $this->cifrar($enderecoRelativo);
            $this->encurtadorLink->set_enderecoRelativoReal();
            $enderecoAbsolutoCifrado = self::DOMINIO . "$enderocoRelativoCifrado";
            
        }
        
        return $enderecoAbsolutoCifrado;
    }
    
    public function cifrar(){
        $enderecoHash = md5($enderecoRelativo);
        
        return $enderecoHash;
    }
}
