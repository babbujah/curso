<?php
/**
* Classe concreta que define um redutor de arquivos do tipo .gif.
*
* @version    1.0
* @package    model.redutorarquivo
* @author     Bruno Lopes
* @since      24/05/2023  
**/
class RedutorArquivoGIF extends RedutorArquivo{
    
    /**
     * Função definida para a compressão de arquivos .gif.
     *
     * @author Bruno Lopes
     * @since  24/05/2023
     */
    public function reduzirArquivo(){
        $info = getimagesize( $this->de );
        $nomeArquivo = $this->getFileInfoDe()['filename'];
        $extensao = $this->getFileInfoDe()['extension'];
        
        if( $info['mime'] == 'image/gif' ){
            $imagem = @imagecreatefromgif( $this->de );
            
            $destinoTemp = self::DIRETORIO_TEMP.$nomeArquivo.'_TMP.'.$extensao;
            imagegif( $imagem, $destinoTemp );    
            
            $this->copiarArquivoReduzido( $destinoTemp ); // Avalia a necessidade de substituição do arquivo baseado na taxa de compressão
            
            $this->setFileInfoPara();
        
            //$this->setStatusCompressao();
        }
        
        
    } 
}
