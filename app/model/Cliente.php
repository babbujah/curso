<?php
/**
* Cliente Active Record
* @author <your-name-here>
**/
class Cliente extends TRecord{
    const TABLENAME = 'cliente';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max'; // {max, serial}
    
    /**
    * atribute Stamps - Grava automaticamente as datas em banco de dados desde que tenha as colunas na tabela
    * CREATEDAT data de criação do objeto
    * UPDATEDAT data de atualização do objeto
    **/
    const CREATEDAT = 'created_at';
    const UPDATEDAT = 'updated_at';
    
    private $cidade;
    private $categoria;
    
    /**
    * Constructor method
    **/
    public function __construct($id = NULL, $callObjectLoad = TRUE){
        parent::__construct($id, $callObjectLoad);
        
        parent::addAttribute('nome');
        parent::addAttribute('endereco');
        parent::addAttribute('telefone');
        parent::addAttribute('nascimento');
        parent::addAttribute('situacao');
        parent::addAttribute('email');
        parent::addAttribute('genero');
        parent::addAttribute('categoria_id');
        parent::addAttribute('cidade_id');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        
    }
    
    public function get_categoria(){
        if(empty($this->categoria)){
            $this->categoria = new Categoria($this->categoria_id);
            
        }
        
        return $this->categoria;
    }
    
    public function get_cidade(){
        if(empty($this->cidade)){
            $this->cidade = new Cidade($this->cidade_id);
        }
        
        return $this->cidade;
    }
    
    /**
    * Hook method - Executa antes de carregar o objeto
    * $id - id do objeto a ser carregado
    * @author <your-name-here>
    **/
    public function onBeforeLoad($id){
        //echo "Antes de carregar o registro $id <br>";
        
    }
    
    /**
    * Hook method - Executa depois de carregar o objeto
    * $object - objeto a ser carregado
    * @author <your-name-here>
    **/
    public function onAfterLoad($object){
        //print_r($object);
        
    }
    
    /**
    * Hook method - Executa antes de gravar o objeto
    * $object - objeto a ser gravado
    * @author <your-name-here>
    **/
    public function onBeforeStore($object){
        /*echo "<b>Antes de gravar o objeto</b> <br>";
        print_r($object);
        echo "<br>";*/
    }
    
    /**
    * Hook method - Executa depois de gravar o objeto
    * $object - objeto a ser gravado
    * @author <your-name-here>
    **/
    public function onAfterStore($object){
        /*echo "<b>Depois de gravar o objeto</b> <br>";
        print_r($object);
        echo "<br>";*/
    }
    
    /**
    * Hook method - Executa antes de excluir o objeto
    * $object - objeto a ser gravado
    * @author <your-name-here>
    **/
    public function onBeforeDelete($object){
        /*echo "<b>Antes de excluir o objeto</b> <br>";
        print_r($object);
        echo "<br>";*/
    }
    
    /**
    * Hook method - Executa depois de excluir o objeto
    * $object - objeto a ser gravado
    * @author <your-name-here>
    **/
    public function onAfterDelete($object){
        /*echo "<b>Depois de excluir o objeto</b> <br>";
        print_r($object);
        echo "<br>";*/
    }
    
}
