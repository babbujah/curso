<?php
/**
* Classe Active Record que representa um objeto Arquivo dentro do sistema.
*
* @version    1.0
* @package    model/arquivo
* @author     Bruno Lopes
* @since      15/05/2023  
**/
class Arquivo extends TRecord{
    const TABLENAME = 'arquivo_info';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'serial';
    
    /**
    * atribute Stamps - Grava automaticamente a data de criação em banco de dados.
    * CREATEDAT data de criação do objeto
    **/
    const CREATEDAT = 'createdat';
    
    /**
     * Class Constructor
     */
    public function __construct( $id = null, $callObjectLoad = true ){
        parent::__construct( $id, $callObjectLoad );
        
        parent::addAttribute( 'dirname' );
        parent::addAttribute( 'filename' );
        parent::addAttribute( 'size_original' );
        parent::addAttribute( 'extension' );
        parent::addAttribute( 'size_final' );
        parent::addAttribute( 'createdat' );
        parent::addAttribute( 'convertat' );
        
    }
    
    /**
    * Método para definir os campos dirname, filename, extension e size_original de um objeto Arquivo.
    *
    * @param $path - caminho do arquivo a ser definido
    * @author Bruno Lopes
    * @since  26/05/2023
    * @return 
    */
    public function setPath( $path ){
        
        if( is_file($path) ){
            $pathinfo = pathinfo( $path );
                
            $this->fromArray( $pathinfo );
            $this->size_original = filesize( $path );
        }
        
    }
}
