<?php
class FormCodeReader extends TPage{

    private $form;
    
    public function __construct(){
        parent::__construct();
        
        try{
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Leitura de barcode e qrcode');
        
        $barcode = new TBarCodeInputReader('barcode');
        $barcode->setSize('100%');
        
        $qrcode = new TQRCodeInputReader('qrcode');
        $qrcode->setSize('100%');
        
        $this->form->addFields([new TLabel('BarCode')], [$barcode]);
        $this->form->addFields([new TLabel('QRCode')], [$qrcode]);
        
        
        parent::add($this->form);
        }catch(Exception $e){
        
        }
    }
    
}
