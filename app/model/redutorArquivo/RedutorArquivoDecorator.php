<?php
class RedutorArquivoDecorator implements IRedutorArquivo{
    protected $redutorArquivo;
    
    public function __construct( IRedutorArquivo $redutorArquivo ){
        $this->redutorArquivo = $redutorArquivo;
        
    }
    
    public function reduzirArquivo(){
        return $this->redutorArquivo->reduzirArquivo();
        
    }
}
