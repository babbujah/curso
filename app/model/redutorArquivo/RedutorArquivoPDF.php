<?php
/**
* @link https://medium.com/@adilaelvieira/comprimir-pdf-usando-php-6f106386111e
* @link https://stackoverflow.com/questions/23026181/fatal-error-class-imagick-not-found - TUTORIAL SEGUIDO
* @link https://medium.com/@adilaelvieira/comprimir-pdf-usando-php-6f106386111e
* @link 4 https://stackoverflow.com/questions/65715913/fatal-error-uncaught-imagickexception-pdfdelegatefailed-the-system-cannot-fin
**/
class RedutorArquivoPDF extends RedutorArquivo{
    
    public function reduzirArquivo(){
    
        //phpinfo();
        set_time_limit(-1);
        //memory_limit(-1);
        
        $image = new Imagick();
        $qualidadeImagemTemp = 200;
        
        $image->setResolution( $qualidadeImagemTemp, $qualidadeImagemTemp );
        
        $caminhoAbsolutoOrigem = realpath( $this->de );
                
        $image->readImage( $caminhoAbsolutoOrigem ); // VER LINK 4
        //$image->setImageCompressionQuality( empty($this->qualidade) ? 60 : $this->qualidade );
        
        $pathinfo = pathinfo( $this->para );
        $diretorioDestino = realpath( $pathinfo['dirname'] );        
        $caminhoImagemTemp = $diretorioDestino. '\\' . 'ImagemTempPage.jpg';
        
        $image->writeImages( $caminhoImagemTemp , true );
        
        
        $image->destroy();
        
        $directory = $diretorioDestino;
        $images = glob( $directory . "/*.jpg" );
        
        $arrImages = [];
        foreach( $images as $image ){
            
            $arrImages[] = $image;
            
            $redutorArquivoJPG = new RedutorArquivoJPG( $image, NULL, $this->qualidade );
            $redutorArquivoJPG->reduzirArquivo();
            
        }
        
        sort( $arrImages, SORT_NATURAL );
        
        $pdf = new Imagick( $arrImages );
        $caminhoAbsolutoDestino = realpath( $this->para );
        
        $pdf->writeImages( $diretorioDestino.'\\'.$pathinfo['basename'], true );
        $pdf->destroy();
        foreach( $arrImages as $image ){
            unlink( $image );
        }
        
        $this->setFileInfoPara();
        
        /*$image = new Imagick();
        $image->newImage(1, 1, new ImagickPixel('#ffffff'));
        $image->setImageFormat('png');
        $pngData = $image->getImagesBlob();
        echo strpos($pngData, "\x89PNG\r\n\x1a\n") === 0 ? 'Ok' : 'Failed';*/ 
        
    }
}
