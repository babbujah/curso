<?php
class RedutorArquivoPNG extends RedutorArquivo{
    
    public function reduzirArquivo(){
        $info = getimagesize( $this->de );
        
        if( $info['mime'] == 'image/png' ){
            $imagem = @imagecreatefrompng( $this->de );
            $qualidade = round( 9 - ($this->qualidade * 9 / 100) );
            imagesavealpha( $imagem, true );
            imagepng( $imagem, $this->para, $qualidade );
            
        }
        
        $this->setFileInfoPara();
    }
}
