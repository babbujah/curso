<?php
class EncurtadorHashBasicoServiceDecorator extends UrlDecorator{
    public function encurtarLink(){
        if(!empty($this->encurtadorLink->get_enderecoRelativoReal())){
            
            $enderecoRelativo = $this->encurtadorLink->get_enderecoRelativoReal();
            $enderecoRelativoCifrado = $this->cifrar($enderecoRelativo);
            $this->encurtadorLink->set_enderecoRelativoEncurtado($enderecoRelativoCifrado);
            //$enderecoAbsolutoCifrado = "$enderocoRelativoCifrado";
            //print_r($this->encurtadorLink->get_enderecoRelativoReal());
            //die;
            
        }
        
        return $this->encurtadorLink->get_enderecoRelativoEncurtado();
    }
    
    private function cifrar($enderecoRelativo){
        $enderecoHash = md5($enderecoRelativo);
        
        return $enderecoHash;
    }
}
