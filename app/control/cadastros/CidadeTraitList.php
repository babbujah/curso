<?php
class CidadeTraitList extends TPage{
    private $form;
    private $datagrid;
    private $pageNavegation;
    
    use Adianti\Base\AdiantiStandardListTrait;
    
    public function __construct(){
        parent::__construct();
        
        $this->setDatabase('cursoOld');
        $this->setActiveRecord('Cidade');
        $this->addFilterField('nome', 'like', 'nome');
        $this->setDefaultOrder('id', 'asc');
        
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Cidades');        
        
        $nome = new TEntry('nome'); 
        
        $this->form->addFields([new TLabel('Nome')], [$nome]);
        
        $this->form->setData(TSession::getValue(__CLASS__.'filter_data'));
        
        $this->form->addAction('Buscar', new TAction([$this, 'onSearch']), 'fa:search blue');
        $this->form->addActionLink('Limpar', new TAction([$this, 'clear']), 'fa:eraser red');
        $this->form->addActionLink('Novo', new TAction(['CidadeForm', 'onClear']), 'fa:plus-circle green');
        
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        $col_id = new TDataGridColumn('id', 'Cód', 'right', '10%');
        $col_nome = new TDataGridColumn('nome', 'Nome', 'left', '60%');
        $col_estado = new TDataGridColumn('estado->nome', 'Estado', 'center', '30%');
        
        $col_id->setAction(new TAction([$this, 'onReload']), ['order' => 'id']);
        $col_nome->setAction(new TAction([$this, 'onReload']), ['order' => 'nome']);
        
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
        
        $panel = new TPanelGroup;
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavegation);
        
        $vbox = new TVBox;
        $vbox->style = 'width:100%';
        $vbox->add($this->form);
        $vbox->add($panel);
        
        parent::add($vbox);
    }
    
    public function clear(){
        $this->clearFilters();
        $this->onReload();
    }
}