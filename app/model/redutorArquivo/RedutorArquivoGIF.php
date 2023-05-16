<?php
class RedutorArquivoGIF extends RedutorArquivo{

    public function reduzirArquivo(){
        $info = getimagesize( $this->de );
        
        if( $info['mime'] == 'image/gif' ){
            $imagem = @imagecreatefromgif( $this->de );
            imagegif( $imagem, $this->para );
        }
        
        $this->setFileInfoPara();
    } 
}
