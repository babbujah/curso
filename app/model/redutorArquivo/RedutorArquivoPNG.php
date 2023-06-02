<?php
/**
* Classe concreta que define um redutor de arquivos do tipo .png.
*
* @version    1.0
* @package    model.redutorarquivo
* @author     Bruno Lopes
* @since      23/05/2023  
**/
class RedutorArquivoPNG extends RedutorArquivo{
    
    /**
     * Função definida para a compressão de arquivos .png.
     *
     * @author Bruno Lopes
     * @since  23/05/2023
     */
    public function reduzirArquivo(){
        $info = getimagesize( $this->de );
        $nomeArquivo = $this->getFileInfoDe()['filename'];
        $extensao = $this->getFileInfoDe()['extension'];
        
        if( $info['mime'] == 'image/png' ){
            $imagem = @imagecreatefrompng( $this->de );
            $qualidade = round( empty( $this->qualidade ) ? 7 : 9 - ($this->qualidade * 9 / 100) ); // Converte a qualidade recebida no internalo de 0 (sem compressão) a 9 e, caso seja nula, define como 7
            imagesavealpha( $imagem, true ); // Mantém o fundo original da imagem
            $destinoTemp = self::DIRETORIO_TEMP.$nomeArquivo.'_TMP.'.$extensao;
            imagepng( $imagem, $destinoTemp, $qualidade );            
            
            $this->copiarArquivoReduzido( $destinoTemp );
            
            $this->setFileInfoPara();
        
            //$this->setStatusCompressao();
            
        }
    }
}
