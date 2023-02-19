<?php
class DialogInputView extends TPage{
    public function __construct(){
        parent::__construct();
        
        $login = new TEntry('login');
        $pass = new TEntry('pass');
        
        $form = new BootstrapFormBuilder('input_form');
        $form->addFields([new TLabel('Login')], [$login]);
        $form->addFields([new TLabel('Senha')], [$pass]);
        
        $form->addAction('Confirma', new TAction( [__CLASS__, 'onConfirm1']), 'fa:save green' );
        
        new TInputDialog('título', $form);
    }
    
    public static function onConfirm1($param){
        //new TMessage('info', 'Login: '.$param['login'].' - Senha: '.$param['pass']);
        new TMessage('info', json_encode($param));
    }
}
