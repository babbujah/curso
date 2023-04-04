<?php
class DatagridScrollHorizontal extends TPage{
    private $datagrid;
    
    public function __construct(){
        parent::__construct();
        
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        $this->datagrid->style = 'min-width: 1900px';
        $this->datagrid->enablePopover('Detalhes', '<b>ID</b> {id} <br> <b>Nome</b> {nome} <br> <b>Cidade</b> {cidade} <br> <b>Estado</b> {estado} <br> <b>País</b> {pais}');
        
        $col_id = new TDataGridColumn('id', 'Código', 'center');
        $col_nome = new TDataGridColumn('nome', 'Nome', 'left');
        $col_cidade = new TDataGridColumn('cidade', 'Cidade', 'left');
        $col_estado = new TDataGridColumn('estado', 'Estado', 'left');
        $col_nascimento = new TDataGridColumn('nascimento', 'Nascimento', 'left');;
        $col_telefone = new TDataGridColumn('telefone', 'Telefone', 'left');
        $col_email = new TDataGridColumn('email', 'Email', 'left');
        $col_pais = new TDataGridColumn('pais', 'País', 'left');
        
        $col_id->title = 'Clique nesta coluna para ação';
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_nome);
        $this->datagrid->addColumn($col_cidade);
        $this->datagrid->addColumn($col_estado);
        $this->datagrid->addColumn($col_nascimento);
        $this->datagrid->addColumn($col_telefone);
        $this->datagrid->addColumn($col_email);
        $this->datagrid->addColumn($col_pais);
        
        $action1 = new TDataGridAction([$this, 'onView'], ['id' => '{id}', 'nome' => '{nome}', 'teste' => '5' ]);
        $action2 = new TDataGridAction([$this, 'onDelete'], ['id' => '{id}', 'nome' => '{nome}', 'teste' => '5' ]);
        
        $this->datagrid->addAction($action1, 'Visualiza', 'fa:search blue');
        $this->datagrid->addAction($action2, 'Exclui', 'fa:trash red');
        
        // após definir colunas e ações... criar a estrutura
        
        $this->datagrid->createModel();
        
        $panel = new TPanelGroup('Datagrid');
        $panel->add($this->datagrid);
        
        $panel->getBody()->style = 'overflow-x: auto';
        
        parent::add($panel);
    }
    
    public function show(){
        $this->onReload();
        parent::show();
    }
    
    public static function onView($param){
        new TMessage('info', 'ID: ' . $param['id'] . ' - Nome: ' . $param['nome']);
    }
    
    public static function onDelete($param){
        new TMessage('info', 'ID: ' . $param['id'] . ' - Nome: ' . $param['nome']);
    }  
    
    public function onReload(){
        
        $this->datagrid->clear();
        
        $item = new stdClass;
        $item->id = 1;
        $item->nome = 'Aretha Franklin';
        $item->cidade = 'Menphis';
        $item->estado = 'Tenessee';
        $item->nascimento = '25/03/1942';
        $item->telefone = '123 123 123 1233';
        $item->email = 'aretha@email.com';
        $item->pais = 'Estados Unidos';
        $this->datagrid->addItem($item);
        
        $item = new stdClass;
        $item->id = 2;
        $item->nome = 'Eric Clapton';
        $item->cidade = 'Ripley';
        $item->estado = 'Surrey (UK)';
        $item->nascimento = '30/03/1945';
        $item->telefone = '234 234 234 234';
        $item->email = 'eric@email.com';
        $item->pais = 'Reino Unido';
        $this->datagrid->addItem($item);
        
        $item = new stdClass;
        $item->id = 3;
        $item->nome = 'B. B. King';
        $item->cidade = 'Itta Bena';
        $item->estado = 'Mississipi (US)';
        $item->nascimento = '16/09/1925';
        $item->telefone = '345 345 345 345';
        $item->email = 'king@email.com';
        $item->pais = 'Estados Unidos';
        $this->datagrid->addItem($item);
        
        $item = new stdClass;
        $item->id = 4;
        $item->nome = 'Janis Joplin';
        $item->cidade = 'Port Arthur';
        $item->estado = 'Texas (US)';
        $item->nascimento = '19/01/1943';
        $item->telefone = '456 456 456 456';
        $item->email = 'janis@email.com';
        $item->pais = 'Estados Unidos';
        $this->datagrid->addItem($item);
    }
}