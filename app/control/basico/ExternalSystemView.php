<?php
class ExternalSystemView extends TPage{
    public function __construct(){
        parent::__construct();
        
        $object = new TElement('iframe');
        $object->width = '100%';
        $object->height = '600px';
        $object->src = 'https://adianti.com.br/framework_files/template-material/';
        $object->frameboard = '0';
        
        parent::add($object);
    }
}
