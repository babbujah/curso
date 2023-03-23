<?php
class FormImageUploaderOLD extends TPage{
    
    private $form;
    
    public function __construct(){
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Captura de corte de imagem');
        
        $imagecropper = new TImageCropper('imagecropper');
        $imagecropper->setSize(300, 150);
        $imagecropper->setCropSize(300,150);
        $imagecropper->setAllowedExtensions(['gif', 'png', 'jpg', 'jpeg']);
        
        $imagecapture = new TImageCapture('imagecapture');
        $imagecapture->setSize(300, 200);
        $imagecapture->setCropSize(300, 200);
        
        $url = new TFile('url');
        var_dump($url);
        
        //$image = new TImage()
        
        $this->form->addFields([new TLabel('Image Cropper')], [$imagecropper]);
        $this->form->addFields([new TLabel('Image Capture')], [$imagecapture]);
        $this->form->addFields([new TLabel('Arquivo')], [$url]);
        
        
        parent::add($this->form);
    }
}
