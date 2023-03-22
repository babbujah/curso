<?php
class FormularioSelecoesBanco extends TPage{
    public function __construct(){
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Campos de seleção');
        
        $radio = new TDBRadioGroup('radio', 'cursoOLD', 'Categoria', 'id', 'nome');
        $radio->setLayout('horizontal');
        //$radio->setValue('b');
        
        $radio2 = new TDBRadioGroup('radio2', 'cursoOLD', 'Categoria', 'id', '{id} - nome');
        $radio2->setLayout('horizontal');
        $radio2->setUseButton();
        //$radio2->setValue('b');
        
        $check = new TDBCheckGroup('check', 'cursoOLD', 'Categoria', 'id', 'nome');
        $check->setLayout('horizontal');
        //$check->setValue(['a', 'c']);
        
        $check2 = new TDBCheckGroup('check2', 'cursoOLD', 'Categoria', 'id', '{id} - {nome}');
        $check2->setLayout('horizontal');
        $check2->setUseButton();
        //$check2->setValue(['a', 'c']);
        
        $combo = new TDBCombo('combo', 'cursoOLD', 'Categoria', 'id', 'nome');
        //$combo->setValue('b');
        
        $combo2 = new TDBCombo('combo2', 'cursoOLD', 'Categoria', 'id', 'nome');
        $combo2->enableSearch();
        //$combo2->setValue('b');
        
        $select = new TDBSelect('select', 'cursoOLD', 'Categoria', 'id', 'nome');
        //$select->setValue(['a', 'c']);
        
        $search = new TDBMultiSearch('search', 'cursoOLD', 'Categoria', 'id', 'nome');
        $search->setMinLength(1);
        $search->setMask('{nome} ({id})');
        //$search->setValue(['a', 'c']);
        
        $unique = new TDBUniqueSearch('unique', 'cursoOLD', 'Categoria', 'id', 'nome');
        $unique->setMinLength(1);
        $unique->setMask('{nome} ({id})');
        //$unique->setValue(['b']);
        
        $autocomp = new TDBEntry('autocomplete', 'cursoOLD', 'Categoria', 'nome');
        //$autocomp->setValue('João');
        
        $this->form->addFields([new TLabel('Radio 1')], [$radio]);
        $this->form->addFields([new TLabel('Radio 2')], [$radio2]);
        $this->form->addFields([new TLabel('Check 1')], [$check]);
        $this->form->addFields([new TLabel('Check 2')], [$check2]);
        $this->form->addFields([new TLabel('Combo 1')], [$combo]);
        $this->form->addFields([new TLabel('Combo 2')], [$combo2]);
        $this->form->addFields([new TLabel('Select')], [$select]);
        $this->form->addFields([new TLabel('Multi Search')], [$search]);
        $this->form->addFields([new TLabel('Unique Search')], [$unique]);
        $this->form->addFields([new TLabel('Auto Complete')], [$autocomp]);
        
        $this->form->addAction('Enviar', new TAction([$this, 'onSend']), 'fa:save');
        
        parent::add($this->form);
    }
    
    public function onSend($param){
        $data = $this->form->getData();
        $this->form->setData($data);
        
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}
