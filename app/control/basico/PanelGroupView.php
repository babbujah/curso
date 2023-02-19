<?php
class PanelGroupView extends TPage{
    public function __construct(){
        parent::__construct();
        
        $table = new TTable;
        $table->border = 1;
        $table->style = 'border-collapse: collapse';
        $table->width = '100%';
        $table->addRowSet('A1', 'A2');
        $table->addRowSet('B1', 'B2');
        
        $panel = new TPanelGroup('Título do painel');
        $panel->add($table);
        $panel->addFooter('rodapé');
        
        parent::add($panel);
    }
}
