<?php
class BootstrapFieldList extends TPage{
    public function __construct(){
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder('meu_form');
        $this->form->setFormTitle('Lista de campos');
        
        $combo = new TCombo('combo[]');
        $combo->enableSearch();
        $combo->addItems(['a' => 'Opção A', 'b' => 'Opção B']);
        $combo->setSize('100%');
        
        $texto = new TEntry('texto[]');
        $texto->setSize('100%');
        
        $numero = new TEntry('valor[]');
        $numero->setNumericMask(2, ',', '.', true);
        $numero->setSize('100%');
        $numero->style = 'text-align:right';
        
        $data = new TDate('dt_registro[]');
        $data->setMask('dd-mm-yyyy');
        $data->setDatabaseMask('yyyy-mm-dd');
        $data->setSize('100%');
        
        $fieldList = new TFieldList;
        $fieldList->width = '100%';
        $fieldList->addField('<b>Combo</b>', $combo, ['width' => '25%']);
        $fieldList->addField('<b>Texto</b>', $texto, ['width' => '25%']);
        $fieldList->addField('<b>Número</b>', $numero, ['width' => '25%', 'sum' => true]);
        $fieldList->addField('<b>Data</b>', $data, ['width' => '25%']);
        
        $fieldList->enableSorting();
        
        /*
        $obj = new stdClass;
        $obj->combo = 'a';
        $obj->texto = 'teste';
        $obj->valor = 100;
        $obj->dt_registro = date('Y-m-d');
        */
        
        $fieldList->addHeader();
        //$fieldList->addDetail( $obj );
        $fieldList->addDetail( new stdClass );
        $fieldList->addDetail( new stdClass );
        $fieldList->addDetail( new stdClass );
        $fieldList->addCloneAction();
        
        $this->form->addField( $combo );
        $this->form->addField( $texto );
        $this->form->addField( $numero );
        $this->form->addField( $data );
        
        $this->form->addContent([$fieldList]);
        
        $this->form->addAction('Enviar', new TAction([$this, 'onSend']), 'fa:save' );
        
        parent::add($this->form);
    }
    
    public static function onSend($param){
        echo '<pre>';
        var_dump($param);
        echo '</pre>';
    } 
}