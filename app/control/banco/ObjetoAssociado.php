<?php
class ObjetoAssociado extends TPage{
    public function __construct(){
        parent::__construct();
        
        try{
            TTransaction::open('curso');
            
            $cliente = new Cliente(2);
            
            echo $cliente->nome;
            echo '<br>';
            echo $cliente->cidade->nome;
            echo '<br>';
            echo $cliente->cidade->estado->nome;
            
            TTransaction::close();
            
        }catch(Exception $e){
            new TMessage('error', $e->getMessage());
        }
    }
}