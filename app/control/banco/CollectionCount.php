<?php
class CollectionCount extends TPage{
    public function __construct(){
        parent::__construct();
        
        try{
            TTransaction::open('cursoOLD');
            
            $criteria = new TCriteria;
            $criteria->add( new TFilter( 'situacao', '=', 'Y' ) );
            $criteria->add( new TFilter( 'genero', '=', 'F' ) );
            
            $repository = new TRepository('Cliente');
            $count = $repository->count( $criteria );
            
            new TMessage('info', "Registro: $count");
            
            TTransaction::close();
        }catch(Exception $e){
            new TMessage('error', $e->getMessage());
        }
    }
}
