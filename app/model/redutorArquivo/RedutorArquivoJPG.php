<?php
/**
* Classe concreta que define um redutor de arquivos do tipo .jpg ou jpeg.
*
* @version    1.0
* @package    model.redutorarquivo
* @author     Bruno Lopes
* @since      23/05/2023  
**/
class RedutorArquivoJPG extends RedutorArquivo{    
    
    /**
     * Função definida para a compressão de arquivos .jpg ou jpeg.
     *
     * @author Bruno Lopes
     * @since  23/05/2023
     */
    public function reduzirArquivo(){
    
        $info = getimagesize( $this->de );
        $nomeArquivo = $this->getFileInfoDe()['filename'];
        $extensao = $this->getFileInfoDe()['extension'];
        
        if( $info['mime'] == 'image/jpeg' ){
            $imagem = @imagecreatefromjpeg( $this->de );
            
            $destinoTemp = self::DIRETORIO_TEMP.$nomeArquivo.'_TMP.'.$extensao;
            imagejpeg( $imagem, $destinoTemp, empty( $this->qualidade ) ? -1 : $this->qualidade ); // caso a qualidade não seja informada a taxa de compressão é definida para 75%
            
            $this->copiarArquivoReduzido( $destinoTemp ); // Avalia a necessidade de substituição do arquivo baseado na taxa de compressão
            
            $this->setFileInfoPara();
        
            //$this->getStatusCompressao();
           
        }
    }
    
}
