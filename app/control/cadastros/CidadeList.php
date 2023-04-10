<?php
class CidadeList extends TPage{
    private $datagrid;
    private $pageNavegation;
    private $loaded;
    
    public function __construct(){
        parent::__construct();
        
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        $col_id = new TDataGridColumn('id', 'Cód', 'right', '10%');
        $col_nome = new TDataGridColumn('nome', 'Nome', 'left', '60%');
        $col_estado = new TDataGridColumn('estado->nome', 'Estado', 'center', '30%');
        
        /**
        ordenação
        **/
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_nome);
        $this->datagrid->addColumn($col_estado);
        
        $action1 = new TDataGridAction(['CidadeForm', 'onEdit'], ['key' => '{id}']);
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{id}']);
        
        $this->datagrid->addAction($action1, 'Editar', 'fa:edit blue');
        $this->datagrid->addAction($action2, 'Excluir', 'fa:trash-alt red');
        
        $this->datagrid->createModel();
        
        $this->pageNavegation = new TPageNavigation;
        $this->pageNavegation->setAction(new TAction([$this, 'onReload']));
        
        /**
        $vbox = new TVBox;
        $vbox->style = 'width:100%';
        $vbox->add($this->datagrid);
        $vbox->add($this->pageNavegation);
        **/
        
        $panel = new TPanelGroup;
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavegation);
        
        parent::add($panel);
    }
    
    public function show(){
        if(!$this->loaded){
            $this->onReload(func_get_arg(0));
        }
        parent::show();
        
    }
    
    public function onReload($param){
        try{
            TTransaction::open('cursoOld');
            
            $repository = new TRepository('Cidade');
            
            $limit = 10;
            
            $criteria = new TCriteria;
            $criteria->setProperty('limit', $limit);
            $criteria->setProperties($param);
            
            $cidades = $repository->load($criteria);
            
            $this->datagrid->clear();
            
            if($cidades){
                foreach($cidades as $cidade){
                    $this->datagrid->addItem($cidade);
                }
            }
            
            $criteria->resetProperties();
            $count = $repository->count($criteria);
            
            $this->pageNavegation->setCount($count);
            $this->pageNavegation->setProperties($param);
            $this->pageNavegation->setLimit($limit);
            
            $this->loaded = true;
            
            TTransaction::close();
            
        }catch(Exception $e){
            new TMessage('error', $e->getMessage());
        }
    }
    public static function onDelete($param){}
    
}
