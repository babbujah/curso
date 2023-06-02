<?php
/**
* Classe concreta que define um redutor de arquivos do tipo .webp.
*
* @version    1.0
* @package    model.redutorarquivo
* @author     Bruno Lopes
* @since      23/05/2023  
**/
class RedutorArquivoWebp extends RedutorArquivo{
    
    /**
     * Função definida para a compressão de arquivos .webp.
     *
     * @author Bruno Lopes
     * @since  23/05/2023
     */
    public function reduzirArquivo(){
        $info = getimagesize( $this->de );
        $nomeArquivo = $this->getFileInfoDe()['filename'];
        $extensao = $this->getFileInfoDe()['extension'];
        
        if( $info['mime'] == 'image/webp' ){
            $imagem = @imagecreatefromwebp( $this->de );
            
            $destinoTemp = self::DIRETORIO_TEMP.$nomeArquivo.'_TMP.'.$extensao;
            imagewebp( $imagem, $destinoTemp, empty( $this->qualidade ) ? -1 : $this->qualidade ); // caso a qualidade não seja informada a taxa de compressão é definida para 75%
            
            $this->copiarArquivoReduzido( $destinoTemp );
            
            $this->setFileInfoPara();
        
            //$this->setStatusCompressao();
        }
    }
}
