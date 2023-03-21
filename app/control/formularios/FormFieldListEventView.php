<?php
class FormFieldListEventView extends TPage{
    private $form;
    private $fieldList;
    
    public function __construct(){
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder('my_form');
        $this->form->setFormTitle('Form field list');
        
        $uniq = new THidden('iniq[]');
        
        $combo = new TCombo('combo[]');
        $combo->enableSearch();
        $combo->addItems(['1' => '<b>One</b>', '2' => '<b>Two</b>', '3' => '<b>Three</b>', '4' => '<b>Four</b>', '5' => '<b>Five</b>']);
        $combo->setSize('100%');
        
        $text = new TEntry('text[]');
        $text->setSize('100%');
        
        $number = new TEntry('number[]');
        $number->setNumericMask(2, ',', '.', true);
        $number->setSize('100%');
        $number->style = 'text-align: right';
        
        $date = new TDate('date[]');
        $date->setSize('100%');
        
        $this->fieldList = new TFieldList;
        $this->fieldList->generateAria();
        $this->fieldList->width = '100%';
        $this->fieldList->name = 'my_field_list';
        $this->fieldList->addField('<b>Unniq</b>', $uniq, ['width' => '0%', 'uniqid' => true]);
        $this->fieldList->addField('<b>Combo</b>', $combo, ['width' => '25%']);
        $this->fieldList->addField('<b>Text</b>', $text, ['width' => '25%']);
        $this->fieldList->addField('<b>Number</b>', $number, ['width' => '25%', 'sum' => true]);
        $this->fieldList->addField('<b>Date</b>', $date, ['width' => '25%']);
        
        $this->fieldList->addButtonAction(new TAction([$this, 'showRow']), 'fa:info-circle purple', 'Mostrar texto');
        
        //$this->fieldList->addButtonFunction("__adianti_post_data('my_form', 'class=FormFieldListEventView&method=showRow&static=1&static=1');return false;", 'fa:info-circle purple', 'Mostrar texto');
        //$this->fieldList->addAction(new TAction([$this, 'showRow']), 'fa:info-circle purple', 'Mostrar texto');
        
        //$this->fieldList->disableRemoveButton();
        
        $this->fieldList->setRemoveAction(new TAction([$this, 'showRow']));
        
        $this->fieldList->enableSorting();
        
        TScript::create('
            function showRow(){
                alert("teste");
            }
        ');
        
        $this->form->addField($combo);
        $this->form->addField($text);
        $this->form->addField($number);
        $this->form->addField($date);
        
        $this->fieldList->addHeader();
        $this->fieldList->addDetail( new stdClass );
        $this->fieldList->addDetail( new stdClass );
        $this->fieldList->addDetail( new stdClass );
        $this->fieldList->addDetail( new stdClass );
        $this->fieldList->addDetail( new stdClass );
        
        $this->fieldList->addCloneAction( new TAction([$this, 'showRow']));
        
        $this->fieldList->setTotalUpdateAction(new TAction([$this, 'onTotalUpdate']));
        
        
        
        $this->form->addContent([$this->fieldList]);
        
        //$this->form->addAction('Save', new TAction([$this, 'onSave'], ['static' => 1]), 'fa:save blue');
        //$this->form->addAction('Clear', new TAction([$this, 'onClear']), 'fa:eraser red');
        //$this->form->addAction('Fill', new TAction([$this, 'onFill']), 'fas:pencil-alt green');
        //$this->form->addAction('Clear/Fill', new TAction([$this, 'onClearFill']), 'fas:pencil-alt orange');
        
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        
        parent::add($vbox);
    }
    
    public static function showRow($param){
        new TMessage('info', str_replace(',', '<br>', json_encode($param)));
    }
    
    public static function onTotalUpdate($param){
        //echo '<pre>';
        //var_dump($param);
        //echo '</pre>';
        
        $grandtotal = 0;
        
        if($param['list_data']){
            foreach($param['list_data'] as $row){
                $grandtotal += floatval(str_replace(['.', ','], ['', '.'], $row['number']));
            }
        }
        
        TToast::show('info', '<b>Total</b>: '. number_format($grandtotal, 2, ',', '.'), 'top right', 'fa fa-tag');
    }
    
}
