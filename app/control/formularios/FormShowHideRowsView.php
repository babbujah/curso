<?php
class FormShowHideRowsView extends TPage{
    
    const DOMINIO = 'https://www.fiern.org.br/';
    private $form;
    
    function __construct(){
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder('form_show_hide');
        $this->form->setFormTitle('Form de teste');
        
        $type = new TCombo('type');
        $item_price = new TEntry('item_price');
        $units = new TEntry('units');
        $hour_price = new TEntry('hour_price');
        $hours = new TEntry('hours');
        $urlOrigem = new TEntry('url_origem');
        $urlGerada = new TEntry('url_gerada');
        
        $urlGerada->setEditable(FALSE);
        $this->encurtarLink(['url_origem' => '']);      
        
        $type->setChangeAction(new TAction(array($this, 'onChangeType')));
        $combo_items = array();
        $combo_items['p'] = 'Product';
        $combo_items['s'] = 'Service';
        $type->addItems($combo_items);
        
        $type->setValue('');
        
        self::onChangeType(['type' => '']);
        
        $this->form->addFields([new TLabel('Type')], [$type]);
        $this->form->addFields( [new TLabel('Item price')], [$item_price] );
        $this->form->addFields( [new TLabel('Units')],      [$units] );
        $this->form->addFields( [new TLabel('Hour price')], [$hour_price] );
        $this->form->addFields( [new TLabel('Hours')],      [$hours] );
        $this->form->addFields( [new TLabel('URL original')], [$urlOrigem] );
        $this->form->addFields( [new TLabel('URL encurtada')], [$urlGerada] );
        
        //$this->form->addButton('Gerar Link', new TAction(array($this, 'encurtarLink')), $icon = 'fa:save');
        $this->form->addAction('Gerar Link', new TAction( [__CLASS__, 'encurtarLink']), 'fa:save green' );
        //Verificar alinhamento do botão
        $this->form->getField('btn_gerar_link')->style = 'text-align: end';
                
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        //$vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        
        parent::add($vbox);
    }
    
    public function encurtarLink($param){
        if($param['url_origem'] == ""){
            TQuickForm::hideField('form_show_hide', 'url_gerada');
        }else{
            TQuickForm::showField('form_show_hide', 'url_gerada');
            $enderecoRelativo = $param['url_origem'];
            $enderocoRelativoCifrado = $this->cifrar($enderecoRelativo);
            //$enderocoRelativoCifrado = self::cifrar($enderecoRelativo);
            $enderoAbsolutoCifrado = self::DOMINIO . "$enderocoRelativoCifrado";
            $this->form->getField('url_gerada')->setValue($enderoAbsolutoCifrado);
            
        }
        //$linkField = 
        //$this->form->addFields([new TLabel('Link')], [$linkEncurtado]);
        
        //new TMessage('info', json_encode($param));
    }
    
    private function cifrar($url){
        $urlVetor = explode('/', $url);
        $enderecoRelativo = end($urlVetor); 
        $enderecoHash = md5($enderecoRelativo);
        
        return $enderecoHash;
    }
    
    public static function onChangeType($param){
        if($param['type'] == 'p'){
            TQuickForm::showField('form_show_hide', 'item_price');
            TQuickForm::showField('form_show_hide', 'units');
            TQuickForm::hideField('form_show_hide', 'hour_price');
            TQuickForm::hideField('form_show_hide', 'hours');
            TQuickForm::hideField('form_show_hide', 'url_gerada');
        }elseif($param['type'] == 's'){
            TQuickForm::hideField('form_show_hide', 'item_price');
            TQuickForm::hideField('form_show_hide', 'units');
            TQuickForm::showField('form_show_hide', 'hour_price');
            TQuickForm::showField('form_show_hide', 'hours');
            TQuickForm::hideField('form_show_hide', 'url_gerada');
        }else{
            TQuickForm::hideField('form_show_hide', 'item_price');
            TQuickForm::hideField('form_show_hide', 'units');
            TQuickForm::hideField('form_show_hide', 'hour_price');
            TQuickForm::hideField('form_show_hide', 'hours');
        }
    }
}
