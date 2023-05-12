<?php
abstract class RedutorArquivo {
    protected $de;
    protected $para;
    protected $qualidade;
    protected $fileInfoDe;
    protected $fileInfoPara;
    
    public function __construct( $de, $para = NULL, $qualidade = NULL ){
        $this->de = $de;
        $this->para = empty( $para ) ? $de : $para;        
        $this->qualidade = $qualidade;
        
        $this->getFileInfoDe();
        
    }
    
    protected function getFileInfoDe(){
        $this->fileInfoDe = $this->getFileInfo( $this->de );
        
    }
    
    protected function getFileInfoPara(){
        $this->fileInfoPara = $this->getFileInfo( $this->para );
        
    }
    
    protected function getFileInfo( $caminho ){
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
    
    public function reduzirArquivo(){}
}
