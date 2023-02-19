<?php
class TemplateViewMask extends TPage{
    public function __construct(){
        parent::__construct();
        
        try{
            $html = new THtmlRenderer('app/resources/template_mask.html');
            
            $replace = [];
            $replace['date'] = date('Y-m-d');
            $replace['datetime'] = date('Y-m-d H:i:s');
            $replace['number'] = 123456.78;
            $replace['value1'] = 10;
            $replace['value2'] = 20;
            $replace['value3'] = 30;
            
            $html->enableSection('main', $replace);
            
            $raplaces2 = [];
            $replaces2['obs'] = 'Esta é a observação';
            
            $html->enableSection('outros', $replaces2);
            
            parent::add($html);
            
        }catch(Exception $e){
            new TMessage('error', $e->getMessage());
        }
    }
}
