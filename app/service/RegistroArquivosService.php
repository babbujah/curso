<?php
class RegistroArquivosService{
    
    public function findAll(){
        $registroArquivos = null;
        try{
            TTransaction::open( 'redutor_arquivo' );
            
            $repository = new TRepository( 'RegistroArquivos' );
            $arquivos = $repository->load();
            
            TTransaction::close();
            
            return $registroArquivos;
            
        }catch( Exception $e ){
            new TMessage( 'error', $e->getMessage() );
            
        }
    }
    
    public function save( RegistroArquivos $registroArquivo ){
        try{
            TTransaction::open( 'redutor_arquivo' );
            
            if( $registroArquivo instanceof RegistroArquivos ){
                $registroArquivo->store();
                
            }else{
                throw new Exception( 'Dados do arquivo inválidos.' );
                
            }
                    
            TTransaction::close();
        }catch( Exception $e ){
            TTransaction::rollback();
            new TMessage( 'erro', $e->getMessage() );
            
        }
    }
}
