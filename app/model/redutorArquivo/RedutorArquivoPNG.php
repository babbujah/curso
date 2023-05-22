<?php
class RedutorArquivoPNG extends RedutorArquivo{
    
    public function reduzirArquivo(){
        $info = getimagesize( $this->de );
        $tamanhoArquivoOriginal = filesize( $this->de );
        
        if( $info['mime'] == 'image/png' ){
            $imagem = @imagecreatefrompng( $this->de );
            $qualidade = round($this->qualidade * 9 / 100 );
            imagesavealpha( $imagem, true );
            //imagepng( $imagem, $this->para, $qualidade );
            $destinoTemp = 'app/images/pdftemp/'.$nomeArquivo.'_TESTE.'.$extensao;
            imagepng( $imagem, $destinoTemp, $qualidade );            
            $tamanhoImgTemp = filesize( $destinoTemp );
            
            
        }
        
        $this->setFileInfoPara();
        
        $this->setStatusConvesao();
    }
}
