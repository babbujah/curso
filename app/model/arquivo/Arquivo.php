<?php
class Arquivo extends TRecord{
    const TABLENAME = 'arquivo_info';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'serial';
    
    public function __construct( $id = null, $callObjectLoad = true ){
        parent::__construct( $id, $callObjectLoad );
        
        parent::addAttribute( 'dirname' );
        parent::addAttribute( 'filename' );
        parent::addAttribute( 'size_original' );
        parent::addAttribute( 'extension' );
        parent::addAttribute( 'size_final' );
    }
}
