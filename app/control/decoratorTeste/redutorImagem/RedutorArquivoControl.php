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
        $arquivoService = new ArquivoService;
        $redutorArquivo = null;
        
        $qntTotalArquivo = 0;
        $tamanhoOriginalTotal = 0;
        $tamanhoFinalTotal = 0;
        
        try{
            foreach( $this->itensDiretorio as $item ){
                $arquivo = $arquivoService->findArquivoByPath( $item );
                $pathinfo = pathinfo( $item );
                $arquivo->size_original = filesize( $item );
                $arquivo->extension = $pathinfo['extension'];
                
                if( $arquivo->size_final == null ){
                    
                    $redutorArquivo = $this->gerarRedutorArquivo( $item );
                    
                    if( !empty($redutorArquivo) ){
                        $redutorArquivo->reduzirArquivo();
                        $arquivo->size_final = $redutorArquivo->getFileInfoPara()['size'];
                    
                    }
                    
                    //$arquivoService->save( $arquivo );
                        
                    $qntTotalArquivo ++;
                    $tamanhoOriginalTotal += $arquivo->size_original;
                    $tamanhoFinalTotal += $arquivo->size_final;
                    
                }
            }
            
            TTransaction::open('redutor_arquivo');
            
            $registroArquivo = new RegistroArquivos;
            
            $registroArquivo->qnt_files = $qntTotalArquivo;
            $registroArquivo->size_total_files_original = $tamanhoOriginalTotal;
            $registroArquivo->size_total_files_reduced = $tamanhoFinalTotal;
            $registroArquivo->store();
            
            TTransaction::close();
            
        }catch( Exception $e ){
            new TMessage( 'error', $e->getMessage() );
            
        }
        
        
        
    }
    
    private function gerarRedutorArquivo( $caminhoAbsolutoArquivo ){
        
        $pathinfo = pathinfo( $caminhoAbsolutoArquivo );
        $diretorio = $pathinfo['dirname'];
        $nomeArquivo = $pathinfo['filename'];
        $extensao = $pathinfo['extension'];
        $tamanhoArquivo = filesize( $caminhoAbsolutoArquivo );
        //$destino = $diretorio.'/imgTeste/'.$nomeArquivo.'_TESTE.'.$extensao;
        $destino = 'app/images/imgTeste/'.$nomeArquivo.'_TESTE.'.$extensao;
                
        $redutorArquivo = NULL;
        switch( $extensao ){
            case 'jpg':
                //$destino = 'app/images/imgTeste/'.$nomeArquivo.'_TESTE.'.$extensao;
                $redutorArquivo = new RedutorArquivoJPG( $caminhoAbsolutoArquivo, $destino, 60 );
                
                break;
                
            case 'png':
                //$destino = 'app/images/imgTeste/'.$nomeArquivo.'_TESTE.'.$extensao;
                $redutorArquivo = new RedutorArquivoPNG( $caminhoAbsolutoArquivo, $destino, 60 );
                
                break;
                
            case 'gif':
                //$destino = 'app/images/imgTeste/'.$nomeArquivo.'_TESTE.'.$extensao;
                $redutorArquivo = new RedutorArquivoGIF( $caminhoAbsolutoArquivo, $destino );
                
                break;
                
            /*case 'pdf':
                if( $tamanhoArquivo >= 100000 ){
                    $destino = $diretorio.'/pdftemp/'.$nomeArquivo.'_TESTE.'.$extensao;
                    $redutorArquivo = new RedutorArquivoPDF( $caminhoAbsolutoArquivo, $destino, 12 );
                    
                }
                
                break;*/
            
            
        }
        
        
        return $redutorArquivo;
    }
    
    private function getItensDiretorio( $caminho ){
         if( is_dir( $caminho ) ){
            $itens = scandir( $caminho );
            foreach( $itens as $item ){
                if( $item == '.' || $item == '..' || $item == 'pdftemp' || $item == 'imgTeste' ){
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
