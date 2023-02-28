<?php
/**
* ClienteHabilidade Active Record
* @author <your-name-here>
**/
class ClienteHabilidade extends TRecord{
    const TABLENAME = 'cliente_habilidade';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max'; // {max, serial}
    
    private $habilidade;
    
    /**
    * Constructor method
    **/
    public function __construct($id = NULL, $callObjectLoad = TRUE){
        parent::__construct($id, $callObjectLoad);
        
        parent::addAttribute('cliente_id');
        parent::addAttribute('habilidade_id');
    }
    
    public function get_habilidade(){
        if(empty($this->habilidade)){
            $this->habilidade = new Habilidade($this->habilidade_id);
        }
        
        return $this->habilidade;
    }
}