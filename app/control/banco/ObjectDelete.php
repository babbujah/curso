<?php
class ObjectDelete extends TPage{
    public function __construct(){
        parent::__construct();
        
        try{
            TTransaction::open('curso');
            
            TTransaction::dump();
            
            /*
            $produto = Produto::find( 28 );
            
            
            if( $produto instanceof Produto ){
                $produto->delete();
            }
            */
            
            
            $produto = new Produto;
            $produto->delete(29);
            
            /*
            $pdo = TTransaction::get();
            //$stmt = $pdo->query('DELETE FROM produto WHERE id = 29');
            $stmt = $pdo->query('SELECT * FROM produto');
            var_dump($stmt->fetchAll());
            */
            
            
            
        }catch(Exception $e){
            new TMessage('error', $e->getMessage());
        }
    }
}
