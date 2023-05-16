<?php
class RedutorArquivoControl extends TPage {    
    
    private $itensDiretorio = [];
    
    public function reduzirArquivo( $param ){
        try{
            if( !empty($param['path']) ){
                $caminhoAbsolutoArquivo = $param['path'];
                
                $this->getItensDiretorio( $caminhoAbsolutoArquivo );
                
                //$this->exibirListaArquivo();
                
                //$destino = 'app/images/imgTeste/teste123.jpg';
                //$redutorArquivo = new RedutorArquivoJPG( 'app/images/123.jpg', $destino, 60 );
                                
                //$destino = 'app/images/imgTeste/teste345.gif';
                //$redutorArquivo = new RedutorArquivoGIF( 'app/images/345.gif', $destino );
                
                //$destino = 'app/images/imgTeste/teste678.png';
                //$redutorArquivo = new RedutorArquivoPNG( 'app/images/678.png', $destino, 10 );
                
                //$destino = 'app/images/imgTeste/pdftemp/TESTE910teste.pdf';
                //$redutorArquivo = new RedutorArquivoPDF( 'app/images/910TESTE.pdf', $destino, 12 );
                
                
                //$redutorArquivo->reduzirArquivo();
                
                //$redutorArquivo->exibirDados();
                
                $this->reduzirArquivos();
                
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
        try{
            foreach( $this->itensDiretorio as $item ){
                $redutorArquivo = $this->gerarRedutorArquivo( $item );
                if( $redutorArquivo instanceof RedutorArquivo ){
                    $redutorArquivo->reduzirArquivo();
                    
                    echo '<br>Reduziu '. $item;
                    
                    
                }else{
                    echo '<br>Arquivo '. $item. ' não reduzido.';
                    
                }
                
                
            }
        }catch( Exception $e ){
            new TMessage( 'error', $e->getMessage() );
        }
        
        
        
    }
    
    private function gerarRedutorArquivo( $caminhoAbsolutoArquivo ){
        
        $pathinfo = pathinfo( $caminhoAbsolutoArquivo );
        $diretorio = $pathinfo['dirname'];
        $nomeArquivo = $pathinfo['filename'];
        $extensao = $pathinfo['extension'];
        $destino = $diretorio.'/imgTeste/'.$nomeArquivo.'_TESTE.'.$extensao;    
        
        $redutorArquivo = NULL;
        switch( $extensao ){
            case 'jpg':
                //$destino = 'app/images/imgTeste/'.$nomeArquivo.'_TESTE.'.$extensao;
                $redutorArquivo = new RedutorArquivoJPG( $caminhoAbsolutoArquivo, $destino, 60 );
                
                break;
                
            case 'png':
                //$destino = 'app/images/imgTeste/'.$nomeArquivo.'_TESTE.'.$extensao;
                $redutorArquivo = new RedutorArquivoPNG( $caminhoAbsolutoArquivo, $destino, 10 );
                
                break;
                
            case 'gif':
                //$destino = 'app/images/imgTeste/'.$nomeArquivo.'_TESTE.'.$extensao;
                $redutorArquivo = new RedutorArquivoGIF( $caminhoAbsolutoArquivo, $destino );
                
                break;
                
            /*case 'pdf':
                $destino = $diretorio.'/imgTeste/pdftemp/'.$nomeArquivo.'_TESTE.'.$extensao;
                $redutorArquivo = new RedutorArquivoPDF( $caminhoAbsolutoArquivo, $destino, 12 );
                break;*/
            
            
        }
        
        return $redutorArquivo;
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
    
    
}
