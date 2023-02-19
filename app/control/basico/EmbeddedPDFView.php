<?php
class EmbeddedPDFView extends TPage{
    public function __construct(){
        parent::__construct();
        
        $object = new TElement('iframe');
        $object->width = '100%';
        $object->height = '600px';
        $object->src = 'https://adiantiframework.com.br/resources/frame_mostra.pdf?ver=20180903';
        $object->type = 'application/pdf';
        
        parent::add($object);
    }
}
