<?php
class FormularioBootstrapEstatico extends TPage{
    private $form;
    
    public function __construct(){
        parent::__construct();
        
        $id = new TEntry('id');
        
        $descricao = new TEntry('descricao');        
        $senha = new TPassword('senha');
        
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Formulário bootstrap estático');
        
        $this->form->appendPage('Aba 1');
        $this->form->addFields([new TLabel('Id')], [$id]);
        $this->form->addFields([new TLabel('Descrição')], [$descricao]);
        $this->form->addFields([new TLabel('Senha')], [$senha]);
                        
        //$this->form->addHeaderAction('Enviar', new TAction([$this, 'onSend']), 'fa:save');
        $this->form->addAction('Enviar', new TAction([$this, 'onSend']), 'fa:save');
        
        parent::add($this->form);
    }
    
    public static function onSend($param){
        echo '<pre>';
        var_dump($param);
        echo '</pre>';
        
        //new TMessage('info', json_encode($param));
    }
}
