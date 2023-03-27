<?php
class EncurtadorHashBasicoServiceDecorator extends UrlDecorator{
    public function encurtarLink(){
        if(!empty($this->encurtadorLink->get_enderecoAbsoluto())){
            
            $enderecoRelativo = $this->recuperarEnderecoRelativo($urlAbsoluta);
            $enderecoRelativoCifrado = $this->cifrar($enderecoRelativo);
            $enderecoAbsolutoCifrado = self::DOMINIO . "$enderocoRelativoCifrado";
            
        }
        
        return $enderecoAbsolutoCifrado;
    }
    
    public function cifrar(){
        $enderecoHash = md5($enderecoRelativo);
        
        return $enderecoHash;
    }
}
