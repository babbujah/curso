<?php
class RedutorArquivoControl extends TPage {    
    
    private $itensDiretorio = [];
    
    public function reduzirArquivo( $param ){
        try{
            if( !empty($param['path']) ){
                $caminhoAbsolutoArquivo = $param['path'];
                
                $this->getItensDiretorio( $caminhoAbsolutoArquivo );
                
                //$this->exibirListaArquivo();
                
                $destino = 'app/images/imgTeste/teste.jpg';
                $redutorArquivo = new RedutorArquivoJPG( 'app/images/123.jpg', $destino, 60 );
                $redutorArquivo->reduzirArquivo();
                
                //$this->reduzirArquivos();
                
            }else{
                throw new Exception( 'Caminho das pastas inválido.' );
                
            }
         }catch(Exception $e){
             new TMessage( 'error', $e->getMessage() );
             
         }
        
    }
    
    public function exibirListaArquivo(){
        foreach( $this->itensDiretorio as $item ){
            print_r( '<br>'.$item );
        }
    }
    
    private function reduzirArquivos(){
        
        
        foreach( $this->itensDiretorio as $item ){
            $redutorArquivo = $this->gerarRedutorArquivo( $item );
            if( $redutorArquivo instanceof RedutorArquivo ){
                continue;
                
            }
            echo '<br>Reduziu '. $item;
            //$redutorArquivo->reduzirArquivo();
        }
        
    }
    
    private function getItensDiretorio( $caminho ){
         if( is_dir( $caminho ) ){
            $itens = scandir( $caminho );
            foreach( $itens as $item ){
                if( $item == '.' || $item == '..' ){
                    continue;
                    
                }
                
                $pathAtual = $caminho.'/'.$item;
                if( is_dir( $pathAtual ) ){
                    $this->getItensDiretorio( $pathAtual );
                    
                }else{
                   $this->itensDiretorio[] = $pathAtual;
                    
                }
            }
        }else{
            echo 'Não é um diretório válido.';
    
        }
    }
    
    private function gerarRedutorArquivo( $caminhoAbsolutoArquivo ){
        $pathinfo = pathinfo( $caminhoAbsolutoArquivo );
        $extensao = $pathinfo['extension'];        
        $redutorArquivo = NULL;
        switch( $extensao ){
            case 'jpg':
                $pathinfo = pathinfo( $caminhoAbsolutoArquivo );
                $nomeArquivo = $pathinfo['filename'];
                //$redutorArquivo = new redutoArquivoJPG($caminhoAbsolutoArquivo);
                break;
                
            case 'png':
                //$redutorArquivo = new redutoArquivoPNG;
                break;
                
            case 'gif':
                break;
                
            case 'pdf':
                break;
            
        }
        
        return $redutorArquivo;
    }
}
