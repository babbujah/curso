<?php
/**
* Classe de controle para execução de redução de tamanho de arquivos.
*
* @version    1.0
* @package    control.redutorarquivo
* @author     Bruno Lopes
* @since      15/05/2023  
**/
class RedutorArquivoControl extends TPage{    
    
    const FORMATOS_SUPORTADOS = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'pdf'];
    const LIMITE_ARQUIVOS_COMPRESSAO = 200;
    const DIRETORIOS = [
        //"../../wp-content/2015",
        //"app/images/01",
        //"app/images/02",
        //"app/images/2015",
        //"app/images/2016",
        "app/images2"
    ];
    
    private $itensDiretorio;    
    private $arquivoService;
    
    /**
     * Class Constructor
     */
    public function __construct(){
        parent::__construct();
    
        $this->arquivoService = new ArquivoService;
        $this->itensDiretorio = [];
        
    }
    
    /**
    * Função para registrar os arquivos encontrados na base de dados.
    *
    * @return $log - exibe as informações de log[total_arquivos, arquivos_novos] dos arquivos armazenados.
    *
    * @author Bruno Lopes
    * @since  29/05/2023
    */
    public function registrarArquivosBaseDados(){
        try{
            foreach( static::DIRETORIOS as $pasta ){
                $diretorio = './'.$pasta;
                
                if( is_dir($diretorio) ){
                    $this->getItensDiretorio( $diretorio );
                    
                }else{
                    throw new Exception( 'Caminho das pastas inválido.' );
                    
                }
                
            }
            
            $arquivos = $this->arquivoService->findOrCreateArquivoByArrayPath( $this->itensDiretorio );
            
            $log = ['total_arquivos' => count($arquivos['total_arquivos']),
                    'arquivos_novos' => count($arquivos['arquivos_novos'])];
            
            echo json_encode( $log );
                        
         }catch(Exception $e){
             new TMessage( 'error', $e->getMessage() );
             
         }        
    }
    
    /**
    * Função para reduzir o tamanho dos arquivos das pastas previamente registradas na base de dados.
    *
    * @author Bruno Lopes
    * @since  29/05/2023
    * @return $log - exibe as informações de log[tempo_decorrido, total_arquivos_reduzidos, lista_itens_reduzidos] dos arquivos reduzidos.
    */
    public function reduzirArquivos(){
        try{
            set_time_limit(0);
            
            $tempoInicialExecucao = microtime(true); 
            
            /* Recupera da base de dados os arquivos nos formatos definidos, que ainda não foram convertidos na quantidade previamente definida */
            $arquivosComprimir = $this->arquivoService->getArquivosPendentes( self::FORMATOS_SUPORTADOS, self::LIMITE_ARQUIVOS_COMPRESSAO );
            
            /* Define a classe de redução de arquivos através de sua extensão */
            $log = [ 'tempo_decorrido' => 0, 'total_reduzidos' => 0, 'itens_reduzidos' => [] ]; 
            foreach( $arquivosComprimir as $arquivo ){
                $caminhoAbsolutoArquivo = $arquivo->dirname.'/'.$arquivo->filename;
                $destino = $arquivo->dirname.'/'.$arquivo->filename;
                $qualidade = 60;
                
                switch( $arquivo->extension ){
                    case 'jpg':
                    case 'jpeg':
                        $redutorArquivo = new RedutorArquivoJPG( $caminhoAbsolutoArquivo, $destino, $qualidade );
                        
                        break;
                        
                    case 'png':
                        $redutorArquivo = new RedutorArquivoPNG( $caminhoAbsolutoArquivo, $destino, $qualidade );
                        
                        break;
                        
                    case 'gif':
                        $redutorArquivo = new RedutorArquivoGIF( $caminhoAbsolutoArquivo, $destino );
                        
                        break;
                        
                    case 'webp':
                        $redutorArquivo = new RedutorArquivoWebp( $caminhoAbsolutoArquivo, $destino, $qualidade );
                        
                        break;
                        
                    case 'pdf':
                        $redutorArquivo = new RedutorArquivoPDFPy( $caminhoAbsolutoArquivo, $destino );
                        
                        break;
                        
                    default:
                        $redutorArquivo = null;
                        
                }                
                
                // Executa procedimento de redução                      
                if( !empty($redutorArquivo) ){
                    
                    $redutorArquivo->reduzirArquivo();
                    
                    $arquivo->size_final = $redutorArquivo->getFileInfoPara()['size'];
                    $arquivo->convertat = date('Y-m-d H:i:s');
                    
                    $this->arquivoService->salvar( $arquivo );
                    
                    $log['total_reduzidos']++;
                    $log['itens_reduzidos'][] = [
                        'path' => $arquivo->dirname.'/'.$arquivo->filename,
                        'size_original' => $arquivo->size_original,
                        'size_final' => $arquivo->size_final,
                        'compression' => $arquivo->size_final < $arquivo->size_original ? (100 - round($arquivo->size_final / $arquivo->size_original * 100, 2)).'%' : 0 
                    ];
                }
            }
            
            $tempoFinalExecucao = microtime(true);
            $tempoDecorridoProcesso = $tempoFinalExecucao - $tempoInicialExecucao;
            $log['tempo_decorrido'] = $tempoDecorridoProcesso;
            
            echo json_encode( $log );
            
        }catch( Exception $e ){
            new TMessage( 'error', $e->getMessage() );
            
        }
        
    }
    
    /**
    * Método para "popular" a lista de arquivos, analisando todas as pastas da lista de diretórios.
    *
    * @author  Bruno Lopes
    * @since   16/05/2023
    * @return
    */
    private function getItensDiretorio( $caminho ){
         if( is_dir( $caminho ) ){
            $itens = scandir( $caminho );
            foreach( $itens as $item ){
                if( $item == '.' || $item == '..' || $item == 'pdftemp' || $item == 'imgTeste' ){
                    continue;
                    
                }
                
                $pathAtual = $caminho.'/'.$item;
                if( is_dir( $pathAtual ) ){
                    $this->getItensDiretorio( $pathAtual );
                    
                }else{
                   $this->itensDiretorio[] = $pathAtual;
                    
                }
            }
        }else{
            echo 'Não é um diretório válido.';
    
        }
    }
        
    /**
    * Função para exibir informações dos arquivos inseridos na lista.
    *
    * @author  Bruno Lopes
    * @since   16/05/2023
    * @return
    */
    public function exibirListaArquivo(){
        print_r( count( $this->itensDiretorio ) );
        foreach( $this->itensDiretorio as $item ){
            print_r( '<br>'.$item );
        }
    }
    
    
}
