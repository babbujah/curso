<?php
class FormularioSelecoes extends TPage{
    public function __construct(){
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Campos de seleção');
        
        $opcoes = ['a' => 'Opção A', 'b' => 'Opção B', 'c' => 'Opção C'];
        
        $radio = new TRadioGroup('radio');
        $radio->addItems($opcoes);
        $radio->setLayout('horizontal');
        $radio->setValue('b');
        
        $radio2 = new TRadioGroup('radio2');
        $radio2->addItems($opcoes);
        $radio2->setLayout('horizontal');
        $radio2->setUseButton();
        $radio2->setValue('b');
        
        $check = new TCheckGroup('check');
        $check->addItems($opcoes);
        $check->setLayout('horizontal');
        $check->setValue(['a', 'c']);
        
        $check2 = new TCheckGroup('check2');
        $check2->addItems($opcoes);
        $check2->setLayout('horizontal');
        $check2->setUseButton();
        $check2->setValue(['a', 'c']);
        
        $combo = new TCombo('combo');
        $combo->addItems($opcoes);
        $combo->setValue('b');
        
        $combo2 = new TCombo('combo2');
        $combo2->addItems($opcoes);
        $combo2->enableSearch();
        $combo2->setValue('b');
        
        $select = new TSelect('select');
        $select->addItems($opcoes);
        $select->setValue(['a', 'c']);
        
        $search = new TMultiSearch('search');
        $search->addItems($opcoes);
        $search->setMinLength(1);
        $search->setValue(['a', 'c']);
        
        $unique = new TUniqueSearch('unique');
        $unique->addItems($opcoes);
        $unique->setMinLength(1);
        $unique->setValue(['b']);
        
        $multi = new TMultiEntry('multi');
        $multi->setMaxSize(3);
        $multi->setValue(['aaa', 'ccc']);
        
        $autocomp = new TEntry('autocomplete');
        $autocomp->setCompletion(['Maria', 'João', 'Pedro']);
        $autocomp->setValue('João');
        
        $this->form->addFields([new TLabel('Radio 1')], [$radio]);
        $this->form->addFields([new TLabel('Radio 2')], [$radio2]);
        $this->form->addFields([new TLabel('Check 1')], [$check]);
        $this->form->addFields([new TLabel('Check 2')], [$check2]);
        $this->form->addFields([new TLabel('Combo 1')], [$combo]);
        $this->form->addFields([new TLabel('Combo 2')], [$combo2]);
        $this->form->addFields([new TLabel('Select')], [$select]);
        $this->form->addFields([new TLabel('Multi Search')], [$search]);
        $this->form->addFields([new TLabel('Unique Search')], [$unique]);
        $this->form->addFields([new TLabel('Multi Entry')], [$multi]);
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
