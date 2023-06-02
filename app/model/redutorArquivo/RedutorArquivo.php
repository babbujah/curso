<?php
/**
* Classe abstrata que define um redutor de arquivos genérico.
*
* @version    1.0
* @package    model.redutorarquivo
* @author     Bruno Lopes
* @since      18/05/2023  
**/
abstract class RedutorArquivo {
    protected $de;
    protected $para;
    protected $qualidade;
    protected $fileInfoDe; // dados do caminho de origem [dirname, filename, extension, size, path]
    protected $fileInfoPara; // dados do caminho de destino [dirname, filename, extension, size, path]
    //private $statusCompressao = FALSE;
    const DIRETORIO_TEMP = 'tmp/';
    
    /**
     * Class Constructor
     *
     * @param $de - Caminho de origem do arquivo.
     * @param $para - Caminho de destino do arquivo, definida originalmente como igual à origem
     * @param $qualidade - Qualidade de compressão a ser atingida, definida originalmente como nula.
     * @author Bruno Lopes
     * @since  19/05/2023
     */
    public function __construct( $de, $para = NULL, $qualidade = NULL ){
        $this->de = $de;
        $this->para = empty( $para ) ? $de : $para;        
        $this->qualidade = $qualidade;
        
        $this->setFileInfoDe();
        
    }
    
    /**
     * Função para recuperar as informações de origem do arquivo
     *
     * @return Retorna $fileInfoDe informações do arquivo 
     * @author Bruno Lopes
     * @since  19/05/2023
     */
    public function getFileInfoDe(){
        
        return $this->fileInfoDe;
        
    }
    
    /**
     * Método para definir as informações da origem do arquivo. Atualiza as informações de fileInfoDe
     *
     * @author Bruno Lopes
     * @since  19/05/2023
     */
    protected function setFileInfoDe(){
        $this->fileInfoDe = $this->setFileInfo( $this->de );
        
    }
    
    /**
     * Função para recuperar as informações de destino do arquivo
     *
     * @return Retorna $fileInfoPara informações do arquivo 
     * @author Bruno Lopes
     * @since  19/05/2023
     */
    public function getFileInfoPara(){
        
        return $this->fileInfoPara;
        
    }
    
    /**
     * Método para definir as informações de destino do arquivo. Atualiza as informações de fileInfoPara
     *
     * @author Bruno Lopes
     * @since  19/05/2023
     */
    protected function setFileInfoPara(){
        $this->fileInfoPara = $this->setFileInfo( $this->para );
        
    }
    
    /**
     * Método para definir as informações de destino do arquivo.
     *
     * @param $caminho - Endereço de localização do arquivo
     * @return Retorna as informações do arquivo
     * @author Bruno Lopes
     * @since  19/05/2023
     */
    private function setFileInfo( $caminho ){
        if( !is_file( $caminho ) ){
            
            throw new Exception( $caminho. ' Não é um arquivo válido.' );
            
        }
        
        $pathinfo = pathinfo( $caminho );
        $dirname = $pathinfo['dirname'];
        $filename = $pathinfo['filename'];
        $extension = $pathinfo['extension'];
        $size = filesize( $caminho );
        
        return [ 
            'dirname' => $dirname,
            'filename' => $filename,
            'extension' => $extension,
            'size' => $size,
            'path' => $caminho
         ];
        
    }
    
    /**
     * Método para definir o status de compressão do arquivo.
     *
     * @author Bruno Lopes
     * @since  22/05/2023
     */
    protected function setStatusCompressao(){
        $this->statusCompressao = TRUE;
        
    }
    
    /**
     * Função para recuperar o status de compressão do arquivo
     *
     * @return Retorna o status de compressão do arquivo.
     * @author Bruno Lopes
     * @since  22/05/2023
     */
    protected function getStatusCompressao(){
        return $this->statusCompressao;
        
    }
    
    /**
     * Função de compressão do arquivo. Esta função deve ser definida e sobrescrita nas instâncias filhas desta classe
     *
     * @author Bruno Lopes
     * @since  18/05/2023
     */
    public function reduzirArquivo(){}
    
    
    /**
     * Método que avalia o tamanho dos arquivos reduzidos e os substituem baseados nesta compressão.
     *
     * @param $arquivoTemp - arquivo gerado através do procedimento de compressão para ser analisada necessidade de substituição
     * @author Bruno Lopes
     * @since  23/05/2023
     */
    public function copiarArquivoReduzido( $arquivoTemp ){
        //$nomeArquivo = $this->fileInfoDe['filename'];
        //$extensao = $this->fileInfoDe['extension'];
        //$arquivoTemp = self::DIRETORIO_TEMP.$nomeArquivo.'_TMP.'.$extensao;
        
        $tamanhoArqTemp = filesize( $arquivoTemp );
        
        // Avalia o tamanho do arquivo reduzido
        if(   $this->fileInfoDe['size'] > $tamanhoArqTemp ){
            copy( $arquivoTemp, $this->para ); // Caso seja menor, substitui o arquivo original pela cópia reduzia
            
        }else{
            $this->para = $this->de; // Caso não, mantem o mesmo arquivo e define o caminho de destino igual ao caminho de origem
         
        }
        
        unlink( $arquivoTemp );
    }
    
    /**
     * Método para exibição as informações do arquivo
     *
     * @author Bruno Lopes
     * @since  18/05/2023
     */
    public function exibirDados(){
        print_r(
            'origem: '. $this->de. '<br>'.
            'destino: '. $this->para. '<br>'.
            'qualidade: '. $this->qualidade. '<br>'
        );
        print_r( '[ dir | nome | ext | tamanho | caminho ]<br>' );
        
        if( !empty($this->fileInfoDe) ){
            print_r( 'Dados de origem:<br>' );        
            foreach( $this->fileInfoDe as $infoDe ){
                print_r( $infoDe. ', ' );
            }
        }
        echo '<br>';
        
        if( !empty($this->fileInfoPara) ){
            print_r( 'Dados de destino:<br>' );
            foreach( $this->fileInfoPara as $infoPara ){
                print_r( $infoPara. ', ' );
            }
        }
        
    }
}
