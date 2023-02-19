<?php
class SinglePageView extends TPage{
    public function __construct(){
        parent::__construct();
        
        $replaces = [];
        $replaces['title'] = 'Título';
        $replaces['body'] = 'Conteúdo';
        $replaces['footer'] = 'Rodapé';
        
        $html = new THtmlRenderer('app/resources/page.html');
        $html->enableSection('main', $replaces);
        
        $vbox = new TVBox;
        $vbox->style = 'width:100%';
        $vbox->add( new TXMLBreadCrumb('menu.xml', __CLASS__) );
        $vbox->add($html);
        
        parent::add($vbox);
    }
}
