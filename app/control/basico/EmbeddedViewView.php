<?php
class EmbeddedViewView extends TPage{
    public function __construct(){
        parent::__construct();
        
        $object = new TElement('iframe');
        $object->width = '100%';
        $object->height = '600px';
        $object->src = 'https://www.youtube.com/watch?v=MwHLawF_FFE';
        $object->frameboard = '0';
        $object->allow = 'acelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture';
        
        parent::add($object);
    }
}
