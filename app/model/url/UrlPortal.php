<?php
/**
 * Base class for Active Records
 *
 * @version    1.0
 * @package    curso
 * @author     Bruno César Lopes da Silva
 * @copyright  
 * @license    
 */
class UrlPortal extends TRecord implements IEncurtadorLink{
    const TABLENAME = 'url_portal';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'serial';
    
    /**
    * atribute Stamps - Grava automaticamente as datas em banco de dados desde que tenha as colunas na tabela
    * CREATEDAT data de criação do objeto
    * UPDATEDAT data de atualização do objeto
    **/
    const CREATEDAT = 'created_at';
    const UPDATEDAT = 'updated_at';
    
    const DOMINIO = 'http:www.fiern.org.br/';
    
    private $enderecoAbsoluto;
    private $enderecoRelativoReal;
    private $enderecoRelativoEncurtado;
    
    /**
    * Método construtor
    **/
    public function __construct($id = NULL, $callObjectLoad = TRUE){
        parent::__construct($id, $callObjectLoad);
        
        parent::addAttribute($enderecoRelativoReal);
        parent::addAttribute($enderecoRelativoEncurtado);
    }
    
    public function get_enderecoAbsoluto(){
        return $this->enderecoAbsoluto;
    }
    
    public function get_enderecoRelativoReal(){
        return $this->enderecoRelativoReal;
    }
    
    public function get_enderecoRelativoEncurtado(){
        return $this->enderecoRelativoEncurtado;
    }
}


/**
    * atribute Stamps - Grava automaticamente as datas em banco de dados desde que tenha as colunas na tabela
    * CREATEDAT data de criação do objeto
    * UPDATEDAT data de atualização do objeto
    **/