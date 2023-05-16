<?php
class RedutorArquivoJPG extends RedutorArquivo{    
    
    public function reduzirArquivo(){
        $info = getimagesize( $this->de );
        
        if( $info['mime'] == 'image/jpeg' ){
            $imagem = @imagecreatefromjpeg( $this->de );
            
            imagejpeg( $imagem, $this->para, empty( $this->qualidade ) ? -1 : $this->qualidade );
        }
        
        $this->setFileInfoPara();
        
    }   
}
