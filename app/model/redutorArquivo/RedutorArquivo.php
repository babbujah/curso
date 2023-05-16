<?php
abstract class RedutorArquivo {
    protected $de;
    protected $para;
    protected $qualidade;
    protected $fileInfoDe; // dados do caminho de origem [dirname, filename, extension, size, path]
    protected $fileInfoPara; // dados do caminho de destino [dirname, filename, extension, size, path]
    
    public function __construct( $de, $para = NULL, $qualidade = NULL ){
        $this->de = $de;
        $this->para = empty( $para ) ? $de : $para;        
        $this->qualidade = $qualidade;
        
        $this->setFileInfoDe();
        
    }
    
    protected function getFileInfoDe(){
        //$this->fileInfoDe = $this->getFileInfo( $this->de );
        
        return $this->fileInfoDe;
        
    }
    
    protected function setFileInfoDe(){
        $this->fileInfoDe = $this->setFileInfo( $this->de );
        
    }
    
    protected function getFileInfoPara(){
        //$this->fileInfoPara = $this->getFileInfo( $this->para );
        
        return $this->fileInfoPara;
        
    }
    
    protected function setFileInfoPara(){
        $this->fileInfoPara = $this->setFileInfo( $this->para );
        
    }
    
    private function setFileInfo( $caminho ){
        if( !is_file( $caminho ) ){
            throw new Exception( $caminho. ' Não é um arquivo válido.' );
            
        }
        $pathinfo = pathinfo( $caminho );
        $dirname = $pathinfo['dirname'];
        $filename = $pathinfo['filename'];
        $extension = $pathinfo['extension'];
        $size = filesize( $caminho );
        
        return [ 
            'dirname' => $dirname,
            'filename' => $filename,
            'extension' => $extension,
            'size' => $size,
            'path' => $caminho
         ];
        
    }
    
    public function reduzirArquivo( ){
        //$redutoArquivoService = new RegistroArquivoReduzidoService( $infoPathArquivo );
        //$redutoArquivoService->salvar();
    
    }
    
    public function exibirDados(){
        print_r(
            'origem: '. $this->de. '<br>'.
            'destino: '. $this->para. '<br>'.
            'qualidade: '. $this->qualidade. '<br>'
        );
        print_r( '[ dir | nome | ext | tamanho | caminho ]<br>' );
        
        if( !empty($this->fileInfoDe) ){
            print_r( 'Dados de origem:<br>' );        
            foreach( $this->fileInfoDe as $infoDe ){
                print_r( $infoDe. ', ' );
            }
        }
        echo '<br>';
        
        if( !empty($this->fileInfoPara) ){
            print_r( 'Dados de destino:<br>' );
            foreach( $this->fileInfoPara as $infoPara ){
                print_r( $infoPara. ', ' );
            }
        }
        
    }
}
