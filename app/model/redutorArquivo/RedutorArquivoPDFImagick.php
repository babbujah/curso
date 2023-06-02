<?php
/**
* (OBSOLETA) Classe concreta que define um redutor de arquivos do tipo .pdf utilizando a biblioteca imagick.
*
* @version    1.0
* @package    model.redutorarquivo
* @author     Bruno Lopes
* @link       https://medium.com/@adilaelvieira/comprimir-pdf-usando-php-6f106386111e
* @link       https://stackoverflow.com/questions/23026181/fatal-error-class-imagick-not-found - TUTORIAL SEGUIDO
* @link       https://medium.com/@adilaelvieira/comprimir-pdf-usando-php-6f106386111e
* @link       https://stackoverflow.com/questions/65715913/fatal-error-uncaught-imagickexception-pdfdelegatefailed-the-system-cannot-fin
* @since      25/05/2023  
**/
class RedutorArquivoPDFImagick extends RedutorArquivo{
    
    /**
     * Função definida para a compressão de arquivos .pdf. O imagick transforma cada página em uma imagem e realiza a compressão para cada uma delas.
     * Após o procedimento, as páginas são reunidas em um único pdf novamente. 
     *
     * @author Bruno Lopes
     * @since  25/05/2023
     */
    public function reduzirArquivo(){
    
        set_time_limit(0);
        
        $image = new Imagick();
        $qualidadeImagemTemp = 200;
        
        $image->setResolution( $qualidadeImagemTemp, $qualidadeImagemTemp );
        
        $caminhoAbsolutoOrigem = realpath( $this->de );
                
        $image->readImage( $caminhoAbsolutoOrigem ); // VER LINK 4
        //$image->setImageCompressionQuality( empty($this->qualidade) ? 60 : $this->qualidade );
        
        $diretorioDestinoTemp = realpath( self::DIRETORIO_TEMP );        
        $caminhoImagemTemp = $diretorioDestinoTemp. '/' . 'ImagemTempPage.jpg';
        
        $image->writeImages( $caminhoImagemTemp , true );
        
        $image->destroy();
        
        $images = glob( $diretorioDestinoTemp . "/*.jpg" );
        
        $arrImages = [];
        foreach( $images as $image ){
            
            // Houve a necessidade de realizar o procedimento de redução dos arquivos de imagem gerados, antes da união das páginas.
            // Isso gerou uma complexidade não esperada e um desempenho não satisfatório.
            $arrImages[] = $image;
            
            $redutorArquivoJPG = new RedutorArquivoJPG( $image, NULL, $this->qualidade );
            $redutorArquivoJPG->reduzirArquivo();
            
        }
        
        sort( $arrImages, SORT_NATURAL ); // Ordenada os arquivos de imagens por numeração de página
        
        $nomeArquivo = $this->getFileInfoDe()['filename'];
        $extensao = $this->getFileInfoDe()['extension'];
        
        $pdf = new Imagick( $arrImages );
        $caminhoAbsolutoDestino = realpath( self::DIRETORIO_TEMP.$nomeArquivo.'_TMP.'.$extensao );
        
        $pdf->writeImages( $caminhoAbsolutoDestino, true );
        $pdf->destroy();
        foreach( $arrImages as $image ){
            unlink( $image );
        }
        
        $this->copiarArquivoReduzido( $caminhoAbsolutoDestino ); // Avalia a necessidade de substituição do arquivo baseado na taxa de compressão
        
        $this->setFileInfoPara();
        
        //$this->setStatusCompressao();
        
    }
}
