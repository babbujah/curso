<?php

/**
* Classe concreta que define um redutor de arquivos do tipo .pdf utilizando bibliotecas python.
*
* @version    1.0
* @package    model.redutorarquivo
* @author     Bruno Lopes
* @link       https://morioh.com/p/04be32a18c48
* @since      24/05/2023  
**/
class RedutorArquivoPDFPy extends RedutorArquivo{

    const PYTHON = 'C:\Users\brunosilva\AppData\Local\Programs\Python\Python38-32\python';
    const COMPRESSPDFPYTHON = 'C:\Users\brunosilva\Desktop\compressorpdf\compressorpdf.py';
    
    /**
     * Função definida para a compressão de arquivos .pdf. Para a compressão foi utilizado bibliotecas python através da chamada exec() do programa compressorpdf.py 
     *
     * @author Bruno Lopes
     * @since  24/05/2023
     */
    public function reduzirArquivo(){
        try{
            //$info = pathinfo( $this->de );
            $nomeArquivo = $this->getFileInfoDe()['filename'];
            $extensao = $this->getFileInfoDe()['extension'];
                    
            $destinoTemp = self::DIRETORIO_TEMP.$nomeArquivo.'_TMP.'.$extensao;
            
            //$python = 'C:\Users\brunosilva\AppData\Local\Programs\Python\Python38-32\python';
            //$compressPDFPython = 'C:\Users\brunosilva\Desktop\compressorpdf\compressorpdf.py';
            
            $comando = exec(self::PYTHON.' '.self::COMPRESSPDFPYTHON.' '.$this->de.' '.$destinoTemp );
        
            $this->copiarArquivoReduzido( $destinoTemp ); // Avalia a necessidade de substituição do arquivo baseado na taxa de compressão
                
            $this->setFileInfoPara();
            
            //$this->setStatusCompressao();
            
        }catch( Exception $e ){
            new TMessage( 'error', $e->getMessage() );
            
        }
    }
}
