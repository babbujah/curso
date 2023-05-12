<?php
class RedutorArquivoJPG extends RedutorArquivo{    
    
    public function reduzirArquivo(){
        $info = getimagesize( $this->de );
        
        
        /*if( $info['mime'] == 'image/jpeg' ){
            $imagem = @imagecreatefromjpeg( $arquivo );
            
            imagejpeg( $this->de, $this->para, $this->qualidade );
        }*/
        
        $this->getFileInfoPara();
        
        $this->exibirDados();
        
        
    }
    
    public function exibirDados(){
        print_r(
            'origem: '. $this->de. '<br>'.
            'destino: '. $this->para. '<br>'.
            'qualidade: '. $this->qualidade. '<br>'
        );
        
        foreach( $this->fileInfoDe as $infoDe ){
            print_r( $infoDe. ', ' );
        }
        echo '<br>';
        
        foreach( $this->fileInfoPara as $infoPara ){
            print_r( $infoPara. ', ' );
        }
    }
        
}
