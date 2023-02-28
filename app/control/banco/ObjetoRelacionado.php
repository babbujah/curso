<?php
class ObjetoRelacionado extends TPage{
    public function __construct(){
        parent::__construct();
        
        try{
            TTransaction::open('cursoOLD');
            
            TTransaction::dump();
            
            // RELACIONAMENTO UM PARA MUITOS
            // Carrega os contatos do cliente a partir da sua chave estrageira usando o padrão cliente_id
            //$contatos = Cliente::find(1)->hasMany('Contato');
            
            // Carrega os contatos do cliente a partir da sua chave estrangeira informando uma chave estrageira qualquer
            //$contatos = Cliente::find(1)->hasMany('Contato', 'cliente_id', 'id', 'tipo');
            
            // Carrega os contatos do cliente a partir da sua chave estrageira usando o padrão cliente_id e aplicando filtros
            //$contatos = Cliente::find(1)->filterMany('Contato')->where('tipo', '=', 'face')->load();
            
            // Carrega os contatos do cliente a partir da sua chave estrangeira informando uma chave estrageira qualquer e aplicando filtros
            //$contatos = Cliente::find(1)->filterMany('Contato', 'cliente_id', 'id', 'tipo')->where('tipo', '=', 'face')->load();
            
            // RELACIONAMENTO MUITOS PARA MUITOS
            // Carrega as habilidades de um cliente em um relacionamento muitos para muitos e usando as chaves estrangeiras em seu formato padrão habilidade_id e cliente_id
            $habilidades = Cliente::find(1)->belongsToMany('Habilidade');
            
            // Carrega as habilidades de um cliente em um relacionamento muitos para muitos e usando as chaves estrangeiras definidas
            //$habilidades = Cliente::find(1)->belongsToMany('Habilidade', 'ClienteHabilidade', 'cliente_id', 'habilidade_id');
            
            echo '<pre>';
            var_dump($habilidades);
            echo '</pre>';
            
            TTransaction::close();
        }catch(Exception $e){
            new TMessage('error', $e->getMessage());
        }
    }
}
