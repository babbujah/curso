<?php
/**
* Classe de serviço para execução para manipulação de arquivos
*
* @version    1.0
* @package    service
* @database   redutor_arquivo
* @author     Bruno Lopes
* @since      22/05/2023  
**/
class ArquivoService{
    
    /**
    * Função para buscar todas as ocorrências de arquivos dentro da base de dados
    *
    * @return $arquivos - lista contendo todos os registros de arquivos da base de dados
    *
    * @author Bruno Lopes
    * @since  22/05/2023    
    */
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
    
    /**
    * Função para buscar todos as ocorrências de arquivos aos quais não foram convertidos.
    * São recuperados somente os registros contendo os formatos suportados pela aplicação,
    * limitados a uma quantidade predefinida.
    *
    * @param  $formatos - array de formatos suportados pela aplicação.
    * @param  $limite - quantidade de registros a serem retornados.
    * @return $arquivos - lista contendo todos os registros de arquivos da base de dados, que seguirem os parâmetros.
    *
    * @author Bruno Lopes
    * @since  22/05/2023    
    */
    public function getArquivosPendentes( $formatos, $limite ){
        try{
        
            TTransaction::open( 'redutor_arquivo' );
            
            $arquivos = Arquivo::where( 'extension', 'IN', $formatos )
                               ->where( 'convertat', 'IS', NULL )
                               ->take( $limite )
                               ->load();
                               
            TTransaction::close();
                               
            return $arquivos;
        
        }catch( Exception $e ){
            new TMessage( 'error', $e->getMessage() );
            
        }
    }
    
    /**
    * Função para buscar um registro de arquivo pelo caminho deste.
    *
    * @param $path - caminho do arquivo a ser buscado. Analisa diretório, nome do arquivo e extensão. 
    * @return $arquivo - registro do arquivo encontrado.
    *
    * @author Bruno Lopes
    * @since  22/05/2023
    * @return $arquivo - registro do arquivo encontrado.
    */
    public function findArquivoByPath( $path ){
        $arquivo = null;
        
        try{
            TTransaction::open( 'redutor_arquivo' );
            
            $pathinfo = pathinfo( $path );
            
            $dirname = dirname( $path );
            $filename = basename( $path );
            $extension = $pathinfo['extension'];
            
            $criteria = new TCriteria;
            $criteria->add( new TFilter( 'dirname', '=', $dirname ) );
            $criteria->add( new TFilter( 'filename', '=', $filename ) );
            $criteria->add( new TFilter( 'extension', '=', $extension ) );
            
            $repositorio = new TRepository( 'Arquivo' );
            $repositorio->load( $criteria );
            
            if( $repositorio->count() == 1 ){
                $arquivo = $repositorio->first();
                
            }
            
            TTransaction::close();
            
            return $arquivo;
            
        }catch( Exception $e ){
            new TMessage( 'error', $e->getMessage() );
        }
    }
    
    /**
    * Função que busca ou cria arquivos na base de dados através de uma lista de caminhos de arquivos. As informações
    * utilizadas na busca são o diretório, nome do arquivo e extensão.
    * Caso os arquivos não sejam encontrados, o sistema gera um novo registro na base de dados para cada arquivo novo.
    *
    * @param $array_path - lista de caminhos dos arquivos a serem buscados na base de dados.
    * @return $arquivos - matriz contendo uma lista com todos os registros de arquivos encontrados e outra lista
    * contendo os arquivos novos criados. 
    *
    * @author Bruno Lopes
    * @since  22/05/2023
    */
    public function findOrCreateArquivoByArrayPath( $array_path ){
        
        try{
            TTransaction::open( 'redutor_arquivo' );
            $arquivos = [ 'total_arquivos' => [], 'arquivos_novos' => [] ];
            
            foreach( $array_path as $path ){
            
                $pathinfo = pathinfo( $path );
                $dirname = dirname( $path );
                $filename = basename( $path );
                $size_original = filesize( $path );
                $extension = $pathinfo['extension'];
                
                $filters = [ 'dirname' => $dirname , 'filename' => $filename, 'extension' => $extension ];
                
                $arquivo = Arquivo::firstOrCreate($filters);
                
                if( empty($arquivo->size_original) ){
                    $arquivo->size_original = $size_original;
                    $arquivo->size_final = $size_original;
                    
                    $arquivo->store();
                    
                    $arquivos['arquivos_novos'][] = $arquivo;
                }
                
                $arquivos['total_arquivos'][] = $arquivo;
            }
            
            
            TTransaction::close();
            
            return $arquivos;
            
        }catch( Exception $e ){
            new TMessage( 'error', $e->getMessage() );
            
        }
    }
    
    /**
    * Função que busca ou cria um arquivo na base de dados através do caminho de um arquivos. As informações
    * utilizadas na busca são o diretório, nome do arquivo e extensão.
    * Caso o arquivo não seja encontrado, o sistema gera um novo registro na base de dados com o novo arquivo. 
    *
    * @param $path - caminho do arquivo a ser buscado na base de dados.
    * @return $arquivo - informações do resgistro de arquivo encontrado ou gerado.
    *
    * @author Bruno Lopes
    * @since  22/05/2023
    */
    public function findOrCreateArquivoByPath( $path ){
        
        try{            
            $dirname = dirname( $path );
            $filename = basename( $path );
            $size_original = filesize( $path );
            $pathinfo = pathinfo( $path );
            $extension = $pathinfo['extension'];
                        
            TTransaction::open( 'redutor_arquivo' );
            
            $filters = [ 'dirname' => $dirname , 'filename' => $filename, 'extension' => $extension ];
            
            $arquivo = Arquivo::firstOrCreate($filters);
            
            if( empty($arquivo->size_original) ){
                $arquivo->size_original = $size_original;
                $arquivo->size_final = $size_original;
                
                $arquivo->store();
            }
            
            TTransaction::close();
            
            return $arquivo;
            
        }catch( Exception $e ){
            new TMessage( 'error', $e->getMessage() );
            
        }
    }
    
    /**
    * Método para salvar um registro de arquivo na base de dados. 
    *
    * @param Arquivo $arquivo - objeto arquivo contendo as informações
    *
    * @author Bruno Lopes
    * @since  22/05/2023
    */
    public function salvar( Arquivo $arquivo ){
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
            new TMessage( 'error', $e->getMessage() );
            
        }
    }
    
    /**
    * Método para atualiza informações de um registro de arquivo na base de dados. 
    *
    * @param Arquivo $arquivo - objeto arquivo contendo as informações
    *
    * @author Bruno Lopes
    * @since  22/05/2023
    */
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
            new TMessage( 'error', $e->getMessage() );
            
        }
    }
}
