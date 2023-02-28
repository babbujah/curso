<?php
class CollectionAggregation extends TPage{
    public function __construct(){
        parent::__construct();
        
        try{
            TTransaction::open('cursoOLD');
            TTransaction::dump();
            
            $total = Venda::sumBy('total');
            
            var_dump($total);            
            
            TTransaction::close();
        }catch(Exception $e){
            new TMessage('error', $e->getMessage());
        }
    }
}
