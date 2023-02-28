<?php

/**
* Contato Active Record
* @author <your-name-here>
**/
class Contato extends TRecord{
    const TABLENAME = 'contato';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max'; // {max, serial}
    
    private $cliente;
    
    public function __construct($id = NULL, $callObjectLoad = TRUE){
        parent::__construct($id, $callObjectLoad);
        
        parent::addAttribute('tipo');
        parent::addAttribute('valor');
        parent::addAttribute('cliente_id');
    
    }
    
    public function get_cliente(){
        if(empty($this->cliente)){
            $this->cliente = new Cliente($this->cliente_id);
            
        }
        
        return $this->cliente;
    }
}
