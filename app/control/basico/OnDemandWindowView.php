<?php
class OnDemandWindowView extends TPage{
    public function __construct(){
        parent::__construct();
        
        $window = TWindow::create('titulo', 0.8, null);
        
        $replaces = [];
        $replaces['title'] = 'Título';
        $replaces['body'] = 'Conteúdo';
        $replaces['footer'] = 'Rodapé';
        
        $html = new THtmlRenderer('app/resources/page.html');
        $html->enableSection('main', $replaces);
        
        $window->add($html);
        $window->show();
    }
}
