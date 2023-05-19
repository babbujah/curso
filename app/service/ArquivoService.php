<?php
class ArquivoService{
            
    public function findAll(){
        $arquivos = null;
        try{
            TTransaction::open( 'redutor_arquivo' );
            
            $repository = new TRepository( 'Arquivo' );
            $arquivos = $repository->load();
            
            TTransaction::close();
            
            return $arquivos;
            
        }catch( Exception $e ){
            new TMessage( 'error', $e->getMessage() );
            
        }
    }
    
    public function findArquivoByPath( $path ){
        $arquivo = NULL;
        
        try{
            $dirname = dirname( $path );
            $filename = basename( $path );
                        
            TTransaction::open( 'redutor_arquivo' );
            
            $filters = [ 'dirname' => $dirname , 'filename' => $filename ];
            
            $arquivo = Arquivo::firstOrNew($filters);
            
            return $arquivo;
            
            $criteria = new TCriteria;
            $criteria->add( new TFilter( 'dirname', '=', $dirname ) );
            $criteria->add( new TFilter( 'filename', '=', $filename ) );
            
            $repository = new TRepository( 'Arquivo' );
            $repository->load( $criteria );
            
            if( $repository->count() == 1 ){
                $arquivo = $repository->first();
                
            }
            
            TTransaction::close();
            
            return $arquivo;
            
        }catch( Exception $e ){
            new TMessage( 'error', $e->getMessage() );
            
        }
    }
    
    public function save( Arquivo $arquivo ){
        try{
            TTransaction::open( 'redutor_arquivo' );
            
            if( $arquivo instanceof Arquivo ){
                $arquivo->store();
                
            }else{
                throw new Exception( 'Dados do arquivo inválidos.' );
                
            }
                    
            TTransaction::close();
        }catch( Exception $e ){
            TTransaction::rollback();
            new TMessage( 'erro', $e->getMessage() );
            
        }
    }
    
    public function update( Arquivo $arquivo ){
        try{
            TTransaction::open( 'redutor_arquivo' );
            
            if( $arquivo instanceof Arquivo && $arquivo->exists() ){
                $arquivo->store();
                
            }else{
                throw new Exception( 'Arquivo não encontrado na base de dados.' );
                
            }
                    
            TTransaction::close();
        }catch( Exception $e ){
            TTransaction::rollback();
            new TMessage( 'erro', $e->getMessage() );
            
        }
    }
}
