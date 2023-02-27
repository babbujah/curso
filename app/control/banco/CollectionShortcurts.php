<?php
class CollectionShortcurts extends TPage{
    public function __construct(){
        parent::__construct();
        
        try{
            TTransaction::open('cursoOLD');
            
            /**
            * Retorna todos os registros encontrados na base
            **/
            /*
            $clientes = Cliente::all();
            echo '<pre>';
            print_r($clientes);
            echo '</pre>';
            */
            
            /**
            * Retorna uma contagem de registros baseados nos critérios
            **/
            /*
            $count = Cliente::where('situacao', '=', 'Y')
                            ->where('genero', '=', 'F')
                            ->count();
            print_r($count);
            */
            
            /**
            * Retorna os registros baseados nos critérios
            **/
            /*
            $clientes = Cliente::where('situacao', '=', 'Y')
                            ->where('genero', '=', 'F')
                            ->load();
            echo '<pre>';
            print_r($clientes);
            echo '</pre>';
            */
            
            /**
            * Retorna os registros baseados nos critérios ordenados
            **/
            /*
            $clientes = Cliente::where('situacao', '=', 'Y')
                            ->where('genero', '=', 'F')
                            ->orderBy('nome')
                            ->load();
            echo '<pre>';
            print_r($clientes);
            echo '</pre>';
            */
            
            /**
            * Retorna os registros baseados nos critérios com paginação
            **/
            /*
            $clientes = Cliente::where('id', '>', 0)
                            ->take(10)
                            ->skip(20)
                            ->load();
            echo '<pre>';
            print_r($clientes);
            echo '</pre>';
            */
            
            /**
            * Retorna os registros baseados nos critérios retornando apenas
            * primeiro registro
            **/
            /*
            $clientes = Cliente::where('situacao', '=', 'Y')
                            ->where('genero', '=', 'F' )
                            ->first();
            echo '<pre>';
            print_r($clientes);
            echo '</pre>';
            */
            
            /**
            * Atualiza o registro a partir de critérios
            **/
            /*
            Cliente::where('cidade_id', '=', '3')
                   ->set('telefone', '222222-444444')
                   ->update();
            */
            
            /**
            * Exclui o registro a partir de critérios
            **/
            /*
            Cliente::where('categoria_id', '=', '3')
                    ->delete()
            */
            
            /**
            * Retorna um vetor a partir de critérios
            **/
            /*
            $clientes = Cliente::getIndexedArray('id', 'nome');
            echo '<pre>';
            print_r($clientes);
            echo '</pre>';
            */
            
            /**
            * Retorna um vetor a partir de critérios ordenado
            **/
            
            $clientes = Cliente::where('situacao', '=', 'Y')
                               ->orderBy('id')
                               ->getIndexedArray('id', 'nome');
            echo '<pre>';
            print_r($clientes);
            echo '</pre>';
            
               
            TTransaction::close();
            
        }catch(Exception $e){
            new TMessage('error', $e->getMessage());
        }
    }

}
