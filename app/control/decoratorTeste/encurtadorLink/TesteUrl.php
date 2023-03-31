<?php
class TesteUrl extends TPage{
    public function __construct(){
        parent::__construct();
        
        $url = 'paginadeteste';
        
        $encurtador = new Encurtador();
        $encutadorHash = new EncurtadorHashBasicoServiceDecorator($encurtador);
        
        //print_r($encurtador->encurtarLink());
        print_r($encutadorHash->encurtarLink());
    }
}
